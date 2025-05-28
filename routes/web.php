<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PilihTiketController;
use App\Http\Controllers\DeskripsiTiketController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\KonfirmasiController;
use App\Http\Controllers\HistoryController;

Route::get('/login', [PageController::class, 'login']);
Route::get('/register', [PageController::class, 'register']);
Route::get('/seat', [PageController::class, 'seat']);
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/makanan', [PageController::class, 'makanan']);
Route::get('/pilihtiket', [PilihTiketController::class, 'index'])->name('pilihtiket');
Route::get('/deskripsitiket', [DeskripsiTiketController::class, 'index'])->name('deskripsitiket');
Route::get('/hotel', [HotelController::class, 'index'])->name('hotel');
route::get('/konfirmasi', [KonfirmasiController::class, 'index'])->name('konfirmasi');
Route::get('/tiket/deskripsi/{id}', [DeskripsiTiketController::class, 'show'])->name('tiket.deskripsi');
Route::get('/history', [HistoryController::class, 'index'])->name('history.tiket');
