<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login (sudah di-handle route view).
     * Method ini opsional jika kamu ingin logic tambahan.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Tampilkan halaman register (sudah di-handle route view).
     * Method ini opsional jika kamu ingin logic tambahan.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses login user.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Coba autentikasi
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // Gagal login
        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    /**
     * Proses register user baru.
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'nama.required'             => 'Nama lengkap wajib diisi.',
            'nama.max'                  => 'Nama maksimal 255 karakter.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.required'         => 'Password wajib diisi.',
            'password.min'              => 'Password minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $validated['nama'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Auto login setelah register
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '!');
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }
}