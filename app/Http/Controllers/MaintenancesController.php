<?php

namespace App\Http\Controllers;

use App\Models\Items_units;
use App\Models\Maintenances;
use App\Models\Rooms;
use App\Models\Technician;
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
                            return '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignTechnicianModal" title="Assign Technician" data-id="' . encrypt($row->id) . '" data-name="' . $row->items->item_name . ' (' . $row->serial_number . ')"><i class="ph ph-duotone ph-wrench"></i></button>';
                        } elseif ($status !== null) {
                            return '<span class="badge rounded-pill text-bg-success">Already Assigned</span>';
                        } else {
                            return '<span class="badge rounded-pill text-bg-info">Not Today</span>';
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else if ($type == 'maintenance') {
                if (auth()->user()->hasRole('superadmin')) {
                    $maintenances = Maintenances::all();
                } elseif (auth()->user()->can('assign technician') && auth()->user()->hasRole('technician')) {
                    $allTechnicians = Technician::where('unit_id', auth()->user()->technician->unit_id)->pluck('id');
                    $maintenances = Maintenances::whereIn('technician_id', $allTechnicians)->get();
                } elseif (auth()->user()->hasRole('technician')) {
                    $maintenances = Maintenances::where('technician_id', auth()->user()->technician->id)->get();
                }

                $maintenances = $maintenances->sortByDesc('created_at');

                return DataTables::of($maintenances)
                    ->addIndexColumn()
                    ->addColumn('item', function ($row) {
                        return $row->item_room->items->item_name;
                    })
                    ->addColumn('serial_number', function ($row) {
                        return $row->item_room->serial_number;
                    })
                    ->addColumn('technician', function ($row) {
                        return $row->technician->name;
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->status == 0) {
                            return '<span class="badge rounded-pill text-bg-info">Pending</span>';
                        } elseif ($row->status == 1) {
                            return '<span class="badge rounded-pill text-bg-secondary">Worked on</span>';
                        } elseif ($row->status == 2) {
                            return '<span class="badge rounded-pill text-bg-warning">Work On Delay</span>';
                        } elseif ($row->status == 3) {
                            return '<span class="badge rounded-pill text-bg-success">Completed</span>';
                        } else {
                            return '<span class="badge rounded-pill text-bg-danger">Need Repair</span>';
                        }
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="d-flex justify-content-center align-items-center">';
                        $btn .= '<a href="' . route('maintenances.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2" title="Show data"><i class="ph-duotone ph-eye"></i></a>';
                        if ($row->date_worked_on == null && $row->date_cancelled == null && $row->status == 0) {
                            $btn .= '<a href="#" class="accept btn btn-success btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Accept Maintenance"><i class="ph-duotone ph-check"></i></a>';
                            $btn .= '<a href="#" class="cancel btn btn-danger btn-sm me-2" data-id="' . encrypt($row->id) . '" title="Cancel Maintenance"><i class="ph-duotone ph-x"></i></a>';
                        }
                        if ($row->date_worked_on != null && $row->date_completed == null && $row->status == 1) {
                            $btn .= '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#startMaintainingModal" title="Start Maintaining" data-id="' . encrypt($row->id) . '" data-name="' . $row->item_room->items->item_name . ' (' . $row->serial_number . ')"><i class="ph ph-duotone ph-wrench"></i></button>';
                        }

                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'status'])
                    ->make(true);
            } else if ($type == 'history') {
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
        $request->validate([
            'item_unit_id' => 'required',
            'technician' => 'required',
        ]);

        if (auth()->user()->can('assign technician') || auth()->user()->hasRole('superadmin')) {
            $create = Maintenances::create([
                'room_id' => Items_units::find(decrypt($request->item_unit_id))->room_id,
                'item_room_id' => decrypt($request->item_unit_id),
                'technician_id' => decrypt($request->technician),
                'status' => 0,
            ]);
        } else {
            return redirect()->back()->with('error', 'You are not authorized to assign maintenance to technician');
        }


        if ($create) {
            return redirect()->back()->with('success', 'Maintenance assigned to technician');
        } else {
            return redirect()->back()->with('error', 'Failed to assign maintenance to technician');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id = decrypt($id);
        $maintenance = Maintenances::find($id);
        return view('maintenances.show', compact('maintenance'));
    }

    public function acceptMaintenances(Request $request)
    {
        return $this->acceptCancelFinishState($request, 'accepted');
    }

    public function cancelMaintenances(Request $request)
    {
        return $this->acceptCancelFinishState($request, 'canceled');
    }

    public function finishMaintenances(Request $request)
    {
        return $this->acceptCancelFinishState($request, 'completed');
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

    private function acceptCancelFinishState($req, $state)
    {
        $maintenance = $this->getMaintenancesById($req);

        if ($maintenance->date_worked_on != null) {
            return response()->json(['error', 'message' => 'Maintenances already accepted']);
        }
        if ($maintenance->date_cancelled != null) {
            return response()->json(['error', 'message' => 'Maintenances already canceled']);
        }
        if ($maintenance->date_completed != null) {
            return response()->json(['error', 'message' => 'Maintenances already completed']);
        }

        if ($state == 'accepted') {
            $maintenance->date_worked_on = now();

            if ($maintenance->date_worked_on == null) {
                $maintenance->date_worked_on = now();
                $maintenance->status = 1;
                $maintenance->save();
            }

        } elseif ($state == 'canceled') {
            $maintenance->date_cancelled = now();

            $allCancelled = Maintenances::whereNull('date_cancelled')
                ->doesntExist();

            if ($allCancelled) {
                $maintenance->date_cancelled = now();
            }
        } elseif ($state == 'completed') {
            $maintenance->date_completed = now();

            $allCompleted = Maintenances::whereNull('date_completed')
                ->doesntExist();

            if ($allCompleted) {
                $maintenance->date_completed = now();
            }
        }
        if ($maintenance->save() && $maintenance->save()) {
            return response()->json(['success' => 'Maintenances ' . $state . ' successfully']);
        }
        $result = strstr($state, 'ed', true);
        return response()->json(['error' => 'Failed to ' . $result . ' repairments']);
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
        dd($id);
        $maintenance = Maintenances::find(decrypt($id));
        dd($maintenance);
        $maintenance->status = $request->status;
        $maintenance->save();

        return redirect()->back()->with('success', 'Maintenance status updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenances $maintenances)
    {
        //
    }
}
