<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\ItemsUnitsController;

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
    // Define a GET route for the root URL ('/')
    Route::get('/', function () {
        // Return a view named 'index' when accessing the root URL
        return view('index');
    });

    // Route::get('/items', [ItemsController::class, 'index'])->name('items.index');
    // Route::get('/get-items', [ItemsController::class, 'getItems'])->name('items.getItems');
    // Route::get('items/{id}/show', [ItemsController::class, 'show'])->name('items.show');
    // Route::get('/items/create', [ItemsController::class, 'create'])->name('items.create');
    // Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
    // Route::get('/items/{id}/edit', [ItemsController::class, 'edit'])->name('items.edit');
    // Route::put('/items/{id}', [ItemsController::class, 'update'])->name('items.update');
    // Route::delete('/items', [ItemsController::class, 'destroy'])->name('items.delete');

    Route::resource('items', ItemsController::class)->name('items','*');
    Route::resource('units', UnitsController::class);
    Route::resource('items_units', ItemsUnitsController::class)->name('items_units','*');

    Route::controller(UserController::class)->prefix('user')->name('user.')->group(function() {
        Route::get('/role', 'role')->name('role');
    });
    Route::resource('user', UserController::class);


    // Define a GET route with dynamic placeholders for route parameters
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});