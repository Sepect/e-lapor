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
        Schema::create('kantor_pusat_penghasil', function (Blueprint $table) {
            $table->uuid('id_kantor_pusat_penghasil')->primary();
            $table->uuid('id_user');
            $table->string('nama_kantor_pusat_penghasil');
            $table->string('alamat_kantor_pusat_penghasil');
            $table->string('telepon_kantor_pusat_penghasil');
            $table->string('fax_kantor_pusat_penghasil')->nullable();
            $table->string('alamat_kantor_perwakilan_penghasil')->nullable();
            $table->string('telepon_kantor_perwakilan_penghasil')->nullable();
            $table->string('fax_kantor_perwakilan_penghasil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kantor_pusat_penghasil');
    }
};
