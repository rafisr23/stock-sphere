<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\ItemsUnitsController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\SubmissionOfRepairController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();


// Define a group of routes with 'auth' middleware applied
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('index');
    });

    Route::resource('items', ItemsController::class)->name('items','*');
    Route::resource('units', UnitsController::class);
    Route::resource('technicians', TechnicianController::class)->name('technicians','*');
    Route::resource('items_units', ItemsUnitsController::class)->name('items_units','*');
    Route::resource('user', UserController::class);

    Route::controller(SubmissionOfRepairController::class)->middleware('role:superadmin|unit')->prefix('submission-of-repair')->name('submission-of-repair.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/getItems', 'getItems')->name('getItems');
    });


    // Define a GET route with dynamic placeholders for route parameters
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});