<?php

namespace App\Http\Controllers;

use App\Models\Spareparts;
use App\Models\Items_units;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Models\SparepartsOfRepair;
use App\Models\SubmissionOfRepair;
use Illuminate\Support\Facades\DB;
use App\Models\DetailsOfRepairSubmission;

class DetailsOfRepairSubmissionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $table = request('table');
            if ($table === 'repairments') {
                if (auth()->user()->hasRole('technician')) {
                    $details_of_repair_submission = DetailsOfRepairSubmission::where('technician_id', auth()->user()->id)->get();
                } else {
                    $details_of_repair_submission = DetailsOfRepairSubmission::all();
                }
                $details_of_repair_submission = DetailsOfRepairSubmission::all();
                return datatables()->of($details_of_repair_submission)
                    ->addIndexColumn()
                    ->addColumn('items_name', function ($row) {
                        return $row->itemUnit->items->item_name;
                    })
                    ->addColumn('serial_number', function ($row) {
                        return $row->itemUnit->serial_number;
                    })
                    ->addColumn('created_at', function ($row) {
                        return $row->created_at->isoFormat('D MMMM Y');
                    })
                    ->addColumn('accepted', function ($row) {
                        $accepted = '<div class="d-flex justify-content-center align-items-center">';
                        if ($row->status == 1) {
                            $accepted .= '<span class="badge bg-info">On Progress</span>';
                        } elseif ($row->date_completed != null) {
                            $accepted .= '<span class="badge bg-primary">Completed</span>';
                        } elseif ($row->date_worked_on != null) {
                            $accepted .= '<span class="badge bg-success">Accepted</span>';
                        } elseif ($row->date_cancelled != null) {
                            $accepted .= '<span class="badge bg-danger">Canceled</span>';
                        } else {
                            $accepted .= '<span class="badge bg-warning">Waiting</span>';
                        }
                        $accepted .= '</div>';
                        return $accepted;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        $btn .= '<a href="' . route('repairments.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="Show data"><i class="ph-duotone ph-eye"></i></a>';
                        if ($row->date_worked_on == null && $row->date_cancelled == null && $row->status == 0) {
                            $btn .= '<a href="#" class="accept btn btn-success btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Accept Repairment"><i class="ph-duotone ph-check"></i></a>';
                            $btn .= '<a href="#" class="cancel btn btn-danger btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Cancel Repairment"><i class="ph-duotone ph-x"></i></a>';
                        }
                        if ($row->date_worked_on != null && $row->date_completed == null && $row->status == 0) {
                            $btn .= '<a href="#" class="start btn btn-secondary btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Start Repairing"><i class="ph-duotone ph-wrench"></i></a>';
                        }

                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'accepted'])
                    ->make(true);
            } elseif ($table === 'work-on') {
                $details_of_repair_submission = DetailsOfRepairSubmission::where('status', 1)->get();
                return datatables()->of($details_of_repair_submission)
                    ->addIndexColumn()
                    ->addColumn('items_name', function ($row) {
                        return $row->itemUnit->items->item_name;
                    })
                    ->addColumn('serial_number', function ($row) {
                        return $row->itemUnit->serial_number;
                    })
                    ->addColumn('status', function ($row) {
                        $statusOptions = ['Running', 'System Down', 'Restricted'];
                        $status = '<div class="btn-group mb-2 me-2 dropdown">';
                        $status .= '<select class="form-control" name="status" id="status" required>';

                        foreach ($statusOptions as $option) {
                            $selected = $row->itemUnit->status == $option ? 'selected' : '';
                            $status .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                        }

                        $status .= '</select>';
                        $status .= '</div>';
                        return $status;
                    })

                    ->addColumn('remark', function ($row) {
                        $remark = '<textarea type="text" name="remarks" rows="4" id="remarks" class="form-control" data-id="' . encrypt($row->id);
                        $remark .= '"placeholder="Enter repairment remark for ' . $row->itemUnit->items->item_name . '">';
                        $remark .= old('remarks', $row->remarks);
                        $remark .= '</textarea>';

                        return $remark;
                    })
                    ->addColumn('sparepart_used', function ($row) {
                        $sparepartUsedCount = SparepartsOfRepair::where('details_of_repair_submission_id', $row->id)->count();
                        return $sparepartUsedCount;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        $btn .= '<a href="#" class="update btn btn-warning btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Update Repairment data"><i class="ph-duotone ph-pencil-line"></i></a>';
                        $btn .= '<a href="' . route('repairments.showSparepart', encrypt($row->id)) . '" class="btn btn-primary btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Add Sparepart"><i class="ph-duotone ph-plus"></i></a>';
                        $btn .= '<a href="#" class="finish btn btn-success btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Finish Repairment"><i class="ph-duotone ph-check"></i></a>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'remark', 'status'])
                    ->make(true);
            }
        }

        return view('repairments.index');
    }

    public function show($id)
    {
        $id = decrypt($id);
        $repairment = DetailsOfRepairSubmission::find($id);
        return view('repairments.show', compact('repairment'));
    }

    public function getRepairments(Request $request)
    {
        if ($request->get('id') == null || $request->get('id') == '') {
            $details_of_repair_submission = [];
        } else {
            $details_of_repair_submission = DetailsOfRepairSubmission::whereIn('id', $request->get('id'))->with('itemUnit')->get();
        }

        return datatables()->of($details_of_repair_submission)
            ->addIndexColumn()
            ->addColumn('items_name', function ($row) {
                return $row->itemUnit->items->item_name;
            })
            ->addColumn('units_name', function ($row) {
                return $row->itemUnit->units->customer_name;
            })
            ->addColumn('serial_number', function ($row) {
                return $row->itemUnit->serial_number;
            })
            ->make(true);
    }

    public function acceptRepairments(Request $request)
    {
        return $this->acceptCancelFinishState($request, 'accepted');
    }

    public function cancelRepairments(Request $request)
    {
        return $this->acceptCancelFinishState($request, 'canceled');
    }

    public function finishRepairments(Request $request)
    {
        return $this->acceptCancelFinishState($request, 'completed');
    }

    private function getRepairmentsById($req)
    {
        if (is_object($req)) {
            $id = decrypt($req->get('id'));
        } else {
            $id = decrypt($req);
        }

        // return DetailsOfRepairSubmission::findOrFail($id);
        $details_of_repair_submission = DetailsOfRepairSubmission::where('id', $id)->first();
        return $details_of_repair_submission;
    }

    private function acceptCancelFinishState($req, $state)
    {
        $details_of_repair_submission = $this->getRepairmentsById($req);
        $submission_of_repair = SubmissionOfRepair::find($details_of_repair_submission->submission_of_repair_id);

        if ($details_of_repair_submission->date_worked_on != null) {
            return response()->json(['error', 'message' => 'Repairments already accepted']);
        }
        if ($details_of_repair_submission->date_cancelled != null) {
            return response()->json(['error', 'message' => 'Repairments already canceled']);
        }
        if ($details_of_repair_submission->date_completed != null) {
            return response()->json(['error', 'message' => 'Repairments already completed']);
        }

        if ($state == 'accepted') {
            $details_of_repair_submission->date_worked_on = now();

            if ($submission_of_repair->date_worked_on == null) {
                $submission_of_repair->date_worked_on = now();
                $submission_of_repair->save();
            }

        } elseif ($state == 'canceled') {
            $details_of_repair_submission->date_cancelled = now();

            $allCancelled = DetailsOfRepairSubmission::where('submission_of_repair_id', $details_of_repair_submission->submission_of_repair_id)
                ->whereNull('date_cancelled')
                ->doesntExist();

            if ($allCancelled) {
                $submission_of_repair->date_cancelled = now();
            }
        } elseif ($state == 'completed') {
            $details_of_repair_submission->date_completed = now();

            $allCompleted = DetailsOfRepairSubmission::where('submission_of_repair_id', $details_of_repair_submission->submission_of_repair_id)
                ->whereNull('date_completed')
                ->doesntExist();

            if ($allCompleted) {
                $submission_of_repair->date_completed = now();
            }
        }
        if ($details_of_repair_submission->save() && $submission_of_repair->save()) {
            return response()->json(['success' => 'Repairments ' . $state . ' successfully']);
        }
        $result = strstr($state, 'ed', true);
        return response()->json(['error' => 'Failed to ' . $result . ' repairments']);
    }

    public function startRepairments(Request $req)
    {
        // dd($req->all());
        $details_of_repair_submission = $this->getRepairmentsById($req);
        if ($details_of_repair_submission->date_worked_on == null) {
            return response()->json(['error', 'message' => 'Repairments not yet accepted']);
        }
        if ($details_of_repair_submission->date_completed != null) {
            return response()->json(['error', 'message' => 'Repairments already completed']);
        }
        $details_of_repair_submission->status = 1;
        if ($details_of_repair_submission->save()) {
            return response()->json(['success' => 'Repairments completed successfully']);
        }
        return response()->json(['error' => 'Failed to complete repairments']);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $details_of_repair_submission = $this->getRepairmentsById($request);
        $item_unit = Items_units::find($details_of_repair_submission->item_unit_id);
        $item_unit->status = $request->status;
        $details_of_repair_submission->remarks = $request->remarks;
        if ($details_of_repair_submission->save() && $item_unit->save()) {
            return response()->json(['success' => 'Repairments updated successfully']);
        }
        return response()->json(['error' => 'Failed to update repairments']);
    }

    public function showSparepart($id)
    {
        return view('repairments.showSparepart', compact('id'));
    }

    public function getSpareparts($id)
    {
        $details_of_repair_submission = DetailsOfRepairSubmission::where('id', decrypt($id))->first();
        $itemId = $details_of_repair_submission->itemUnit->item_id;

        $spareparts = Spareparts::where('item_id', $itemId)->orWhere('is_generic', 1)->get();
        $spareparts_of_repair = SparepartsOfRepair::where('details_of_repair_submission_id', $details_of_repair_submission->id)->get();
        $spareparts_id = $spareparts_of_repair->pluck('sparepart_id')->toArray();
        return datatables()->of($spareparts)
            ->addColumn('check_box', function ($row) use ($spareparts_id) {
                $checkboxes = '<div class="text-center dtr-control">';
                if (in_array($row->id, $spareparts_id)) {
                    $checkboxes .= '<input type="checkbox" class="select-row form-check-input" name="sparepart_id[]" value="' . encrypt($row->id) . '" checked>';
                } else {
                    $checkboxes .= '<input type="checkbox" class="select-row form-check-input" name="sparepart_id[]" value="' . encrypt($row->id) . '">';
                }
                $checkboxes .= '</div>';
                return $checkboxes;
            })
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('serial_no', function ($row) {
                return $row->serial_no;
            })
            ->addColumn('description', function ($row) {
                return $row->description;
            })
            ->rawColumns(['check_box'])
            ->make(true);
    }

    public function addSparepart($idDetails, $idSparepart)
    {
        $details_of_repair_submission = $this->getRepairmentsById($idDetails);
        $sparepart = Spareparts::where('id', decrypt($idSparepart))->first();
        $spareparts_of_repair = new SparepartsOfRepair();
        $spareparts_of_repair->details_of_repair_submission_id = $details_of_repair_submission->id;
        $spareparts_of_repair->sparepart_id = $sparepart->id;
        $spareparts_of_repair->save();
        return response()->json(['success' => 'Sparepart added successfully']);
    }

    public function removeSparepart($idDetails, $idSparepart)
    {
        $details_of_repair_submission = $this->getRepairmentsById($idDetails);
        $sparepart = Spareparts::where('id', decrypt($idSparepart))->first();
        $spareparts_of_repair = SparepartsOfRepair::where('details_of_repair_submission_id', $details_of_repair_submission->id)
            ->where('sparepart_id', $sparepart->id)
            ->first();
        $spareparts_of_repair->delete();
        return response()->json(['success' => 'Sparepart removed successfully']);
    }

    public function finish(Request $request)
    {
        $details_of_repair_submission = $this->getRepairmentsById($request);
        $submission_of_repair = SubmissionOfRepair::find($details_of_repair_submission->submission_of_repair_id);
        $details_of_repair_submission->status = 2;
        $details_of_repair_submission->date_completed = now();
        $fullData = DetailsOfRepairSubmission::where('submission_of_repair_id', $details_of_repair_submission->submission_of_repair_id)->count();
        $allCompleted = DetailsOfRepairSubmission::where('submission_of_repair_id', $details_of_repair_submission->submission_of_repair_id)
            ->whereNotNull('date_completed')
            ->count();
        if ($allCompleted + 1 == $fullData) {
            $submission_of_repair->date_completed = now();
        }
        if ($details_of_repair_submission->save() && $submission_of_repair->save()) {
            return response()->json(['success' => 'Repairments finished successfully']);
        }
        return response()->json(['error' => 'Failed to finish repairments']);
    }
}
