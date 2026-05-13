<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Tambahkan ini

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ]);

            $user = User::where('username', $request->username)->first();

            if (!$user) {
                return back()->withErrors([
                    'username' => 'Username tidak terdaftar di sistem.',
                ])->onlyInput('username');
            }

            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                return back()->withErrors([
                    'password' => 'Password yang Anda masukkan salah.',
                ])->onlyInput('username');
            }

            $request->session()->regenerate();
            $role = Auth::user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'penghasil' => redirect()->route('penghasil.dashboard'),
                'transporter' => redirect()->route('transporter.dashboard'),
                default => redirect('/'),
            };

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
