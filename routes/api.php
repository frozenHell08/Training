<?php

use App\Http\Controllers\Api\Auth\{
    LoginController,
    RegisterController,
    AuthController,
    VerifyController
};
use App\Http\Controllers\Api\Transaction\ReceiverController;
use App\Http\Controllers\Api\Transaction\TransactionController;
use App\Http\Controllers\DashboardController;
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
    Route::post('register/validate', [RegisterController::class, 'validateEntry']);
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

Route::get('email/resend', [VerificationController::class, 'resendEmail'])->name('verification.resend');

Route::group([
    'prefix' => 'user',
], function () {
    Route::post('transfer', [TransactionController::class, 'send_money']);
    Route::get('dashboard', [DashboardController::class, 'show_details']);
    Route::get('transfer/receiver', [ReceiverController::class, 'check_receiver']);
    Route::get('dashboard/connections', [DashboardController::class, 'show_connections']);
    Route::put('dashboard/cashin', [DashboardController::class, 'cash_in']);
});

//Route::get("/posts/:id");