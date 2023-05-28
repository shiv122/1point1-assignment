<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Employee\BasicController;
use App\Http\Controllers\Admin\Mail\MailController;

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


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('index');


  Route::prefix('employees')->name('employees.')->controller(BasicController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::delete('/delete/{id}', 'delete')->name('delete');
    Route::post('update', 'update')->name('update');
    Route::post('/store', 'store')->name('store');
    Route::post('/bulk-store', 'bulkStore')->name('bulk-store');
  });
});
