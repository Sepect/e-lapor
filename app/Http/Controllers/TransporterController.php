<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLimbahRequest;
use App\Models\BeritaAcara;
use App\Models\InformasiTransporter;
use App\Models\KontrakKerjasama;
use App\Models\Limbah;
use App\Models\PerizinanTransporter;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransporterController extends Controller
{
    public function dashboard()
    {
        $id_user = Auth::user()->id_user;

        $dikirim = Limbah::where('id_transporter', $id_user)->where('status', 'Terangkut')->count();
        $diterima = Limbah::where('id_transporter', $id_user)->whereIn('status', ['Diterima', 'Telah Setor PAD'])->count();
        $diolah = Limbah::where('id_transporter', $id_user)->where('status', 'Terolah')->count();

        $padSetor = Tagihan::where('id_user', $id_user)->where('jenis_tagihan', 'PAD')->where('status_pembayaran', 'Lunas')->sum('jumlah_tagihan');
        $padBelumSetor = Tagihan::where('id_user', $id_user)->where('jenis_tagihan', 'PAD')->where('status_pembayaran', 'Belum Dibayar')->sum('jumlah_tagihan');

        $stats = [
            'dikirim' => $dikirim,
            'diterima' => $diterima,
            'diolah' => $diolah,
            'disetor' => Tagihan::where('id_user', $id_user)->where('jenis_tagihan', 'PAD')->where('status_pembayaran', 'Lunas')->count(),
            'jumlah_setor' => $padSetor,
            'jumlah_belum_setor' => $padBelumSetor,
        ];

        return view('transporter.dashboard', compact('stats'));
    }

    public function profil()
    {
        $id_user = Auth::user()->id_user;
        $info = InformasiTransporter::where('id_user', $id_user)->first();
        $izin = PerizinanTransporter::where('id_user', $id_user)->first();

        // Pass info and izin instead of profil array
        return view('transporter.profil', compact('info', 'izin'));
    }

    public function kontrak(Request $request)
    {
        $id_user = Auth::user()->id_user;

        $query = KontrakKerjasama::with(['penghasil.informasiPenghasil', 'penghasil.perizinanPenghasil'])
            ->where('id_transporter', $id_user);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_kontrak', 'like', '%'.$keyword.'%')
                    ->orWhereHas('penghasil.informasiPenghasil', function ($q2) use ($keyword) {
                        $q2->where('nama_penghasil', 'like', '%'.$keyword.'%');
                    });
            });
        }

        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        match ($request->get('sort_by', 'terbaru')) {
            'nama_az' => $query->join('users', 'users.id_user', '=', 'kontrak_kerjasamas.id_penghasil')
                ->orderBy('users.nama_user')
                ->select('kontrak_kerjasamas.*'),
            'nama_za' => $query->join('users', 'users.id_user', '=', 'kontrak_kerjasamas.id_penghasil')
                ->orderByDesc('users.nama_user')
                ->select('kontrak_kerjasamas.*'),
            'berakhir' => $query->orderBy('masa_berlaku_sampai'),
            default => $query->orderByDesc('created_at'),
        };

        $kontraks = $query->paginate(10)->withQueryString();

        $penghasilList = User::where('role', 'penghasil')
            ->with(['informasiPenghasil', 'perizinanPenghasil'])
            ->get();

        return view('transporter.kontrak', compact('kontraks', 'penghasilList'));
    }

    public function getPenghasilInfo(string $id)
    {
        $penghasil = User::where('id_user', $id)
            ->where('role', 'penghasil')
            ->with(['informasiPenghasil', 'perizinanPenghasil'])
            ->firstOrFail();

        $info = $penghasil->informasiPenghasil;
        $izin = $penghasil->perizinanPenghasil;

        return response()->json([
            'nama' => $info->nama_penghasil ?? $penghasil->nama_user,
            'alamat' => $info->alamat_penghasil ?? '',
            'kota' => $info->kota_penghasil ?? '',
            'limbah_dihasilkan' => $izin?->limbah_dihasilkan ?? '',
            'no_perling' => $izin?->no_perling ?? '',
            'lampiran_perling' => $izin?->lampiran_perling
                ? asset('storage/'.$izin->lampiran_perling)
                : null,
            'masa_berlaku_perling_dari' => $izin?->masa_berlaku_perling_dari
                ? \Carbon\Carbon::parse($izin->masa_berlaku_perling_dari)->format('d M Y')
                : null,
            'masa_berlaku_perling_sampai' => $izin?->masa_berlaku_perling_sampai
                ? \Carbon\Carbon::parse($izin->masa_berlaku_perling_sampai)->format('d M Y')
                : null,
        ]);
    }

    public function storeKontrak(Request $request)
    {
        $request->validate([
            'id_penghasil' => ['required', 'exists:users,id_user'],
            'nomor_kontrak' => ['required', 'string', 'max:100'],
            'tgl_terbit' => ['required', 'date'],
            'masa_berlaku_dari' => ['required', 'date'],
            'masa_berlaku_sampai' => ['required', 'date', 'after_or_equal:masa_berlaku_dari'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:2048'],
        ], [
            'id_penghasil.required' => 'Penghasil wajib dipilih.',
            'id_penghasil.exists' => 'Penghasil tidak valid.',
            'nomor_kontrak.required' => 'Nomor kontrak wajib diisi.',
            'tgl_terbit.required' => 'Tanggal terbit wajib diisi.',
            'masa_berlaku_dari.required' => 'Tanggal mulai berlaku wajib diisi.',
            'masa_berlaku_sampai.required' => 'Tanggal akhir berlaku wajib diisi.',
            'masa_berlaku_sampai.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal mulai.',
            'status.required' => 'Status wajib dipilih.',
            'lampiran.mimes' => 'Format lampiran tidak didukung.',
            'lampiran.max' => 'Ukuran lampiran maksimal 2MB.',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('kontrak', 'public');
        }

        KontrakKerjasama::create([
            'id_penghasil' => $request->id_penghasil,
            'id_transporter' => Auth::user()->id_user,
            'nomor_kontrak' => $request->nomor_kontrak,
            'tgl_terbit' => $request->tgl_terbit,
            'masa_berlaku_dari' => $request->masa_berlaku_dari,
            'masa_berlaku_sampai' => $request->masa_berlaku_sampai,
            'status' => $request->status,
            'lampiran' => $lampiranPath,
        ]);

        return redirect()->route('transporter.kontrak')
            ->with('success', 'Kontrak kerjasama berhasil disimpan.');
    }

    public function updateKontrak(Request $request, string $id)
    {
        $id_user = Auth::user()->id_user;
        $kontrak = KontrakKerjasama::where('id_kontrak_kerjasama', $id)
            ->where('id_transporter', $id_user)
            ->firstOrFail();

        $request->validate([
            'id_penghasil' => ['required', 'exists:users,id_user'],
            'nomor_kontrak' => ['required', 'string', 'max:100'],
            'tgl_terbit' => ['required', 'date'],
            'masa_berlaku_dari' => ['required', 'date'],
            'masa_berlaku_sampai' => ['required', 'date', 'after_or_equal:masa_berlaku_dari'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:2048'],
        ], [
            'id_penghasil.required' => 'Penghasil wajib dipilih.',
            'nomor_kontrak.required' => 'Nomor kontrak wajib diisi.',
            'tgl_terbit.required' => 'Tanggal terbit wajib diisi.',
            'masa_berlaku_dari.required' => 'Tanggal mulai berlaku wajib diisi.',
            'masa_berlaku_sampai.required' => 'Tanggal akhir berlaku wajib diisi.',
            'masa_berlaku_sampai.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal mulai.',
            'status.required' => 'Status wajib dipilih.',
            'lampiran.mimes' => 'Format lampiran tidak didukung.',
            'lampiran.max' => 'Ukuran lampiran maksimal 2MB.',
        ]);

        $lampiranPath = $kontrak->lampiran;
        if ($request->hasFile('lampiran')) {
            if ($lampiranPath) {
                Storage::disk('public')->delete($lampiranPath);
            }
            $lampiranPath = $request->file('lampiran')->store('kontrak', 'public');
        }

        $kontrak->update([
            'id_penghasil' => $request->id_penghasil,
            'nomor_kontrak' => $request->nomor_kontrak,
            'tgl_terbit' => $request->tgl_terbit,
            'masa_berlaku_dari' => $request->masa_berlaku_dari,
            'masa_berlaku_sampai' => $request->masa_berlaku_sampai,
            'status' => $request->status,
            'lampiran' => $lampiranPath,
        ]);

        return redirect()->route('transporter.kontrak', ['tab' => 'tabel'])
            ->with('success', 'Kontrak kerjasama berhasil diperbarui.');
    }

    public function destroyKontrak(string $id)
    {
        $id_user = Auth::user()->id_user;
        $kontrak = KontrakKerjasama::where('id_kontrak_kerjasama', $id)
            ->where('id_transporter', $id_user)
            ->firstOrFail();

        if ($kontrak->lampiran) {
            Storage::disk('public')->delete($kontrak->lampiran);
        }

        $kontrak->delete();

        return redirect()->route('transporter.kontrak', ['tab' => 'tabel'])
            ->with('success', 'Kontrak kerjasama berhasil dihapus.');
    }

    public function limbah(Request $request)
    {
        $id_user = Auth::user()->id_user;

        $query = Limbah::with('penghasil.informasiPenghasil')
            ->where('id_transporter', $id_user);

        if ($request->filled('kode')) {
            $query->where('kode_limbah', 'like', '%'.$request->kode.'%');
        }

        if ($request->filled('penghasil')) {
            $query->whereHas('penghasil.informasiPenghasil', function ($q) use ($request) {
                $q->where('nama_penghasil', 'like', '%'.$request->penghasil.'%');
            });
        }

        if ($request->filled('dari')) {
            $query->whereDate('tgl_rencana', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tgl_rencana', '<=', $request->sampai);
        }

        match ($request->get('sort', 'terbaru')) {
            'az' => $query->orderBy('kode_limbah'),
            'za' => $query->orderByDesc('kode_limbah'),
            'lama' => $query->orderBy('tgl_rencana'),
            default => $query->orderByDesc('tgl_rencana'),
        };

        $dataLimbah = $query->paginate(10)->withQueryString();

        $penghasilList = KontrakKerjasama::where('id_transporter', $id_user)
            ->where('status', 'Aktif')
            ->with('penghasil.informasiPenghasil')
            ->get()
            ->pluck('penghasil')
            ->unique('id_user')
            ->values();

        $infoTransporter = InformasiTransporter::where('id_user', $id_user)->first();

        return view('transporter.limbah', compact('dataLimbah', 'penghasilList', 'infoTransporter'));
    }

    public function storeLimbah(StoreLimbahRequest $request)
    {
        $id_user = Auth::user()->id_user;

        $kontrak = KontrakKerjasama::where('id_transporter', $id_user)
            ->where('id_penghasil', $request->id_penghasil)
            ->where('status', 'Aktif')
            ->latest()
            ->first();

        Limbah::create([
            'id_penghasil' => $request->id_penghasil,
            'id_transporter' => $id_user,
            'id_kontrak' => $kontrak?->id_kontrak_kerjasama,
            'kode_limbah' => $request->kode_limbah,
            'jenis_limbah' => $request->jenis_limbah,
            'sifat_limbah' => $request->sifat_limbah,
            'jumlah_limbah' => $request->jumlah_limbah,
            'satuan' => $request->satuan ?? 'TON',
            'tgl_rencana' => $request->tgl_rencana,
            'no_manifest' => $request->no_manifest,
            'nama_driver' => $request->nama_driver,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'no_kendaraan' => $request->no_kendaraan,
            'catatan' => $request->catatan,
            'status' => 'Rencana',
        ]);

        return redirect()->route('transporter.limbah', ['tab' => 'tabel'])
            ->with('success', 'Data pengangkutan limbah berhasil disimpan.');
    }

    public function destroyLimbah(string $id)
    {
        $id_user = Auth::user()->id_user;
        Limbah::where('id_limbah', $id)
            ->where('id_transporter', $id_user)
            ->firstOrFail()
            ->delete();

        return redirect()->route('transporter.limbah', ['tab' => 'tabel'])
            ->with('success', 'Data limbah berhasil dihapus.');
    }

    public function edit_limbah(string $id)
    {
        $id_user = Auth::user()->id_user;
        $dataLimbah = Limbah::with(['penghasil.informasiPenghasil', 'beritaAcara'])
            ->where('id_limbah', $id)
            ->where('id_transporter', $id_user)
            ->firstOrFail();

        return view('transporter.edit_limbah', compact('dataLimbah'));
    }

    public function storeBeritaAcara(Request $request, string $id)
    {
        $id_user = Auth::user()->id_user;
        $limbah = Limbah::with('beritaAcara')
            ->where('id_limbah', $id)
            ->where('id_transporter', $id_user)
            ->firstOrFail();

        $request->validate([
            'jumlah_limbah' => ['required', 'numeric', 'min:0.01'],
            'ba_nama' => ['required', 'string', 'max:255'],
            'ba_alamat' => ['nullable', 'string', 'max:500'],
            'ba_jabatan' => ['nullable', 'string', 'max:255'],
            'tgl_penyerahan' => ['required', 'date'],
            'tandatangan' => ['nullable', 'file', 'image', 'max:2048'],
            'stempel' => ['nullable', 'file', 'image', 'max:2048'],
        ], [
            'jumlah_limbah.required' => 'Jumlah limbah wajib diisi.',
            'jumlah_limbah.min' => 'Jumlah limbah harus lebih dari 0.',
            'ba_nama.required' => 'Nama penandatangan wajib diisi.',
            'tgl_penyerahan.required' => 'Tanggal penyerahan wajib diisi.',
        ]);

        $existing = $limbah->beritaAcara;

        $tandatanganPath = $existing?->tandatangan_penyerah;
        if ($request->hasFile('tandatangan')) {
            if ($tandatanganPath) {
                Storage::disk('public')->delete($tandatanganPath);
            }
            $tandatanganPath = $request->file('tandatangan')->store('berita_acara/tandatangan', 'public');
        }

        $stempelPath = $existing?->stempel_penyerah;
        if ($request->hasFile('stempel')) {
            if ($stempelPath) {
                Storage::disk('public')->delete($stempelPath);
            }
            $stempelPath = $request->file('stempel')->store('berita_acara/stempel', 'public');
        }

        BeritaAcara::updateOrCreate(
            ['id_limbah' => $limbah->id_limbah],
            [
                'nama_penyerah' => $request->ba_nama,
                'alamat_penyerah' => $request->ba_alamat,
                'jabatan_penyerah' => $request->ba_jabatan,
                'tandatangan_penyerah' => $tandatanganPath,
                'stempel_penyerah' => $stempelPath,
                'tgl_penyerahan' => $request->tgl_penyerahan,
            ]
        );

        $limbah->update([
            'jumlah_limbah' => $request->jumlah_limbah,
            'status' => 'Terangkut',
            'tgl_terangkut' => $request->tgl_penyerahan,
        ]);

        return redirect()->route('transporter.limbah', ['tab' => 'tabel'])
            ->with('success', 'Berita Acara berhasil disimpan. Status limbah diperbarui menjadi Terangkut.');
    }

    public function beritaAcara(Request $request)
    {
        $id_user = Auth::user()->id_user;

        $dataBA = BeritaAcara::whereHas('limbah', function ($query) use ($id_user, $request) {
            $query->where('id_transporter', $id_user);

            if ($request->filled('manifest')) {
                $query->where('no_manifest', 'like', '%'.$request->manifest.'%');
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('penghasil')) {
                $query->whereHas('penghasil.informasiPenghasil', function ($q) use ($request) {
                    $q->where('nama_penghasil', 'like', '%'.$request->penghasil.'%');
                });
            }
        })->with(['limbah.penghasil.informasiPenghasil'])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('transporter.berita_acara', compact('dataBA'));
    }

    public function tagihan()
    {
        $id_user = Auth::user()->id_user;
        $tagihan = Tagihan::where('id_user', $id_user)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('transporter.tagihan', compact('tagihan'));
    }

    public function pad()
    {
        $id_user = Auth::user()->id_user;
        $pad = Tagihan::with(['limbah.penghasil.informasiPenghasil', 'limbah.beritaAcara'])
            ->where('id_user', $id_user)
            ->where('jenis_tagihan', 'PAD')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('transporter.pad', compact('pad'));
    }

    public function retribusi()
    {
        $id_user = Auth::user()->id_user;
        $retribusi = Tagihan::with(['limbah.penghasil.informasiPenghasil', 'limbah.beritaAcara'])
            ->where('id_user', $id_user)
            ->where('jenis_tagihan', 'Retribusi')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('transporter.retribusi', compact('retribusi'));
    }

    public function formSetor(string $id): \Illuminate\View\View
    {
        $id_user = Auth::user()->id_user;

        $tagihan = Tagihan::with(['limbah.penghasil.informasiPenghasil', 'limbah.beritaAcara'])
            ->where('id_tagihan', $id)
            ->where('id_user', $id_user)
            ->whereIn('jenis_tagihan', ['PAD', 'Retribusi'])
            ->firstOrFail();

        return view('transporter.setor_form', [
            'tagihan' => $tagihan,
            'instansi' => config('instansi'),
        ]);
    }

    public function setor(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $id_user = Auth::user()->id_user;

        $tagihan = Tagihan::where('id_tagihan', $id)
            ->where('id_user', $id_user)
            ->whereIn('jenis_tagihan', ['PAD', 'Retribusi'])
            ->where('status_pembayaran', 'Belum Dibayar')
            ->firstOrFail();

        $request->validate([
            'metode_pembayaran' => ['required', 'in:Transfer Bank,Virtual Account,Tunai,Lainnya'],
            'no_referensi' => ['required', 'string', 'max:100'],
            'tgl_bayar' => ['required', 'date', 'before_or_equal:today'],
            'bukti_pembayaran' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'catatan_pembayaran' => ['nullable', 'string', 'max:500'],
        ]);

        $buktiPath = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        $tagihan->update([
            'status_pembayaran' => 'Lunas',
            'bukti_pembayaran' => $buktiPath,
            'metode_pembayaran' => $request->metode_pembayaran,
            'no_referensi' => $request->no_referensi,
            'tgl_bayar' => $request->tgl_bayar,
            'catatan_pembayaran' => $request->catatan_pembayaran,
        ]);

        $route = $tagihan->jenis_tagihan === 'PAD' ? 'transporter.pad' : 'transporter.retribusi';

        return redirect()->route($route)
            ->with('success', 'Setoran '.$tagihan->jenis_tagihan.' berhasil disimpan dan ditandai lunas.');
    }

    public function akun()
    {
        $user = Auth::user();

        return view('transporter.akun', compact('user'));
    }
}
