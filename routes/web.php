<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\IsDriverController;
use App\Http\Controllers\NoteController;

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

Route::get('/', function () {
    return view('dashboard');
});

Route::resource('customer',CustomerController::class);
Route::resource('employee',EmployeeController::class);
Route::resource('driver',DriverController::class);
// Route::resource('manager',ManagerController::class);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware'=>['web','auth','verified']], function(){
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
});

Route::group(['middleware'=>['auth','role:manager']], function(){
    Route::resource('promo',PromoController::class);
    Route::resource('shift',ShiftController::class);
    Route::get('/manager/promo', 'App\Http\Controllers\ManagerController@promo')->name('manager.promo');
    Route::get('/manager/shift', 'App\Http\Controllers\ManagerController@shift')->name('manager.shift');
    Route::get('/searchPromo',[PromoController::class,'search'])->name('searchPromo');
    Route::get('/searchShift',[ShiftController::class,'search'])->name('searchShift');
});

Route::group(['middleware'=>['auth','role:admin']], function(){
    Route::resource('car',CarController::class);
    Route::resource('mitraAdmin',MitraController::class);
    Route::get('/searchCar',[CarController::class,'search'])->name('searchCar');
    Route::get('/carMitra',[CarController::class,'mitra'])->name('carMitra');
    Route::get('/searchMitraAdmin',[MitraController::class,'searchAdmin'])->name('searchMitraAdmin');
    Route::get('/searchEmployee',[EmployeeController::class,'search'])->name('searchEmployee');
    Route::get('/searchDriver',[DriverController::class,'search'])->name('searchDriver');
});

Route::group(['middleware'=>['auth','role:customerServices']], function(){
    Route::get('/searchCustomer',[CustomerController::class,'search'])->name('searchCustomer');
    Route::resource('transactionCS',TransactionController::class);
    Route::get('/searchTransaction',[TransactionController::class,'search'])->name('searchTransaction');
    Route::put('/storeFindDriver/{id}', [IsDriverController::class,'create'])->name('storeFindDriver.create');
    Route::post('/storeFindDriver/{id}', [IsDriverController::class,'store'])->name('storeFindDriver.store');
});

Route::group(['middleware'=>['auth','role:customer']], function(){
    Route::resource('mitra',MitraController::class);
    Route::resource('transaction',TransactionController::class);
    Route::resource('isDriver',IsDriverController::class);
    Route::resource('note',NoteController::class);
    Route::get('/searchMitra',[MitraController::class,'search'])->name('searchMitra');
    Route::delete('/finishCustomer/{id}', [DriverController::class,'finishOrder'])->name('finishCustomer');
    Route::get('/export/{id}',[CustomerController::class,'export'])->name('exportCard');
});

Route::group(['middleware'=>['auth','role:driver']], function(){
    Route::resource('transactionDriver',TransactionController::class);
    Route::put('/accept/{id}', [DriverController::class,'acceptOrder'])->name('accept');
    Route::put('/decline/{id}', [DriverController::class,'declineOrder'])->name('decline');
    Route::delete('/finishDriver/{id}', [DriverController::class,'finishOrder'])->name('finishDriver');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
