<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = Vendor::all();
            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name ?? '-';
                })
                ->addColumn('email', function ($row) {
                    return $row->email ?? '-';
                })
                ->addColumn('province', function ($row) {
                    return $row->province ?? '-';
                })
                ->addColumn('city', function ($row) {
                    return $row->city ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('vendor.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('vendor.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2"><i class="ph-duotone ph-pen"></i></a>';
                    $btn .= '<button type="button" class="delete btn btn-danger btn-sm" data-id="' . $row->id . '"><i class="ph-duotone ph-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 
        
        return view('vendor.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}