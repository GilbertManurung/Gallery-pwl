<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // ============================
    // Tampilkan form register (web)
    // ============================
    public function showForm()
    {
        return view('auth.register');
    }

    // ============================
    // Submit register (web)
    // ============================
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // 🔹 Buat token API untuk user web
        $token = $user->createToken('web-token')->plainTextToken;

        // 🔹 Simpan token ke session, optional
        session(['api_token' => $token]);

        // ❌ Jangan auto login user
        // Auth::login($user);

        // Redirect ke halaman login dengan flash message sukses
        return redirect()->route('login.form')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // ============================
    // Register via API
    // ============================
    public function apiRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Generate token API (Sanctum)
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }
}
