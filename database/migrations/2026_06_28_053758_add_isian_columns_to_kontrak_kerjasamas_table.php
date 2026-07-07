<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kontrak_kerjasamas', function (Blueprint $table) {
            $table->string('hari')->nullable()->after('lampiran');
            $table->string('tanggal_ttd')->nullable()->after('hari');
            $table->string('bulan')->nullable()->after('tanggal_ttd');
            $table->string('tahun')->nullable()->after('bulan');
            $table->string('jangka_waktu')->nullable()->after('tahun');
            $table->string('nama_perusahaan')->nullable()->after('jangka_waktu');
            $table->string('jenis_usaha')->nullable()->after('nama_perusahaan');
            $table->string('perizinan')->nullable()->after('jenis_usaha');
            $table->string('alamat_ttd')->nullable()->after('perizinan');
            $table->string('kota_ttd')->nullable()->after('alamat_ttd');
            $table->string('provinsi_ttd')->nullable()->after('kota_ttd');
            $table->string('nama_ttd')->nullable()->after('provinsi_ttd');
            $table->string('jabatan_ttd')->nullable()->after('nama_ttd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kontrak_kerjasamas', function (Blueprint $table) {
            $table->dropColumn([
                'hari', 'tanggal_ttd', 'bulan', 'tahun', 'jangka_waktu',
                'nama_perusahaan', 'jenis_usaha', 'perizinan', 'alamat_ttd',
                'kota_ttd', 'provinsi_ttd', 'nama_ttd', 'jabatan_ttd',
            ]);
        });
    }
};
