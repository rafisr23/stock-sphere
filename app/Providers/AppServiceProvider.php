<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Technician;
use View;
use DB;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
        View::composer('*', function ($view) {
            if (Auth::check()) {

                if (auth()->user()->hasRole('technician') && !auth()->user()->can('assign technician')) {
                    $technician = Technician::where('user_id', auth()->user()->id)->first();
                    $status_count = DB::table('details_of_repair_submissions')
                        ->select('status', DB::raw('COUNT(*) as total'))
                        ->whereIn('status', [0, 1])
                        ->where('technician_id', $technician->id)
                        ->groupBy('status')
                        ->get();
                    $maintenance_count = DB::table('maintenances')
                        ->select('status', DB::raw('COUNT(*) as total'))
                        ->whereIn('status', [0, 1, 2, 3, 4, 5, 6, 7])
                        ->where('technician_id', $technician->id)
                        ->where('date_completed', null)
                        ->groupBy('status')
                        ->get();
                    $calibration_count = 0;
                } else {
                    $status_count = DB::table('details_of_repair_submissions')
                        ->select('status', DB::raw('COUNT(*) as total'))
                        ->whereIn('status', [0, 1])
                        ->groupBy('status')
                        ->get();
                    $maintenance_count = DB::table('maintenances')
                        ->select('status', DB::raw('COUNT(*) as total'))
                        ->whereIn('status', [0, 1, 2, 3, 4, 5, 6, 7])
                        ->where('date_completed', null)
                        ->groupBy('status')
                        ->get();
                    $calibration_count = DB::table('calibrations')
                        ->select('status', DB::raw('COUNT(*) as total'))
                        ->whereIn('status', [0, 1, 2, 3, 4, 5, 6, 7])
                        ->where('date_completed', null)
                        ->groupBy('status')
                        ->get();
                }

                $view->with('status_count', $status_count);
                $view->with('maintenance_count', $maintenance_count);
                $view->with('calibration_count', $calibration_count);
            }
        });
    }
}
