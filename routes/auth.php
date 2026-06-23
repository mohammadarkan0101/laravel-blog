<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ConfirmationController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('handle.login');

    Route::get('/register', [RegistrationController::class, 'index'])
        ->name('register');

    Route::post('/register', [RegistrationController::class, 'register'])
        ->name('handle.register');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('oauth/google', [GoogleController::class, 'redirectToGoogle']);
    Route::get('oauth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
});

Route::middleware('auth')->group(function () {

    Route::get('verify-email', [VerificationController::class, 'notice'])
        ->name('verification.notice');

    Route::post('verify-email', [VerificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.store');

    Route::get('verify-email/{id}/{hash}', [VerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('confirm-password', [ConfirmationController::class, 'create'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmationController::class, 'store'])
        ->name('confirmation.store');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});