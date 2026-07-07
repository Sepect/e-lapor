<?php

namespace Tests\Feature;

use App\Models\KontrakKerjasama;
use App\Models\Limbah;
use App\Models\MasterLimbah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenghasilStoreLimbahTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_limbah_resolves_kode_jenis_sifat_from_master(): void
    {
        $penghasil = User::factory()->penghasil()->create();
        $transporter = User::factory()->transporter()->create();
        $master = MasterLimbah::factory()->create([
            'kode_limbah' => 'B105d',
            'jenis_limbah' => 'Oli Bekas',
            'sifat_limbah' => 'Mudah Menyala',
        ]);

        KontrakKerjasama::create([
            'id_penghasil' => $penghasil->id_user,
            'id_transporter' => $transporter->id_user,
            'nomor_kontrak' => 'MOU-001',
            'tgl_terbit' => now(),
            'masa_berlaku_dari' => now(),
            'masa_berlaku_sampai' => now()->addYear(),
            'status' => 'Aktif',
        ]);

        $this->actingAs($penghasil)->post(route('penghasil.limbah.store'), [
            'id_transporter' => $transporter->id_user,
            'id_master_limbah' => $master->id_master_limbah,
            'jumlah_limbah' => 3.5,
        ])->assertSessionHas('success');

        $limbah = Limbah::where('id_penghasil', $penghasil->id_user)->first();
        $this->assertNotNull($limbah);
        $this->assertSame($master->id_master_limbah, $limbah->id_master_limbah);
        $this->assertSame('B105d', $limbah->kode_limbah);
        $this->assertSame('Oli Bekas', $limbah->jenis_limbah);
        $this->assertSame('Mudah Menyala', $limbah->sifat_limbah);
    }

    public function test_store_limbah_requires_master_selection(): void
    {
        $penghasil = User::factory()->penghasil()->create();
        $transporter = User::factory()->transporter()->create();

        $this->actingAs($penghasil)->post(route('penghasil.limbah.store'), [
            'id_transporter' => $transporter->id_user,
            'jumlah_limbah' => 3.5,
        ])->assertSessionHasErrors('id_master_limbah');
    }
}
