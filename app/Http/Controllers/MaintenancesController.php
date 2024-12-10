<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Rooms;
use App\Models\Technician;
use App\Models\Items_units;
use App\Models\Maintenances;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

            $loginDate = Carbon::parse(auth()->user()->last_login_date);

            $extData = Maintenances::all();

            if (($type == 'list' && auth()->user()->hasRole('superadmin')) || ($type == 'list' && auth()->user()->can('assign technician'))) {
                $endDate = null;
                if ($filter == '1') {
                    $endDate = Carbon::parse($loginDate)->addMonth()->format('Y-m-d');
                } else if ($filter == '3') {
                    $endDate = Carbon::parse($loginDate)->addMonth(3)->format('Y-m-d');
                }

                if ($endDate) {
                    if (auth()->user()->hasRole('superadmin')) {
                        $items = Items_units::where('maintenance_date', '<=', $endDate)->get();
                    } else {
                        $technician = auth()->user()->technician;
                        $roomId = Rooms::where('unit_id', $technician->unit_id)->pluck('id');
                        $items = Items_units::whereIn('room_id', $roomId)->where('maintenance_date', '<=', $endDate)->get();
                    }
                } else {
                    $items = Items_units::all();
                }

                $items = $items->sortBy('maintenance_date');

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
                    ->addColumn('maintenance_date', function ($row) {
                        return Carbon::parse($row->maintenance_date)->isoFormat('D MMMM Y');
                    })
                    ->addColumn('reschedule_date', function ($row) {
                        $date = '';
                        if ($row->maintenances && Carbon::parse($row->maintenance_date)->lessThan(Carbon::parse($row->maintenances->schedule_by_room))) {
                            if ($row->maintenances == null || $row->maintenances->status == 5) {
                                $date = '<span class="badge text-bg-info">Waiting Room Confirmation</span>';
                            } elseif ($row->maintenances->schedule_by_room == $row->maintenance_date) {
                                $date = '<span class="badge text-bg-success">According To The Schedule</span>';
                            } elseif ($row->maintenances->schedule_by_room != $row->maintenance_date) {
                                $date = Carbon::parse($row->maintenances->schedule_by_room)->isoFormat('D MMMM Y');
                            }
                        } else {
                            $date = '<span class="badge text-bg-success">According To The Schedule</span>';
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

                        if (($loginDate->isSameDay($row->maintenance_date) && $status === null) || ($loginDate->greaterThan($row->maintenance_date) && $count == 0 && $status === null)) {
                            return '<button class="btn btn-primary btn-sm alertRoom" title="Alert Room" data-id="' . encrypt($row->id) . '" data-name="' . $row->items->item_name . '" data-room="' . $row->rooms->name . '"><i class="ph-duotone ph-info"></i></button>';
                        } else if ($status == 6 || $status == 7) {
                            return '<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#assignTechnicianModal" title="Assign Technician" data-id="' . encrypt($row->id) . '" data-name="' . $row->items->item_name . ' (' . $row->serial_number . ')"><i class="ph-duotone ph-user-plus"></i></button>';
                        } else if ($status == 5) {
                            return '<span class="badge rounded-pill text-bg-secondary">Pending Room</span>';
                        } else if ($status == 0 && $status != 5 && $status != 6 && $status != 7) {
                            return '<span class="badge rounded-pill text-bg-success">Already Assigned</span>';
                        } else {
                            return '<span class="badge rounded-pill text-bg-info">Not Today</span>';
                        }
                    })
                    ->rawColumns(['action', 'reschedule_date'])
                    ->make(mDataSupport: true);
            } else if ($type == 'maintenance') {
                if (auth()->user()->hasRole('superadmin')) {
                    $maintenances = Maintenances::all();
                } elseif (auth()->user()->can('assign technician') && auth()->user()->hasRole('technician')) {
                    $allTechnicians = Technician::where('unit_id', auth()->user()->technician->unit_id)->pluck('id');
                    $maintenances = Maintenances::whereIn('technician_id', $allTechnicians)->get();
                } elseif (auth()->user()->hasRole('technician')) {
                    $maintenances = Maintenances::where('technician_id', auth()->user()->technician->id)->get();
                }

                return DataTables::of($maintenances)
                    ->addIndexColumn()
                    ->addColumn('item', function ($row) {
                        return $row->item_room->items->item_name;
                    })
                    ->addColumn('room', function ($row) {
                        return $row->item_room->rooms->name;
                    })
                    ->addColumn('serial_number', function ($row) {
                        return $row->item_room->serial_number;
                    })
                    ->addColumn('installation_date', function ($row) {
                        return Carbon::parse($row->item_room->installation_date)->isoFormat('D MMMM Y');
                    })
                    ->addColumn('technician', function ($row) {
                        return $row->technician->name ?? '<span class="badge rounded-pill text-bg-warning">Not Selected</span>';
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 0) {
                            return '<span class="badge rounded-pill text-bg-info">Pending</span>';
                        } elseif ($row->status == 1) {
                            return '<span class="badge rounded-pill text-bg-secondary">Worked on</span>';
                        } elseif ($row->status == 2) {
                            return '<span class="badge rounded-pill text-bg-warning">Worked on Delay</span>';
                        } elseif ($row->status == 3) {
                            return '<span class="badge rounded-pill text-bg-success">Completed</span>';
                        } elseif ($row->status == 4) {
                            return '<span class="badge rounded-pill text-bg-danger">Need Repair</span>';
                        } elseif ($row->status == 5) {
                            return '<span class="badge rounded-pill text-bg-light">Pending Room</span>';
                        } elseif ($row->status == 6) {
                            return '<span class="badge rounded-pill text-bg-primary">Accepted by Room</span>';
                        } elseif ($row->status == 7) {
                            return '<span class="badge rounded-pill text-bg-info">Reschedule</span>';
                        } else {
                            return '<span class="badge rounded-pill text-bg-danger">Undefined</span>';
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        $btn .= '<a href="' . route('maintenances.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="Show data"><i class="ph-duotone ph-eye"></i></a>';
                        if (auth()->user()->hasRole('technician') && $row->technician_id == auth()->user()->technician->id) {
                            if ($row->date_worked_on == null && $row->date_cancelled == null && $row->status == 0) {
                                $btn .= '<a href="#" class="accept btn btn-secondary btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Start Maintenance"><i class="ph-duotone ph-wrench"></i></a>';
                            }
                        }

                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'status', 'technician'])
                    ->make(true);
            } else if ($type == 'process') {
                if (auth()->user()->hasRole('superadmin')) {
                    $maintenances = Maintenances::where('date_worked_on', '!=', null)->where('date_completed', null)->get();
                } elseif (auth()->user()->can('assign technician') && auth()->user()->hasRole('technician')) {
                    $allTechnicians = Technician::where('unit_id', auth()->user()->technician->unit_id)->pluck('id');
                    $maintenances = Maintenances::where('date_worked_on', '!=', null)->where('date_completed', null)->whereIn('technician_id', $allTechnicians)->get();
                } elseif (auth()->user()->hasRole('technician')) {
                    $maintenances = Maintenances::where('date_worked_on', '!=', null)->where('date_completed', null)->where('technician_id', auth()->user()->technician->id)->get();
                }

                $maintenances = $maintenances->sortByDesc('created_at');

                return DataTables::of($maintenances)
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
                        $remark .= '"placeholder="Enter maintenance remark for ' . $row->item_room->items->item_name . '">';
                        $remark .= old('remarks', $row->remarks);
                        $remark .= '</textarea>';

                        return $remark;
                    })
                    ->addColumn('description', function ($row) {
                        $description = '<textarea type="text" name="description" rows="4" id="" class="form-control description" data-id="' . encrypt($row->id);
                        $description .= '"placeholder="Enter maintenance description for ' . $row->item_room->items->item_name . '">';
                        $description .= old('description', $row->description);
                        $description .= '</textarea>';

                        return $description;
                    })
                    ->addColumn('evidence', function ($row) {
                        $evidence = '<input type="file" name="evidence" class="form-control" id="evidence" placeholder="Upload evidence for ' . $row->item_room->items->item_name . '">';
                        return $evidence;
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        if ($row->evidence) {
                            $btn .= '<a href="' . asset('/temp/' . $row->evidence) . '" target="_blank" class="btn btn-info btn-sm me-2" title="View Evidence"><i class="ph-duotone ph-eye"></i></a>';
                        }
                        if (!$row->date_completed) {
                            $btn .= '<a href="#" class="update btn btn-warning btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Update Maintenance"><i class="ph-duotone ph-pencil-line"></i></a>';
                        }
                        $btn .= '<a href="#" class="finish btn btn-success btn-sm" data-id="' . encrypt($row->id) . '" title="Finish Maintenance"';
                        $btn .= '><i class="ph-duotone ph-check"></i></a>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'remarks', 'description', 'evidence', 'status'])
                    ->make(true);
            }
        } else {
            if (auth()->user()->hasRole('superadmin')) {
                $technicians = Technician::all();
            } elseif (auth()->user()->can('assign technician') && auth()->user()->hasRole('technician')) {
                $technicians = Technician::where('unit_id', auth()->user()->technician->unit_id)->get();
            } else {
                $technicians = [];
            }
            return view('maintenances.index', compact('technicians'));
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
                    $itemUnit = Items_units::find(decrypt($request->item_unit_id));
                    $create = Maintenances::create([
                        'room_id' => $itemUnit->room_id,
                        'item_room_id' => decrypt($request->item_unit_id),
                        'status' => 5,
                    ]);
                } else {
                    return response()->json(['error' => 'You are not authorized to alert room']);
                }

                $room = Rooms::find($itemUnit->room_id);
                $itemLog = [
                    'norec' => $itemUnit->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => 'Item ' . $itemUnit->items->item_name . ' has been requested for maintenance by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                    'item_unit_id' => $itemUnit->id,
                ];

                $maintenanceLog = [
                    'norec' => $create->norec,
                    // 'norec_parent' => $submissionOfRepair->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => 'Item ' . $itemUnit->items->item_name . ' has been requested for maintenance by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                    'item_unit_id' => $itemUnit->id,
                ];

                createLog($itemLog);
                createLog($maintenanceLog);

                DB::commit();
                return response()->json(['success' => 'The room has been successfully alerted!']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to alert maintenance to unit: ' . $e->getMessage()]);
            }
        } else {
            DB::beginTransaction();
            try {
                $request->validate([
                    'item_unit_id' => 'required',
                    'technician' => 'required',
                ]);
    
                if (auth()->user()->can('assign technician') || auth()->user()->hasRole('superadmin')) {
                    $create = Maintenances::updateOrCreate(
                        [
                            'item_room_id' => decrypt($request->item_unit_id),
                        ],
                        [
                            'room_id' => Items_units::find(decrypt($request->item_unit_id))->room_id,
                            'technician_id' => decrypt($request->technician),
                            'status' => 0,
                        ]
                    );
                } else {
                    return redirect()->back()->with('error', 'You are not authorized to assign maintenance to technician');
                }

                $room = Rooms::find($create->room_id);
                $technician = Technician::find($create->technician_id);

                if ($create) {
                    $maintenanceLog = [
                        'norec' => $create->norec,
                        // 'norec_parent' => $submission->norec,
                        'module_id' => 3,
                        'is_maintenance' => true,
                        'desc' => 'Technician ' . $create->technician->name . ' has been assigned for maintenance of ' . $create->item_room->items->item_name . ' by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                        'item_unit_id' => $create->item_room_id,
                        'technician_id' => $create->technician_id,
                    ];
        
                    $technicianLog = [
                        'norec' => $create->technician->norec,
                        'norec_parent' => auth()->user()->norec,
                        'module_id' => 3,
                        'desc' => $technician->name . ' has been assigned for maintenance of ' . $create->item_room->items->item_name . ' by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                        'is_maintenance' => true,
                        'item_unit_id' => $create->item_room_id,
                        'technician_id' => $create->technician_id,
                    ];
        
                    createLog($maintenanceLog);
                    createLog($technicianLog);

                    DB::commit();
                    return redirect()->back()->with('success', 'Maintenance assigned to technician');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                $line = $e->getLine();
                return redirect()->back()->with('error', 'Failed to alert maintenance to unit: ' . $e->getMessage() . ' in line ' . $line);
            }
        }
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = decrypt($id);
        $maintenance = Maintenances::find($id);
        $items = Items_units::find($maintenance->item_room_id);
        return view('maintenances.show', compact('maintenance', 'items'));
    }

    public function acceptMaintenances(Request $request)
    {
        return $this->acceptOrFinishState($request, 'accepted');
    }

    public function finishMaintenances(Request $request)
    {
        return $this->acceptOrFinishState($request, 'completed');
    }

    private function getMaintenancesById($req)
    {
        if (is_object($req)) {
            $id = decrypt($req->get('id'));
        } else {
            $id = decrypt($req);
        }

        // return Maintenances::findOrFail($id);
        $maintenance = Maintenances::where('id', $id)->first();
        return $maintenance;
    }

    private function acceptOrFinishState($req, $state)
    {
        $maintenance = $this->getMaintenancesById($req);

        if ($maintenance->status == 1) {
            return response()->json(['error', 'message' => 'You need to complete the maintenance first']);
        }

        if ($state == 'accepted' && $maintenance->status == 0) {
            try {
                DB::beginTransaction();

                $maintenance->date_worked_on = now();
                $maintenance->status = 1;
                $maintenance->save();

                $room = Rooms::find($maintenance->room_id);

                $maintenanceLog = [
                    'norec' => $maintenance->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => 'Technician ' . $maintenance->technician->name . ' has started maintenance on item ' . $maintenance->item_room->items->item_name . ' by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                    'item_unit_id' => $maintenance->item_room_id,
                    'technician_id' => $maintenance->technician_id,
                ];

                $technicianLog = [
                    'norec' => $maintenance->technician->norec,
                    'module_id' => 3,
                    'desc' => 'Maintenance of ' . $maintenance->item_room->items->item_name . ' has been started by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                    'is_maintenance' => true,
                    'item_unit_id' => $maintenance->item_room_id,
                    'technician_id' => $maintenance->technician_id,
                ];

                createLog($maintenanceLog);
                createLog($technicianLog);

                DB::commit();
                return response()->json(['success' => 'Maintenance accepted!']);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to accept maintenance']);
            }
        } elseif ($state == 'completed' && ($maintenance->status == 2 || $maintenance->status == 3 || $maintenance->status == 4)) {
            DB::beginTransaction();

            try {
                $maintenance->date_completed = now();
    
                if ($maintenance->status == 2) {
                    $maintenance->status = 3;
                }
    
                $items = Items_units::find($maintenance->item_room_id);
    
                $items->status = 'Running';
    
                $date_completed = date('Y-m-d', strtotime($maintenance->date_completed));
                $condition = strtotime($date_completed) - strtotime($items->maintenance_date);
                // 2592000 = 30 days
                if ($condition > 25923000) {
                    $items->maintenance_date = date('Y-m-d', strtotime($maintenance->date_completed) + ($items->items->downtime * 86400));
                } else {
                    $items->maintenance_date = date('Y-m-d', strtotime($items->maintenance_date) + ($items->items->downtime * 86400));
                }
                $items->save();
                $maintenance->save();
                

                $maintenanceLog = [
                    'norec' => $maintenance->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => 'Technician ' . $maintenance->technician->name . ' has finished maintenance ' . $maintenance->item_room->items->item_name . ' by ' . auth()->user()->name . ' from ' . $maintenance->room->name . ' (' . $maintenance->room->units->customer_name . ')',
                    'old_data' => $maintenance->toJson(),
                    'item_unit_id' => $maintenance->item_room_id,
                    'technician_id' => $maintenance->technician_id,
                ];
    
                $technicianLog = [
                    'norec' => auth()->user()->technician->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => $maintenance->technician->name . ' has finished maintenance ' . $maintenance->item_room->items->item_name . ' from ' . $maintenance->room->name . ' (' . $maintenance->room->units->customer_name . ')',
                    'item_unit_id' => $maintenance->item_room_id,
                    'technician_id' => $maintenance->technician_id,
                ];
    
                $itemLog = [
                    'norec' => $items->norec,
                    'module_id' => 7,
                    'is_maintenance' => true,
                    'desc' => 'Maintenance of ' . $maintenance->item_room->items->item_name . ' has been FINISHED by ' . $maintenance->technician->name . ' from ' . $maintenance->room->name . ' (' . $maintenance->room->units->customer_name . ') with last STATUS ' . $maintenance->item_room->status . ' and REMARKS ' . $maintenance->remarks,
                    'old_data' => $maintenance->item_room->toJson(),
                    'item_unit_id' => $maintenance->item_room_id,
                    'technician_id' => $maintenance->technician_id,
                ];
    
                createLog($maintenanceLog);
                createLog($technicianLog);
                createLog($itemLog);

                DB::commit();
                return response()->json(['success' => 'Maintenance completed!']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to complete maintenance: ' . $e->getMessage() . ' in line ' . $e->getLine()]);
            }
        }
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
    public function update(Request $request, $id)
    {
        $id = decrypt($id);

        if ($request->type == 'acceptRoom') {
            DB::beginTransaction();

            try {
                $maintenance = Maintenances::find($id);
                $itemUnit = Items_units::find($maintenance->item_room_id);
                $maintenance->status = 6;
                $maintenance->schedule_by_room = $itemUnit->maintenance_date;

                $maintenance->save();

                $room = Rooms::find($itemUnit->room_id);
                $itemLog = [
                    'norec' => $itemUnit->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => 'Item ' . $itemUnit->items->item_name . ' has been accepted for maintenance by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                    'item_unit_id' => $itemUnit->id,
                ];

                $maintenanceLog = [
                    'norec' => $maintenance->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => 'Item ' . $itemUnit->items->item_name . ' has been accepted for maintenance by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                    'item_unit_id' => $itemUnit->id,
                ];

                createLog($itemLog);
                createLog($maintenanceLog);

                DB::commit();
                return response()->json(['success' => 'Maintenance accepted!']);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'Failed to accept maintenance']);
            }
        }

        if ($request->type == 'reschedule') {
            DB::beginTransaction();

            try {
                $request->validate([
                    'newMaintenance_date' => 'required',
                ]);
    
                $maintenance = Maintenances::find($id);
                $itemUnit = Items_units::find($maintenance->item_room_id);
                $maintenance->status = 7;
                $maintenance->schedule_by_room = $request->newMaintenance_date;

                $maintenance->save();

                $room = Rooms::find($maintenance->room_id);

                $itemLog = [
                    'norec' => $itemUnit->norec,
                    'norec_parent' => auth()->user()->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => 'Item ' . $itemUnit->items->item_name . ' has been rescheduled for maintenance to: ' . $request->newMaintenance_date . ' by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                    'item_unit_id' => $itemUnit->id,
                ];

                $maintenanceLog = [
                    'norec' => $maintenance->norec,
                    'module_id' => 3,
                    'is_maintenance' => true,
                    'desc' => 'Item ' . $itemUnit->items->item_name . ' has been rescheduled for maintenance to: ' . $request->newMaintenance_date . ' by ' . auth()->user()->name . ' from ' . $room->name . ' (' . $room->units->customer_name . ')',
                    'item_unit_id' => $itemUnit->id,
                ];

                createLog($itemLog);
                createLog($maintenanceLog);

                DB::commit();
                return redirect()->back()->with('success', 'Maintenance rescheduled!');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Failed to reschedule maintenance');
            }
        }

        try {
            DB::beginTransaction();

            $request->validate([
                'remarks' => 'required',
                'description' => 'required',
                'status' => 'required',
                'evidence' => 'required',
            ]);
    
            $maintenance = Maintenances::find($id);
            $item_unit = Items_units::find($maintenance->item_room_id);
            $oldMaintenance = $maintenance->toJson();
            $oldItemUnit = $item_unit->toJson();
            $oldData = json_encode(array_merge(json_decode($oldMaintenance, true), json_decode($oldItemUnit, true)));
            $oldStatus = $item_unit->status;
            $maintenance->remarks = $request->remarks;
            $maintenance->description = $request->description;
            $maintenance->evidence = $request->evidence;
    
            $item_unit->status = $request->status;
    
            if ($request->status == 'Running') {
                $maintenance->status = 3;
            } elseif ($request->status == 'System Down') {
                $maintenance->status = 2;
            } elseif ($request->status == 'Restricted') {
                $maintenance->status = 4;
            }
    
            $maintenance->save();
            $item_unit->save();

            $maintenanceLog = [
                'norec' => $maintenance->norec,
                'module_id' => 3,
                'is_maintenance' => true,
                'desc' => 'Technician ' . $maintenance->technician->name . ' has UPDATED THE STATUS and REMARKS of ' . $maintenance->item_room->items->item_name . ' to ' . $request->status . ' from ' . $oldStatus . ' by ' . auth()->user()->name . ' from ' . $maintenance->room->name . ' (' . $maintenance->room->units->customer_name . ')' . ' with REMARKS ' . $request->remarks,
                'old_data' => $oldData,
                'item_unit_id' => $maintenance->item_room_id,
                'technician_id' => $maintenance->technician_id,
            ];

            $technicianLog = [
                'norec' => auth()->user()->technician->norec,
                'module_id' => 3,
                'is_maintenance' => true,
                'desc' => $maintenance->technician->name . ' has UPDATED THE STATUS and REMARKS of ' . $maintenance->item_room->items->item_name . ' to ' . $request->status . ' from ' . $oldStatus . ' with REMARKS ' . $request->remarks,
                'item_unit_id' => $maintenance->item_room_id,
                'technician_id' => $maintenance->technician_id,
            ];

            $itemLog = [
                'norec' => $item_unit->norec,
                'module_id' => 7,
                'is_maintenance' => true,
                'desc' => 'STATUS of ' . $item_unit->items->item_name . ' has been UPDATED to ' . $request->status . ' from ' . $oldStatus . ' with REMARKS ' . $request->remarks,
                'old_data' => $oldItemUnit,
                'item_unit_id' => $maintenance->item_room_id,
                'technician_id' => $maintenance->technician_id,
            ];

            createLog($maintenanceLog);
            createLog($technicianLog);
            createLog($itemLog);
    
            DB::commit();
            return response()->json(['success' => 'Maintenance status updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update maintenance status: ' . $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenances $maintenances)
    {
        //
    }

    public function history()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('superadmin')) {
                $maintenances = Maintenances::all();
            } elseif (auth()->user()->can('assign technician') && auth()->user()->hasRole('technician')) {
                $allTechnicians = Technician::where('unit_id', auth()->user()->technician->unit_id)->pluck('id');
                $maintenances = Maintenances::whereIn('technician_id', $allTechnicians)->get();
            } elseif (auth()->user()->hasRole('technician')) {
                $maintenances = Maintenances::where('technician_id', auth()->user()->technician->id)->get();
            } else if (auth()->user()->hasRole('room')) {
                $room = auth()->user()->room;
                $maintenances = Maintenances::where('room_id', $room->id)->get();
            }

            return DataTables::of($maintenances)
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
                ->addColumn('maintenance_date', function ($row) {
                    return Carbon::parse($row->item_room->first()->maintenance_date)->isoFormat('D MMMM Y');
                })
                ->addColumn('reschedule_date', function ($row) {
                    $date = '';
                    if ($row->status == 5) {
                        $date = '<span class="badge rounded-pill text-bg-info">Waiting Room Confirmation</span>';
                    } elseif ($row->schedule_by_room == $row->item_room->first()->maintenance_date) {
                        $date = '<span class="badge rounded-pill text-bg-success">According To The Schedule</span>';
                    } elseif ($row->schedule_by_room != $row->item_room->first()->maintenance_date) {
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
                        'module_id' => 3,
                        'status' => 'is_maintenance',
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
                ->rawColumns(['worked_on', 'completed', 'reschedule_date', 'action'])
                ->make(true);
        } else {
            return view('maintenances.history');
        }
    }

    public function confirmation()
    {
        if (request()->ajax()) {
            if (auth()->user()->hasRole('superadmin')) {
                $maintenances = Maintenances::where('status', 5)->get();
            } else if (auth()->user()->hasRole('room')) {
                $room = auth()->user()->room;
                $maintenances = Maintenances::where('room_id', $room->id)->where('status', 5)->get();
            }

            return DataTables::of($maintenances)
                ->addIndexColumn()
                ->addColumn('item', function ($row) {
                    $items = $row->item_room->items->item_name;
                    return $items;
                })
                ->addColumn('serial_number', function ($row) {
                    return $row->item_room->serial_number;
                })
                ->addColumn('maintenance_date', function ($row) {
                    return Carbon::parse($row->item_room->maintenance_date)->isoFormat('D MMMM Y');
                })
                ->addColumn('action', function ($row) {
                    if ($row->status == 5) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        $btn = '<button type="button" class="btn btn-success btn-sm accMaintenance me-2" title="Accept Maintenance" data-id="' . encrypt($row->id) . '" data-name="' . $row->item_room->items->item_name . '"><i class="ph ph-duotone ph-check"></i></button>';
                        $btn .= '<button type="button" class="btn btn-warning btn-sm rescheduleMaintenance" title="Reschedule Maintenance" data-id="' . encrypt($row->id) . '" data-name="' . $row->item_room->items->item_name . '"><i class="ph ph-duotone ph-pencil-line"></i></button>';
                        $btn .= '</div>';
                    } else if ($row->schedule_by_room == $row->item_room->maintenance_date) {
                        $btn = '<span class="badge text-bg-success">According To The Schedule</span>';
                    } else if ($row->schedule_by_room != $row->item_room->maintenance_date) {
                        $btn = '<span class="badge text-bg-info">Rescheduled</span>';
                    } else {
                        $btn = '<span class="badge rounded-pill text-bg-info">Nothing To Do Here</span>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } else {
            return view('maintenances.confirmation');
        }
    }
}