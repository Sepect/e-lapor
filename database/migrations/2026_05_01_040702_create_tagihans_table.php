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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->uuid('id_tagihan')->primary();
            $table->uuid('id_user')->index();
            $table->string('nomor_tagihan')->unique();
            $table->enum('jenis_tagihan', ['PAD', 'Retribusi', 'Layanan']);
            $table->decimal('jumlah_tagihan', 15, 2);
            $table->enum('status_pembayaran', ['Belum Dibayar', 'Lunas'])->default('Belum Dibayar');
            $table->date('tgl_tagihan');
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
