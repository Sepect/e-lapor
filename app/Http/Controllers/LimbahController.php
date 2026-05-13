<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;
use App\Models\Limbah;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LimbahController extends Controller
{
    public function index(Request $request, ?string $status = null): \Illuminate\View\View
    {
        $statusMap = [
            'terkirim' => 'Terangkut',
            'diterima'  => 'Diterima',
            'diolah'    => 'Terolah',
            'selesai'   => 'Telah Setor PAD',
        ];

        $query = Limbah::with(['penghasil.informasiPenghasil', 'transporter.informasiTransporter']);

        if ($status && isset($statusMap[$status])) {
            $query->where('status', $statusMap[$status]);
        }

        $dataLimbah = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        $statusCounts = [
            'terkirim' => Limbah::where('status', 'Terangkut')->count(),
            'diterima'  => Limbah::where('status', 'Diterima')->count(),
            'diolah'    => Limbah::where('status', 'Terolah')->count(),
            'selesai'   => Limbah::where('status', 'Telah Setor PAD')->count(),
        ];

        return view('admin.penerimaan.index', [
            'dataLimbah'   => $dataLimbah,
            'status'       => $status,
            'statusCounts' => $statusCounts,
        ]);
    }

    public function show(string $id): \Illuminate\View\View
    {
        $limbah = Limbah::with([
            'penghasil.informasiPenghasil',
            'transporter.informasiTransporter',
            'beritaAcara',
            'kontrak',
        ])->findOrFail($id);

        return match ($limbah->status) {
            'Diterima'        => view('admin.penerimaan.detail_diterima', compact('limbah')),
            'Terolah'         => view('admin.penerimaan.detail_diolah', compact('limbah')),
            'Telah Setor PAD' => view('admin.penerimaan.detail_selesai', compact('limbah')),
            default           => view('admin.penerimaan.detail', compact('limbah')),
        };
    }

    public function terima(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $limbah = Limbah::where('id_limbah', $id)->where('status', 'Terangkut')->firstOrFail();

        $request->validate([
            'nama_penerima'        => ['required', 'string', 'max:255'],
            'alamat_penerima'      => ['required', 'string', 'max:500'],
            'jabatan_penerima'     => ['required', 'string', 'max:255'],
            'tandatangan_penerima' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'stempel_penerima'     => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
        ]);

        $ba = $limbah->beritaAcara ?? new BeritaAcara(['id_limbah' => $id]);

        if ($request->hasFile('tandatangan_penerima')) {
            if ($ba->tandatangan_penerima) {
                Storage::disk('public')->delete($ba->tandatangan_penerima);
            }
            $ba->tandatangan_penerima = $request->file('tandatangan_penerima')->store('berita-acara/ttd', 'public');
        }

        if ($request->hasFile('stempel_penerima')) {
            if ($ba->stempel_penerima) {
                Storage::disk('public')->delete($ba->stempel_penerima);
            }
            $ba->stempel_penerima = $request->file('stempel_penerima')->store('berita-acara/stempel', 'public');
        }

        $ba->nama_penerima    = $request->nama_penerima;
        $ba->alamat_penerima  = $request->alamat_penerima;
        $ba->jabatan_penerima = $request->jabatan_penerima;
        $ba->tgl_penyerahan   = today();
        $ba->save();

        $limbah->update([
            'status'      => 'Diterima',
            'tgl_diterima' => today(),
        ]);

        return redirect()->route('admin.penerimaan.index', 'diterima')
            ->with('success', 'Limbah berhasil diterima dan berita acara disimpan.');
    }

    public function kembalikan(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $limbah = Limbah::where('id_limbah', $id)->where('status', 'Terangkut')->firstOrFail();

        $request->validate([
            'alasan_dikembalikan' => ['required', 'string', 'max:1000'],
        ]);

        $limbah->update([
            'status'  => 'Rencana',
            'catatan' => $request->alasan_dikembalikan,
        ]);

        return redirect()->route('admin.penerimaan.index', 'terkirim')
            ->with('warning', 'Limbah telah dikembalikan ke penghasil.');
    }

    public function olah(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $limbah = Limbah::where('id_limbah', $id)->where('status', 'Diterima')->firstOrFail();

        $request->validate([
            'tgl_diolah'    => ['required', 'date'],
            'total_tagihan' => ['required', 'numeric', 'min:0'],
        ], [
            'tgl_diolah.required'    => 'Tanggal diolah wajib diisi.',
            'total_tagihan.required' => 'Total tagihan wajib diisi.',
            'total_tagihan.min'      => 'Total tagihan tidak boleh negatif.',
        ]);

        $nomorTagihan = 'INV-'.str_pad(Tagihan::count() + 1, 4, '0', STR_PAD_LEFT).'/'.date('Y');

        Tagihan::create([
            'id_user'           => $limbah->id_penghasil,
            'nomor_tagihan'     => $nomorTagihan,
            'jenis_tagihan'     => 'Retribusi',
            'jumlah_tagihan'    => $request->total_tagihan,
            'status_pembayaran' => 'Belum Dibayar',
            'tgl_tagihan'       => today(),
            'tgl_jatuh_tempo'   => today()->addDays(30),
        ]);

        $limbah->update([
            'status'     => 'Terolah',
            'tgl_terolah' => $request->tgl_diolah,
        ]);

        return redirect()->route('admin.penerimaan.index', 'diolah')
            ->with('success', 'Limbah berhasil diproses dan tagihan telah diterbitkan.');
    }

    public function selesai(Request $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $limbah = Limbah::where('id_limbah', $id)->where('status', 'Terolah')->firstOrFail();

        $limbah->update(['status' => 'Telah Setor PAD']);

        return redirect()->route('admin.penerimaan.index', 'selesai')
            ->with('success', 'Limbah telah selesai diolah dan PAD berhasil dicatat.');
    }

    public function cetak(string $id): string
    {
        $limbah = Limbah::findOrFail($id);

        return 'Fungsi Cetak PDF untuk ID: '.$limbah->id_limbah;
    }
}
