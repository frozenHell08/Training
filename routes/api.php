<?php

use App\Http\Controllers\Api\Auth\{
    LoginController,
    RegisterController,
    AuthController,
    VerifyController
} ;
use App\Http\Controllers\VerificationController;
use App\Http\Requests\VerificationRequest;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('user-profile', 'App\Http\Controllers\Api\Auth\AuthController@userProfile')->name('profile');
    Route::post('refresh', 'App\Http\Controllers\Api\Auth\AuthController@refresh');
    Route::post('logout', 'App\Http\Controllers\Api\Auth\AuthController@logout');
});

Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->name('verification.verify');