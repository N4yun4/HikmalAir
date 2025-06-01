<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.loginadmin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'usr_admin' => 'required',
            'pass_admin' => 'required',
        ]);

        if (Auth::guard('admin')->attempt([
            'usr_admin' => $credentials['usr_admin'],
            'pass_admin' => $credentials['pass_admin']
        ])) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'usr_admin' => 'Username atau password salah.',
        ])->onlyInput('usr_admin');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}


