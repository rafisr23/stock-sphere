<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Models\Units;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $technicians = Technician::where('is_enabled', true)->get();
            return datatables()->of($technicians)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        return 'Active';
                    } else {
                        return 'Inactive';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . route('technicians.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('technicians.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 8,
                        'status' => 'is_generic',
                    ];
                    $showLogBtn =
                        "<a href='#'class='btn btn-sm btn-secondary' data-bs-toggle='modal'
                    data-bs-target='#exampleModal'
                    data-title='Detail Log' data-bs-tooltip='tooltip'
                    data-remote=" . route('log.getLog', ['norec' => $log['norec'], 'module' => $log['module_id'], 'status' => $log['status']]) . "
                    title='Log Information'>
                    <i class='ph-duotone ph-info'></i>
                        </a></div>
                        ";

                    $btn = $btn . $showLogBtn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('technicians.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technician = Technician::where('user_id', '!=', null)->where('is_enabled', true)->get();
        if ($technician->count() > 0) {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'technician');
            })->whereNotIn('id', Technician::where('user_id', '!=', null)->pluck('user_id'))->where('is_enabled', true)->get();
        } else {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'technician');
            })->where('is_enabled', true)->get();
        }

        $province = getAllProvince();
        $province = json_decode($province->content());
        $province = $province->province;

        return view('technicians.create', compact('users', 'technician', 'province'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'village' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'status' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            if (File::exists(public_path('images/technicians/' . $request->image))) {
                File::delete(public_path('images/technicians/' . $request->image));
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->has('user_id') && $request->user_id != null) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:technicians,user_id',
            ]);

            if ($validator->fails()) {
                if (File::exists(public_path('images/technicians/' . $request->image))) {
                    File::delete(public_path('images/technicians/' . $request->image));
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        $province = getProvince($request->province);
        $province = json_decode($province->content());
        $request['province'] = $province->province->name;

        $city = getCity($request->city);
        $city = json_decode($city->content());
        $request['city'] = $city->city->name;

        $district = getDistrict($request->district);
        $district = json_decode($district->content());
        $request['district'] = $district->district->name;

        $village = getVillage($request->village);
        $village = json_decode($village->content());
        $request['village'] = $village->village->name;

        DB::beginTransaction();
        try {
            $technician = Technician::create($request->all());
            $log = [
                'norec' => $technician->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 8,
                'is_generic' => true,
                'desc' => 'Create a new technician: ' . $technician->name . ' from ' . $technician->city . ' by ' . auth()->user()->name,
            ];
            createLog($log);
            DB::commit();

            return redirect()->route('technicians.index')->with('success', 'Technician created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (File::exists(public_path('images/technicians/' . $request->image))) {
                File::delete(public_path('images/technicians/' . $request->image));
            }
            return redirect()->back()->with('error', 'Technician creation failed: ' . $e->getMessage());
        }
    }

    public function assign()
    {
        $technicians = Technician::where('unit_id', null)->where('is_enabled', true)->get();
        $units = Units::where('is_enabled', true)->get();
        return view('technicians.assign', compact('technicians', 'units'));
    }

    public function assignTechnician(Request $request)
    {
        $request->validate([
            'unit_id' => 'required',
            'technician_id' => 'required',
        ]);

        $unit = Units::find($request->unit_id);

        DB::beginTransaction();
        try {
            foreach ($request->technician_id as $technician_id) {
                $technician = Technician::find($technician_id);
                $technician->unit_id = $request->unit_id;
                $technician->save();
                $log = [
                    'norec' => $technician->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 8,
                    'is_generic' => true,
                    'desc' => 'Assign technician: ' . $technician->name . ' to unit: ' . $unit->customer_name . ' by ' . auth()->user()->name,
                ];
                createLog($log);
            }
            DB::commit();
            return redirect()->route('technicians.index')->with('success', 'Technician assigned successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Technician assignment failed: ' . $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $technician = Technician::find(decrypt($id));
        return view('technicians.show', compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $technician = Technician::find(decrypt($id));
        $selected_user = User::find($technician->user_id);
        if ($technician->user_id) {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'technician');
            })->where('id', '!=', $technician->user_id)->where('is_enabled', true)->get();
        } else {
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'technician');
            })->whereNotIn('id', Technician::where('user_id', '!=', null)->pluck('user_id'))->where('is_enabled', true)->get();
        }
        $province_id = null;
        $city_id = null;
        $district_id = null;
        $village_id = null;

        $province_all = getAllProvince();
        $province_all = json_decode($province_all->content());
        $province_all = $province_all->province;

        $get_province = getAllProvince();
        $province = json_decode($get_province->content());
        foreach ($province->province as $prov) {
            if ($prov->name == $technician->province) {
                $province_id = $prov->id;
            }
        }
        $get_city = getAllCity($province_id);
        $city = json_decode($get_city->content());
        foreach ($city->city as $cit) {
            if ($cit->name == $technician->city) {
                $city_id = $cit->id;
            }
        }
        $get_district = getAllDistrict($city_id);
        $district = json_decode($get_district->content());
        foreach ($district->district as $dist) {
            if ($dist->name == $technician->district) {
                $district_id = $dist->id;
            }
        }
        $get_village = getAllVillage($district_id);
        $village = json_decode($get_village->content());
        foreach ($village->village as $vil) {
            if ($vil->name == $technician->village) {
                $village_id = $vil->id;
            }
        }

        return view('technicians.edit', compact('technician', 'users', 'selected_user', 'province_id', 'city_id', 'district_id', 'village_id', 'province_all'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $technician = Technician::find($id);
        $oldTechnician = $technician->toJson();

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'village' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'status' => 'required',
            'image' => 'required',
        ]);

        $province = getProvince($request->province);
        $province = json_decode($province->content());
        $request['province'] = $province->province->name;

        $city = getCity($request->city);
        $city = json_decode($city->content());
        $request['city'] = $city->city->name;

        $district = getDistrict($request->district);
        $district = json_decode($district->content());
        $request['district'] = $district->district->name;

        $village = getVillage($request->village);
        $village = json_decode($village->content());
        $request['village'] = $village->village->name;

        if ($request->user_id) {
            $request['user_id'] = $request->user_id;
        }

        DB::beginTransaction();
        try {
            $technician->update($request->all());
            $log = [
                'norec' => $technician->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 8,
                'is_generic' => true,
                'desc' => 'Update technician data: ' . $technician->name . 'from' . $technician->city . ' by ' . auth()->user()->name,
                'old_data' => $oldTechnician,
            ];
            createLog($log);
            DB::commit();

            return redirect()->route('technicians.index')->with('success', 'Technician updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (File::exists(public_path('images/technicians/' . $request->image))) {
                File::delete(public_path('images/technicians/' . $request->image));
            }
            return redirect()->back()->with('error', 'Technician update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $technician = Technician::find(decrypt($id));
        $oldTechnician = $technician->toJson();
        if ($technician->unit) {
            return response()->json(['error' => 'Technician has unit.']);
        } else {
            if ($technician->user) {
                $log = [
                    'norec' => $technician->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 8,
                    'is_generic' => true,
                    'desc' => 'Delete an existing technician: ' . $technician->name . ' by ' . auth()->user()->name,
                    'old_data' => $oldTechnician,
                ];
                createLog($log);
                $soft_delete = $technician->update(['is_enabled' => false]);
                if ($soft_delete) {
                    return response()->json(['success' => 'Technician deleted successfully.']);
                } else {
                    return response()->json(['error' => 'Technician delete failed.']);
                }
            } else {
                return response()->json(['error' => 'Technician has no user.']);
            }
        }
    }
}
