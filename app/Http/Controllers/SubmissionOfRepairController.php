<?php

namespace App\Http\Controllers;

use App\Models\Items_units;
use Illuminate\Http\Request;
use App\Models\SubmissionOfRepair;
use App\Models\DetailsOfRepairSubmission;
use Illuminate\Support\Facades\DB;

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
                    return '<input type="checkbox" class="select-row form-check-input" value="' . $row->id . '" name="itemId[]">';
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

    public function getItems(Request $request) {
        if ($request->get('id') == null || $request->get('id') == '') {
            $items_units = [];
        } else {
            $items_units = Items_units::whereIn('id', $request->get('id'))->with('items')->get();
        }


        return datatables()->of($items_units)
            ->addIndexColumn()
            ->addColumn('items_name', function ($row) {
                return $row->items->item_name;
            })
            ->addColumn('serial_number', function ($row) {
                return $row->serial_number;
            })
            ->addColumn('description', function ($row) {
                $desc = '
                    <textarea type="text" name="description[]" rows="4" class="form-control" id="description[' . $row->id . ']" placeholder="Enter repair description for ' . $row->items->item_name . '"></textarea>
                ';
                
                return $desc;
            })
            ->addColumn('evidence', function ($row) {
                $evidence = '
                    <input type="file" name="evidence[' . $row->id . ']" class="form-control" id="evidence[' . $row->id . ']" placeholder="Upload evidence for ' . $row->items->item_name . '">
                ';

                return $evidence;
            })
            ->rawColumns(['description', 'evidence'])
            ->make(true);
    }

    
    public function storeTemporaryFile(Request $request) {
        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $fileName = time() . '_temp_' . $file->getClientOriginalName();
            $file->move(public_path('temp'), $fileName);
            
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'File has been uploaded successfully!', 
                'fileName' => $fileName
            ]);
        }
    }
    
    public function store(Request $request) {
        // return $request->all();

        DB::beginTransaction();

        try {
            $submissionOfRepair = SubmissionOfRepair::create([
                'unit_id' => auth()->user()->unit->id ?? 1,
                'status' => 0,
                'description' => '',
                'date_submitted' => date('Y-m-d H:i:s')
            ]);
    
            $itemUnitId = explode(',', $request->items);
    
            foreach ($itemUnitId as $key => $value) {
                // if ($key == 0) continue;
                // return $request->evidence[$value] . ' - ' . $request->description[$value];
    
                $item = Items_units::find($value);
                $evidence = str_replace('_temp_', '_', $request->evidence[$value]);
                $submissionOfRepair->details()->create([
                    'submission_of_repair_id' => $submissionOfRepair->id,
                    'item_unit_id' => $item->id,
                    'description' => $request->description[$value],
                    'evidence' => $evidence,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Your submission has been saved successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}