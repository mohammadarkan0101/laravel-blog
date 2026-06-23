<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware('role:administrator|editor')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::patch('/update-profile', [ProfileController::class, 'updateUserProfile'])->name('update.profile');
        Route::patch('/update-password', [ProfileController::class, 'updateUserPassword'])->name('update.password');
    });

    Route::middleware('role:administrator')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/datatable', [UserController::class, 'datatable'])->name('users.datatable');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::middleware('role:editor')->group(function () {
        Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
        Route::get('/blogs/datatable', [BlogController::class, 'datatable'])->name('blogs.datatable');
        Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::patch('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    });
});