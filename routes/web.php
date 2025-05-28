<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [PageController::class, 'login']);
Route::get('/register', [PageController::class, 'register']);
Route::get('/seat', [PageController::class, 'seat']);
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
