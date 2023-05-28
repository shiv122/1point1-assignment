<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Employee\DashboardController;
use App\Http\Controllers\Employee\Mail\MailController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


Route::prefix('employee')->name('employee.')->middleware(['auth', 'employee'])->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('index');
  Route::prefix('mails')->name('mails.')->controller(MailController::class)->group(function () {
    Route::get('/',  'index')->name('index');
    Route::get('/{id}/details',  'details')->name('details');
    Route::post('reply',  'reply')->name('reply');
    Route::post('send-mail',  'sendMail')->name('send-mail');


    Route::get('/google',  'redirectToGoogle')->name('redirect-to-google');
    Route::get('/google/callback',  'handleGoogleCallback')->name('handel-google-callback');
  });
});
