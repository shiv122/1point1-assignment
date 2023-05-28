<?php

use App\Http\Controllers\Admin\Mail\MailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

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


Route::get('auth/index', [MailController::class, 'index'])->name('auth.index');
Route::get('auth/logout', [LoginController::class, 'logout'])->name('auth.logout');
Route::prefix('auth')->name('auth.')->middleware(['guest'])->group(function () {

  Route::prefix('login')->name('login.')->controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
  });
  Route::prefix('register')->name('register.')->controller(RegisterController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/', 'store')->name('store');
  });
});
