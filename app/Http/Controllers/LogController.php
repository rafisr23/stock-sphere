<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use App\Models\NewLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            $logs = NewLog::orderBy('created_at', 'desc')->get();
            return datatables()->of($logs)
                ->addIndexColumn()
                ->addColumn('module_id', function ($row) {
                    switch ($row->module_id) {
                        case '1':
                            return 'Item';
                            break;
                        case '2':
                            return 'Repair';
                            break;
                        case '3':
                            return 'Maintenance';
                            break;
                        case '4':
                            return 'Room';
                            break;
                        case '5':
                            return 'Unit';
                            break;
                        case '6':
                            return 'Spare part';
                            break;
                        case '7':
                            return 'Assign Item';
                            break;
                        case '8':
                            return 'Technician';
                            break;
                        case '9':
                            return 'User';
                            break;
                        default:
                            return '-';
                            break;
                    }
                })
                ->addColumn('desc', function ($row) {
                    return $row->desc ?? '-';
                })
                ->addColumn('ip', function ($row) {
                    return $row->ip ?? '-';
                })
                ->addColumn('user', function ($row) {
                    $user = User::find($row->user_id);
                    return $user->name ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $showUrl = route('log.show', encrypt($row->id));
                    $btn = '<a href="' . $showUrl . '" class="edit btn btn-info btn-sm me-2"><i class="ph-duotone ph-info"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 

        return view('log.index');
    }

    public function getLog($norec, $module, $status) {
        $logs = NewLog::where('norec', $norec)
            ->orWhere('norec_parent', $norec)
            // ->where('is_generic', true)
            ->orderBy('created_at', 'desc')
            ->get();
        // if ($status == 'is_generic' && $norec != null) {
        // } else if ($status == 'is_repair' && $norec != null) {
        //     $logs = NewLog::where('norec', $norec)
        //         ->orWhere('norec_parent', $norec)
        //         ->where('is_repair', true)
        //         ->orderBy('created_at', 'desc')
        //         ->get();
        // } else if ($status == 'is_maintenance' && $norec != null) {
        //     $logs = NewLog::where('norec', $norec)
        //         ->orWhere('norec_parent', $norec)
        //         ->where('is_maintenance', true)
        //         ->orderBy('created_at', 'desc')
        //         ->get();
        // } else {
        //     $logs = [];
        // }

        return view('log.modal', compact('logs'));
    }

    public function show($id) {
        $decId = decrypt($id);
        $log = NewLog::find($decId);

        switch ($log->module_id) {
            case 1:
                $log->module_name = 'Item';
                break;
            case 2:
                $log->module_name = 'Repair';
                break;
            case 3:
                $log->module_name = 'Maintenance';
                break;
            case 4:
                $log->module_name = 'Room';
                break;
            case 5:
                $log->module_name = 'Unit';
                break;
            case 6:
                $log->module_name = 'Spare part';
                break;
            case 7:
                $log->module_name = 'Assign Item';
                break;
            case 8:
                $log->module_name = 'Technician';
                break;
            case 9:
                $log->module_name = 'User';
                break;
            default:
                $log->module_name = '-';
                break;
        }

        return view('log.show', compact('log'));
    }
}