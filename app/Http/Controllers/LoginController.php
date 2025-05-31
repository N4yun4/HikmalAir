<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk fungsi otentikasi Laravel
use Illuminate\Support\Facades\Session; // Untuk menampilkan pesan flash (error/sukses)
use App\Models\User; // Penting: Impor model User Anda (yang sudah kita set ke tabel 'login')

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     * Jika pengguna sudah login, akan diarahkan ke halaman dashboard.
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Arahkan ke rute 'dashboard' jika sudah login
        } else {
            return view('login'); // Tampilkan view 'login.blade.php'
        }
    }

    /**
     * Memproses percobaan login dari form.
     */
    public function actionlogin(Request $request)
    {
        // 1. Validasi data input dari form login
        $request->validate([
            // Input bisa berupa email atau username, tergantung apa yang user masukkan
            'email_or_username' => 'required|string',
            'password' => 'required|string',
        ], [
            'email_or_username.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Menentukan apakah input adalah email atau username
        $fieldType = filter_var($request->email_or_username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Menyiapkan kredensial untuk percobaan login
        // Gunakan $fieldType untuk menentukan kolom yang akan dicari (email atau username)
        $credentials = [
            $fieldType => $request->email_or_username,
            'password' => $request->password,
        ];

        // 2. Mencoba login menggunakan Auth::attempt()
        if (Auth::attempt($credentials)) {
            // Jika login berhasil
            $request->session()->regenerate(); // Regenerasi session ID untuk keamanan
            Session::flash('success', 'Login berhasil! Selamat datang kembali.');
            return redirect()->route('dashboard'); // Arahkan ke rute 'dashboard'
        } else {
            // Jika login gagal
            Session::flash('error', 'Email/Username atau Password salah.');
            return redirect()->back()->withInput($request->except('password')); // Kembali ke halaman sebelumnya dengan input, kecuali password
        }
    }

    /**
     * Memproses logout pengguna.
     */
    public function actionlogout(Request $request)
    {
        Auth::logout(); // Logout pengguna
        $request->session()->invalidate(); // Hapus semua data dari session
        $request->session()->regenerateToken(); // Regenerasi token CSRF

        Session::flash('success', 'Anda telah berhasil logout.');
        return redirect()->route('login'); // Arahkan kembali ke halaman login
    }
}