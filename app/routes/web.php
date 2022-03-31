<?php

use App\Http\Controllers\GameWebController;
use App\Http\Controllers\MessageWebController;
use App\Http\Controllers\RoleWebController;
use App\Http\Controllers\UserWebController;
use App\Http\Controllers\WeaponWebController;
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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::resource('games', GameWebController::class);
Route::resource('messages', MessageWebController::class);
Route::resource('roles', RoleWebController::class);
Route::resource('users', UserWebController::class);
Route::resource('games', WeaponWebController::class);
