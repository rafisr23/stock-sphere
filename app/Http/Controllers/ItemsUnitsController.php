<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Units;
use App\Models\Items_units;
use App\Models\Rooms;
use Illuminate\Http\Request;

class ItemsUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('room')) {
            $rooms = Rooms::where('id', auth()->user()->id)->get();
            if ($rooms->isEmpty()) {
                return redirect()->back()->with('error', 'Your account is not assigned to any room.');
            }
            $items_units = Items_units::where('room_id', auth()->user()->room->id)->get();
        } elseif (auth()->user()->hasRole('unit')) {
            $units = Units::where('id', auth()->user()->id)->get();
            if ($units->isEmpty()) {
                return redirect()->back()->with('error', 'Your account is not assigned to any unit.');
            }
            $items_units = Items_units::whereIn('unit_id', auth()->user()->unit->id)->get();
        } else {
            $items_units = Items_units::all();
        }
        if (request()->ajax()) {
            return datatables()->of($items_units)
                ->addIndexColumn()
                ->addColumn('items_name', function ($row) {
                    return $row->items->item_name;
                })
                ->addColumn('rooms_name', function ($row) {
                    return $row->rooms->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . route('items_units.show', $row->id) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('items_units.edit', $row->id) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
                    $showLogBtn =
                        "<a href='#'class='btn btn-sm btn-secondary' data-bs-toggle='modal'
                    data-bs-target='#exampleModal'
                    data-title='Detail Log' data-bs-tooltip='tooltip'
                    data-remote=" . route('log.getLog', ['moduleCode' => 7, 'moduleId' => $row->id, 'itemId' => $row->id]) . "
                    title='Log Information'>
                    <i class='ph-duotone ph-info'></i>
                        </a></div>
                        ";

                    $btn = $btn . $showLogBtn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('items_units.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Items::all();
        if (auth()->user()->hasRole('room')) {
            $rooms = Rooms::where('id', auth()->user()->room->id)->get();

        } elseif (auth()->user()->hasRole('unit')) {
            $rooms = Rooms::where('unit_id', auth()->user()->unit->id)->get();
        } else {
            $rooms = Rooms::all();
        }
        return view('items_units.create', compact('items', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'room_id' => 'required',
            'serial_number' => 'required',
            'software_version' => 'required',
            'functional_location_no' => 'required',
            'installation_date' => 'required',
            'contract' => 'required',
            'end_of_service' => 'required',
            'srs_status' => 'required',
            'status' => 'required|in:Running,System Down,Restricted',
            'last_checked_date' => 'required',
        ]);

        foreach ($request['item_id'] as $key => $value) {
            $items_units = Items_units::create([
                'item_id' => $value,
                'room_id' => $request['room_id'],
                'serial_number' => $request['serial_number'],
                'software_version' => $request['software_version'],
                'functional_location_no' => $request['functional_location_no'],
                'installation_date' => $request['installation_date'],
                'contract' => $request['contract'],
                'end_of_service' => $request['end_of_service'],
                'srs_status' => $request['srs_status'],
                'status' => $request['status'],
                'last_checked_date' => $request['last_checked_date'],
            ]);
            createLog(7, $items_units->id, 'create a new items room');
        }
        return redirect()->route('items_units.index')->with('success', 'Items added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Items_units::find($id);
        return view('items_units.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item_unit = Items_units::find($id);
        $items = Items::all();
        if (auth()->user()->hasRole('room')) {
            $rooms = Rooms::where('id', auth()->user()->room->id)->get();
        } elseif (auth()->user()->hasRole('unit')) {
            $rooms = Rooms::where('unit_id', auth()->user()->unit->id)->get();
        } else {
            $rooms = Rooms::all();
        }
        return view('items_units.edit', compact('item_unit', 'rooms', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_id' => 'required',
            'room_id' => 'required',
            'serial_number' => 'required',
            'software_version' => 'required',
            'functional_location_no' => 'required',
            'installation_date' => 'required',
            'contract' => 'required',
            'end_of_service' => 'required',
            'srs_status' => 'required',
            'status' => 'required|in:Running,System Down,Restricted',
            'last_checked_date' => 'required',
        ]);

        $itemUnits = Items_units::where('id', $id)->first();
        $oldItemUnits = $itemUnits->toJson();
        if ($request['srs_status'] == $itemUnits->srs_status) {
            $last_checked_date = $itemUnits->last_checked_date;
        } else {
            $last_checked_date = $request['last_checked_date'];
        }

        $itemUnits->update([
            'item_id' => $request['item_id'],
            'room_id' => $request['room_id'],
            'serial_number' => $request['serial_number'],
            'software_version' => $request['software_version'],
            'functional_location_no' => $request['functional_location_no'],
            'installation_date' => $request['installation_date'],
            'contract' => $request['contract'],
            'end_of_service' => $request['end_of_service'],
            'srs_status' => $request['srs_status'],
            'status' => $request['status'],
            'last_checked_date' => $last_checked_date,
        ]);

        createLog(7, $itemUnits->id, 'update items room', null, $oldItemUnits);

        if ($itemUnits) {
            return redirect()->route('items_units.index')->with('success', 'Item updated successfully.');
        }
        return redirect()->route('items_units.index')->with('error', 'Item not updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $item = Items_units::find(decrypt($request->id));
        createLog(7, $item->id, 'delete items room', $item->toJson());
        if ($item->delete()) {
            return response()->json(['success' => 'Item deleted successfully.']);
        }
        return response()->json(['error' => 'Item not deleted.']);
    }
}