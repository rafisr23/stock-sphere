<?php

namespace App\Http\Controllers;

use DB;
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
            // $status_count = DB::table('details_of_repair_submissions')
            //     ->select('status', DB::raw('COUNT(*) as total'))
            //     ->whereIn('status', [0, 1])
            //     ->groupBy('status')
            //     ->get();


            if (auth()->user()->hasRole('superadmin')) {
                $items_repairments_count = DB::table('items_units as iu')
                    // get data items_units from details_of_repair_submissions so we can count the repairments by item
                    ->leftJoin('details_of_repair_submissions as d', 'iu.id', '=', 'd.item_unit_id')
                    ->leftJoin('items as i', 'iu.item_id', '=', 'i.id')
                    ->select('i.item_name', 'd.created_at as date')
                    ->where('d.item_unit_id', '!=', null)
                    ->get();

                $sparepart_repairments_count = DB::table('spareparts as s')
                    ->select('s.name as sparepart_name', 'i.id as items_id', 'd.created_at as date')
                    ->leftJoin('spareparts_of_repairs as sr', 's.id', '=', 'sr.sparepart_id')
                    ->leftJoin('details_of_repair_submissions as d', 'sr.details_of_repair_submission_id', '=', 'd.id')
                    ->leftJoin('items_units as iu', 'd.item_unit_id', '=', 'iu.id')
                    ->leftJoin('items as i', 'iu.item_id', '=', 'i.id')
                    ->where('sr.sparepart_id', '!=', null)
                    ->get();
                $items_units = Items_units::all();
                $items2 = $itemsQuery->get();
                $items = $itemsQuery->where('maintenance_date', '<=', $loginDatePlusMonth)->where('maintenance_date', '>=', $loginDate->format('Y-m-d'))->exists();
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
                    $existingMaintenance = Maintenances::where('item_room_id', $item->id)
                        ->whereBetween('created_at', [
                            Carbon::parse($loginDate)->startOfMonth(),
                            Carbon::parse($loginDate)->endOfMonth()
                        ])
                        ->exists();

                    if (!$existingMaintenance) {
                        $maintenanceExpired = 'true';
                        break;
                    }
                }
            }

            return view(
                'index',
                compact(
                    'maintenanceSoon',
                    'maintenanceExpired',
                    'sparepart_repairments_count',
                    'items_units',
                    'items_repairments_count',
                )
            );
        } else {
            return view('index');
        }
    }
}
