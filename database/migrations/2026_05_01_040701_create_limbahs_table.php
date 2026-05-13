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
        Schema::create('limbahs', function (Blueprint $table) {
            $table->uuid('id_limbah')->primary();
            $table->uuid('id_penghasil')->index();
            $table->uuid('id_transporter')->nullable()->index();
            $table->uuid('id_kontrak')->nullable()->index();
            $table->string('kode_limbah');
            $table->decimal('jumlah_limbah', 10, 2);
            $table->string('satuan')->default('TON');
            $table->string('no_manifest')->nullable();
            $table->string('no_kendaraan')->nullable();
            $table->enum('status', ['Rencana', 'Terangkut', 'Diterima', 'Terolah', 'Telah Setor PAD'])->default('Rencana');
            $table->date('tgl_rencana')->nullable();
            $table->date('tgl_terangkut')->nullable();
            $table->date('tgl_diterima')->nullable();
            $table->date('tgl_terolah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limbahs');
    }
};
