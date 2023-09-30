<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/webapp', function () {
    return inertia('CheckUser');
})->name('webapp');

Route::get('/webapp/registration', [\App\Http\Controllers\UserController::class, 'registration'])->name('registration');
Route::post('/check-nickname', [\App\Http\Controllers\CheckController::class, 'checkNickname']);
Route::post('/check-email', [\App\Http\Controllers\CheckController::class, 'checkEmail']);


Route::get('/webapp/cabinet', [\App\Http\Controllers\UserController::class, 'cabinet'])->name('cabinet');

