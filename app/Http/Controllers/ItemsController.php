<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Units;
use App\Models\Items_units;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $items = Items::all();
            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('items.show', $row->id) . '" class="view btn btn-info btn-sm me-2"><i class="ph-duotone ph-eye"></i></a>';
                    $btn = $btn . '<a href="' . route('items.edit', $row->id) . '" class="edit btn btn-warning btn-sm me-2"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn = $btn . '<a href="#" class="delete btn btn-danger btn-sm"  data-id="' . $row->id . '"><i class="ph-duotone ph-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('items.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Units::all();
        return view('items.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'item_description' => 'required',
            'downtime' => 'required',
            'modality' => 'required',
            'serial_number' => 'required',
            'software_version' => 'required',
            'installation_date' => 'required',
            'contract' => 'required',
            'end_of_service' => 'required',
            'unit_id' => 'required',
            'srs_status' => 'required',
            'last_checked_date' => 'required',
        ]);

        $item = Items::create([
            'item_name' => $request['item_name'],
            'item_description' => $request['item_description'],
            'downtime' => $request['downtime'],
            'modality' => $request['modality'],
        ]);

        if ($item) {
            $newItem = Items::latest()->first();
            $itemUnits = Items_units::create([
                'item_id' => $newItem->id,
                'unit_id' => $request['unit_id'],
                'serial_number' => $request['serial_number'],
                'software_version' => $request['software_version'],
                'installation_date' => $request['installation_date'],
                'contract' => $request['contract'],
                'end_of_service' => $request['end_of_service'],
                'srs_status' => $request['srs_status'],
                'last_checked_date' => $request['last_checked_date'],
            ]);
            if ($itemUnits) {
                return redirect()->route('items.index')->with('success', 'Item created successfully.');
            }
        }
        return redirect()->route('items.index')->with('error', 'Item not created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Items_units::find($id);
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Items_units::find($id);
        $units = Units::all();
        return view('items.edit', compact('item', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required',
            'item_description' => 'required',
            'downtime' => 'required',
            'modality' => 'required',
            'serial_number' => 'required',
            'software_version' => 'required',
            'installation_date' => 'required',
            'contract' => 'required',
            'end_of_service' => 'required',
            'unit_id' => 'required',
            'srs_status' => 'required',
            'last_checked_date' => 'required',
        ]);

        $itemUnits = Items_units::where('id', $id)->first();
        if ($request['srs_status'] == $itemUnits->srs_status) {
            $last_checked_date = $itemUnits->last_checked_date;
        } else {
            $last_checked_date = $request['last_checked_date'];
        }
        $item = Items::where('id', $itemUnits->item_id)->first();
        $item->update([
            'item_name' => $request['item_name'],
            'item_description' => $request['item_description'],
            'downtime' => $request['downtime'],
            'modality' => $request['modality'],
        ]);

        if ($item) {
            $itemUnits->update([
                'unit_id' => $request['unit_id'],
                'serial_number' => $request['serial_number'],
                'software_version' => $request['software_version'],
                'installation_date' => $request['installation_date'],
                'contract' => $request['contract'],
                'end_of_service' => $request['end_of_service'],
                'srs_status' => $request['srs_status'],
                'last_checked_date' => $last_checked_date,
            ]);
            if ($itemUnits) {
                return redirect()->route('items.index')->with('success', 'Item updated successfully.');
            }
        }
        return redirect()->route('items.index')->with('error', 'Item not updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $itemUnit = Items_units::where('id', $request['id'])->first();
        $item = Items::where('id', $itemUnit->item_id)->first();
        if ($itemUnit->delete()) {
            if ($item->delete()) {
                return response()->json(['success' => 'Item deleted successfully.']);
            }
        }

        return response()->json(['error' => 'Item not deleted.']);
    }
}