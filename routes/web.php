<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\VerifyController;
use App\Http\Controllers\CustomVerifyController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\VerificationController;
use App\Http\Requests\VerificationRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Psy\Readline\Hoa\Console;

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

Route::get('/login', function () {
    return view('welcome');
})->name('login');

// Auth::routes(['verify' => true]);

Route::get('/dash', function () {
    return view('/pages/home');
})
// ->middleware(['verified'])
->middleware('verified')
->name('board');
 
Route::get('/verf', function () {
    return view('/verification/verifyEmail');
}) // ->middleware('verified')
    ->name('verification.notice');


/* Route::get('/verify/{id}/{hash}', function(VerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])
    ->name('verification.verify'); */