<?php

namespace App\Http\Controllers;

use App\Models\Units;
use App\Models\Rooms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $units = Units::where('is_enabled', true)->get();
            return datatables()->of($units)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('units.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('units.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 5,
                        'status' => 'is_generic',
                    ];
                    $showLogBtn =
                        "<a href='#'class='btn btn-sm btn-secondary' data-bs-toggle='modal'
                            data-bs-target='#exampleModal'
                            data-title='Detail Log' data-bs-tooltip='tooltip'
                            data-remote=" . route('log.getLog', ['norec' => $log['norec'], 'module' => $log['module_id'], 'status' => $log['status']]) . "
                            title='Log Information'>
                            <i class='ph-duotone ph-info'></i>
                        </a>
                    ";

                    $btn = $btn . $showLogBtn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('units.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'unit');
        })
            ->whereDoesntHave('unit')
            ->get();

        $province = getAllProvince();
        $province = json_decode($province->content());
        $province = $province->province;

        return view('units.create', compact('user', 'province'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'village' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            if (File::exists(public_path('images/units/' . $request->image))) {
                File::delete(public_path('images/units/' . $request->image));
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->has('user_id') && $request->user_id != null) {
            $decryptedUserId = decrypt($request->user_id);
            $request->merge(['user_id' => $decryptedUserId]);

            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:units,user_id',
            ]);

            if ($validator->fails()) {
                if (File::exists(public_path('images/units/' . $request->image))) {
                    File::delete(public_path('images/units/' . $request->image));
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

        $request['serial_no'] = rand(100000, 999999);

        DB::beginTransaction();
        try {
            $unit = Units::create($request->all());
            $log = [
                'norec' => $unit->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 5,
                'status' => 'is_generic',
                'desc' => 'Create a new unit: ' . $unit->customer_name . ' with address: ' . $unit->street . ', ' . $unit->city . ', ' . $unit->province . ' by ' . auth()->user()->name,
            ];
            createLog($log);
            DB::commit();

            return redirect()->route('units.index')->with('success', 'Unit created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (File::exists(public_path('images/units/' . $request->image))) {
                File::delete(public_path('images/units/' . $request->image));
            }
            return redirect()->route('units.index')->with('error', 'Unit creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $unit = Units::find(decrypt($id));
        return view('units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $unit = Units::find(decrypt($id));
        $id_enc = encrypt($unit->id);

        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'unit');
        })
            ->get();

        $province = getAllProvince();
        $province = json_decode($province->content());
        $province = $province->province;

        $provinceID = collect($province)->where('name', $unit->province)->first()->id;

        $city = getAllCity($provinceID);
        $city = json_decode($city->content());
        $city = $city->city;

        $cityID = collect($city)->where('name', $unit->city)->first()->id;

        $district = getAllDistrict($cityID);
        $district = json_decode($district->content());
        $district = $district->district;

        $districtID = collect($district)->where('name', $unit->district)->first()->id;

        $village = getAllVillage($districtID);
        $village = json_decode($village->content());
        $village = $village->village;

        return view('units.edit', compact('unit', 'id_enc', 'user', 'province', 'provinceID', 'city', 'cityID', 'district', 'districtID', 'village'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $unit = Units::find(decrypt($id));
        $oldUnit = $unit->toJson();

        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'village' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            if (File::exists(public_path('images/units/' . $request->image))) {
                File::delete(public_path('images/units/' . $request->image));
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->has('user_id') && $request->user_id != null) {
            $decryptedUserId = decrypt($request->user_id);
            $request->merge(['user_id' => $decryptedUserId]);
        }

        $extUser = Units::where('id', decrypt($id))->first();

        if ($extUser->user_id != $request->user_id) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|unique:units,user_id',
            ]);

            if ($validator->fails()) {
                if ($extUser->image != $request->image) {
                    if (File::exists(public_path('images/units/' . $request->image))) {
                        File::delete(public_path('images/units/' . $request->image));
                    }
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

        $request = array_filter($request->all());

        DB::beginTransaction();
        try {
            $unit->update($request);
            $log = [
                'norec' => $unit->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 5,
                'status' => 'is_generic',
                'desc' => 'Update unit data: ' . $unit->customer_name . ' with address: ' . $unit->street . ', ' . $unit->city . ', ' . $unit->province . ' by ' . auth()->user()->name,
                'old_data' => $oldUnit,
            ];
            createLog($log);
            DB::commit();

            return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (File::exists(public_path('images/units/' . $request->image))) {
                File::delete(public_path('images/units/' . $request->image));
            }
            return redirect()->route('units.index')->with('error', 'Unit update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $checkRooms = Rooms::where('unit_id', $id)->exists();

        if ($checkRooms) {
            return response()->json(['error' => 'There are still rooms on the unit.']);
        }

        $unit = Units::find($id);
        $oldUnit = $unit->toJson();
        $log = [
            'norec' => $unit->norec,
            'norec_parent' => auth()->user()->norec,
            'module_id' => 5,
            'status' => 'is_generic',
            'desc' => 'Delete unit data: ' . $unit->customer_name . ' with address: ' . $unit->street . ', ' . $unit->city . ', ' . $unit->province . ' by ' . auth()->user()->name,
            'old_data' => $oldUnit,
        ];
        createLog($log);
        $soft_delete = $unit->update(['is_enabled' => false]);

        if ($soft_delete) {
            return response()->json(['success' => 'Unit deleted successfully.']);
        } else {
            return response()->json(['error' => 'Unit deletion failed.']);
        }
    }
}
