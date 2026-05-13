<?php

namespace App\Http\Controllers;

use App\Models\InformasiPenghasilModel;
use App\Models\KantorPusatPenghasilModel;
use App\Models\KontrakKerjasama;
use App\Models\Limbah;
use App\Models\PerizinanPenghasilModel;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenghasilController extends Controller
{
    public function dashboard()
    {
        $id_user = Auth::user()->id_user;

        $dikirim = Limbah::where('id_penghasil', $id_user)->where('status', 'Terangkut')->count();
        $diterima = Limbah::where('id_penghasil', $id_user)->whereIn('status', ['Diterima', 'Telah Setor PAD'])->count();
        $diolah = Limbah::where('id_penghasil', $id_user)->where('status', 'Terolah')->count();

        $stats = [
            'dikirim' => $dikirim,
            'diterima' => $diterima,
            'diolah' => $diolah,
        ];

        return view('penghasil.dashboard', compact('stats'));
    }

    public function profil()
    {
        $id_user = Auth::user()->id_user;
        $info = InformasiPenghasilModel::where('id_user', $id_user)->first();
        $kantor = KantorPusatPenghasilModel::where('id_user', $id_user)->first();
        $izin = PerizinanPenghasilModel::where('id_user', $id_user)->first();

        return view('penghasil.profil', compact('info', 'kantor', 'izin'));
    }

    public function kontrak(Request $request)
    {
        $id_user = Auth::user()->id_user;

        $query = KontrakKerjasama::with(['transporter.informasiTransporter', 'transporter.perizinanTransporter'])
            ->where('id_penghasil', $id_user);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_kontrak', 'like', '%'.$keyword.'%')
                    ->orWhereHas('transporter.informasiTransporter', function ($q2) use ($keyword) {
                        $q2->where('nama_transporter', 'like', '%'.$keyword.'%');
                    });
            });
        }

        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        match ($request->get('sort_by', 'terbaru')) {
            'berakhir' => $query->orderBy('masa_berlaku_sampai'),
            default => $query->orderByDesc('created_at'),
        };

        $kontraks = $query->paginate(10)->withQueryString();

        $transporterList = User::where('role', 'transporter')
            ->with(['informasiTransporter', 'perizinanTransporter'])
            ->get();

        return view('penghasil.kontrak', compact('kontraks', 'transporterList'));
    }

    public function getTransporterInfo(string $id): \Illuminate\Http\JsonResponse
    {
        $id_user = Auth::user()->id_user;
        $transporter = User::where('id_user', $id)
            ->where('role', 'transporter')
            ->with(['informasiTransporter', 'perizinanTransporter'])
            ->firstOrFail();

        $info = $transporter->informasiTransporter;
        $izin = $transporter->perizinanTransporter;

        $kontrakAktif = KontrakKerjasama::where('id_penghasil', $id_user)
            ->where('id_transporter', $id)
            ->whereNotNull('lampiran')
            ->latest()
            ->first();

        return response()->json([
            'nama' => $info->nama_transporter ?? $transporter->nama_user,
            'no_perling' => $izin?->no_perling ?? '',
            'masa_berlaku_perling_dari' => $izin?->masa_berlaku_perling_dari?->format('Y-m-d') ?? '',
            'masa_berlaku_perling_sampai' => $izin?->masa_berlaku_perling_sampai?->format('Y-m-d') ?? '',
            'lampiran_url' => $kontrakAktif ? asset('storage/'.$kontrakAktif->lampiran) : null,
        ]);
    }

    public function storeKontrak(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'id_transporter' => ['required', 'exists:users,id_user'],
            'nomor_kontrak' => ['required', 'string', 'max:100'],
            'tgl_terbit' => ['required', 'date'],
            'masa_berlaku_dari' => ['required', 'date'],
            'masa_berlaku_sampai' => ['required', 'date', 'after_or_equal:masa_berlaku_dari'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:2048'],
        ], [
            'id_transporter.required' => 'Transporter wajib dipilih.',
            'id_transporter.exists' => 'Transporter tidak valid.',
            'nomor_kontrak.required' => 'Nomor kontrak wajib diisi.',
            'tgl_terbit.required' => 'Tanggal terbit wajib diisi.',
            'masa_berlaku_dari.required' => 'Tanggal mulai berlaku wajib diisi.',
            'masa_berlaku_sampai.required' => 'Tanggal akhir berlaku wajib diisi.',
            'masa_berlaku_sampai.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal mulai.',
            'lampiran.mimes' => 'Format lampiran tidak didukung.',
            'lampiran.max' => 'Ukuran lampiran maksimal 2MB.',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('kontrak', 'public');
        }

        KontrakKerjasama::create([
            'id_penghasil' => Auth::user()->id_user,
            'id_transporter' => $request->id_transporter,
            'nomor_kontrak' => $request->nomor_kontrak,
            'tgl_terbit' => $request->tgl_terbit,
            'masa_berlaku_dari' => $request->masa_berlaku_dari,
            'masa_berlaku_sampai' => $request->masa_berlaku_sampai,
            'status' => 'Aktif',
            'lampiran' => $lampiranPath,
        ]);

        return redirect()->route('penghasil.kontrak', ['tab' => 'tabel'])
            ->with('success', 'Kontrak kerjasama berhasil disimpan.');
    }

    public function updateKontrak(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $id_user = Auth::user()->id_user;
        $kontrak = KontrakKerjasama::where('id_kontrak_kerjasama', $id)
            ->where('id_penghasil', $id_user)
            ->firstOrFail();

        $request->validate([
            'id_transporter' => ['required', 'exists:users,id_user'],
            'nomor_kontrak' => ['required', 'string', 'max:100'],
            'tgl_terbit' => ['required', 'date'],
            'masa_berlaku_dari' => ['required', 'date'],
            'masa_berlaku_sampai' => ['required', 'date', 'after_or_equal:masa_berlaku_dari'],
            'status' => ['required', 'in:Aktif,Non-Aktif'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:2048'],
        ], [
            'id_transporter.required' => 'Transporter wajib dipilih.',
            'nomor_kontrak.required' => 'Nomor kontrak wajib diisi.',
            'tgl_terbit.required' => 'Tanggal terbit wajib diisi.',
            'masa_berlaku_dari.required' => 'Tanggal mulai berlaku wajib diisi.',
            'masa_berlaku_sampai.required' => 'Tanggal akhir berlaku wajib diisi.',
            'masa_berlaku_sampai.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal mulai.',
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
            'id_transporter' => $request->id_transporter,
            'nomor_kontrak' => $request->nomor_kontrak,
            'tgl_terbit' => $request->tgl_terbit,
            'masa_berlaku_dari' => $request->masa_berlaku_dari,
            'masa_berlaku_sampai' => $request->masa_berlaku_sampai,
            'status' => $request->status,
            'lampiran' => $lampiranPath,
        ]);

        return redirect()->route('penghasil.kontrak', ['tab' => 'tabel'])
            ->with('success', 'Kontrak kerjasama berhasil diperbarui.');
    }

    public function limbah(Request $request)
    {
        $id_user = Auth::user()->id_user;

        $query = Limbah::with(['transporter.informasiTransporter'])
            ->where('id_penghasil', $id_user);

        if ($request->filled('kode')) {
            $query->where('kode_limbah', 'like', '%'.$request->kode.'%');
        }

        if ($request->filled('transporter')) {
            $query->whereHas('transporter.informasiTransporter', function ($q) use ($request) {
                $q->where('nama_transporter', 'like', '%'.$request->transporter.'%');
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

        $transporterList = KontrakKerjasama::where('id_penghasil', $id_user)
            ->where('status', 'Aktif')
            ->with('transporter.informasiTransporter')
            ->get()
            ->pluck('transporter')
            ->unique('id_user')
            ->values();

        return view('penghasil.limbah', compact('dataLimbah', 'transporterList'));
    }

    public function getLimbahTransporterInfo(string $id): \Illuminate\Http\JsonResponse
    {
        $transporter = User::where('id_user', $id)
            ->where('role', 'transporter')
            ->with('informasiTransporter')
            ->firstOrFail();

        $info = $transporter->informasiTransporter;

        return response()->json([
            'nama_driver' => $info?->nama_driver ?? '',
        ]);
    }

    public function storeLimbah(Request $request): \Illuminate\Http\RedirectResponse
    {
        $id_user = Auth::user()->id_user;

        $request->validate([
            'id_transporter' => ['required', 'exists:users,id_user'],
            'kode_limbah' => ['required', 'string', 'max:100'],
            'jenis_limbah' => ['nullable', 'string', 'max:255'],
            'sifat_limbah' => ['nullable', 'string', 'max:255'],
            'jumlah_limbah' => ['required', 'numeric', 'min:0.01'],
            'nama_driver' => ['nullable', 'string', 'max:255'],
            'jenis_kendaraan' => ['nullable', 'string', 'max:100'],
            'no_kendaraan' => ['nullable', 'string', 'max:50'],
        ], [
            'id_transporter.required' => 'Transporter wajib dipilih.',
            'kode_limbah.required' => 'Kode limbah wajib diisi.',
            'jumlah_limbah.required' => 'Berat limbah wajib diisi.',
            'jumlah_limbah.min' => 'Berat limbah harus lebih dari 0.',
        ]);

        $kontrak = KontrakKerjasama::where('id_penghasil', $id_user)
            ->where('id_transporter', $request->id_transporter)
            ->where('status', 'Aktif')
            ->latest()
            ->first();

        Limbah::create([
            'id_penghasil' => $id_user,
            'id_transporter' => $request->id_transporter,
            'id_kontrak' => $kontrak?->id_kontrak_kerjasama,
            'kode_limbah' => $request->kode_limbah,
            'jenis_limbah' => $request->jenis_limbah,
            'sifat_limbah' => $request->sifat_limbah,
            'jumlah_limbah' => $request->jumlah_limbah,
            'satuan' => 'TON',
            'tgl_rencana' => now()->toDateString(),
            'nama_driver' => $request->nama_driver,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'no_kendaraan' => $request->no_kendaraan,
            'status' => 'Rencana',
        ]);

        return redirect()->route('penghasil.limbah', ['tab' => 'tabel'])
            ->with('success', 'Data limbah berhasil disimpan.');
    }

    public function destroyLimbah(string $id): \Illuminate\Http\RedirectResponse
    {
        $id_user = Auth::user()->id_user;
        Limbah::where('id_limbah', $id)
            ->where('id_penghasil', $id_user)
            ->where('status', 'Rencana')
            ->firstOrFail()
            ->delete();

        return redirect()->route('penghasil.limbah', ['tab' => 'tabel'])
            ->with('success', 'Data limbah berhasil dihapus.');
    }

    public function beritaAcara(Request $request)
    {
        $id_user = Auth::user()->id_user;

        $query = Limbah::with(['transporter.informasiTransporter', 'beritaAcara'])
            ->where('id_penghasil', $id_user)
            ->whereNotIn('status', ['Rencana']);

        if ($request->filled('manifest')) {
            $query->where('no_manifest', 'like', '%'.$request->manifest.'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('transporter')) {
            $query->whereHas('transporter.informasiTransporter', function ($q) use ($request) {
                $q->where('nama_transporter', 'like', '%'.$request->transporter.'%');
            });
        }

        $dataLimbah = $query->orderByDesc('tgl_rencana')->paginate(10)->withQueryString();

        return view('penghasil.berita_acara', compact('dataLimbah'));
    }

    public function beritaAcaraDetail(string $id)
    {
        $id_user = Auth::user()->id_user;

        $limbah = Limbah::with([
            'transporter.informasiTransporter',
            'penghasil.informasiPenghasil',
            'beritaAcara',
            'kontrak',
        ])
            ->where('id_limbah', $id)
            ->where('id_penghasil', $id_user)
            ->firstOrFail();

        return view('penghasil.berita_acara_detail', compact('limbah'));
    }

    public function tagihan(Request $request)
    {
        $id_user = Auth::user()->id_user;

        $query = Limbah::with(['transporter.informasiTransporter', 'tagihan'])
            ->where('id_penghasil', $id_user)
            ->whereIn('status', ['Terolah', 'Telah Setor PAD']);

        if ($request->filled('manifest')) {
            $query->where('no_manifest', 'like', '%'.$request->manifest.'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('transporter')) {
            $query->whereHas('transporter.informasiTransporter', function ($q) use ($request) {
                $q->where('nama_transporter', 'like', '%'.$request->transporter.'%');
            });
        }

        $dataTagihan = $query->orderByDesc('tgl_terolah')->paginate(10)->withQueryString();

        return view('penghasil.tagihan', compact('dataTagihan'));
    }

    public function tagihanDetail(string $id)
    {
        $id_user = Auth::user()->id_user;

        $limbah = Limbah::with([
            'transporter.informasiTransporter',
            'kontrak',
        ])
            ->where('id_limbah', $id)
            ->where('id_penghasil', $id_user)
            ->whereIn('status', ['Terolah', 'Telah Setor PAD'])
            ->firstOrFail();

        $info = InformasiPenghasilModel::where('id_user', $id_user)->first();
        $kantor = KantorPusatPenghasilModel::where('id_user', $id_user)->first();

        $tagihanRecord = Tagihan::where('id_limbah', $limbah->id_limbah)->first();

        return view('penghasil.tagihan_detail', compact('limbah', 'info', 'kantor', 'tagihanRecord'));
    }

    public function pembayaran(Request $request)
    {
        $id_user = Auth::user()->id_user;

        $query = Limbah::with(['transporter.informasiTransporter', 'beritaAcara', 'tagihan'])
            ->where('id_penghasil', $id_user)
            ->whereIn('status', ['Terolah', 'Telah Setor PAD']);

        if ($request->filled('manifest')) {
            $query->where('no_manifest', 'like', '%'.$request->manifest.'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('transporter')) {
            $query->whereHas('transporter.informasiTransporter', function ($q) use ($request) {
                $q->where('nama_transporter', 'like', '%'.$request->transporter.'%');
            });
        }

        $dataLimbah = $query->orderByDesc('tgl_terolah')->paginate(10)->withQueryString();

        return view('penghasil.pembayaran', compact('dataLimbah'));
    }

    public function formSetor(string $id): \Illuminate\View\View
    {
        $id_user = Auth::user()->id_user;

        $limbah = Limbah::with(['transporter.informasiTransporter', 'beritaAcara', 'kontrak'])
            ->where('id_limbah', $id)
            ->where('id_penghasil', $id_user)
            ->where('status', 'Terolah')
            ->firstOrFail();

        $tagihanRecord = Tagihan::where('id_limbah', $limbah->id_limbah)->first();

        return view('penghasil.pembayaran_form', compact('limbah', 'tagihanRecord'));
    }

    public function setor(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $id_user = Auth::user()->id_user;

        $limbah = Limbah::where('id_limbah', $id)
            ->where('id_penghasil', $id_user)
            ->where('status', 'Terolah')
            ->firstOrFail();

        $request->validate([
            'metode_pembayaran' => ['required', 'in:Transfer Bank,Virtual Account,Tunai,Lainnya'],
            'no_referensi' => ['required', 'string', 'max:100'],
            'tgl_bayar' => ['required', 'date', 'before_or_equal:today'],
            'bukti_pembayaran' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'catatan_pembayaran' => ['nullable', 'string', 'max:500'],
        ], [
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'no_referensi.required' => 'Nomor referensi wajib diisi.',
            'tgl_bayar.required' => 'Tanggal pembayaran wajib diisi.',
            'tgl_bayar.before_or_equal' => 'Tanggal pembayaran tidak boleh lebih dari hari ini.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_pembayaran.mimes' => 'Format file harus JPG, PNG, atau PDF.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $buktiPath = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        $tagihanRecord = Tagihan::where('id_limbah', $limbah->id_limbah)
            ->where('status_pembayaran', 'Belum Dibayar')
            ->first();

        if ($tagihanRecord) {
            $tagihanRecord->update([
                'status_pembayaran' => 'Lunas',
                'bukti_pembayaran' => $buktiPath,
                'metode_pembayaran' => $request->metode_pembayaran,
                'no_referensi' => $request->no_referensi,
                'tgl_bayar' => $request->tgl_bayar,
                'catatan_pembayaran' => $request->catatan_pembayaran,
            ]);
        }

        $limbah->update(['status' => 'Telah Setor PAD']);

        return redirect()->route('penghasil.pembayaran')
            ->with('success', 'Pembayaran berhasil disetor. Tagihan telah ditandai lunas.');
    }

    public function akun()
    {
        $user = Auth::user();

        return view('penghasil.akun', compact('user'));
    }
}
