<?php

use App\Http\Controllers\Api\Auth\{
    LoginController,
    RegisterController,
    AuthController
} ;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * 

*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
*    return $request->user();
*});
 */

Route::group([
    // 'middleware' => ['api'],
    'prefix' => 'auth',
], function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [LoginController::class, 'login']);
});

Route::group([
    'middleware' => 'jwtm',
    'prefix' => 'auth',
], function () {
    Route::get('user-profile', 'App\Http\Controllers\Api\Auth\AuthController@userProfile');
    Route::post('refresh', 'App\Http\Controllers\Api\Auth\AuthController@refresh');
    Route::post('logout', 'App\Http\Controllers\Api\Auth\AuthController@logout');
});