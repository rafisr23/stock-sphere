<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Http\Requests\StoreRoomsRequest;
use App\Http\Requests\UpdateRoomsRequest;
use App\Models\User;
use App\Models\Units;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $room = Rooms::all();
            return datatables()->of($room)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . route('rooms.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('rooms.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
                    $btn .= '</div>';
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
        $hospital = Units::all();
        return view('rooms.create', compact('user', 'hospital'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomsRequest $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'serial_no' => 'required',
                'unit_id' => 'required',
                'user_id' => 'required',
            ]);

            $rooms = Rooms::create([
                'name' => $request->name,
                'description' => $request->description,
                'serial_no' => $request->serial_no,
                'unit_id' => decrypt($request->unit_id),
                'user_id' => decrypt($request->user_id),
            ]);
            if ($rooms) {
                createLog(4, $rooms->id, 'create new room');
                return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
            } else {
                return redirect()->route('rooms.index')->with('error', 'Room creation failed.');
            }
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')->with('error', 'Room creation failed.');
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
        $hospital = Units::all();

        return view('rooms.edit', compact('room', 'id_enc', 'user', 'hospital'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomsRequest $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'serial_no' => 'required',
            'unit_id' => 'required',
            'user_id' => 'required',
        ]);

        $request = array_filter($request->all());;

        $room = Rooms::find(decrypt($id));
        $oldRoom = $room->toJson();
        $room->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'serial_no' => $request['serial_no'],
            'unit_id' => decrypt($request['unit_id']),
            'user_id' => decrypt($request['user_id']),
        ]);

        if ($room) {
            createLog(4, $room->id, 'update room', null, $oldRoom);
            return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
        } else {
            return redirect()->route('rooms.index')->with('error', 'Room update failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = decrypt($id);

        $room = Rooms::find($id);
        createLog(4, $room->id, 'delete room', null, $room->toJson());
        $room->delete();

        if ($room) {
            $return = response()->json(['success' => 'Room deleted successfully.']);
        } else {
            $return = response()->json(['error' => 'Room deletion failed.']);
        }

        return $return;
    }
}
