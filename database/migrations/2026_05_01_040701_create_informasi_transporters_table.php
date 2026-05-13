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
        Schema::create('informasi_transporters', function (Blueprint $table) {
            $table->uuid('id_informasi_transporter')->primary();
            $table->uuid('id_user')->index();
            $table->string('nama_transporter');
            $table->string('alamat_transporter');
            $table->string('kota_transporter');
            $table->string('telepon_transporter');
            $table->string('fax_transporter')->nullable();
            $table->string('nama_penanggung_jawab')->nullable();
            $table->string('telepon_penanggung_jawab')->nullable();
            $table->string('email_penanggung_jawab')->nullable();
            $table->string('nama_driver')->nullable();
            $table->string('telepon_driver')->nullable();
            $table->string('email_driver')->nullable();
            $table->string('logo_transporter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_transporters');
    }
};
