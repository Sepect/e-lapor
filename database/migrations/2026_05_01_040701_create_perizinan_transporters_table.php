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
        Schema::create('perizinan_transporters', function (Blueprint $table) {
            $table->uuid('id_perizinan_transporter')->primary();
            $table->uuid('id_user')->index();
            $table->string('no_akta');
            $table->date('tgl_terbit');
            $table->string('lampiran');
            $table->string('no_perling');
            $table->date('tgl_terbit_perling');
            $table->date('masa_berlaku_perling_dari');
            $table->date('masa_berlaku_perling_sampai');
            $table->string('lampiran_perling');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perizinan_transporters');
    }
};
