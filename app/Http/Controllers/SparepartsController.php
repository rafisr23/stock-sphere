<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Spareparts;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSparepartsRequest;
use App\Http\Requests\UpdateSparepartsRequest;

class SparepartsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            // if (auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('technician')) {
            // } else {
            //     $sparepart = Spareparts::where('user_id', auth()->user()->id)->get();
            // }
            $sparepart = Spareparts::where('is_enabled', true)->get();
            return datatables()->of($sparepart)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . route('spareparts.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('spareparts.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';

                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 6,
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

        DB::beginTransaction();

        try {
            $spareparts = Spareparts::create([
                'name' => $request->name,
                'description' => $request->description,
                'serial_no' => $request->serial_no,
                'item_id' => $request->item_id ? decrypt($request->item_id) : null,
                'is_generic' => $request->is_generic,
            ]);

            if ($request->item_id != null) {
                $items = Items::find(decrypt($request->item_id));
            }

            $desc = $spareparts->item_id ? 'Create a new sparepart: ' . $spareparts->name . ' for item: ' . $items->item_name . ' by ' . auth()->user()->name : 'Create a new generic sparepart: ' . $spareparts->name . ' by ' . auth()->user()->name; 

            $log = [
                'norec' => $spareparts->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 6,
                'is_generic' => true,
                'desc' => $desc,
            ];

            createLog($log);
            DB::commit();
            return redirect()->route('spareparts.index')->with('success', 'Sparepart created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('spareparts.index')->with('error', 'Failed to create sparepart: ' . $e->getMessage());
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
        DB::beginTransaction();

        try {
            $spareparts = Spareparts::find(decrypt($id));
            $oldSpareparts = $spareparts->toJson();
            $spareparts->update([
                'name' => $request->name,
                'description' => $request->description,
                'serial_no' => $request->serial_no,
                'item_id' => $request->item_id ? decrypt($request->item_id) : null,
                'is_generic' => $request->is_generic,
            ]);

            if ($request->item_id != null) {
                $items = Items::find(decrypt($request->item_id));
            }

            $desc = $spareparts->item_id ? 'Update sparepart: ' . $spareparts->name . ' for item: ' . $items->item_name . ' by ' . auth()->user()->name : 'Update generic sparepart: ' . $spareparts->name . ' by ' . auth()->user()->name; 

            $log = [
                'norec' => $spareparts->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 6,
                'is_generic' => true,
                'desc' => $desc,
                'old_data' => $oldSpareparts,
            ];

            createLog($log);
            DB::commit();
            return redirect()->route('spareparts.index')->with('success', 'Sparepart updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('spareparts.index')->with('error', 'Failed to update sparepart: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $spareparts = Spareparts::find(decrypt($id));
            $oldSpareparts = $spareparts->toJson();
            $spareparts->is_enabled = false;
            $spareparts->save();

            if ($spareparts->item_id != null) {
                $items = Items::find($spareparts->item_id);
            }

            $desc = $spareparts->item_id ? 'Delete sparepart: ' . $spareparts->name . ' for item: ' . $items->item_name . ' by ' . auth()->user()->name : 'Delete generic sparepart: ' . $spareparts->name . ' by ' . auth()->user()->name; 

            $log = [
                'norec' => $spareparts->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 6,
                'is_generic' => true,
                'desc' => $desc,
                'old_data' => $oldSpareparts,
            ];

            createLog($log);
            DB::commit();
            return response()->json([
                'success' => 'Sparepart deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to delete sparepart: ' . $e->getMessage(),
            ]);
        }
    }
}