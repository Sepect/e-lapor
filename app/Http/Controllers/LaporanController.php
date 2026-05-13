<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('admin.laporan.index');
    }

    public function penghasil(): \Illuminate\View\View
    {
        $daftarPenghasil = User::where('role', 'penghasil')
            ->with('informasiPenghasil')
            ->get();

        return view('admin.laporan.penghasil.index', compact('daftarPenghasil'));
    }

    public function transporter(): \Illuminate\View\View
    {
        $daftarTransporter = User::where('role', 'transporter')
            ->with('informasiTransporter')
            ->get();

        return view('admin.laporan.trasporter.index', compact('daftarTransporter'));
    }

    public function potensi_pad(): \Illuminate\View\View
    {
        return view('admin.laporan.potensi_pad.index');
    }

    public function penerimaan_pad(): \Illuminate\View\View
    {
        return view('admin.laporan.penerimaan_pad.index');
    }

    public function piutang_pad(): \Illuminate\View\View
    {
        return view('admin.laporan.piutang_pad.index');
    }

    /**
     * Cek ketersediaan file laporan dan download jika ada.
     *
     * Konvensi penamaan file:
     *   laporan/{jenis_laporan}_{tahun}_{tgl_awal}_{tgl_akhir}.{pdf|xlsx}
     *
     * Contoh: laporan/penghasil_2025_2025-01-01_2025-06-30.pdf
     */
    public function cetak(Request $request): \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $request->validate([
            'tahun'         => ['required', 'digits:4'],
            'tgl_awal'      => ['required', 'date'],
            'tgl_akhir'     => ['required', 'date', 'after_or_equal:tgl_awal'],
            'tgl_cetak'     => ['required', 'date'],
            'jenis_cetak'   => ['required', 'in:pdf,excel'],
            'jenis_laporan' => ['required', 'in:lengkap,penghasil,transporter,potensi_pad,penerimaan_pad,piutang_pad'],
        ], [
            'tahun.required'           => 'Tahun wajib dipilih.',
            'tahun.digits'             => 'Format tahun tidak valid.',
            'tgl_awal.required'        => 'Tanggal awal periode wajib diisi.',
            'tgl_akhir.required'       => 'Tanggal akhir periode wajib diisi.',
            'tgl_akhir.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal.',
            'tgl_cetak.required'       => 'Tanggal cetak wajib diisi.',
            'jenis_cetak.required'     => 'Jenis format cetak wajib dipilih.',
        ]);

        $jenisLaporan = $request->input('jenis_laporan');
        $jenisCetak = $request->input('jenis_cetak');
        $tahun = $request->input('tahun');
        $tglAwal = $request->input('tgl_awal');
        $tglAkhir = $request->input('tgl_akhir');

        $labelMap = [
            'lengkap'        => 'Keseluruhan/Lengkap',
            'penghasil'      => 'Penghasil',
            'transporter'    => 'Transporter',
            'potensi_pad'    => 'Potensi PAD',
            'penerimaan_pad' => 'Penerimaan PAD',
            'piutang_pad'    => 'Piutang PAD',
        ];

        $label = $labelMap[$jenisLaporan] ?? 'Laporan';
        $ekstensi = $jenisCetak === 'pdf' ? 'pdf' : 'xlsx';

        /* Cari file yang cocok dengan konvensi penamaan */
        $namaFile = "{$jenisLaporan}_{$tahun}_{$tglAwal}_{$tglAkhir}.{$ekstensi}";
        $pathFile = "laporan/{$namaFile}";

        if (! Storage::disk('public')->exists($pathFile)) {
            return back()->with('error', "File Laporan {$label} dengan format " . strtoupper($jenisCetak) . " untuk periode {$tglAwal} s/d {$tglAkhir} tidak tersedia. Silakan hubungi administrator untuk membuat laporan terlebih dahulu.");
        }

        $downloadName = "Laporan_{$label}_{$tahun}_{$tglAwal}_sd_{$tglAkhir}.{$ekstensi}";

        return response()->download(
            Storage::disk('public')->path($pathFile),
            $downloadName
        );
    }
}

