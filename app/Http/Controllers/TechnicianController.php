<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Models\Units;
use App\Models\User;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    protected $APIsController;

    public function __construct(APIsController $APIsController)
    {
        $this->APIsController = $APIsController;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $technicians = Technician::all();
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
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
                    $btn .= '</div>';
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
        $technician = Technician::where('user_id', '!=', null)->get();
        if ($technician->count() > 0) {
            $users = User::whereHas('roles', function ($query) {$query->where('name', 'technician');})->where('id', '!=', $technician->pluck('user_id'))->get();
        } else {
            $users = User::whereHas('roles', function ($query) {$query->where('name', 'technician');})->get();
        }
        return view('technicians.create', compact('users', 'technician'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
        ]);

        $province = $this->APIsController->getProvince($request->province);
        $province = json_decode($province->content());
        $request['province'] = $province->province->name;

        $city = $this->APIsController->getCity($request->city);
        $city = json_decode($city->content());
        $request['city'] = $city->city->name;

        $district = $this->APIsController->getDistrict($request->district);
        $district = json_decode($district->content());
        $request['district'] = $district->district->name;

        $village = $this->APIsController->getVillage($request->village);
        $village = json_decode($village->content());
        $request['village'] = $village->village->name;

        $technician = new Technician();
        $technician->name = $request->name;
        $technician->phone = $request->phone;
        $technician->province = $request->province;
        $technician->city = $request->city;
        $technician->district = $request->district;
        $technician->village = $request->village;
        $technician->street = $request->street;
        $technician->postal_code = $request->postal_code;
        $technician->status = $request->status;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/technicians'), $image_name);
            $technician->image = $image_name;
        }
        if ($request->user_id) {
            $technician->user_id = $request->user_id;
        }
        $technician->save();

        return redirect()->route('technicians.index')->with('success', 'Technician created successfully.');

    }

    public function assign()
    {
        $technicians = Technician::where('unit_id', null)->get();
        $units = Units::all();
        return view('technicians.assign', compact('technicians', 'units'));
    }

    public function assignTechnician(Request $request)
    {
        $request->validate([
            'unit_id' => 'required',
            'technician_id' => 'required',
        ]);

        foreach ($request->technician_id as $technician_id) {
            $technician = Technician::find($technician_id);
            $technician->unit_id = $request->unit_id;
            $technician->save();
        }

        return redirect()->route('technicians.index')->with('success', 'Technician assigned successfully.');
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
            $users = User::whereHas('roles', function ($query) {$query->where('name', 'technician');})->where('id', '!=', $technician->user_id)->get();
        } else {
            $users = User::whereHas('roles', function ($query) {$query->where('name', 'technician');})->whereNotIn('id', Technician::where('user_id', '!=', null)->pluck('user_id'))->get();
        }
        $province_id = null;
        $city_id = null;
        $district_id = null;
        $village_id = null;

        $get_province = $this->APIsController->getAllProvince();
        $province = json_decode($get_province->content());
        foreach ($province->province as $prov) {
            if ($prov->name == $technician->province) {
                $province_id = $prov->id;
            }
        }
        $get_city = $this->APIsController->getAllCity2($province_id);
        $city = json_decode($get_city->content());
        foreach ($city->city as $cit) {
            if ($cit->name == $technician->city) {
                $city_id = $cit->id;
            }
        }
        $get_district = $this->APIsController->getAllDistrict2($city_id);
        $district = json_decode($get_district->content());
        foreach ($district->district as $dist) {
            if ($dist->name == $technician->district) {
                $district_id = $dist->id;
            }
        }
        $get_village = $this->APIsController->getAllVillage2($district_id);
        $village = json_decode($get_village->content());
        foreach ($village->village as $vil) {
            if ($vil->name == $technician->village) {
                $village_id = $vil->id;
            }
        }
        
    
        return view('technicians.edit', compact('technician', 'users', 'selected_user', 'province_id', 'city_id', 'district_id', 'village_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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
        ]);

        $province = $this->APIsController->getProvince($request->province);
        $province = json_decode($province->content());
        $request['province'] = $province->province->name;

        $city = $this->APIsController->getCity($request->city);
        $city = json_decode($city->content());
        $request['city'] = $city->city->name;

        $district = $this->APIsController->getDistrict($request->district);
        $district = json_decode($district->content());
        $request['district'] = $district->district->name;

        $village = $this->APIsController->getVillage($request->village);
        $village = json_decode($village->content());
        $request['village'] = $village->village->name;

        $technician = Technician::find($id);
        $technician->name = $request->name;
        $technician->phone = $request->phone;
        $technician->province = $request->province;
        $technician->city = $request->city;
        $technician->district = $request->district;
        $technician->village = $request->village;
        $technician->street = $request->street;
        $technician->postal_code = $request->postal_code;
        $technician->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/technicians'), $image_name);
            $technician->image = $image_name;
        }

        if ($request->user_id) {
            $technician->user_id = $request->user_id;
        }

        $technician->save();

        return redirect()->route('technicians.index')->with('success', 'Technician updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $technician = Technician::find(decrypt($id));
        if ($technician->unit) {
            return response()->json(['error' => 'Technician has unit.']);
        } else {
            if ($technician->user) {
                // delete user
                $technician->user->delete();
            }
            $technician->delete();
            return response()->json(['success' => 'Technician deleted successfully.']);
        }
    }
}
