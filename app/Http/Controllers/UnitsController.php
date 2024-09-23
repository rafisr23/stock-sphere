<?php

namespace App\Http\Controllers;

use App\Models\Units;
use App\Http\Requests\StoreUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use App\Models\Items_units;
use Illuminate\Http\Request;

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
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'city' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
        ]);

        $unit = Units::create($request->all());

        if ($unit) {
            return redirect()->route('units.index')->with('success', 'Unit created successfully.');
        } else {
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
        return view('units.edit', compact('unit', 'id_enc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required',
            'city' => 'required',
            'street' => 'required',
            'postal_code' => 'required',
        ]);

        $unit = Units::find(decrypt($id));
        $unit->update($request->all());

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
        $checkUnit = Items_units::where('unit_id', $id)->exists();

        if ($checkUnit) {
            $return = response()->json(['error' => 'There are still items on the unit.']);
        } else {
            $unit = Units::find($id);
            $unit->delete();

            if ($unit) {
                $return = response()->json(['success' => 'Unit deleted successfully.']);
            } else {
                $return = response()->json(['error' => 'Unit deletion failed.']);
            }
        }

        return $return;
    }
}
