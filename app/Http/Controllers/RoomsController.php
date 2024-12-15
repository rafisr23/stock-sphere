<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rooms;
use App\Models\Units;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRoomsRequest;
use App\Http\Requests\UpdateRoomsRequest;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('superadmin')) {
                $room = Rooms::where('is_enabled', true)->get();
            } else {
                $room = Rooms::where('user_id', auth()->user()->id)->where('is_enabled', true)->get();
            }
            return datatables()->of($room)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . route('rooms.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('rooms.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';

                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 4,
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

                    $btn .= $showLogBtn . '</div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('rooms.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'room');
        })->get();
        $hospital = Units::where('is_enabled', true)->get();
        return view('rooms.create', compact('user', 'hospital'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomsRequest $request)
    {
        DB::beginTransaction();

        try {
            $request = array_filter($request->all());
            $rooms = Rooms::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'serial_no' => $request['serial_no'],
                'unit_id' => decrypt($request['unit_id'][1]),
                'user_id' => decrypt($request['user_id']),
            ]);

            $unit = Units::find(decrypt($request['unit_id'][1]));

            $log = [
                'norec' => $rooms->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 4,
                'is_generic' => true,
                'desc' => 'Create a new room: ' . $rooms->name . ' in ' . $unit->customer_name . ' by ' . auth()->user()->name,
            ];

            createLog($log);
            DB::commit();

            return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('rooms.index')->with('error', 'Room creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = Rooms::find(decrypt($id));
        $hospital = Units::all();
        return view('rooms.show', compact('room', 'hospital'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Rooms::find(decrypt($id));
        $id_enc = encrypt($room->id);

        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'room');
        })->get();
        $hospital = Units::where('is_enabled', true)->get();

        return view('rooms.edit', compact('room', 'id_enc', 'user', 'hospital'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomsRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $request = array_filter($request->all());
            $room = Rooms::find(decrypt($id));
            $oldRoom = $room->toJson();
            $room->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'serial_no' => $request['serial_no'],
                'unit_id' => decrypt($request['unit_id']),
                'user_id' => decrypt($request['user_id']),
            ]);

            $unit = Units::find(decrypt($request['unit_id']));

            $log = [
                'norec' => $room->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 4,
                'is_generic' => true,
                'desc' => 'Update room: ' . $room->name . ' in ' . $unit->customer_name . ' by ' . auth()->user()->name,
                'old_data' => $oldRoom,
            ];

            createLog($log);
            DB::commit();

            return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('rooms.index')->with('error', 'Room update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $room = Rooms::find(decrypt($id));
            $oldRoom = $room->toJson();
            $room->is_enabled = false;
            $room->save();

            $log = [
                'norec' => $room->norec,
                'module_id' => 4,
                'is_generic' => true,
                'desc' => 'Delete room: ' . $room->name . ' in ' . $room->units->customer_name . ' by ' . auth()->user()->name,
                'old_data' => $oldRoom,
            ];

            createLog($log);
            DB::commit();

            return response()->json([
                'success' => 'Room deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Room deletion failed: ' . $e->getMessage(),
            ]);
        }
    }
}