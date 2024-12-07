<?php

namespace App\Http\Controllers;

use App\Models\EvidenceTechnicianRepairments;
use App\Models\Spareparts;
use App\Models\Items_units;
use App\Models\Technician;
use Illuminate\Http\Request;
use League\Fractal\Resource\Item;
use App\Models\SparepartsOfRepair;
use App\Models\SubmissionOfRepair;
use Illuminate\Support\Facades\DB;
use App\Models\DetailsOfRepairSubmission;
use Illuminate\Support\Facades\File;

class DetailsOfRepairSubmissionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $table = request('table');
            if ($table === 'repairments') {
                if (auth()->user()->hasRole('technician') && !auth()->user()->can('assign technician')) {
                    $technician = Technician::where('user_id', auth()->user()->id)->first();
                    $details_of_repair_submission = DetailsOfRepairSubmission::where('technician_id', $technician->id)->get();
                } else {
                    $details_of_repair_submission = DetailsOfRepairSubmission::all();
                }
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
                        // Tambahin show sparepart used
                        $sparepartUsedText = '<div class="d-flex justify-content-center align-items-center">';
                        $sparepartUsedText .= "<a href='#'class='btn btn-sm btn-secondary' data-bs-toggle='modal'
                        data-bs-target='#exampleModal'
                        data-title='Detail Sparepart Used for " . $row->itemUnit->items->item_name . "' data-bs-tooltip='tooltip'
                        data-remote=" . route('repairments.showSparepartUsed', ['id' => encrypt($row->id)]) . "
                        title='Number of Sparepart Used'>
                        " . $sparepartUsedCount . "
                            </a>
                            ";
                        $sparepartUsedText .= '</div>';
                        return $sparepartUsedText;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        $btn .= '<a href="#" class="update btn btn-warning btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Update Repairment data"><i class="ph-duotone ph-pencil-line"></i></a>';
                        $btn .= '<a href="' . route('repairments.showSparepart', encrypt($row->id)) . '" class="btn btn-primary btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Add Sparepart"><i class="ph-duotone ph-plus"></i></a>';
                        $btn .= "<a href='#'class='btn btn-secondary btn-sm me-2' data-bs-toggle='modal'
                        data-bs-target='#exampleModal' data-title='Evidence for " . $row->itemUnit->items->item_name . "' data-bs-tooltip='tooltip'
                        data-remote=" . route('repairments.showEvidenceTechnician', ['id' => encrypt($row->id)]) . "
                        title='Show Evidence'>
                        <i class='ph-duotone ph-image'></i>
                            </a>
                            ";
                        $btn .= '<a href="#" class="finish btn btn-success btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Finish Repairment"><i class="ph-duotone ph-check"></i></>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'remark', 'status', 'sparepart_used'])
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
            DB::beginTransaction();
            try {
                $details_of_repair_submission->date_worked_on = now();

                if ($submission_of_repair->date_worked_on == null) {
                    $submission_of_repair->date_worked_on = now();
                    $submission_of_repair->save();
                }
                
                $detailLog = [
                    'norec' => $details_of_repair_submission->norec,
                    'norec_parent' => $submission_of_repair->norec,
                    'module_id' => 2,
                    'is_repair' => true,
                    'desc' => 'Technician ' . $details_of_repair_submission->technician->name . ' has been accepted for repair of ' . $details_of_repair_submission->itemUnit->items->item_name . ' by ' . auth()->user()->name . ' from ' . $submission_of_repair->room->name . ' (' . $submission_of_repair->unit->customer_name . ')',
                    'item_unit_id' => $details_of_repair_submission->item_unit_id,
                    'technician_id' => $details_of_repair_submission->technician_id,
                ];

                $technicianLog = [
                    'norec' => auth()->user()->technician->norec,
                    'module_id' => 8,
                    'is_repair' => true,
                    'desc' => 'Repair of ' . $details_of_repair_submission->itemUnit->items->item_name . ' has been accepted by ' . $details_of_repair_submission->technician->name . ' from ' . $submission_of_repair->room->name . ' (' . $submission_of_repair->unit->customer_name . ')',
                    'item_unit_id' => $details_of_repair_submission->item_unit_id,
                    'technician_id' => $details_of_repair_submission->technician_id,
                ];
    
                createLog($detailLog);
                createLog($technicianLog);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to accept repairments']);
            }
        } elseif ($state == 'canceled') {
            DB::beginTransaction();

            try {
                $details_of_repair_submission->date_cancelled = now();
    
                $allCancelled = DetailsOfRepairSubmission::where('submission_of_repair_id', $details_of_repair_submission->submission_of_repair_id)
                    ->whereNull('date_cancelled')
                    ->doesntExist();
    
                if ($allCancelled) {
                    $submission_of_repair->date_cancelled = now();

                    $submissionLog = [
                        'norec' => $submission_of_repair->norec,
                        'module_id' => 2,
                        'is_repair' => true,
                        'desc' => 'Submission of repair for ' . $submission_of_repair->room->name . ' (' . $submission_of_repair->unit->customer_name . ') has been canceled by ' . $details_of_repair_submission->technician->name,
                    ];

                    createLog($submissionLog);
                }

                $detailLog = [
                    'norec' => $details_of_repair_submission->norec,
                    'norec_parent' => $submission_of_repair->norec,
                    'module_id' => 2,
                    'is_repair' => true,
                    'desc' => 'Technician ' . $details_of_repair_submission->technician->name . ' has been canceled for repair of ' . $details_of_repair_submission->itemUnit->items->item_name . ' by ' . $details_of_repair_submission->technician->name . ' from ' . $submission_of_repair->room->name . ' (' . $submission_of_repair->unit->customer_name . ')',
                    'item_unit_id' => $details_of_repair_submission->item_unit_id,
                    'technician_id' => $details_of_repair_submission->technician_id,
                ];

                $technicianLog = [
                    'norec' => auth()->user()->technician->norec,
                    'module_id' => 2,
                    'is_repair' => true,
                    'desc' => 'Repair of ' . $details_of_repair_submission->itemUnit->items->item_name . ' has been canceled by ' . $details_of_repair_submission->technician->name . ' from ' . $submission_of_repair->room->name . ' (' . $submission_of_repair->unit->customer_name . ')',
                    'item_unit_id' => $details_of_repair_submission->item_unit_id,
                    'technician_id' => $details_of_repair_submission->technician_id,
                ];

                createLog($detailLog);
                createLog($technicianLog);
                
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to cancel repairments']);
            }
        } elseif ($state == 'completed') {
            $details_of_repair_submission->date_completed = now();
            // tambahin "No Remark from Technician"

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
        DB::beginTransaction();

        try {
            $details_of_repair_submission = $this->getRepairmentsById($req);
            if ($details_of_repair_submission->date_worked_on == null) {
                return response()->json(['error', 'message' => 'Repairments not yet accepted']);
            }
            if ($details_of_repair_submission->date_completed != null) {
                return response()->json(['error', 'message' => 'Repairments already completed']);
            }
            $details_of_repair_submission->status = 1;

            $detailLog = [
                'norec' => $details_of_repair_submission->norec,
                'norec_parent' => $details_of_repair_submission->submission->norec,
                'module_id' => 2,
                'is_repair' => true,
                'desc' => 'Technician ' . $details_of_repair_submission->technician->name . ' has started repairing ' . $details_of_repair_submission->itemUnit->items->item_name . ' from ' . $details_of_repair_submission->submission->room->name . ' (' . $details_of_repair_submission->submission->unit->customer_name . ')',
                'item_unit_id' => $details_of_repair_submission->item_unit_id,
                'technician_id' => $details_of_repair_submission->technician_id,
            ];

            $technicianLog = [
                'norec' => auth()->user()->technician->norec,
                'module_id' => 2,
                'is_repair' => true,
                'desc' => 'Repair of ' . $details_of_repair_submission->itemUnit->items->item_name . ' has been started by ' . $details_of_repair_submission->technician->name . ' from ' . $details_of_repair_submission->submission->room->name . ' (' . $details_of_repair_submission->submission->unit->customer_name . ')',
                'item_unit_id' => $details_of_repair_submission->item_unit_id,
                'technician_id' => $details_of_repair_submission->technician_id,
            ];

            createLog($detailLog);
            createLog($technicianLog);

            if ($details_of_repair_submission->save()) {
                DB::commit();
                return response()->json(['success' => 'Repairments completed successfully']);
            }
            
            DB::rollBack();
            return response()->json(['error' => 'Failed to complete repairments']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to start repairments']);
        }
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

    public function showSparepartUsed($id)
    {
        $sparepartsOfRepair = SparepartsOfRepair::where('details_of_repair_submission_id', decrypt($id))->get();
        $sparepartUsed = $sparepartsOfRepair->map(function ($item) {
            return [
                'name' => $item->sparepart->name,
                'serial_no' => $item->sparepart->serial_no,
                'description' => $item->sparepart->description,
            ];
        });
        return view('repairments.sparepartsModal', compact('sparepartUsed'));
    }

    public function showEvidenceTechnician($id)
    {
        $details_of_repair_submissions = DetailsOfRepairSubmission::find(decrypt($id));
        // dd($details_of_repair_submissions);
        $evidence_technician = EvidenceTechnicianRepairments::where('details_of_repair_submission_id', decrypt($id))->get();
        // dd($evidence_technician);
        return view('repairments.evidenceTechnicianModal', compact('evidence_technician', 'details_of_repair_submissions'));
    }

    public function storeTemporaryFile(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('repairments_evidence')) {
            $file = $request->file('repairments_evidence');
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

    public function storeEvidenceTechnician(Request $request, $id)
    {
        // dd($request->all());
        $evidence = $request->input('repairments_evidence');

        $tempDir = public_path('temp');
        $targetDir = public_path('images/evidence');

        // Pastikan direktori tujuan ada
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        $pattern = "*_temp_" . $evidence; // contoh: "*_temp_Screenshot_2024-11-22-10-08-55-44_5dd0bdc881f4608ad98b5ecfcfb5553a.jpg"
        $files = glob($tempDir . DIRECTORY_SEPARATOR . $pattern);

        // Periksa apakah file ditemukan
        if (empty($files)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        // Ambil file pertama yang cocok
        $sourceFile = $files[0];

        // Tentukan nama file tujuan
        $targetFile = $targetDir . DIRECTORY_SEPARATOR . $evidence;
        $path = 'images/evidence' . DIRECTORY_SEPARATOR . $evidence;
        // dd($targetFile, $path);

        if (File::copy($sourceFile, $targetFile)) {
            $request->validate([
                'repairments_evidence' => 'required',
            ]);

            $create = EvidenceTechnicianRepairments::create([
                'details_of_repair_submission_id' => decrypt($id),
                'evidence' => $path,
            ]);

            if ($create) {
                return redirect()->back()->with('success', 'Evidence uploaded successfully');
            }
        }
        return redirect()->back()->with('error', 'Failed to upload evidence');
    }
}