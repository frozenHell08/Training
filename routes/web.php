<?php

use App\Http\Controllers\Api\Auth\VerifyController;
use App\Http\Controllers\CustomVerifyController;
use App\Http\Requests\VerificationRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
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

Route::get('/dashboard', function () {
    return view('/pages/home');
})
->middleware(['verified'])
->name('dashboard');

Route::get('/verf', function () {
    return view('/verification/verifyEmail');
}) // ->middleware('verified')
    ->name('verification.notice');

/* Route::get('/verify/{id}/{hash}', function(VerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])
    ->name('verification.verify'); */