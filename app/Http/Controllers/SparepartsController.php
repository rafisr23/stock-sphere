<?php

namespace App\Http\Controllers;

use App\Models\Spareparts;
use App\Http\Requests\StoreSparepartsRequest;
use App\Http\Requests\UpdateSparepartsRequest;
use App\Models\Items;

class SparepartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $sparepart = Spareparts::all();
            return datatables()->of($sparepart)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . route('spareparts.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('spareparts.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('spareparts.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = Items::all();
        return view('spareparts.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSparepartsRequest $request)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'serial_no'=>'required',
            'item_id'=>'nullable',
            'is_generic'=>'required|in:0,1',
        ]);

        $spareparts = Spareparts::create([
            'name' => $request->name,
            'description' => $request->description,
            'serial_no' => $request->serial_no,
            'item_id' => $request->item_id ? decrypt($request->item_id) : null,
            'is_generic' => $request->is_generic,
        ]);

        if ($spareparts) {
            createLog(6, $spareparts->id, 'Create', );
            return redirect()->route('spareparts.index')->with('success', 'Sparepart created successfully');
        } else {
            return redirect()->route('spareparts.index')->with('error', 'Failed to create sparepart');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sparepart = Spareparts::find(decrypt($id));
        return view('spareparts.show', compact('sparepart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sparepart = Spareparts::find(decrypt($id));
        $id_enc = encrypt($sparepart->id);

        $item = Items::all();
        return view('spareparts.edit', compact( 'item', 'id_enc', 'sparepart'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSparepartsRequest $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required',
            'serial_no'=>'required',
            'item_id'=>'nullable',
            'is_generic'=>'required|in:0,1',
        ]);

        $spareparts = Spareparts::find(decrypt($id));
        $oldSpareparts = $spareparts->toJson();
        $spareparts->update([
            'name' => $request->name,
            'description' => $request->description,
            'serial_no' => $request->serial_no,
            'item_id' => decrypt($request->item_id),
            'is_generic' => $request->is_generic,
        ]);

        if ($spareparts) {
            createLog(6, $spareparts->id, 'Update', null, $oldSpareparts);
            return redirect()->route('spareparts.index')->with('success', 'Sparepart updated successfully');
        } else {
            return redirect()->route('spareparts.index')->with('error', 'Failed to update sparepart');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = decrypt($id);
        $spareparts = Spareparts::find($id);
        createLog(6, $spareparts->id, 'Delete',null, $spareparts->toJson());
        $spareparts->delete();

        if ($spareparts) {
            return response()->json(['success' => 'Sparepart deleted successfully',]);
        } else {
            return response()->json(['success' => 'Failed to delete sparepart',]);
        }
    }
}
