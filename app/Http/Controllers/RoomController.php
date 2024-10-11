<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\User;
use App\Models\Items_units;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $room = Room::all();
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
        return view('rooms.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'unit_id'=>'required',
        ]);

        if ($request->has('user_id') && $request->user_id != null){
            $request['user_id'] = decrypt($request->user_id);

            $checkID = Room::where('user_id', $request->user_id)->exists();

            if ($checkID) {
                return redirect()->back()->with('error', 'The user has already been assigned to another unit.');
            }
        }

        $unit = Room::create($request->all());

        if ($unit) {
            return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
        } else {
            return redirect()->route('rooms.index')->with('error', 'Room creation failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $room = Room::find(decrypt($id));
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Room::find(decrypt($id));
        $id_enc = encrypt($room->id);

        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'room');
        })->get();

        return view('rooms.edit', compact('room', 'id_enc', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'unit_id'=>'required',
        ]);

        if ($request->has('user_id') && $request->user_id != null){
            $request['user_id'] = decrypt($request->user_id);

            $checkID = Room::where('user_id', $request->user_id)->exists();

            if ($checkID) {
                return redirect()->back()->with('error', 'The user has already been assigned to another unit.');
            }
        }

        $request = array_filter($request->all());

        $room = Room::find(decrypt($id));
        $room->update($request);

        if ($room) {
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

        $room = Room::find($id);
        $room->delete();

        if ($room) {
            $return = response()->json(['success' => 'Room deleted successfully.']);
        } else {
            $return = response()->json(['error' => 'Room deletion failed.']);
        }

        return $return;
    }
}
