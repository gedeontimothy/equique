<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MainController as AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;


Route::middleware('guest')->group(function(){

	Route::get('/register', [AuthController::class, 'signUp'])->name('sign_up');
	Route::post('/register', [AuthController::class, 'register'])->name('register');

	Route::post('/login', [AuthController::class, 'login'])->name('login');
	Route::get('/login', [AuthController::class, 'signIn'])->name('sign_in');
	
	Route::get('/oauth/google/callback', [AuthController::class, 'callbackGoogle'])->name('callbackGoogle');
	Route::get('/redirect-google', [AuthController::class, 'redirect'])->name('redirect-google');

});


Route::middleware('auth')->group(function(){

	// ========= EMAIL START 
		Route::get('verify-email', [EmailVerificationController::class, 'prompt'])
					->name('verification.notice');

		Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
					->middleware(['signed', 'throttle:6,1'])
					->name('verification.verify');

		Route::post('email/verification-notification', [EmailVerificationController::class, 'notification'])
					->middleware('throttle:6,1')
					->name('verification.send');
	// ========= EMAIL STOP

	Route::any('/logout', [AuthController::class, 'destroy'])->name('logout');

});
