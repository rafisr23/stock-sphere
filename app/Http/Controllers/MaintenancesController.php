<?php

namespace App\Http\Controllers;

use App\Models\Items_units;
use App\Models\Maintenances;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class MaintenancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $type = $request->input('type');
            $filter = $request->input('filter');

            $loginDate = Carbon::parse(auth()->user()->last_login_date)->format('Y-m-d');

            if ($type == 'list') {
                if ($filter == '1') {
                    $endDate = Carbon::parse($loginDate)->addMonth()->format('Y-m-d');

                    $maintenances = Items_units::where('maintenance_date', '>=', $loginDate)
                        ->where('maintenance_date', '<=', $endDate)
                        ->get();
                } else if ($filter == '3') {
                    $endDate = Carbon::parse($loginDate)->addMonth(3)->format('Y-m-d');

                    $maintenances = Items_units::where('maintenance_date', '>=', $loginDate)
                        ->where('maintenance_date', '<=', $endDate)
                        ->get();
                } else {
                    $maintenances = Items_units::all();
                }

                $maintenances = $maintenances->sortBy('maintenance_date');

                return DataTables::of($maintenances)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($row) use ($loginDate) {
                        if ($loginDate == $row->maintenance_date) {
                            return '<input type="checkbox" class="select-row form-check-input" value="' . encrypt($row->id) . '" name="itemId[]">';
                        } else {
                            return '<span class="badge rounded-pill text-bg-info">Not Today</span>';
                        }
                    })
                    ->addColumn('item', function ($row) {
                        return $row->items->item_name;
                    })
                    ->addColumn('room', function ($row) {
                        return $row->rooms->name;
                    })
                    ->addColumn('serial_number', function ($row) {
                        return $row->serial_number;
                    })
                    ->addColumn('maintenance_date', function ($row) {
                        return Carbon::parse($row->maintenance_date)->isoFormat('D MMMM Y');
                    })
                    ->rawColumns(['checkbox'])
                    ->make(true);
            } else {
                $maintenances = Maintenances::all();
            }
        } else {
            return view('maintenances.index');
        }
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
    public function show(Maintenances $maintenances)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenances $maintenances)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maintenances $maintenances)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenances $maintenances)
    {
        //
    }
}
