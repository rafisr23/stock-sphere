<?php

namespace App\Http\Controllers;

use App\Models\Calibrations;
use App\Models\Items_units;
use App\Models\Rooms;
use App\Models\Technician;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
                                return '<button class="btn btn-primary btn-sm alertRoom" title="Alert Room" data-id="' . encrypt($idCalibration) . '" data-name="' . $row->items->item_name . '" data-room="' . $row->rooms->name . '"><i class="ph-duotone ph-info"></i></button>';
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
                            return $row->item_room->first()->items->item_name;
                        })
                        ->addColumn('status', function ($row) {
                            $statusOptions = ['Running', 'System Down', 'Restricted'];
                            $status = '<div class="btn-group mb-2 me-2 dropdown">';
                            $status .= '<select class="form-control" name="status" id="status" required>';

                            foreach ($statusOptions as $option) {
                                $selected = $row->item_room->first()->status == $option ? 'selected' : '';
                                $status .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                            }

                            $status .= '</select>';
                            $status .= '</div>';
                            return $status;
                        })
                        ->addColumn('remarks', function ($row) {
                            $remark = '<textarea type="text" name="remarks" rows="4" id="remarks" class="form-control" data-id="' . encrypt($row->id);
                            $remark .= '"placeholder="Enter calibration remark for ' . $row->item_room->first()->items->item_name . '">';
                            $remark .= old('remarks', $row->remarks);
                            $remark .= '</textarea>';

                            return $remark;
                        })
                        ->addColumn('evidence', function ($row) {
                            $evidence = '<input type="file" name="evidence" class="form-control" id="evidence" placeholder="Upload evidence for ' . $row->item_room->first()->items->item_name . '" accept="image/png, image/jpeg, ,image/jpg">';
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
                        ->rawColumns(['action', 'remarks', 'evidence', 'status'])
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
            $request->validate([
                'item_unit_id' => 'required',
            ]);

            if (auth()->user()->can('assign technician') || auth()->user()->hasRole('superadmin')) {
                $create = Calibrations::create([
                    'room_id' => Items_units::find(decrypt($request->item_unit_id))->room_id,
                    'item_room_id' => decrypt($request->item_unit_id),
                    'status' => 5,
                ]);
                if ($create) {
                    // createLog(3, $create->id, 'alert calibration to unit', null, now());
                    return response()->json(['success' => 'The room has been successfully alerted!']);
                } else {
                    return response()->json(['error' => 'Failed to alert calibration to unit']);
                }
            } else {
                return response()->json(['error' => 'You are not authorized to alert room']);
            }
        } else {
            // $request->validate([
            //     'item_unit_id' => 'required',
            //     'technician' => 'required',
            // ]);

            // if (auth()->user()->can('assign technician') || auth()->user()->hasRole('superadmin')) {
            //     $create = Maintenances::updateOrCreate(
            //         [
            //             'item_room_id' => decrypt($request->item_unit_id),
            //         ],
            //         [
            //             'room_id' => Items_units::find(decrypt($request->item_unit_id))->room_id,
            //             'technician_id' => decrypt($request->technician),
            //             'status' => 0,
            //         ]
            //     );
            // } else {
            //     return redirect()->back()->with('error', 'You are not authorized to assign maintenance to technician');
            // }

            // if ($create) {
            //     createLog(3, $create->id, 'assign maintenance to technician', null, Items_units::where('id', $create->item_room_id)->get('maintenance_date')->toJson());
            //     return redirect()->back()->with('success', 'Maintenance assigned to technician');
            // } else {
            //     return redirect()->back()->with('error', 'Failed to assign maintenance to technician');
            // }
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
            $calibration = Calibrations::find($id);
            $calibration->status = 6;
            $calibration->schedule_by_room = Items_units::find($calibration->item_room_id)->calibration_date;

            if ($calibration->save()) {
                // createLog(3, $calibration->id, 'accept calibration by room', null, now());
                return response()->json(['success' => 'Calibration accepted!']);
            } else {
                return response()->json(['error' => 'Failed to accept calibration']);
            }
        }

        if ($request->type == 'reschedule') {
            $request->validate([
                'newCalibration_date' => 'required',
            ]);

            $calibration = Calibrations::find($id);
            $calibration->status = 7;
            $calibration->schedule_by_room = $request->newCalibration_date;

            if ($calibration->save()) {
                // createLog(3, $calibration->id, 'reschedule calibration by room', null, $request->newCalibration_date);
                return redirect()->back()->with('success', 'Calibration rescheduled!');
            } else {
                return redirect()->back()->with('error', 'Failed to reschedule calibration');
            }
        }

        if ($request->type == 'callVendor') {
            $calibration = Calibrations::find($id);
            $calibration->status = 1;
            $calibration->date_worked_on = now();

            if ($calibration->save()) {
                // createLog(3, $calibration->id, 'call vendor for calibration', null, now());
                return response()->json(['success' => 'Vendor has been called!']);
            } else {
                return response()->json(['error' => 'Failed to call vendor']);
            }
        }

        if ($request->type == 'updateCalibration') {
            $request->validate([
                'status' => 'required',
                'remarks' => 'required',
                'evidence' => 'required',
            ]);

            $calibration = Calibrations::find($id);
            $calibration->remarks = $request->remarks;
            $calibration->evidence = $request->evidence;

            $items = Items_units::find($calibration->item_room_id);
            $items->status = $request->status;

            if ($request->status == 'Running') {
                $calibration->status = 3;
            } elseif ($request->status == 'System Down') {
                $calibration->status = 2;
            } elseif ($request->status == 'Restricted') {
                $calibration->status = 4;
            }

            if ($calibration->save() && $items->save()) {
                // createLog(3, $calibration->id, 'update calibration status', null, $request->status);
                return response()->json(['success' => 'Calibration status updated!']);
            } else {
                return response()->json(['error' => 'Failed to update calibration status']);
            }
        }

        if ($request->type == 'finishCalibration') {
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
            $items->save();

            if ($calibration->save()) {
                // createLog(3, $calibration->id, 'finish calibration', null, now());
                return response()->json(['success' => 'Calibration has been finished!']);
            } else {
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
                    $items = $row->item_room->first()->items->item_name;
                    return $items;
                })
                ->addColumn('room', function ($row) {
                    return $row->room->name;
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->item_room->first()->serial_number;
                })
                ->addColumn('calibration_date', function ($row) {
                    return Carbon::parse($row->item_room->first()->calibration_date)->isoFormat('D MMMM Y');
                })
                ->addColumn('reschedule_date', function ($row) {
                    $date = '';
                    if ($row->status == 5) {
                        $date = '<span class="badge rounded-pill text-bg-info">Waiting Room Confirmation</span>';
                    } elseif ($row->schedule_by_room == $row->item_room->first()->calibration_date) {
                        $date = '<span class="badge rounded-pill text-bg-success">According To The Schedule</span>';
                    } elseif ($row->schedule_by_room != $row->item_room->first()->calibration_date) {
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
                ->rawColumns(['worked_on', 'completed', 'reschedule_date'])
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
                    $items = $row->item_room->first()->items->item_name;
                    return $items;
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->item_room->first()->serial_number;
                })
                ->addColumn('calibration_date', function ($row) {
                    if (Carbon::parse($row->item_room->first()->calibration_date)->lessThan(now())) {
                        $info = Carbon::parse($row->item_room->first()->calibration_date)->isoFormat('D MMMM Y') . '  <span class="badge rounded-pill text-bg-danger">Overdue</span>';
                    } else {
                        $info = Carbon::parse($row->item_room->first()->calibration_date)->isoFormat('D MMMM Y');
                    }
                    return $info;
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 5) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        if (Carbon::parse($row->item_room->first()->calibration_date)->greaterThan(now())) {
                            $btn = '<button type="button" class="btn btn-success btn-sm accCalibration" title="Accept Calibration" data-id="' . encrypt($row->id) . '" data-name="' . $row->item_room->first()->items->item_name . '"><i class="ph ph-duotone ph-check"></i></button>';
                        }
                        $btn .= '<button type="button" class="btn btn-warning btn-sm rescheduleCalibration" title="Reschedule Calibration" data-id="' . encrypt($row->id) . '" data-name="' . $row->item_room->first()->items->item_name . '"><i class="ph ph-duotone ph-pencil-line"></i></button>';
                        $btn .= '</div>';
                    } else if ($row->schedule_by_room == $row->item_room->first()->calibration_date) {
                        $btn = '<span class="badge text-bg-success">According To The Schedule</span>';
                    } else if ($row->schedule_by_room != $row->item_room->first()->calibration_date) {
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
}
