<?php

use App\Http\Controllers\EditProfileController;
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
    
    Route::get('technicians', [TechnicianController::class, 'index'])->name('technicians.index');
    Route::get('technicians/create', [TechnicianController::class, 'create'])->name('technicians.create');
    Route::post('technicians/store', [TechnicianController::class, 'store'])->name('technicians.store');
    Route::get('technicians/{id}/edit', [TechnicianController::class, 'edit'])->name('technicians.edit');
    Route::put('technicians/{id}', [TechnicianController::class, 'update'])->name('technicians.update');
    Route::delete('technicians/destroy', [TechnicianController::class, 'destroy'])->name('technicians.destroy');
    Route::get('technicians/{id}/show', [TechnicianController::class, 'show'])->name('technicians.show');
    Route::get('technicians/assign', [TechnicianController::class, 'assign'])->name('technicians.assign');
    Route::post('technicians/assignTechnician', [TechnicianController::class, 'assignTechnician'])->name('technicians.assignTechnician');

    Route::resource('items_units', ItemsUnitsController::class)->name('items_units','*');
    Route::resource('user', UserController::class);
    Route::get('profile/{id}/change_password', [EditProfileController::class, 'change_password'])->name('profile.change_password');
    Route::put('profile/{id}/update_password', [EditProfileController::class, 'update_password'])->name('profile.update_password');
    Route::resource('profile', EditProfileController::class)->name('profile','*');

    Route::controller(SubmissionOfRepairController::class)->middleware('role:superadmin|unit')->prefix('submission-of-repair')->name('submission-of-repair.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/getItems', 'getItems')->name('getItems');
    });


    // Define a GET route with dynamic placeholders for route parameters
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});
