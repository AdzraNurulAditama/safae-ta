<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FORM REGISTER
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'required|string|max:15',
            'password' => 'required|min:4|confirmed',
        ]);

        User::create([
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'username' => $request->username,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password),
            'role' => 'user', // DEFAULT USER
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil, silakan login!');
    }

    // FORM LOGIN
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // CEK ROLE
            if (Auth::user()->role === 'admin') {
                return redirect('/admin');
            }

            return redirect('/genre'); // USER BIASA
        }

        return back()->withErrors([
            'login' => 'Username atau password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Berhasil logout.');
    }
}
