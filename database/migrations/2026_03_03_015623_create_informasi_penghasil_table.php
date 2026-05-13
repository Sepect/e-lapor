<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('informasi_penghasil', function (Blueprint $table) {
            $table->uuid('id_informasi_penghasil')->primary();
            $table->uuid('id_user');
            $table->string('nama_penghasil');
            $table->string('alamat_penghasil');
            $table->string('kota_penghasil');
            $table->string('telepon_penghasil');
            $table->string('fax_penghasil')->nullable();
            $table->string('nama_penanggung_jawab')->nullable();
            $table->string('telepon_penanggung_jawab')->nullable();
            $table->string('email_penanggung_jawab')->nullable();
            $table->string('nama_driver')->nullable();
            $table->string('telepon_driver')->nullable();
            $table->string('email_driver')->nullable();
            $table->string('logo_penghasil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_penghasil');
    }
};
