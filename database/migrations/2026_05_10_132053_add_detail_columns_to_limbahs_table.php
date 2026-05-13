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
        Schema::table('limbahs', function (Blueprint $table) {
            $table->string('jenis_limbah')->nullable()->after('kode_limbah');
            $table->string('sifat_limbah')->nullable()->after('jenis_limbah');
            $table->string('nama_driver')->nullable()->after('no_kendaraan');
            $table->string('jenis_kendaraan')->nullable()->after('nama_driver');
            $table->text('catatan')->nullable()->after('jenis_kendaraan');
        });
    }

    public function down(): void
    {
        Schema::table('limbahs', function (Blueprint $table) {
            $table->dropColumn(['jenis_limbah', 'sifat_limbah', 'nama_driver', 'jenis_kendaraan', 'catatan']);
        });
    }
};
