<?php

namespace App\Http\Controllers;

use App\Models\Calibrations;
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
            $maintenanceSoonRoom = false;
            $calibrationSoonRoom = false;
            // $status_count = DB::table('details_of_repair_submissions')
            //     ->select('status', DB::raw('COUNT(*) as total'))
            //     ->whereIn('status', [0, 1])
            //     ->groupBy('status')
            //     ->get();

            if (auth()->user()->hasRole('superadmin') || auth()->user()->can('assign technician')) {
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

                $performanceData = $this->getPerformanceData();

                $items_units = Items_units::all();
                $items2 = $itemsQuery->get();
                $items = $itemsQuery->where('maintenance_date', '<=', $loginDatePlusMonth)->where('maintenance_date', '>=', $loginDate->format('Y-m-d'))->exists();
                $items_c = $itemsQuery->where('calibration_date', '<=', $loginDatePlusMonth)->where('calibration_date', '>=', $loginDate->format('Y-m-d'))->exists();
                $maintenanceSoonRoom = Maintenances::where('status', 5)->exists();
                $calibrationSoonRoom = Calibrations::where('status', 5)->exists();
            } else {
                $technician = auth()->user()->technician;
                $roomId = Rooms::where('unit_id', $technician->unit_id)->pluck('id');
                $items2 = $itemsQuery->whereIn('room_id', $roomId)->get();
                $items = $itemsQuery->whereIn('room_id', $roomId)->where('maintenance_date', '<=', $loginDatePlusMonth)->where('maintenance_date', '>=', $loginDate->format('Y-m-d'))->exists();
                $items_c = $itemsQuery->whereIn('room_id', $roomId)->where('calibration_date', '<=', $loginDatePlusMonth)->where('calibration_date', '>=', $loginDate->format('Y-m-d'))->exists();
                $sparepart_repairments_count = null;
                $items_units = null;
                $items_repairments_count = null;
                $performanceData = [];
            }

            $maintenanceSoon = $items ? 'true' : 'false';
            $calibrationSoon = $items_c ? 'true' : 'false';
            $maintenanceExpired = 'false';
            $calibrationExpired = 'false';

            foreach ($items2 as $item) {
                if (
                    Carbon::parse($loginDate)->greaterThan($item->maintenance_date) && !Maintenances::where('item_room_id', $item->id)
                        ->whereBetween('created_at', [
                            Carbon::parse($loginDate)->startOfMonth(),
                            Carbon::parse($loginDate)->endOfMonth()
                        ])->exists()
                ) {
                    $maintenanceExpired = 'true';
                    break;
                }
            }

            foreach ($items2 as $item) {
                if (
                    Carbon::parse($loginDate)->greaterThan($item->calibration_date) && !Calibrations::where('item_room_id', $item->id)
                        ->whereBetween('created_at', [
                            Carbon::parse($loginDate)->startOfMonth(),
                            Carbon::parse($loginDate)->endOfMonth()
                        ])->exists()
                ) {
                    $calibrationExpired = 'true';
                    break;
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
                    'maintenanceSoonRoom',
                    'calibrationSoonRoom',
                    'calibrationSoon',
                    'calibrationExpired',
                    'performanceData'
                )
            );
        } else if (auth()->user()->hasRole('room')) {
            $maintenanceSoonRoom = Maintenances::where('room_id', auth()->user()->room->id)->where('status', 5)->exists();
            $calibrationSoonRoom = Calibrations::where('room_id', auth()->user()->room->id)->where('status', 5)->exists();

            $items_units = Items_units::where('room_id', auth()->user()->room->id)->get();
            $items_repairments_count = DB::table('items_units as iu')
                // get data items_units from details_of_repair_submissions so we can count the repairments by item
                ->leftJoin('details_of_repair_submissions as d', 'iu.id', '=', 'd.item_unit_id')
                ->leftJoin('items as i', 'iu.item_id', '=', 'i.id')
                ->leftJoin('rooms as r', 'iu.room_id', '=', 'r.id')
                ->select('i.item_name', 'd.created_at as date')
                ->where('d.item_unit_id', '!=', null,)
                ->where('r.id', '=', auth()->user()->room->id)
                ->get();

            $sparepart_repairments_count = DB::table('spareparts as s')
                ->select('s.name as sparepart_name', 'i.id as items_id', 'd.created_at as date')
                ->leftJoin('spareparts_of_repairs as sr', 's.id', '=', 'sr.sparepart_id')
                ->leftJoin('details_of_repair_submissions as d', 'sr.details_of_repair_submission_id', '=', 'd.id')
                ->leftJoin('items_units as iu', 'd.item_unit_id', '=', 'iu.id')
                ->leftJoin('items as i', 'iu.item_id', '=', 'i.id')
                ->leftJoin('rooms as r', 'iu.room_id', '=', 'r.id')
                ->where('sr.sparepart_id', '!=', null)
                ->where('r.id', '=', auth()->user()->room->id)
                ->get();

            $performanceData = $this->getPerformanceData();

            return view('index', compact('maintenanceSoonRoom', 'calibrationSoonRoom', 'items_repairments_count', 'items_units', 'sparepart_repairments_count', 'performanceData'));
        } else if (auth()->user()->hasRole('technician')) {
            $items_repairments_count = DB::table('items_units as iu')
                // get data items_units from details_of_repair_submissions so we can count the repairments by item
                ->leftJoin('details_of_repair_submissions as d', 'iu.id', '=', 'd.item_unit_id')
                ->leftJoin('items as i', 'iu.item_id', '=', 'i.id')
                ->select('i.item_name', 'd.created_at as date')
                ->where('d.item_unit_id', '!=', null)
                ->where('d.technician_id', '=', auth()->user()->technician->id)
                ->get();
            $sparepart_repairments_count = DB::table('spareparts as s')
                ->select('s.name as sparepart_name', 'i.id as items_id', 'd.created_at as date')
                ->leftJoin('spareparts_of_repairs as sr', 's.id', '=', 'sr.sparepart_id')
                ->leftJoin('details_of_repair_submissions as d', 'sr.details_of_repair_submission_id', '=', 'd.id')
                ->leftJoin('items_units as iu', 'd.item_unit_id', '=', 'iu.id')
                ->leftJoin('items as i', 'iu.item_id', '=', 'i.id')
                ->where('sr.sparepart_id', '!=', null)
                ->where('d.technician_id', '=', auth()->user()->technician->id)
                ->get();

            $performanceData = $this->getPerformanceData();

            return view('index', compact('items_repairments_count', 'sparepart_repairments_count', 'performanceData'));
        } else if (auth()->user()->hasRole('unit')) {
            // return auth()->user()->unit;
            $room = Rooms::where('unit_id', auth()->user()->unit->id)->pluck('id');
            $items_repairments_count = DB::table('items_units as iu')
                // get data items_units from details_of_repair_submissions so we can count the repairments by item
                ->select('i.item_name', 'd.created_at as date')
                ->leftJoin('details_of_repair_submissions as d', 'iu.id', '=', 'd.item_unit_id')
                ->leftJoin('items as i', 'iu.item_id', '=', 'i.id')
                ->leftJoin('rooms as r', 'iu.room_id', '=', 'r.id')
                ->leftJoin('units as u', 'r.unit_id', '=', 'u.id')
                ->where('d.item_unit_id', '!=', null)
                // ->where('u.id', '=', auth()->user()->unit->id)
                ->whereIn('r.id', $room)
                ->get();
            $sparepart_repairments_count = DB::table('spareparts as s')
                ->select('s.name as sparepart_name', 'i.id as items_id', 'd.created_at as date')
                ->leftJoin('spareparts_of_repairs as sr', 's.id', '=', 'sr.sparepart_id')
                ->leftJoin('details_of_repair_submissions as d', 'sr.details_of_repair_submission_id', '=', 'd.id')
                ->leftJoin('items_units as iu', 'd.item_unit_id', '=', 'iu.id')
                ->leftJoin('items as i', 'iu.item_id', '=', 'i.id')
                ->leftJoin('rooms as r', 'iu.room_id', '=', 'r.id')
                ->leftJoin('units as u', 'r.unit_id', '=', 'u.id')
                ->where('sr.sparepart_id', '!=', null)
                // ->where('u.id', '=', auth()->user()->unit->id)
                ->whereIn('r.id', $room)
                ->get();

            $performanceData = $this->getPerformanceData();

            return view('index', compact('items_repairments_count', 'sparepart_repairments_count', 'performanceData'));
        } else {
            return view('index');
        }
    }

    public static function getPerformanceData($startDate = null, $endDate = null)
    {
        $query = "
            WITH log_intervals AS (
                SELECT
                    l.item_unit_id,
                    l.item_unit_status,
                    l.created_at AS log_time,
                    LAG(l.created_at) OVER (PARTITION BY l.item_unit_id ORDER BY l.created_at) AS prev_time
                FROM
                    new_logs l
                INNER JOIN
                    items_units iu ON l.item_unit_id = iu.id
                INNER JOIN
                    items it ON iu.item_id = it.id
                WHERE
                    l.item_unit_status IS NOT NULL
                    AND (
                        (? IS NULL OR l.created_at >= ?)
                        AND (? IS NULL OR l.created_at <= ?)
                    )
            ),
            duration_intervals AS (
                SELECT
                    l.item_unit_id,
                    l.item_unit_status,
                    COALESCE(TIMESTAMPDIFF(SECOND, prev_time, log_time), 0) AS duration_in_seconds
                FROM
                    log_intervals l
                WHERE
                    prev_time IS NOT NULL
            )
            SELECT
                di.item_unit_id,
                it.item_name,
                SUM(CASE WHEN di.item_unit_status IN ('Running', 'Restricted') THEN di.duration_in_seconds ELSE 0 END) AS total_uptime_seconds,
                SUM(CASE WHEN di.item_unit_status = 'System Down' THEN di.duration_in_seconds ELSE 0 END) AS total_downtime_seconds,
                SUM(di.duration_in_seconds) AS total_duration_seconds,
                ROUND(
                    (SUM(CASE WHEN di.item_unit_status IN ('Running', 'Restricted') THEN di.duration_in_seconds ELSE 0 END) /
                    SUM(di.duration_in_seconds)) * 100, 2
                ) AS uptime_percentage
            FROM
                duration_intervals di
            INNER JOIN
                items_units iu ON di.item_unit_id = iu.id
            INNER JOIN
                items it ON iu.item_id = it.id
            GROUP BY
                di.item_unit_id,
                it.item_name
        ";

        $params = [
            $startDate, // untuk IS NULL
            $startDate, // untuk l.created_at >= ?
            $endDate,   // untuk IS NULL
            $endDate    // untuk l.created_at <= ?
        ];

        $performanceData = DB::select($query, $params);
        return $performanceData;
    }
}
