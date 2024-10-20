<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;


/*Route::get('/search', [RegistrationController::class, 'search'])->name('search');
Route::post('/search', [RegistrationController::class, 'checkStatus'])->name('check.status');*/


Route::get('/', [RegistrationController::class, 'create'])->name('register.create');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');
Route::get('/registration-success', [RegistrationController::class, 'registrationSuccess'])->name('registration_success');
Route::get('/status', [RegistrationController::class, 'searchStatus'])->name('status');
