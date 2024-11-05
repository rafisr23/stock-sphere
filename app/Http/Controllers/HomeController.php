<?php

namespace App\Http\Controllers;

use App\Models\Items_units;
use App\Models\Maintenances;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function pageView($routeName, $page = null)
    {
        // Construct the view name based on the provided routeName and optional page parameter
        $viewName = ($page) ? $routeName . '.' . $page : $routeName;
        // Check if the constructed view exists
        if (View::exists($viewName)) {
            // If the view exists, return the view
            return view($viewName);
        } else {
            // If the view doesn't exist, return a 404 error
            abort(404);
        }
    }

    public function index()
    {
        $loginDate = Carbon::parse(auth()->user()->last_login_date);

        if (auth()->user()->hasRole('superadmin') || auth()->user()->can('assign technician')) {
            $maintenanceData = Maintenances::all();
            $loginDatePlusMonth = Carbon::parse($loginDate)->addMonth()->format('Y-m-d');
            $itemsQuery = Items_units::query();

            if (auth()->user()->hasRole('superadmin')) {
                $items = $itemsQuery->where('maintenance_date', '<=', $loginDatePlusMonth)->exists();
                $items2 = $itemsQuery->get();
            } else {
                $technician = auth()->user()->technician;
                $roomId = Rooms::where('unit_id', $technician->unit_id)->pluck('id');
                $items = $itemsQuery->whereIn('room_id', $roomId)->where('maintenance_date', '<=', $loginDatePlusMonth)->exists();
                $items2 = $itemsQuery->whereIn('room_id', $roomId)->get();
            }

            $maintenanceSoon = $items ? 'true' : 'false';
            $maintenanceExpired = 'false';

            foreach ($items2 as $item) {
                if (Carbon::parse($loginDate)->greaterThan($item->maintenance_date)) {
                    $maintenanceMonth = Carbon::parse($item->maintenance_date)->format('Y-m');
                    $existingMaintenance = Maintenances::where('item_room_id', $item->id)
                        ->whereBetween('created_at', [
                            Carbon::parse($maintenanceMonth)->startOfMonth(),
                            Carbon::parse($maintenanceMonth)->endOfMonth()
                        ])
                        ->exists();

                    if (!$existingMaintenance) {
                        $maintenanceExpired = 'true';
                        break;
                    }
                }
            }

            return view('index', compact('maintenanceSoon', 'maintenanceExpired'));
        } else {
            return view('index');
        }
    }
}
