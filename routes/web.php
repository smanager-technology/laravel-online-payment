<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/payment', [PaymentController::class, 'index']);
Route::get('/payment/success/{trnxId}', [PaymentController::class, 'success']);
Route::get('/payment/fail', [PaymentController::class, 'fail'])->name('fail');

