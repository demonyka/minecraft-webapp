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

Route::get('/', function () {
    return inertia('CheckUser');
})->name('webapp');
Route::get('/skins/{filename}', [\App\Http\Controllers\StorageController::class, 'skinShow'])->where('filename', '(.*)');
Route::get('/head/{filename}', [\App\Http\Controllers\StorageController::class, 'headShow'])->where('filename', '(.*)');


Route::get('/registration', [\App\Http\Controllers\UserController::class, 'registration'])->name('registration');
Route::post('/check-nickname', [\App\Http\Controllers\CheckController::class, 'checkNickname']);
Route::post('/check-email', [\App\Http\Controllers\CheckController::class, 'checkEmail']);


Route::get('/cabinet', [\App\Http\Controllers\UserController::class, 'cabinet'])->name('cabinet');

Route::get('/test', [\App\Http\Controllers\UserController::class, 'test'])->name('test');

