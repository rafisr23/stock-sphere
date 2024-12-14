<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rooms;
use App\Models\Units;
use App\Models\Technician;
use App\Models\Items_units;
use Illuminate\Http\Request;
use App\Models\SubmissionOfRepair;
use Illuminate\Support\Facades\DB;
use App\Models\DetailsOfRepairSubmission;
use App\Models\Spareparts;
use App\Models\SparepartsOfRepair;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;

class SubmissionOfRepairController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('unit')) {
                $submission = SubmissionOfRepair::where('room_id', auth()->user()->unit->id)->whereIn('status', [0, 1, 2])->pluck('id');
                $itemInRepair = DetailsOfRepairSubmission::whereIn('submission_of_repair_id', $submission)->pluck('item_unit_id');
                $items_units = Items_units::whereIn('room_id', auth()->user()->unit->room->id)->whereNotIn('id', $itemInRepair)->get();
            } elseif (auth()->user()->hasRole('room')) {
                $submission = SubmissionOfRepair::where('room_id', auth()->user()->room->id)->whereIn('status', [0, 1, 2])->pluck('id');
                $itemInRepair = DetailsOfRepairSubmission::whereIn('submission_of_repair_id', $submission)->pluck('item_unit_id');
                $items_units = Items_units::whereNotIn('id', $itemInRepair)->where('room_id', auth()->user()->room->id)->get();
            } else {
                $submission = SubmissionOfRepair::whereIn('status', [0, 1, 2])->pluck('id');
                $itemInRepair = DetailsOfRepairSubmission::whereIn('submission_of_repair_id', $submission)->pluck('item_unit_id');
                $items_units = Items_units::whereNotIn('id', $itemInRepair)->get();
            }
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

        $rooms = Rooms::all();

        return view('submission.index', compact('rooms'));
    }

    public function getItems(Request $request)
    {
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


    public function storeTemporaryFile(Request $request)
    {
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

    public function store(Request $request)
    {
        // return $request->all();

        $request->validate([
            'items' => 'required',
            'description' => 'required',
        ]);

        DB::beginTransaction();

        try {
            if (auth()->user()->hasRole('superadmin')) {
                $room = Rooms::where('id', $request->room_id)->first();
            } else {
                $room = Rooms::find(auth()->user()->room->id);
            }
            $unit = Units::find($room->unit_id);
            $submissionOfRepair = SubmissionOfRepair::create([
                'unit_id' => $unit->id,
                'room_id' => $room->id,
                'status' => 0,
                'description' => '',
                'date_submitted' => date('Y-m-d H:i:s')
            ]);

            $itemUnitId = explode(',', $request->items);

            foreach ($itemUnitId as $key => $value) {
                // if ($key == 0) continue;
                // return $request->evidence[$value] . ' - ' . $request->description[$value];

                $item = Items_units::find($value);
                $evidence = $request->evidence ? $request->evidence[$value] : '';
                $detail = $submissionOfRepair->details()->create([
                    'submission_of_repair_id' => $submissionOfRepair->id,
                    'item_unit_id' => $item->id,
                    'description' => $request->description[$value] ?? '-',
                    'evidence' => $evidence,
                ]);

                $log = [
                    'norec' => $item->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 2,
                    'is_repair' => true,
                    'desc' => 'Item ' . $item->items->item_name . ' has been submitted for repair by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $unit->customer_name . ')' . ' with description: ' . $request->description[$value],
                    'item_unit_id' => $item->id,
                    'item_unit_status' => $item->status,
                ];

                $detailLog = [
                    'norec' => $detail->norec,
                    'norec_parent' => $submissionOfRepair->norec,
                    'module_id' => 2,
                    'is_repair' => true,
                    'desc' => 'Item ' . $item->items->item_name . ' has been submitted for repair by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $unit->customer_name . ')' . ' with description: ' . $request->description[$value],
                    'item_unit_id' => $item->id,
                    'item_unit_status' => $item->status,
                ];

                createLog($log);
                createLog($detailLog);
            }

            $submissionLog = [
                'norec' => $submissionOfRepair->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 2,
                'is_repair' => true,
                'desc' => 'Submission of repair has been submitted by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $unit->customer_name . ')' . ' with ' . count($itemUnitId) . ' item(s)',
            ];

            createLog($submissionLog);

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

    public function history()
    {
        if (request()->ajax()) {
            $submission = auth()->user()->hasRole('unit')
                ? SubmissionOfRepair::where('unit_id', auth()->user()->unit->id)->orderBy('created_at', 'desc')->get()
                : SubmissionOfRepair::orderBy('created_at', 'desc')->get();
            return datatables()->of($submission)
                ->addIndexColumn()
                ->addColumn('count', function ($row) {
                    $count = $row->details->count();
                    return $count;
                })
                ->addColumn('date_submitted', function ($row) {
                    return date('d M Y H:i:s', strtotime($row->date_submitted));
                })
                ->addColumn('estimated_date_completed', function ($row) {
                    if ($row->estimated_date_completed != '' || $row->estimated_date_completed != null) {
                        $diffForHumans = \Carbon\Carbon::parse($row->estimated_date_completed)->diffForHumans();
                        return date('d M Y', strtotime($row->estimated_date_completed)) . ' (' . $diffForHumans . ')';
                    } else {
                        return '-';
                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 0) {
                        return '<span class="badge bg-warning">Pending</span>';
                    } elseif ($row->status == 1) {
                        return '<span class="badge bg-secondary">In Progress</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-primary">Work On Delay</span>';
                    } elseif ($row->status == 3) {
                        return '<span class="badge bg-success">Completed</span>';
                    } else {
                        return '<span class="badge bg-danger">Cancelled</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $detailUrl = route('submission-of-repair.detail', encrypt($row->id));
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $btn .= '<a href="' . $detailUrl . '" class="view btn btn-info btn-sm me-2" title="See Details"><i class="ph-duotone ph-eye"></i></a>';
                    // $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';

                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 2,
                        'status' => 'is_repair',
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
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('submission.history');
    }

    public function viewListOfRepairs()
    {
        return view('submission.list');
    }

    public function getListOfRepairs()
    {
        $submission = auth()->user()->hasRole('unit')
            ? SubmissionOfRepair::where('unit_id', auth()->user()->unit->id)->orderBy('created_at', 'desc')->get()
            : SubmissionOfRepair::orderBy('created_at', 'desc')->get();
        return datatables()->of($submission)
            ->addIndexColumn()
            ->addColumn('count', function ($row) {
                $count = $row->details->count();
                return $count;
            })
            ->addColumn('date_submitted', function ($row) {
                return date('d M Y H:i:s', strtotime($row->date_submitted));
            })
            ->addColumn('estimated_date_completed', function ($row) {
                if ($row->estimated_date_completed != '' || $row->estimated_date_completed != null) {
                    $diffForHumans = \Carbon\Carbon::parse($row->estimated_date_completed)->diffForHumans();
                    return date('d M Y', strtotime($row->estimated_date_completed)) . ' (' . $diffForHumans . ')';
                } else {
                    return '-';
                }
            })
            ->addColumn('hospital', function ($row) {
                return $row->room->units->customer_name;
            })
            ->addColumn('unit', function ($row) {
                return $row->room->name;
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 0) {
                    return '<span class="badge bg-warning">Pending</span>';
                } elseif ($row->status == 1) {
                    return '<span class="badge bg-secondary">In Progress</span>';
                } elseif ($row->status == 2) {
                    return '<span class="badge bg-primary">Work On Delay</span>';
                } elseif ($row->status == 3) {
                    return '<span class="badge bg-success">Completed</span>';
                } else {
                    return '<span class="badge bg-danger">Cancelled</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $detailUrl = route('submission-of-repair.detail', encrypt($row->id));
                $btn = '<div class="d-flex justify-content-center align-items-center">';
                $btn .= '<a href="' . $detailUrl . '" class="view btn btn-info btn-sm me-2" title="Detail Submission"><i class="ph-duotone ph-eye"></i></a>';
                // $btn .= '<a href="' . route('items_units.edit', $row->id) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                // $btn .= '<a href="#" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '" title="Delete Data"><i class="ph-duotone ph-trash"></i></a>';

                $log = [
                    'norec' => $row->norec ?? null,
                    'module_id' => 2,
                    'status' => 'is_repair',
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
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function detailSubmission($submissionId)
    {
        $submissionId = decrypt($submissionId);
        $submission = SubmissionOfRepair::find($submissionId);
        $details = DetailsOfRepairSubmission::where('submission_of_repair_id', $submissionId)->get();
        $technicians = User::role('technician')->where('id', '!=', auth()->id())->get();

        // return $details[0]->technician;

        return view('submission.assign', compact('submission', 'technicians', 'details'));
    }

    public function getTechnicians()
    {
        $technicians = Technician::where('user_id', '!=', auth()->id())->get();

        if ($technicians->count() > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Technicians has been fetched successfully!',
                'data' => $technicians
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Technicians not found!',
                'data' => []
            ]);
        }
    }

    public function getTechnician(Request $request)
    {
        $technicianId = $request->get('technicianId');
        $technician = Technician::find(decrypt($technicianId));

        if ($technician) {
            return response()->json([
                'success' => true,
                'message' => 'Technician has been fetched successfully!',
                'data' => $technician
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Technician not found!',
                'data' => []
            ]);
        }
    }

    public function assignTechnician(Request $request)
    {
        $request->validate([
            'technicianId' => 'required',
            'detailId' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // $submission = SubmissionOfRepair::find($request->submissionId);
            // $submission->update([
            //     'status' => 1,
            //     'technician_id' => $request->technician,
            // ]);
            $detail = DetailsOfRepairSubmission::where('id', $request->detailId)->first();
            $detail->update([
                'technician_id' => $request->technicianId,
                'status' => 0,
            ]);

            $submission = SubmissionOfRepair::find($detail->submission_of_repair_id);
            $technician = Technician::find($request->technicianId);

            $detailLog = [
                'norec' => $detail->norec,
                'norec_parent' => $submission->norec,
                'module_id' => 2,
                'is_repair' => true,
                'desc' => 'Technician ' . $detail->technician->name . ' has been assigned for repair of ' . $detail->itemUnit->items->item_name . ' by ' . auth()->user()->name . ' from ' . $submission->room->name . ' (' . $submission->unit->customer_name . ')',
                'item_unit_id' => $detail->item_unit_id,
                'item_unit_status' => $detail->itemUnit->status,
                'technician_id' => $detail->technician_id,
            ];

            $technicianLog = [
                'norec' => $detail->technician->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 8,
                'desc' => $technician->name . ' has been assigned for repair of ' . $detail->itemUnit->items->item_name . ' by ' . auth()->user()->name . ' from ' . $submission->room->name . ' (' . $submission->unit->customer_name . ')',
                'is_repair' => true,
                'item_unit_id' => $detail->item_unit_id,
                'item_unit_status' => $detail->itemUnit->status,
            ];

            createLog($detailLog);
            createLog($technicianLog);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Technician has been assigned successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function detail($submissionId)
    {
        $submissionId = decrypt($submissionId);
        $submission = SubmissionOfRepair::find($submissionId);
        $details = DetailsOfRepairSubmission::where('submission_of_repair_id', $submissionId)->get();
        $technicians = User::role('technician')->where('id', '!=', auth()->id())->get();

        // return $details;

        return view('submission.assign', compact('submission', 'technicians', 'details'));
    }

    public function toPDF($detailId)
    {
        $detail = DetailsOfRepairSubmission::where('date_cancelled', null)->where('id', decrypt($detailId))->first();
        $date_worked_on = $detail->date_worked_on;
        $date_completed = $detail->date_completed;
        $workHour = $this->calculateWorkHourDifference2($date_worked_on, $date_completed);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('submission.toPDF2', compact('detail', 'workHour'));

        return $pdf->stream('submission-of-repair.pdf');
    }

    private function calculateWorkHourDifference($datesWorkedOn, $datesCompleted)
    {
        $start = Carbon::parse($datesWorkedOn);
        $end = Carbon::parse($datesCompleted);

        if ($start->greaterThanOrEqualTo($end)) {
            return 0;
        }

        $workStart = 8;
        $workEnd = 17;
        $totalMinutes = 0;

        while ($start->lessThan($end)) {
            if ($start->isWeekday()) {
                $workDayStart = $start->copy()->hour($workStart)->minute(0)->second(0);
                $workDayEnd = $start->copy()->hour($workEnd)->minute(0)->second(0);

                if ($start->between($workDayStart, $workDayEnd)) {
                    $endOfDay = $workDayEnd->lessThan($end) ? $workDayEnd : $end;
                    $totalMinutes += $start->diffInMinutes($endOfDay);
                }
            }

            $start->addDay()->hour($workStart)->minute(0)->second(0);
        }

        return [
            'hours' => intdiv($totalMinutes, 60),
            'minutes' => $totalMinutes % 60,
        ];
    }
}