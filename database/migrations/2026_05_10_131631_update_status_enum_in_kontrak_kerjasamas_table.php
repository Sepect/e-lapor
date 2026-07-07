<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing lowercase values before changing the enum
        DB::table('kontrak_kerjasamas')->where('status', 'aktif')->update(['status' => 'Aktif']);
        DB::table('kontrak_kerjasamas')
            ->whereIn('status', ['menunggu', 'habis_masa_berlaku', 'ditolak'])
            ->update(['status' => 'Non-Aktif']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE kontrak_kerjasamas MODIFY COLUMN status ENUM('Aktif', 'Non-Aktif') NOT NULL DEFAULT 'Aktif'");
        } else {
            Schema::table('kontrak_kerjasamas', function (Blueprint $table) {
                $table->string('status')->default('Aktif')->change();
            });
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE kontrak_kerjasamas MODIFY COLUMN status ENUM('menunggu', 'aktif', 'habis_masa_berlaku', 'ditolak') NOT NULL DEFAULT 'menunggu'");
        }

        DB::table('kontrak_kerjasamas')->where('status', 'Aktif')->update(['status' => 'aktif']);
        DB::table('kontrak_kerjasamas')->where('status', 'Non-Aktif')->update(['status' => 'menunggu']);
    }
};
