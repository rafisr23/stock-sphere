<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Models\NewLog;
use App\Models\Technician;
use App\Models\Items_units;
use App\Models\Calibrations;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CalibrationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('superadmin') || auth()->user()->can('assign technician') || auth()->user()->hasRole('room')) {
            if (request()->ajax()) {
                $type = $request->input('type');
                $filter = $request->input('filter');

                $loginDate = Carbon::parse(auth()->user()->last_login_date);

                $extData = Calibrations::all();

                if (($type == 'list' && auth()->user()->hasRole('superadmin')) || ($type == 'list' && auth()->user()->can('assign technician'))) {
                    $endDate = null;
                    if ($filter == '1') {
                        $endDate = Carbon::parse($loginDate)->addMonth()->format('Y-m-d');
                    } else if ($filter == '3') {
                        $endDate = Carbon::parse($loginDate)->addMonth(3)->format('Y-m-d');
                    }

                    if ($endDate) {
                        if (auth()->user()->hasRole('superadmin')) {
                            $items = Items_units::where('calibration_date', '<=', $endDate)->get();
                        } else {
                            $technician = auth()->user()->technician;
                            $roomId = Rooms::where('unit_id', $technician->unit_id)->pluck('id');
                            $items = Items_units::whereIn('room_id', $roomId)->where('calibration_date', '<=', $endDate)->get();
                        }
                    } else {
                        $items = Items_units::all();
                    }

                    $items = $items->sortBy('calibration_date');

                    return DataTables::of($items)
                        ->addIndexColumn()
                        ->addColumn('item', function ($row) {
                            return $row->items->item_name;
                        })
                        ->addColumn('room', function ($row) {
                            return $row->rooms->name;
                        })
                        ->addColumn('serial_number', function ($row) {
                            return $row->serial_number;
                        })
                        ->addColumn('calibration_date', function ($row) {
                            return Carbon::parse($row->calibration_date)->isoFormat('D MMMM Y');
                        })
                        ->addColumn('reschedule_date', function ($row) use ($loginDate) {
                            $date = '';

                            if ($row->calibrations && $row->calibrations->schedule_by_room && Carbon::parse($row->calibrations->created_at)->isSameMonth($loginDate) && $row->calibrations->schedule_by_room != $row->calibration_date) {
                                $date = Carbon::parse($row->calibrations->schedule_by_room)->isoFormat('D MMMM Y');
                            } else {
                                $date = '<span class="badge text-bg-info">According To The Schedule</span>';
                            }

                            return $date;
                        })
                        ->addColumn('action', function ($row) use ($loginDate, $extData) {
                            $count = $extData->where('item_id', $row->item_id)
                                ->filter(function ($item) use ($loginDate) {
                                    return $item->created_at->year == $loginDate->year &&
                                        $item->created_at->month == $loginDate->month;
                                })
                                ->count();

                            $status = $extData->where('item_room_id', $row->id)
                                ->filter(function ($item) use ($loginDate) {
                                    return $item->created_at->year == $loginDate->year &&
                                        $item->created_at->month == $loginDate->month;
                                })
                                ->first()->status ?? null;

                            $idCalibration = $extData->where('item_room_id', $row->id)
                                ->filter(function ($item) use ($loginDate) {
                                    return $item->created_at->year == $loginDate->year &&
                                        $item->created_at->month == $loginDate->month;
                                })
                                ->first()->id ?? null;

                            if (($loginDate->isSameDay($row->calibration_date) && $status === null) || ($loginDate->greaterThan($row->calibration_date) && $count == 0 && $status === null)) {
                                return '<button class="btn btn-primary btn-sm alertRoom" title="Alert Room" data-id="' . encrypt($row->id) . '" data-name="' . $row->items->item_name . '" data-room="' . $row->rooms->name . '"><i class="ph-duotone ph-info"></i></button>';
                            } else if ($status == 6 || $status == 7) {
                                return '<button type="button" class="btn btn-info btn-sm callVendor" title="Call Vendor" data-id="' . encrypt($idCalibration) . '" data-name="' . $row->items->item_name . ' (' . $row->serial_number . ')"><i class="ph-duotone ph-phone-plus"></i></button>';
                            } else if ($status == 5) {
                                return '<span class="badge rounded-pill text-bg-secondary">Pending Room</span>';
                            } else if ($status == 1 && $status != 5 && $status != 6 && $status != 7) {
                                return '<span class="badge rounded-pill text-bg-success">Already Worked On</span>';
                            } else {
                                return '<span class="badge rounded-pill text-bg-info">Not Today</span>';
                            }
                        })
                        ->rawColumns(['action', 'reschedule_date'])
                        ->make(true);
                } else if ($type == 'process') {
                    if (auth()->user()->hasRole('superadmin')) {
                        $data = Calibrations::where('date_worked_on', '!=', null)->where('date_completed', null)->get();
                    } elseif (auth()->user()->can('assign technician')) {
                        $technician = auth()->user()->technician;
                        $roomId = Rooms::where('unit_id', $technician->unit_id)->pluck('id');
                        $data = Calibrations::where('date_worked_on', '!=', null)->where('date_completed', null)->whereIn('room_id', $roomId)->get();
                    } else {
                        $data = [];
                    }

                    $data = $data->sortByDesc('created_at');

                    return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('item', function ($row) {
                            return $row->item_room->items->item_name;
                        })
                        ->addColumn('status', function ($row) {
                            $statusOptions = ['Running', 'System Down', 'Restricted'];
                            $status = '<div class="btn-group mb-2 me-2 dropdown">';
                            $status .= '<select class="form-control status" name="status" id="" required>';

                            foreach ($statusOptions as $option) {
                                $selected = $row->item_room->status == $option ? 'selected' : '';
                                $status .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                            }

                            $status .= '</select>';
                            $status .= '</div>';
                            return $status;
                        })
                        ->addColumn('remarks', function ($row) {
                            $remark = '<textarea type="text" name="remarks" rows="4" id="" class="form-control remarks" data-id="' . encrypt($row->id);
                            $remark .= '"placeholder="Enter calibration remark for ' . $row->item_room->items->item_name . '">';
                            $remark .= old('remarks', $row->remarks);
                            $remark .= '</textarea>';

                            return $remark;
                        })
                        ->addColumn('description', function ($row) {
                            $description = '<textarea type="text" name="description" rows="4" id="" class="form-control description" data-id="' . encrypt($row->id);
                            $description .= '"placeholder="Enter calibration description for ' . $row->item_room->items->item_name . '">';
                            $description .= old('description', $row->description);
                            $description .= '</textarea>';

                            return $description;
                        })
                        ->addColumn('evidence', function ($row) {
                            $evidence = '<input type="file" name="evidence" class="form-control" id="evidence" placeholder="Upload evidence for ' . $row->item_room->items->item_name . '" accept="image/png, image/jpeg, ,image/jpg">';
                            return $evidence;
                        })
                        ->addColumn('action', function ($row) {
                            $btn = '<div class="d-flex justify-content-center align-items-center">';
                            if ($row->evidence) {
                                $btn .= '<a href="' . asset('/temp/' . $row->evidence) . '" target="_blank" class="btn btn-info btn-sm me-2" title="View Evidence"><i class="ph-duotone ph-eye"></i></a>';
                            }
                            if (!$row->date_completed) {
                                $btn .= '<a href="#" class="update btn btn-warning btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Update Calibration"><i class="ph-duotone ph-pencil-line"></i></a>';
                            }
                            if ($row->evidence && !$row->date_completed && $row->remarks) {
                                $btn .= '<a href="#" class="finish btn btn-success btn-sm" data-id="' . encrypt($row->id) . '" title="Finish Calibration"><i class="ph-duotone ph-check"></i></a>';
                            }
                            $btn .= '</div>';
                            return $btn;
                        })
                        ->rawColumns(['action', 'remarks', 'description', 'evidence', 'status'])
                        ->make(true);
                }
            } else {
                return view('calibrations.index');
            }
        } else {
            return redirect()->back()->with('error', 'You are not authorized to access this page');
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
        if ($request->type == 'alert') {
            DB::beginTransaction();

            try {
                $request->validate([
                    'item_unit_id' => 'required',
                ]);

                if (auth()->user()->can('assign technician') || auth()->user()->hasRole('superadmin')) {
                    $create = Calibrations::create([
                        'room_id' => Items_units::find(decrypt($request->item_unit_id))->room_id,
                        'item_room_id' => decrypt($request->item_unit_id),
                        'status' => 5,
                    ]);
                    $itemUnit = Items_units::find(decrypt($request->item_unit_id));
                    $itemLog = [
                        'norec' => $itemUnit->norec,
                        'norec_parent' => auth()->user()->norec,
                        'module_id' => 7,
                        'is_calibration' => true,
                        'desc' => 'Item ' . $itemUnit->items->item_name . ' has been requested for calibration by ' . auth()->user()->name . ' from ' . $create->room->name . ' (' . $create->room->units->customer_name . ')',
                        'item_unit_id' => $itemUnit->id,
                        'item_unit_status' => $itemUnit->status,
                    ];

                    $calibrationLog = [
                        'norec' => $create->norec,
                        // 'norec_parent' => $submissionOfRepair->norec,
                        'module_id' => 10,
                        'is_calibration' => true,
                        'desc' => 'Item ' . $itemUnit->items->item_name . ' has been requested for calibration by ' . auth()->user()->name . ' from ' . $create->room->name . ' (' . $create->room->units->customer_name . ')',
                        'item_unit_id' => $itemUnit->id,
                        'item_unit_status' => $itemUnit->status,
                    ];

                    createLog($itemLog);
                    createLog($calibrationLog);

                    DB::commit();
                    return response()->json(['success' => 'The room has been successfully alerted!']);
                } else {
                    return response()->json(['error' => 'You are not authorized to alert room']);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to alert calibration to unit']);
            }
        } else {
            return response()->json(['error' => 'Failed to alert calibration to unit']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Calibrations $calibrations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calibrations $calibrations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = decrypt($id);

        if ($request->type == 'acceptRoom') {
            DB::beginTransaction();

            try {
                $calibration = Calibrations::find($id);
                $calibration->status = 6;
                $calibration->schedule_by_room = Items_units::find($calibration->item_room_id)->calibration_date;
                $calibration->save();

                $itemLog = [
                    'norec' => $calibration->item_room->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 7,
                    'is_calibration' => true,
                    'desc' => 'Item ' . $calibration->item_room->items->item_name . ' has been accepted for calibration by ' . auth()->user()->name . ' from ' . $calibration->room->name . ' (' . $calibration->room->units->customer_name . ')',
                    'item_unit_id' => $calibration->item_room->id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                $calibrationLog = [
                    'norec' => $calibration->norec,
                    'module_id' => 10,
                    'is_calibration' => true,
                    'desc' => 'Item ' . $calibration->item_room->items->item_name . ' has been accepted for calibration by ' . auth()->user()->name . ' from ' . $calibration->room->name . ' (' . $calibration->room->units->customer_name . ')',
                    'item_unit_id' => $calibration->item_room->id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                createLog($itemLog);
                createLog($calibrationLog);

                DB::commit();
                return response()->json(['success' => 'Calibration accepted!']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to accept calibration']);
            }
        }

        if ($request->type == 'reschedule') {
            DB::beginTransaction();

            try {
                $request->validate([
                    'newCalibration_date' => 'required',
                ]);

                $calibration = Calibrations::find($id);
                $calibration->status = 7;
                $calibration->schedule_by_room = $request->newCalibration_date;
                $calibration->save();


                $itemLog = [
                    'norec' => $calibration->item_room->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 7,
                    'is_calibration' => true,
                    'desc' => 'Item ' . $calibration->item_room->items->item_name . ' has been rescheduled for calibration to: ' . $request->newCalibration_date . ' by ' . auth()->user()->name . ' from ' . $calibration->room->name . ' (' . $calibration->room->units->customer_name . ')',
                    'item_unit_id' => $calibration->item_room->id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                $calibrationLog = [
                    'norec' => $calibration->norec,
                    'module_id' => 10,
                    'is_calibration' => true,
                    'desc' => 'Item ' . $calibration->item_room->items->item_name . ' has been rescheduled for calibration to: ' . $request->newCalibration_date . ' by ' . auth()->user()->name . ' from ' . $calibration->room->name . ' (' . $calibration->room->units->customer_name . ')',
                    'item_unit_id' => $calibration->item_room->id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                createLog($itemLog);
                createLog($calibrationLog);

                DB::commit();
                return redirect()->back()->with('success', 'Calibration rescheduled!');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to reschedule calibration');
            }
        }

        if ($request->type == 'callVendor') {
            DB::beginTransaction();

            try {
                $calibration = Calibrations::find($id);
                $calibration->status = 1;
                $calibration->date_worked_on = now();
                $calibration->save();

                $calibrationLog = [
                    'norec' => $calibration->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 10,
                    'is_calibration' => true,
                    'desc' => 'Technician has called vandor to calibrate on item ' . $calibration->item_room->items->item_name . ' by ' . auth()->user()->name . ' from ' . $calibration->room->name . ' (' . $calibration->room->units->customer_name . ')',
                    'item_unit_id' => $calibration->item_room_id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                createLog($calibrationLog);

                DB::commit();
                return response()->json(['success' => 'Vendor has been called!']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to call vendor']);
            }
        }

        if ($request->type == 'updateCalibration') {
            DB::beginTransaction();

            try {
                $request->validate([
                    'status' => 'required',
                    'remarks' => 'required',
                    'description' => 'required',
                    'evidence' => 'required',
                ]);

                $calibration = Calibrations::find($id);
                $oldCalibration = $calibration->toJson();
                $calibration->remarks = $request->remarks;
                $calibration->description = $request->description;
                $calibration->evidence = $request->evidence;

                $item_unit = Items_units::find($calibration->item_room_id);
                $oldItemUnit = $item_unit->toJson();
                $oldStatus = $item_unit->status;
                $item_unit->status = $request->status;

                $oldData = json_encode(array_merge(json_decode($oldCalibration, true), json_decode($oldItemUnit, true)));

                if ($request->status == 'Running') {
                    $calibration->status = 3;
                } elseif ($request->status == 'System Down') {
                    $calibration->status = 2;
                } elseif ($request->status == 'Restricted') {
                    $calibration->status = 4;
                }

                $calibration->save();
                $item_unit->save();

                $calibrationLog = [
                    'norec' => $calibration->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 10,
                    'is_calibration' => true,
                    'desc' => 'Technician has UPDATED THE STATUS and REMARKS of ' . $calibration->item_room->items->item_name . ' to ' . $request->status . ' from ' . $oldStatus . ' by ' . auth()->user()->name . ' from ' . $calibration->room->name . ' (' . $calibration->room->units->customer_name . ')' . ' with REMARKS ' . $request->remarks,
                    'old_data' => $oldData,
                    'item_unit_id' => $calibration->item_room_id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                $itemLog = [
                    'norec' => $item_unit->norec,
                    'module_id' => 7,
                    'is_calibration' => true,
                    'desc' => 'STATUS of ' . $item_unit->items->item_name . ' has been UPDATED to ' . $request->status . ' from ' . $oldStatus . ' with REMARKS ' . $request->remarks,
                    'old_data' => $oldItemUnit,
                    'item_unit_id' => $calibration->item_room_id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                createLog($calibrationLog);
                createLog($itemLog);

                DB::commit();
                return response()->json(['success' => 'Calibration has been updated!']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to update calibration']);
            }
        }

        if ($request->type == 'finishCalibration') {
            DB::beginTransaction();

            try {
                $request->validate([
                    'status' => 'required',
                ]);
                $calibration = Calibrations::find($id);
                $calibration->date_completed = now();

                if ($calibration->status == 2) {
                    $calibration->status = 3;
                }

                $items = Items_units::find($calibration->item_room_id);

                $items->status = $request->status;

                $date_completed = date('Y-m-d', strtotime($calibration->date_completed));
                $condition = strtotime($date_completed) - strtotime($items->calibration_date);
                // 2592000 = 30 days
                if ($condition > 2592000) {
                    $items->calibration_date = date('Y-m-d', strtotime($items->date_completed . ' +1 year'));
                } else {
                    $items->calibration_date = date('Y-m-d', strtotime($items->calibration_date . ' +1 year'));
                }

                $calibration->save();
                $items->save();

                $calibrationLog = [
                    'norec' => $calibration->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 10,
                    'is_calibration' => true,
                    'desc' => 'Technician has finished calibration ' . $calibration->item_room->items->item_name . ' by ' . auth()->user()->name . ' from ' . $calibration->room->name . ' (' . $calibration->room->units->customer_name . ')',
                    'old_data' => $calibration->toJson(),
                    'item_unit_id' => $calibration->item_room_id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                $itemLog = [
                    'norec' => $items->norec,
                    'module_id' => 7,
                    'is_calibration' => true,
                    'desc' => 'Calibration of ' . $calibration->item_room->items->item_name . ' has been FINISHED by vendor from ' . $calibration->room->name . ' (' . $calibration->room->units->customer_name . ') with last STATUS ' . $calibration->item_room->status . ' and REMARKS ' . $calibration->remarks,
                    'old_data' => $calibration->item_room->toJson(),
                    'item_unit_id' => $calibration->item_room_id,
                    'item_unit_status' => $calibration->item_room->status,
                ];

                createLog($calibrationLog);
                createLog($itemLog);

                DB::commit();
                return response()->json(['success' => 'Calibration has been finished!']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to finish calibration']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calibrations $calibrations)
    {
        //
    }

    public function history()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('superadmin')) {
                $data = Calibrations::all();
            } elseif (auth()->user()->can('assign technician')) {
                $technician = auth()->user()->technician;
                $roomId = Rooms::where('unit_id', $technician->unit_id)->pluck('id');
                $data = Calibrations::whereIn('room_id', $roomId)->get();
            } else if (auth()->user()->hasRole('room')) {
                $room = auth()->user()->room;
                $data = Calibrations::where('room_id', $room->id)->get();
            } else {
                $data = [];
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('item', function ($row) {
                    $items = $row->item_room->items->item_name;
                    return $items;
                })
                ->addColumn('room', function ($row) {
                    return $row->room->name;
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->item_room->serial_number;
                })
                ->addColumn('calibration_date', function ($row) {
                    return Carbon::parse($row->item_room->calibration_date)->isoFormat('D MMMM Y');
                })
                ->addColumn('reschedule_date', function ($row) {
                    $date = '';
                    if ($row->status == 5) {
                        $date = '<span class="badge rounded-pill text-bg-info">Waiting Room Confirmation</span>';
                    } elseif ($row->schedule_by_room == $row->item_room->calibration_date) {
                        $date = '<span class="badge rounded-pill text-bg-success">According To The Schedule</span>';
                    } elseif ($row->schedule_by_room != $row->item_room->calibration_date) {
                        $date = Carbon::parse($row->schedule_by_room)->isoFormat('D MMMM Y');
                    }
                    return $date;
                })
                ->addColumn('worked_on', function ($row) {
                    if ($row->date_worked_on) {
                        return Carbon::parse($row->date_worked_on)->isoFormat('D MMMM Y, HH:mm');
                    } else {
                        return '<span class="badge rounded-pill text-bg-info">Not Started Yet</span>';
                    }
                })
                ->addColumn('completed', function ($row) {
                    if ($row->date_completed) {
                        return Carbon::parse($row->date_completed)->isoFormat('D MMMM Y, HH:mm');
                    } else {
                        return '<span class="badge rounded-pill text-bg-info">Not Completed Yet</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center align-items-center">';
                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 10,
                        'status' => 'is_maintenance',
                    ];
                    $btn .= '<a href="' . route('calibrations.toPDF', encrypt($row->id)) . '" class="edit btn btn-danger btn-sm me-2" target="_blank" title="Export to PDF"><i class="ph-duotone ph-file-pdf"></i></a>';
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
                ->rawColumns(['worked_on', 'completed', 'reschedule_date', 'action'])
                ->make(true);
        } else {
            return view('calibrations.history');
        }
    }

    public function confirmation()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('superadmin')) {
                $data = Calibrations::where('status', 5)->get();
            } else if (auth()->user()->hasRole('room')) {
                $room = auth()->user()->room;
                $data = Calibrations::where('room_id', $room->id)->where('status', 5)->get();
            } else {
                $data = [];
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('item', function ($row) {
                    $items = $row->item_room->items->item_name;
                    return $items;
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->item_room->serial_number;
                })
                ->addColumn('calibration_date', function ($row) {
                    if (Carbon::parse($row->item_room->calibration_date)->lessThan(now())) {
                        $info = Carbon::parse($row->item_room->calibration_date)->isoFormat('D MMMM Y') . '  <span class="badge rounded-pill text-bg-danger">Overdue</span>';
                    } else {
                        $info = Carbon::parse($row->item_room->calibration_date)->isoFormat('D MMMM Y');
                    }
                    return $info;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 5) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        if (Carbon::parse($row->item_room->calibration_date)->greaterThan(now())) {
                            $btn = '<button type="button" class="btn btn-success btn-sm accCalibration" title="Accept Calibration" data-id="' . encrypt($row->id) . '" data-name="' . $row->item_room->items->item_name . '"><i class="ph ph-duotone ph-check"></i></button>';
                        }
                        $btn .= '<button type="button" class="btn btn-warning btn-sm rescheduleCalibration" title="Reschedule Calibration" data-id="' . encrypt($row->id) . '" data-name="' . $row->item_room->items->item_name . '"><i class="ph ph-duotone ph-pencil-line"></i></button>';
                        $btn .= '</div>';
                    } else if ($row->schedule_by_room == $row->item_room->calibration_date) {
                        $btn = '<span class="badge text-bg-success">According To The Schedule</span>';
                    } else if ($row->schedule_by_room != $row->item_room->calibration_date) {
                        $btn = '<span class="badge text-bg-info">Rescheduled</span>';
                    } else {
                        $btn = '<span class="badge rounded-pill text-bg-info">Nothing To Do Here</span>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'calibration_date'])
                ->make(true);
        } else {
            return view('calibrations.confirmation');
        }
    }

    public function storeTemporaryFile(Request $request)
    {
        if ($request->hasFile('evidence')) {

            $request->validate([
                'evidence' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $file = $request->file('evidence');
            $fileName = time() . '_temp_calibration_' . $file->getClientOriginalName();
            $file->move(public_path('temp'), $fileName);

            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'File has been uploaded successfully!',
                'fileName' => $fileName
            ]);
        }
    }

    public function toPDF($id)
    {
        $calibration = Calibrations::where('date_completed', '!=', null)->where('id', decrypt($id))->first();
        $date_worked_on = $calibration->date_worked_on;
        $date_completed = $calibration->date_completed;
        // $technician = Technician::where('id', $calibration->technician_id)->first();
        $workHours = $this->calculateWorkHourDifference($date_worked_on, $date_completed);
        $calibrationLog = NewLog::where('norec', $calibration->norec)->where('module_id', 10)->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('calibrations.toPDF', compact('calibration', 'workHours', 'calibrationLog'));
        return $pdf->stream(date(now()) . '_calibration_' . $calibration->item_room->items->item_name . '.pdf');
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
