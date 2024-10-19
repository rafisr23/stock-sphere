<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index() {
        if (request()->ajax()) {
            $logs = Log::orderBy('created_at', 'desc')->get();
            return datatables()->of($logs)
                ->addIndexColumn()
                ->addColumn('module', function ($row) {
                    switch ($row->module) {
                        case '1':
                            return 'Item';
                            break;
                        case '2':
                            return 'Repir';
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
                ->addColumn('activity', function ($row) {
                    return $row->action ?? '-';
                })
                ->addColumn('ip', function ($row) {
                    return $row->ip ?? '-';
                })
                ->addColumn('user', function ($row) {
                    $user = User::find($row->user_id);
                    return $user->name ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . '" class="edit btn btn-info btn-sm me-2"><i class="ph-duotone ph-info"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 

        return view('log.index');
    }

    public function getLog($moduleId) {
        $logs = Log::where('module_id', $moduleId)->orderBy('created_at', 'desc')->get();
        return view('log.modal', compact('logs'));
    }
}