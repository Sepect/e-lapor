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
        Schema::create('berita_acaras', function (Blueprint $table) {
            $table->uuid('id_berita_acara')->primary();
            $table->uuid('id_limbah')->index();
            $table->string('nama_penyerah')->nullable();
            $table->string('alamat_penyerah')->nullable();
            $table->string('jabatan_penyerah')->nullable();
            $table->string('tandatangan_penyerah')->nullable();
            $table->string('stempel_penyerah')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->string('alamat_penerima')->nullable();
            $table->string('jabatan_penerima')->nullable();
            $table->string('tandatangan_penerima')->nullable();
            $table->string('stempel_penerima')->nullable();
            $table->date('tgl_penyerahan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acaras');
    }
};
