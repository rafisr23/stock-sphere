<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items_units;

class SubmissionOfRepairController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            $items_units = auth()->user()->hasRole('unit') 
                ? Items_units::where('unit_id', auth()->user()->unit->id)->get() 
                : Items_units::all();
            return datatables()->of($items_units)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="select-row form-check-input" value="' . $row->id . '">';
                })
                ->addColumn('items_name', function ($row) {
                    return $row->items->item_name;
                })
                ->addColumn('units_name', function ($row) {
                    return $row->units->customer_name ?? '-';
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->serial_number;
                })
                ->addColumn('last_checked_date', function ($row) {
                    return date('d M Y H:i:s', strtotime($row->last_checked_date));
                })
                ->addColumn('last_serviced_date', function ($row) {
                    return $row->last_serviced_date != '' || $row->last_serviced_date != null ? date('d M Y H:i:s', strtotime($row->last_serviced_date)) : '-';
                })
                ->addColumn('contract', function ($row) {
                    return $row->contract;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . route('items_units.show', $row->id) . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    $btn .= '<a href="' . route('items_units.edit', $row->id) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
    
        return view('submission.index');
    }
}