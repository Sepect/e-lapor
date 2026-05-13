<?php

namespace App\Http\Controllers\Penghasil;

use App\Http\Controllers\Controller;
use App\Models\InformasiPenghasilModel;
use App\Models\KantorPusatPenghasilModel;
use App\Models\PerizinanPenghasilModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function updateInformasi(Request $request)
    {
        $data = $request->validate([
            'nama_penghasil'           => ['required', 'string', 'max:255'],
            'alamat_penghasil'         => ['required', 'string', 'max:500'],
            'kota_penghasil'           => ['required', 'string', 'max:100'],
            'telepon_penghasil'        => ['required', 'string', 'max:20'],
            'fax_penghasil'            => ['nullable', 'string', 'max:20'],
            'nama_penanggung_jawab'    => ['nullable', 'string', 'max:255'],
            'telepon_penanggung_jawab' => ['nullable', 'string', 'max:20'],
            'email_penanggung_jawab'   => ['nullable', 'email', 'max:255'],
            'nama_driver'              => ['nullable', 'string', 'max:255'],
            'telepon_driver'           => ['nullable', 'string', 'max:20'],
            'email_driver'             => ['nullable', 'email', 'max:255'],
        ]);

        InformasiPenghasilModel::updateOrCreate(
            ['id_user' => Auth::user()->id_user],
            $data
        );

        return back()->with('success', 'Informasi Penghasil berhasil disimpan!');
    }

    public function updateKantor(Request $request)
    {
        $data = $request->validate([
            'nama_kantor_pusat_penghasil'           => ['required', 'string', 'max:255'],
            'alamat_kantor_pusat_penghasil'         => ['required', 'string', 'max:500'],
            'telepon_kantor_pusat_penghasil'        => ['required', 'string', 'max:20'],
            'fax_kantor_pusat_penghasil'            => ['nullable', 'string', 'max:20'],
            'alamat_kantor_perwakilan_penghasil'    => ['nullable', 'string', 'max:500'],
            'telepon_kantor_perwakilan_penghasil'   => ['nullable', 'string', 'max:20'],
            'fax_kantor_perwakilan_penghasil'       => ['nullable', 'string', 'max:20'],
        ]);

        KantorPusatPenghasilModel::updateOrCreate(
            ['id_user' => Auth::user()->id_user],
            $data
        );

        return back()->with('success', 'Data Kantor berhasil disimpan!');
    }

    public function updatePerizinan(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $izin = PerizinanPenghasilModel::where('id_user', Auth::user()->id_user)->first();

        if ($request->hasFile('lampiran')) {
            if ($izin && $izin->lampiran) Storage::delete('public/' . $izin->lampiran);
            $data['lampiran'] = $request->file('lampiran')->store('perizinan/akta', 'public');
        }

        if ($request->hasFile('lampiran_perling')) {
            if ($izin && $izin->lampiran_perling) Storage::delete('public/' . $izin->lampiran_perling);
            $data['lampiran_perling'] = $request->file('lampiran_perling')->store('perizinan/perling', 'public');
        }

        PerizinanPenghasilModel::updateOrCreate(
            ['id_user' => Auth::user()->id_user],
            $data
        );

        return back()->with('success', 'Data Perizinan berhasil disimpan!');
    }

    public function updateLogo(Request $request)
    {
        if (InformasiPenghasilModel::count() <= 0) {
            return back()->with('error', 'Informasi Penghasil tidak boleh kosong!');
        }

        $request->validate([
            'logo_penghasil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $info = InformasiPenghasilModel::firstOrCreate(['id_user' => Auth::user()->id_user]);

        if ($request->hasFile('logo_penghasil')) {
            if ($info->logo_penghasil) Storage::delete('public/' . $info->logo_penghasil);

            $path = $request->file('logo_penghasil')->store('logo_penghasil', 'public');
            $info->update(['logo_penghasil' => $path]);
        }

        return back()->with('success', 'Logo berhasil diperbarui!');
    }
}
