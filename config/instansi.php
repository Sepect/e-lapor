<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Identitas Instansi (Pihak Ketiga / Pengolah)
    |--------------------------------------------------------------------------
    |
    | Data UPT Pengelolaan Limbah B3 yang menjadi pihak ketiga (PIHAK KETIGA)
    | pada draft kontrak kerjasama tripartid. Nilai default mengikuti dokumen
    | resmi PKS Tiga Pihak. Ubah melalui environment variable bila diperlukan.
    |
    */

    'nama' => env('INSTANSI_NAMA', 'UPT-PLB3 Dinas Pengelolaan Lingkungan Hidup Provinsi Sulawesi Selatan'),
    'dinas' => env('INSTANSI_DINAS', 'Dinas Lingkungan Hidup dan Kehutanan Provinsi Sulawesi Selatan'),
    'alamat' => env('INSTANSI_ALAMAT', 'Jl. Jenderal Urip Sumoharjo No. 269'),
    'kelurahan' => env('INSTANSI_KELURAHAN', 'Panaikang'),
    'kecamatan' => env('INSTANSI_KECAMATAN', 'Panakkukang'),
    'kota' => env('INSTANSI_KOTA', 'Makassar'),
    'provinsi' => env('INSTANSI_PROVINSI', 'Sulawesi Selatan'),

    'pimpinan' => env('INSTANSI_PIMPINAN', 'Thamrin, S.Hut., MM'),
    'jabatan' => env('INSTANSI_JABATAN', 'Kepala UPT-PLB3 Dinas Pengelolaan Lingkungan Hidup Provinsi Sulawesi Selatan'),
    'pangkat' => env('INSTANSI_PANGKAT', 'Penata Tk. I'),
    'nip' => env('INSTANSI_NIP', '19771226 199903 1 003'),

    /*
    | Dasar izin pengolahan Limbah B3 (Pihak Ketiga).
    */
    'izin_no' => env('INSTANSI_IZIN_NO', 'S.460/Menlhk/Setjen/PLB.3/7/2019'),
    'izin_tgl' => env('INSTANSI_IZIN_TGL', '15 Juli 2019'),
    'izin_berakhir' => env('INSTANSI_IZIN_BERAKHIR', '15 Juli 2024'),

    /*
    | Rekening pembayaran jasa pengolahan (PAD/Retribusi) ke UPT.
    */
    'bank_nama' => env('INSTANSI_BANK_NAMA', 'Bank Sulselbar Cabang Utama Makassar'),
    'bank_rekening' => env('INSTANSI_BANK_REKENING', '130-002-000033676-7'),
    'bank_atas_nama' => env('INSTANSI_BANK_ATAS_NAMA', 'BLUD UPT Pengelolaan Limbah B3'),

];
