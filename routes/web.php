<?php

use App\Http\Controllers\DetailsOfRepairSubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\ItemsUnitsController;
use App\Http\Controllers\SparepartsController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\EditProfileController;
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
    })->name('dashboard');

    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/get-all-province', function () {
            return response()->json(getAllProvince());
        })->name('get-all-province');

        Route::post('/get-all-city/{id}', function ($provinceId) {
            return response()->json(getAllCity($provinceId));
        })->name('get-all-city');

        Route::post('/get-all-district/{id}', function ($cityId) {
            return response()->json(getAllDistrict($cityId));
        })->name('get-all-district');

        Route::post('/get-all-village/{id}', function ($districtId) {
            return response()->json(getAllVillage($districtId));
        })->name('get-all-village');

        Route::post('/get-province/{id}', function ($province_id) {
            return response()->json(getProvince($province_id));
        })->name('get-province');

        Route::post('/get-city/{id}', function ($city_id) {
            return response()->json(getCity($city_id));
        })->name('get-city');

        Route::post('/get-district/{id}', function ($district_id) {
            return response()->json(getDistrict($district_id));
        })->name('get-district');

        Route::post('/get-village/{id}', function ($village_id) {
            return response()->json(getVillage($village_id));
        })->name('get-village');
    });

    Route::controller(DropzoneController::class)->name('dropzone.')->group(function () {
        Route::post('/upload-file', 'uploadFile')->name('upload');
        Route::post('/delete-uploaded-file', 'deleteUploadedFile')->name('delete');
    });

    Route::get('profile/{id}/change_password', [EditProfileController::class, 'change_password'])->name('profile.change_password');
    Route::put('profile/{id}/update_password', [EditProfileController::class, 'update_password'])->name('profile.update_password');
    Route::resource('profile', EditProfileController::class)->name('profile', '*');

    Route::resource('vendor', VendorController::class)->middleware('role:superadmin')->name('vendor', '*');

    // ROUTE FOR SUPERADMIN
    Route::group(['middleware' => ['role:superadmin']], function () {
        Route::resource('units', UnitsController::class);
        Route::resource('items', ItemsController::class)->name('items', '*');
        Route::resource('spareparts', SparepartsController::class)->name('spareparts', '*');
        Route::resource('user', UserController::class);

        Route::controller(LogController::class)->name('log.')->prefix('log')->middleware('role:superadmin')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getLog/{moduleCode}/{moduleId}/{itemId?}', 'getLog')->name('getLog');
        });

        Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
            Route::get('/role', 'role')->name('role');
        });

        Route::get('technicians', [TechnicianController::class, 'index'])->name('technicians.index');
        Route::get('technicians/create', [TechnicianController::class, 'create'])->name('technicians.create');
        Route::post('technicians/store', [TechnicianController::class, 'store'])->name('technicians.store');
        Route::get('technicians/{id}/edit', [TechnicianController::class, 'edit'])->name('technicians.edit');
        Route::put('technicians/{id}', [TechnicianController::class, 'update'])->name('technicians.update');
        Route::delete('technicians/{id}', [TechnicianController::class, 'destroy'])->name('technicians.destroy');
    });

    // ROUTE FOR SUPERADMIN OR UNIT
    Route::group(['middleware' => ['role:superadmin|unit']], function () {
        Route::resource('rooms', RoomsController::class)->name('rooms', '*');
    });

    // ROUTE FOR SUPERADMIN OR TECHNICIAN
    Route::group(['middleware' => ['role:superadmin|technician']], function () {
        Route::get('technicians/{id}/show', [TechnicianController::class, 'show'])->name('technicians.show');
        Route::get('technicians/assign', [TechnicianController::class, 'assign'])->name('technicians.assign');
        Route::post('technicians/assignTechnician', [TechnicianController::class, 'assignTechnician'])->name('technicians.assignTechnician');

        Route::controller(SubmissionOfRepairController::class)->prefix('submission-of-repair')->name('submission-of-repair.')->group(function () {
            Route::get('/list', 'viewListOfRepairs')->name('list');
            Route::get('/getList', 'getListOfRepairs')->name('getList');
            Route::get('/getTechnicians', 'getTechnicians')->name('getTechnicians');
            Route::post('/assignTechnician', 'assignTechnician')->name('assignTechnician');
        });

        // Route::get('/repairments', [DetailsOfRepairSubmissionController::class, 'index'])->name('detail_submission.index');
        Route::controller(DetailsOfRepairSubmissionController::class)->prefix('repairments')->name('repairments.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/acceptRepairments/{id}', 'acceptRepairments')->name('acceptRepairments');
            Route::put('/cancelRepairments/{id}', 'cancelRepairments')->name('cancelRepairments');
            Route::get('/{id}', 'show')->name('show');
            Route::put('/startRepairments/{id}', 'startRepairments')->name('startRepairments');
            Route::put('/update/{id}', 'update')->name('update');
            Route::get('/showSparepart/{id}', 'showSparepart')->name('showSparepart');
            Route::get('/getSpareparts/{id}', 'getSpareparts')->name('getSpareparts');
            Route::put('/finish/{id}', 'finish')->name('finish');
        });
    });

    // ROUTE FOR SUPERADMIN OR UNIT OR ROOM
    Route::group(['middleware' => ['role:superadmin|unit|room']], function () {
        Route::resource('items_units', ItemsUnitsController::class)->name('items_units', '*');

        Route::controller(SubmissionOfRepairController::class)->prefix('submission-of-repair')->name('submission-of-repair.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/getItems', 'getItems')->name('getItems');
            Route::post('/store', 'store')->name('store');
            Route::post('/store/temporary-file', 'storeTemporaryFile')->name('store.temporary-file');
            Route::get('/history', 'history')->name('history');
            Route::get('/getTechnician', 'getTechnician')->name('getTechnician');
        });
    });
    
    Route::controller(SubmissionOfRepairController::class)->prefix('submission-of-repair')->name('submission-of-repair.')->middleware('role:superadmin|room|unit|technician')->group(function () {
        Route::get('/detail/{submissionId}', 'detailSubmission')->name('detail');
    });
});