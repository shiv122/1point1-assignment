<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\User\BasicController;

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


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin', 'custom-gate'])->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('index');
  Route::prefix('users')->name('users.')->controller(BasicController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::delete('/delete/{id}', 'delete')->name('delete');
    Route::post('update', 'update')->name('update');
    Route::post('/store', 'store')->name('store');
    Route::post('/bulk-store', 'bulkStore')->name('bulk-store');
  });
});
