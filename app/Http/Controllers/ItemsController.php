<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Units;
use App\Models\Items_units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('unit')) {
                $itemUnits = Items_units::where('unit_id', auth()->user()->unit->id)->where('is_enabled', true)->get();
                $items = Items::whereIn('id', $itemUnits->pluck('item_id'))->where('is_enabled', true)->get();
            } else {
                $items = Items::where('is_enabled', true)->get();
            }
            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('items.show', $row->id) . '" class="view btn btn-info btn-sm me-2"><i class="ph-duotone ph-eye"></i></a>';
                    $btn = $btn . '<a href="' . route('items.edit', $row->id) . '" class="edit btn btn-warning btn-sm me-2"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn = $btn . '<a href="#" class="delete btn btn-danger btn-sm me-2"  data-id="' . $row->id . '"><i class="ph-duotone ph-trash"></i></a>';
                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 1,
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
                    $btn = $btn . $showLogBtn;
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
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
            'item_description' => 'required',
            // 'downtime' => 'required',
            'modality' => 'required',
            'distributor' => 'required',
            'merk' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $item = Items::create($request->all());
            $log = [
                'norec' => $item->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 1,
                'is_generic' => true,
                'desc' => 'Create a new item: ' . $item->item_name . ' with description: ' . $item->item_description . ' by ' . auth()->user()->name,
            ];
            createLog($log);
            DB::commit();
            return redirect()->route('items.index')->with('success', 'Item created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (File::exists(public_path('images/items/' . $request->image))) {
                File::delete(public_path('images/items/' . $request->image));
            }
            return redirect()->route('items.index')->with('error', 'Item creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Items::find($id);
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Items::find($id);
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item = Items::where('id', $id)->first();
        $oldItem = $item->toJson();

        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
            'item_description' => 'required',
            // 'downtime' => 'required',
            'modality' => 'required',
            'distributor' => 'required',
            'merk' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            if (File::exists(public_path('images/items/' . $request->image))) {
                File::delete(public_path('images/items/' . $request->image));
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $item->update($request->all());
            $log = [
                'norec' => $item->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 1,
                'is_generic' => true,
                'desc' => 'Update item data: ' . $item->item_name . ' with description: ' . $item->item_description . ' by ' . auth()->user()->name,
                'old_data' => $oldItem,
            ];
            createLog($log);
            DB::commit();
            return redirect()->route('items.index')->with('success', 'Item updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            if (File::exists(public_path('images/items/' . $request->image))) {
                File::delete(public_path('images/items/' . $request->image));
            }
            return redirect()->route('items.index')->with('error', 'Item update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $item = Items::where('id', $request->id)->first();
        $oldItem = $item->toJson();
        $checkItem = Items_units::where('item_id', $request->id)->exists();
        if ($checkItem) {
            return response()->json(['error' => 'Item is assign in Units Items table.']);
        } else {
            $old_image = public_path('images/items/' . $item->image);
            if (file_exists($old_image)) {
                unlink($old_image);
            }
            $log = [
                'norec' => $item->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 1,
                'is_generic' => true,
                'desc' => 'Delete item: ' . $item->item_name . ' with description: ' . $item->item_description . ' by ' . auth()->user()->name,
                'old_data' => $oldItem,
            ];
            createLog($log);
            $soft_delete = $item->update(['is_enabled' => false]);
            if ($soft_delete) {
                return response()->json(['success' => 'Item deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Item not deleted.']);
    }
}