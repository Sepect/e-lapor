<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing lowercase values before changing the enum
        DB::table('kontrak_kerjasamas')->where('status', 'aktif')->update(['status' => 'Aktif']);
        DB::table('kontrak_kerjasamas')
            ->whereIn('status', ['menunggu', 'habis_masa_berlaku', 'ditolak'])
            ->update(['status' => 'Non-Aktif']);

        DB::statement("ALTER TABLE kontrak_kerjasamas MODIFY COLUMN status ENUM('Aktif', 'Non-Aktif') NOT NULL DEFAULT 'Aktif'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE kontrak_kerjasamas MODIFY COLUMN status ENUM('menunggu', 'aktif', 'habis_masa_berlaku', 'ditolak') NOT NULL DEFAULT 'menunggu'");

        DB::table('kontrak_kerjasamas')->where('status', 'Aktif')->update(['status' => 'aktif']);
        DB::table('kontrak_kerjasamas')->where('status', 'Non-Aktif')->update(['status' => 'menunggu']);
    }
};
