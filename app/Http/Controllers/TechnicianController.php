<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Models\Units;
use App\Models\User;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
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
            'street' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'status' => 'required',
        ]);

        $technician = new Technician();
        $technician->name = $request->name;
        $technician->phone = $request->phone;
        $technician->street = $request->street;
        $technician->city = $request->city;
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
        return view('technicians.edit', compact('technician', 'users', 'selected_user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'street' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'status' => 'required',
        ]);

        $technician = Technician::find($id);
        $technician->name = $request->name;
        $technician->phone = $request->phone;
        $technician->street = $request->street;
        $technician->city = $request->city;
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
