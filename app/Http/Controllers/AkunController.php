<?php

namespace App\Http\Controllers;

use App\Models\Limbah;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AkunController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        // ── Limbah B3 Statistics ──
        $totalLimbahDiterima = Limbah::whereIn('status', ['Diterima', 'Terolah', 'Telah Setor PAD'])
            ->sum('jumlah_limbah');

        $totalLimbahTerolah = Limbah::whereIn('status', ['Terolah', 'Telah Setor PAD'])
            ->sum('jumlah_limbah');

        $totalLimbahBelumDiolah = Limbah::where('status', 'Diterima')
            ->sum('jumlah_limbah');

        // ── PAD Statistics (from tagihans) ──
        $potensiPad = Tagihan::query()->sum('jumlah_tagihan');

        $realisasiPad = Tagihan::where('status_pembayaran', 'Lunas')
            ->sum('jumlah_tagihan');

        $piutangPad = Tagihan::where('status_pembayaran', 'Belum Dibayar')
            ->sum('jumlah_tagihan');

        // ── Status Counts ──
        $statusCounts = [
            'rencana' => Limbah::where('status', 'Rencana')->count(),
            'terangkut' => Limbah::where('status', 'Terangkut')->count(),
            'diterima' => Limbah::where('status', 'Diterima')->count(),
            'terolah' => Limbah::where('status', 'Terolah')->count(),
            'selesai' => Limbah::where('status', 'Telah Setor PAD')->count(),
        ];

        // ── User Counts ──
        $totalPenghasil = User::where('role', 'penghasil')->count();
        $totalTransporter = User::where('role', 'transporter')->count();

        // ── Rekap Table: group limbah per penghasil with PAD info ──
        $rekapPenghasil = User::where('role', 'penghasil')
            ->with('informasiPenghasil')
            ->withSum(
                ['limbahs as total_limbah' => fn ($q) => $q->whereIn('status', ['Diterima', 'Terolah', 'Telah Setor PAD'])],
                'jumlah_limbah'
            )
            ->get()
            ->map(function (User $user) {
                $limbahIds = Limbah::where('id_penghasil', $user->id_user)
                    ->whereIn('status', ['Diterima', 'Terolah', 'Telah Setor PAD'])
                    ->pluck('id_limbah');

                $sudahSetor = Tagihan::whereIn('id_limbah', $limbahIds)
                    ->where('status_pembayaran', 'Lunas')
                    ->sum('jumlah_tagihan');

                $belumSetor = Tagihan::whereIn('id_limbah', $limbahIds)
                    ->where('status_pembayaran', 'Belum Dibayar')
                    ->sum('jumlah_tagihan');

                $limbahSudahSetor = Limbah::where('id_penghasil', $user->id_user)
                    ->where('status', 'Telah Setor PAD')
                    ->sum('jumlah_limbah');

                $limbahBelumSetor = Limbah::where('id_penghasil', $user->id_user)
                    ->whereIn('status', ['Diterima', 'Terolah'])
                    ->sum('jumlah_limbah');

                return (object) [
                    'nama' => $user->informasiPenghasil->nama_perusahaan ?? $user->nama_user,
                    'total_limbah' => $user->total_limbah ?? 0,
                    'limbah_sudah_setor' => $limbahSudahSetor,
                    'limbah_belum_setor' => $limbahBelumSetor,
                    'sudah_setor' => $sudahSetor,
                    'belum_setor' => $belumSetor,
                ];
            })
            ->filter(fn ($item) => $item->total_limbah > 0)
            ->values();

        // ── Aktivitas terbaru ──
        $aktivitasTerbaru = Limbah::with(['penghasil.informasiPenghasil', 'transporter.informasiTransporter'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'totalLimbahDiterima',
            'totalLimbahTerolah',
            'totalLimbahBelumDiolah',
            'potensiPad',
            'realisasiPad',
            'piutangPad',
            'statusCounts',
            'totalPenghasil',
            'totalTransporter',
            'rekapPenghasil',
            'aktivitasTerbaru',
        ));
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

        return back()->with('success', 'Akun '.$request->role.' berhasil ditambahkan!');
    }

    public function updatePengguna(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$id.',id_user',
            'email' => 'required|email|unique:users,email,'.$id.',id_user',
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

        // Periksa apakah pengguna memiliki data terkait
        $hasLimbah = \App\Models\Limbah::where('id_penghasil', $id)->orWhere('id_transporter', $id)->exists();
        $hasKontrak = \App\Models\KontrakKerjasama::where('id_penghasil', $id)->orWhere('id_transporter', $id)->exists();

        if ($hasLimbah || $hasKontrak) {
            return back()->with('error', 'Akun pengguna tidak dapat dihapus karena memiliki data Limbah atau Kontrak Kerjasama terkait.');
        }

        // Hapus data profil dan perizinan terkait
        if ($user->role === 'penghasil') {
            $user->informasiPenghasil()->delete();
            $user->perizinanPenghasil()->delete();
            \App\Models\KantorPusatPenghasilModel::where('id_user', $id)->delete();
        } elseif ($user->role === 'transporter') {
            $user->informasiTransporter()->delete();
            $user->perizinanTransporter()->delete();
        }

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
