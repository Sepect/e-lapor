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
        Schema::create('master_limbahs', function (Blueprint $table) {
            $table->uuid('id_master_limbah')->primary();
            $table->string('kode_limbah')->unique();
            $table->string('jenis_limbah');
            $table->string('sifat_limbah');
            $table->decimal('tarif', 15, 2)->default(0);
            $table->string('satuan')->default('TON');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_limbahs');
    }
};
