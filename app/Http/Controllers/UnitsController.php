<?php

namespace App\Http\Controllers;

use App\Models\Units;
use App\Http\Requests\StoreUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use App\Models\Items_units;
use App\Models\Rooms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $units = Units::all();
            return datatables()->of($units)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . route('units.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('units.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
                    $btn .= '</div>';
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

        $unit = Units::create($request->all());

        if ($unit) {
            return redirect()->route('units.index')->with('success', 'Unit created successfully.');
        } else {
            if (File::exists(public_path('images/units/' . $request->image))) {
                File::delete(public_path('images/units/' . $request->image));
            }
            return redirect()->route('units.index')->with('error', 'Unit creation failed.');
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

        $extUserID = Units::where('id', decrypt($id))->first()->user_id;

        if ($extUserID != $request->user_id) {
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

        $request = array_filter($request->all());

        $unit = Units::find(decrypt($id));
        $unit->update($request);

        if ($unit) {
            return redirect()->route('units.index')->with('success', 'Unit updated successfully.');
        } else {
            return redirect()->route('units.index')->with('error', 'Unit update failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $checkItems = Items_units::where('unit_id', $id)->exists();
        $checkRooms = Rooms::where('unit_id', $id)->exists();

        if ($checkItems) {
            return response()->json(['error' => 'There are still items on the unit.']);
        }

        if ($checkRooms) {
            return response()->json(['error' => 'There are still rooms on the unit.']);
        }

        $unit = Units::find($id);
        $unit->delete();

        if ($unit) {
            return response()->json(['success' => 'Unit deleted successfully.']);
        } else {
            return response()->json(['error' => 'Unit deletion failed.']);
        }
    }
}
