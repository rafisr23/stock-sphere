<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Units;
use App\Models\Items_units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('items.create');
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
            'image' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('images/items'), $image_name);

            $item = Items::create([
                'item_name' => $request['item_name'],
                'item_description' => $request['item_description'],
                'downtime' => $request['downtime'],
                'modality' => $request['modality'],
                'image' => $image_name,
            ]);
        }

        if ($item) {
            return redirect()->route('items.index')->with('success', 'Item created successfully.');
        }

        return redirect()->route('items.index')->with('error', 'Item not created.');
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
        $request->validate([
            'item_name' => 'required',
            'item_description' => 'required',
            'downtime' => 'required',
            'modality' => 'required',
        ]);

        $item = Items::where('id', $id)->first();
        $item->update([
            'item_name' => $request['item_name'],
            'item_description' => $request['item_description'],
            'downtime' => $request['downtime'],
            'modality' => $request['modality'],
        ]);

        if ($request->hasFile('image')) {
            $old_image = public_path('images/items/' . $item->image);
            if (file_exists($old_image)) {
                unlink($old_image);
            }
            $image = $request->file('image');
            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('images/items'), $image_name);
            $item->update([
                'image' => $image_name,
            ]);
        }

        if ($item) {
            return redirect()->route('items.index')->with('success', 'Item updated successfully.');
        }
        return redirect()->route('items.index')->with('error', 'Item not updated.');
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
            if ($item->delete()) {
                return response()->json(['success' => 'Item deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Item not deleted.']);
    }
}