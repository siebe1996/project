<?php

use App\Http\Controllers\GameApiController;
use App\Http\Controllers\GameLogicController;
use App\Http\Controllers\GameUserApiController;
use App\Http\Controllers\MessageApiController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\WeaponApiController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $id = Auth::id();
    $u = User::with('roles')->findOrFail($id);
    $user = new UserResource(User::with('roles')->findOrFail($id));
    return response(['data' => $user, 'admin' => $u->hasRole('administrator')], 200)
        ->header('Content-Type', 'application/json');
});

//Route::middleware('auth:sanctum')->post('userinfo/{id}', [GameUserApiController::class, 'store']);//->middleware('auth:sanctum');
/*Route::middleware('auth:sanctum')->group(function (){*/
    Route::apiResource('games', GameApiController::class)->only(['index', 'show', 'update']);
    Route::get('currentgames', [GameApiController::class, 'current']);
    Route::get('target', [GameUserApiController::class, 'target']);
    Route::apiResource('messages', MessageApiController::class)->only(['index', 'show']);
    Route::apiResource('users', UserApiController::class)->only(['index', 'show', 'update', 'store']);//->middleware('auth:sanctum');;
    Route::apiResource('userinfo', GameUserApiController::class)->only(['index', 'show', 'store']);
    //Route::post('/userinfo/{gameId}', [GameUserApiController::class, 'store'])->whereNumber('gameId');
//Route::get('usergames/{id}', [GameUserApiController::class, 'getGamesForUser'])->where(['id' => '[0-9]+']);
    Route::apiResource('weapons', WeaponApiController::class)->only(['index', 'show']);
    Route::prefix('gamelogic')->group(function () {
        Route::patch('{gameId}', [GameLogicController::class, 'gotKilled'])->where(['gameId' => '[0-9]+']);
        /*Route::get('add', [BlogController::class,'add']);
        Route::get('search', [BlogController::class, 'search']);

        Route::post('add', [BlogController::class,'store']);
        Route::post('{id}/delete', [BlogController::class, 'deleteBlogpost'])->where(['id' => '[0-9]+'])
            ->middleware('auth');*/
    });
/*});*/

