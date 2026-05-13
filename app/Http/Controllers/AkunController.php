<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function pengguna()
    {
        $penghasil = User::where('role', 'penghasil')->get();
        $transporter = User::where('role', 'transporter')->get();

        return view('admin.pengguna.index', compact('penghasil', 'transporter'));
    }

    public function storePengguna(Request $request)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:penghasil,transporter',
        ]);

        User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        return back()->with('success', 'Akun ' . $request->role . ' berhasil ditambahkan!');
    }

    public function updatePengguna(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id . ',id_user',
            'email' => 'required|email|unique:users,email,' . $id . ',id_user',
            'password' => 'nullable|string|min:6',
        ]);

        $user->nama_user = $request->nama_user;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        return back()->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroyPengguna($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Akun pengguna berhasil dihapus!');
    }

    public function pengaturan()
    {
        $user = Auth::user();

        return view('pengaturan.index', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_user' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->nama_user = $request->nama_user;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->save();

        return back()->with('success', 'Data akun berhasil diperbarui!');
    }
}
