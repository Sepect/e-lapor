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
        Schema::create('kontrak_kerjasamas', function (Blueprint $table) {
            $table->uuid('id_kontrak_kerjasama')->primary();
            $table->uuid('id_penghasil')->index();
            $table->uuid('id_transporter')->nullable()->index();
            $table->string('nomor_kontrak');
            $table->date('tgl_terbit');
            $table->date('masa_berlaku_dari');
            $table->date('masa_berlaku_sampai');
            $table->enum('status', ['menunggu', 'aktif', 'habis_masa_berlaku', 'ditolak'])->default('menunggu');
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_kerjasamas');
    }
};
