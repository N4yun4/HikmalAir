<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PilihTiketController;
use App\Http\Controllers\DeskripsiTiketController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\KonfirmasiController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookingController;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AkunAdminController;
use App\Http\Controllers\TiketAdminController;

// USER
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('/register', [PageController::class, 'register'])->name('register');

Route::post('/actionregister', [PageController::class, 'actionregister'])->name('actionregister');
Route::post('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');
Route::get('/seat', [PageController::class, 'seat']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/makanan', [MakananController::class, 'index'])->name('makanan.index');
Route::get('/pilihtiket', [PilihTiketController::class, 'index'])->name('pilihtiket');
Route::get('/hotel', [HotelController::class, 'index'])->name('hotel');
Route::get('/tiket/deskripsi/{id}', [DeskripsiTiketController::class, 'show'])->name('tiket.deskripsi');
Route::get('/history', [HistoryController::class, 'index'])->name('history.tiket');
Route::get('/destinasi', [DestinasiController::class, 'destinasi']);
Route::get('/diskon', [PageController::class, 'diskon']);
Route::get('/merchant', [MerchantController::class, 'index'])->name('merchant');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::post('/booking/process', [BookingController::class, 'processBooking'])->name('booking.process');
Route::get('/booking/confirmation/{booking_code}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

// ADMIN
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login']);
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboardadmin');
})->middleware('auth:admin')->name('admin.dashboardadmin');

Route::get('/admin/akunadmin', [AkunAdminController::class, 'index'])->middleware('auth:admin');
Route::get('/admin/tiketadmin', [TiketAdminController::class, 'index'])->middleware('auth:admin');

// API
Route::prefix('api')->group(function () {
    Route::get('/admins', [AkunAdminController::class, 'list']);
    Route::post('/admins', [AkunAdminController::class, 'store']);
    Route::put('/admins/{id}', [AkunAdminController::class, 'update']);
    Route::delete('/admins/{id}', [AkunAdminController::class, 'delete']);
});

Route::prefix('api/flights')->group(function () {
    Route::get('/', [TiketAdminController::class, 'list']);
    Route::post('/', [TiketAdminController::class, 'store']);
    Route::put('/{id}', [TiketAdminController::class, 'update']);
    Route::delete('/{id}', [TiketAdminController::class, 'delete']);
});