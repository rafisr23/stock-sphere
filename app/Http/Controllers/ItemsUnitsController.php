<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Units;
use App\Models\Items_units;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('room')) {
            $rooms = Rooms::where('user_id', auth()->user()->id)->where('is_enabled', true)->get();
            if ($rooms->isEmpty()) {
                return redirect()->back()->with('error', 'Your account is not assigned to any room.');
            }
            $items_units = Items_units::where('room_id', auth()->user()->room->id)->where('is_enabled', true)->get();
        } elseif (auth()->user()->hasRole('unit')) {
            $units = Units::where('user_id', auth()->user()->id)->where('is_enabled', true)->get();
            if ($units->isEmpty()) {
                return redirect()->back()->with('error', 'Your account is not assigned to any unit.');
            }
            // get rooms where the unit_id is equal to the unit_id of the authenticated user
            $rooms = Rooms::where('unit_id', auth()->user()->unit->id)->where('is_enabled', true)->get();
            $items_units = Items_units::whereIn('room_id', $rooms->pluck('id'))->where('is_enabled', true)->get();
        } else {
            $items_units = Items_units::where('is_enabled', true)->get();
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
                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 7,
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
        } else {
            return view('items_units.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Items::where('is_enabled', true)->get();
        if (auth()->user()->hasRole('room')) {
            $rooms = Rooms::where('id', auth()->user()->room->id)->where('is_enabled', true)->get();
        } elseif (auth()->user()->hasRole('unit')) {
            $rooms = Rooms::where('unit_id', auth()->user()->unit->id)->where('is_enabled', true)->get();
        } else {
            $rooms = Rooms::where('is_enabled', true)->get();
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

        DB::beginTransaction();
        try {
            foreach ($request['item_id'] as $key => $value) {
                $item = Items::find($value);
                $maintenance_date = date('Y-m-d', strtotime($request['installation_date']) + ($item->downtime * 86400));

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
                    'maintenance_date' => $maintenance_date,
                ]);
                $log = [
                    'norec' => $items_units->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 7,
                    'is_generic' => true,
                    'desc' => 'Assign item: ' . $items_units->items->item_name . ' to room: ' . $items_units->rooms->name . ' by ' . auth()->user()->name,
                ];
                createLog($log);
            }
            DB::commit();
            return redirect()->route('items_units.index')->with('success', 'Items added successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('items_units.index')->with('error', 'Items not added.');
        }
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
        $items = Items::where('is_enabled', true)->get();
        if (auth()->user()->hasRole('room')) {
            $rooms = Rooms::where('id', auth()->user()->room->id)->where('is_enabled', true)->get();
        } elseif (auth()->user()->hasRole('unit')) {
            $rooms = Rooms::where('unit_id', auth()->user()->unit->id)->where('is_enabled', true)->get();
        } else {
            $rooms = Rooms::where('is_enabled', true)->get();
        }
        return view('items_units.edit', compact('item_unit', 'rooms', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $itemUnits = Items_units::where('id', $id)->first();
        $oldItemUnits = $itemUnits->toJson();

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


        if ($request['srs_status'] == $itemUnits->srs_status) {
            $last_checked_date = $itemUnits->last_checked_date;
        } else {
            $last_checked_date = $request['last_checked_date'];
        }

        $maintenance_date = $request->installation_date != $itemUnits->installation_date
            ? date('Y-m-d', strtotime($request['installation_date']) + ($itemUnits->items->downtime * 86400))
            : $itemUnits->maintenance_date;

        DB::beginTransaction();
        try {
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
                'maintenance_date' => $maintenance_date,
            ]);
            $log = [
                'norec' => $itemUnits->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 7,
                'is_generic' => true,
                'desc' => 'Update item: ' . $itemUnits->items->item_name . ' for room: ' . $itemUnits->rooms->name . ' by ' . auth()->user()->name,
                'old_data' => $oldItemUnits,
            ];
            createLog($log);
            DB::commit();

            return redirect()->route('items_units.index')->with('success', 'Item updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('items_units.index')->with('error', 'Item not updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $item = Items_units::find(decrypt($request->id));
        $oldItem = $item->toJson();
        $log = [
            'norec' => $item->norec,
            'norec_parent' => auth()->user()->norec,
            'module_id' => 7,
            'is_generic' => true,
            'desc' => 'Delete item: ' . $item->items->item_name . ' from room: ' . $item->rooms->name . ' by ' . auth()->user()->name,
            'old_data' => $oldItem,
        ];
        createLog($log);
        $soft_delete = $item->update(['is_enabled' => false]);
        if ($soft_delete) {
            return response()->json(['success' => true, 'message' => 'Item deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Item not deleted.']);
        }
    }
}
