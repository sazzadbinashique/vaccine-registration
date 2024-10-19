<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;


Route::get('/register', [RegistrationController::class, 'create'])->name('register.create');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');
Route::get('/search', [RegistrationController::class, 'search'])->name('search');
Route::post('/search', [RegistrationController::class, 'checkStatus'])->name('check.status');
