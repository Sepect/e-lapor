<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['Transfer Bank', 'Virtual Account', 'Tunai', 'Lainnya'])
                ->nullable()
                ->after('bukti_pembayaran');
            $table->string('no_referensi')->nullable()->after('metode_pembayaran');
            $table->date('tgl_bayar')->nullable()->after('no_referensi');
            $table->text('catatan_pembayaran')->nullable()->after('tgl_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'no_referensi', 'tgl_bayar', 'catatan_pembayaran']);
        });
    }
};
