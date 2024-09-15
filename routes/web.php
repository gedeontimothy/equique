<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\LanguageController;


// ===== LANG START
	Route::get('/lang-available', [LanguageController::class, 'allAvailable'])->name('lang.available');
	Route::get('/lang/show/{lang?}', [LanguageController::class, 'show'])->name('lang.show');
	Route::get('/lang/{lang}', [LanguageController::class, 'store'])->name('lang.store');
// ===== LANG STOP


Route::get('/', [PublicController::class, 'home'])->name('home');  


// Route::middleware('auth')->group(function(){});


Route::middleware(['auth', 'verified'])->group(function(){


	Route::middleware('manager')->group(function(){

		Route::get('/dashboard', [UserManagerController::class, 'dashboard'])->name('dashboard');

	});


	// Route::get('/', [PublicController::class, 'home'])->name('home');

});


Route::middleware('guest')->group(function(){

	Route::get('/welcome', [PublicController::class, 'welcome'])->name('welcome');

});


// Route::view('/mt', 'mails.user.auth.mail-verification', ['url' => 'ged', 'name' => 'Timothy Gedeon', 'min' => config('auth.verification.expire', 60)]);


require_once __DIR__ . '/auth.php';
