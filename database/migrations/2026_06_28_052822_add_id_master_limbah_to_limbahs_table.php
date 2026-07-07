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
            $table->uuid('id_master_limbah')->nullable()->index()->after('id_kontrak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('limbahs', function (Blueprint $table) {
            $table->dropColumn('id_master_limbah');
        });
    }
};
