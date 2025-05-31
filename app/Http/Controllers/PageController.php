<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // <-- Pastikan ini ada dan mengarah ke Model User Anda
use Illuminate\Support\Facades\Hash; // <-- Pastikan ini ada untuk Hash::make()
use Illuminate\Support\Facades\Auth; // <-- Pastikan ini ada untuk Auth::check()
use Illuminate\Support\Facades\Session; // <-- Pastikan ini ada untuk Session::flash()
use Illuminate\Support\Facades\Log; // <-- Tambahkan ini untuk Log::error()

class PageController extends Controller
{
    public function login()
    {
        // Jika user sudah login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function actionregister(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:150|unique:login,email', // 'unique:nama_tabel,nama_kolom'
            'phone' => 'required|string|max:15',
            'username' => 'required|string|max:100|unique:login,username', // 'unique:nama_tabel,nama_kolom'
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted', // <-- Tambahkan validasi ini jika checkbox 'terms' wajib dicentang
        ], [
            'first_name.required' => 'Nama Depan wajib diisi.',
            'last_name.required' => 'Nama Belakang wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'phone.required' => 'Nomor Telepon wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'terms.accepted' => 'Anda harus menyetujui kebijakan kami untuk mendaftar.', // <-- Pesan error untuk checkbox
        ]);

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'username' => $request->username,
                'password' => Hash::make($request->password), // Password di-hash untuk keamanan
                // HAPUS BARIS INI: 'created_at' => now(), // Laravel akan otomatis mengisi created_at dan updated_at
            ]);

            // HAPUS BARIS INI: Auth::login($user); // TIDAK OTOMATIS LOGIN SETELAH REGISTRASI

            // UBAH redirect ke halaman login
            Session::flash('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
            return redirect()->route('login'); // Redirect ke halaman login

        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan saat registrasi. Silakan coba lagi.');
            Log::error("Registration error: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile());
            return redirect()->back()->withInput();
        }
    }

    public function seat(){
        return view('seat');
    }

    public function diskon(){
        return view('diskon');
    }
}