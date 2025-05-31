<?php

// user controller
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PilihTiketController;
use App\Http\Controllers\DeskripsiTiketController; // Ini yang sebelumnya TiketDeskripsiController, pastikan konsisten
use App\Http\Controllers\HotelController;
use App\Http\Controllers\KonfirmasiController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookingController; // Pastikan ini diimpor!

// admin controller
use App\Http\Controllers\AdminController;

// Rute untuk menampilkan form login dan memproses login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

// Rute untuk menampilkan form registrasi
Route::get('/register', [PageController::class, 'register'])->name('register');

// Rute untuk memproses data registrasi (WAJIB DITAMBAHKAN)
Route::post('/actionregister', [PageController::class, 'actionregister'])->name('actionregister');
Route::post('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth'); // <-- UBAH KE POST

Route::get('/seat', [PageController::class, 'seat']);
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth'); // Tambahkan middleware 'auth' untuk dashboard
Route::get('/makanan', [MakananController::class, 'index'])->name('makanan.index');
Route::get('/pilihtiket', [PilihTiketController::class, 'index'])->name('pilihtiket');
// Route::get('/deskripsitiket', [DeskripsiTiketController::class, 'index'])->name('deskripsitiket'); // Ini mungkin tidak perlu jika Anda selalu menggunakan /tiket/deskripsi/{id}
Route::get('/hotel', [HotelController::class, 'index'])->name('hotel');
// route::get('/konfirmasi', [KonfirmasiController::class, 'index'])->name('konfirmasi');
Route::get('/tiket/deskripsi/{id}', [DeskripsiTiketController::class, 'show'])->name('tiket.deskripsi');
Route::get('/history', [HistoryController::class, 'index'])->name('history.tiket');
Route::get('/destinasi', [DestinasiController::class, 'destinasi']);
Route::get('/diskon', [PageController::class, 'diskon']);
Route::get('/merchant', [MerchantController::class, 'index']);
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

// --- TAMBAHKAN DUA BARIS INI ---
Route::post('/booking/process', [BookingController::class, 'processBooking'])->name('booking.process');
Route::get('/booking/confirmation/{booking_code}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
// ------------------------------

// Admin management page
Route::get('/admin', [AdminController::class, 'index']);

// API Routes untuk Admin Management
Route::prefix('api')->group(function () {
    Route::get('/admins', [AdminController::class, 'list']);
    Route::post('/admins', [AdminController::class, 'store']);
    Route::put('/admins/{id}', [AdminController::class, 'update']);
    Route::delete('/admins/{id}', [AdminController::class, 'delete']);
});

// Admin authentication routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });
});
