<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Units;
use App\Models\Items_units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('unit')) {
                $itemUnits = Items_units::where('unit_id', auth()->user()->unit->id)->get();
                $items = Items::whereIn('id', $itemUnits->pluck('item_id'))->get();
            } else {
                $items = Items::all();
            }
            return datatables()->of($items)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('items.show', $row->id) . '" class="view btn btn-info btn-sm me-2"><i class="ph-duotone ph-eye"></i></a>';
                    $btn = $btn . '<a href="' . route('items.edit', $row->id) . '" class="edit btn btn-warning btn-sm me-2"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn = $btn . '<a href="#" class="delete btn btn-danger btn-sm me-2"  data-id="' . $row->id . '"><i class="ph-duotone ph-trash"></i></a>';
                    $showLogBtn =
                        "<a href='#'class='btn btn-sm btn-secondary' data-bs-toggle='modal'
                    data-bs-target='#exampleModal'
                    data-title='Detail Log' data-bs-tooltip='tooltip'
                    data-remote=" . route('log.getLog', ['moduleCode' => 1, 'moduleId' => $row->id]) . "
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
            'downtime' => 'required',
            'modality' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = Items::create($request->all());

        createLog(1, $item->id, 'create a new item');

        if ($item) {
            return redirect()->route('items.index')->with('success', 'Item created successfully.');
        } else {
            if (File::exists(public_path('images/items/' . $request->image))) {
                File::delete(public_path('images/items/' . $request->image));
            }
            return redirect()->route('items.index')->with('error', 'Item creation failed.');
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
        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
            'item_description' => 'required',
            'downtime' => 'required',
            'modality' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            if (File::exists(public_path('images/items/' . $request->image))) {
                File::delete(public_path('images/items/' . $request->image));
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $item = Items::where('id', $id)->first();
        $oldItem = $item->toJson();

        $item->update($request->all());

        createLog(1, $item->id, 'update item data', null, $oldItem);

        if ($item) {
            return redirect()->route('items.index')->with('success', 'Item updated successfully.');
        } else {
            return redirect()->route('items.index')->with('error', 'Item update failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $item = Items::where('id', $request->id)->first();
        // check if item is used in items_units table
        $checkItem = Items_units::where('item_id', $request->id)->exists();
        if ($checkItem) {
            return response()->json(['error' => 'Item is assign in Units Items table.']);
        } else {
            $old_image = public_path('images/items/' . $item->image);
            if (file_exists($old_image)) {
                unlink($old_image);
            }
            createLog(1, $item->id, 'delete item data', $item->toJson());
            if ($item->delete()) {
                return response()->json(['success' => 'Item deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Item not deleted.']);
    }
}