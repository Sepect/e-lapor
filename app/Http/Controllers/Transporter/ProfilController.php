<?php

namespace App\Http\Controllers\Transporter;

use App\Http\Controllers\Controller;
use App\Models\InformasiTransporter;
use App\Models\PerizinanTransporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function updateInformasi(Request $request)
    {
        $data = $request->validate([
            'nama_transporter'         => ['required', 'string', 'max:255'],
            'alamat_transporter'       => ['required', 'string', 'max:500'],
            'kota_transporter'         => ['required', 'string', 'max:100'],
            'telepon_transporter'      => ['required', 'string', 'max:20'],
            'fax_transporter'          => ['nullable', 'string', 'max:20'],
            'nama_penanggung_jawab'    => ['nullable', 'string', 'max:255'],
            'telepon_penanggung_jawab' => ['nullable', 'string', 'max:20'],
            'email_penanggung_jawab'   => ['nullable', 'email', 'max:255'],
            'nama_driver'              => ['nullable', 'string', 'max:255'],
            'telepon_driver'           => ['nullable', 'string', 'max:20'],
            'email_driver'             => ['nullable', 'email', 'max:255'],
        ]);

        InformasiTransporter::updateOrCreate(
            ['id_user' => Auth::user()->id_user],
            $data
        );

        return back()->with('success', 'Informasi Transporter berhasil disimpan!');
    }

    public function updatePerizinan(Request $request)
    {
        $request->validate([
            'no_akta'                   => ['nullable', 'string', 'max:255'],
            'tgl_terbit'                => ['nullable', 'date'],
            'lampiran'                  => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:2048'],
            'no_perling'                => ['nullable', 'string', 'max:255'],
            'tgl_terbit_perling'        => ['nullable', 'date'],
            'masa_berlaku_perling_dari' => ['nullable', 'date'],
            'masa_berlaku_perling_sampai' => ['nullable', 'date', 'after_or_equal:masa_berlaku_perling_dari'],
            'lampiran_perling'          => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:2048'],
        ]);

        $data = $request->except(['_token', '_method']);
        $izin = PerizinanTransporter::where('id_user', Auth::user()->id_user)->first();

        if ($request->hasFile('lampiran')) {
            if ($izin && $izin->lampiran) {
                Storage::delete('public/' . $izin->lampiran);
            }
            $data['lampiran'] = $request->file('lampiran')->store('perizinan/akta', 'public');
        }

        if ($request->hasFile('lampiran_perling')) {
            if ($izin && $izin->lampiran_perling) {
                Storage::delete('public/' . $izin->lampiran_perling);
            }
            $data['lampiran_perling'] = $request->file('lampiran_perling')->store('perizinan/perling', 'public');
        }

        PerizinanTransporter::updateOrCreate(
            ['id_user' => Auth::user()->id_user],
            $data
        );

        return back()->with('success', 'Data Perizinan berhasil disimpan!');
    }

    public function updateLogo(Request $request)
    {
        $info = InformasiTransporter::where('id_user', Auth::user()->id_user)->first();

        if (! $info) {
            return back()->with('error', 'Lengkapi Informasi Transporter terlebih dahulu sebelum mengunggah logo!');
        }

        $request->validate([
            'logo_transporter' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('logo_transporter')) {
            if ($info->logo_transporter) {
                Storage::delete('public/' . $info->logo_transporter);
            }

            $path = $request->file('logo_transporter')->store('logo_transporter', 'public');
            $info->update(['logo_transporter' => $path]);
        }

        return back()->with('success', 'Logo berhasil diperbarui!');
    }
}
