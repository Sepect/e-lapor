<?php

namespace Tests\Feature;

use App\Models\Limbah;
use App\Models\MasterLimbah;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenerimaanLimbahOlahTest extends TestCase
{
    use RefreshDatabase;

    public function test_total_tagihan_dihitung_otomatis_dari_berat_kali_tarif(): void
    {
        $admin = User::factory()->admin()->create();
        $penghasil = User::factory()->penghasil()->create();
        $transporter = User::factory()->transporter()->create();
        $master = MasterLimbah::factory()->create(['tarif' => 1000000]);

        $limbah = Limbah::create([
            'id_penghasil' => $penghasil->id_user,
            'id_transporter' => $transporter->id_user,
            'id_master_limbah' => $master->id_master_limbah,
            'kode_limbah' => $master->kode_limbah,
            'jenis_limbah' => $master->jenis_limbah,
            'sifat_limbah' => $master->sifat_limbah,
            'jumlah_limbah' => 2.5,
            'satuan' => 'TON',
            'status' => 'Diterima',
            'tgl_rencana' => now(),
        ]);

        $this->actingAs($admin)->post(route('admin.penerimaan.olah', $limbah->id_limbah), [
            'tgl_diolah' => now()->toDateString(),
        ])->assertSessionHas('success');

        // Tagihan penghasil (biaya pengolahan)
        $tagihanPenghasil = Tagihan::where('id_limbah', $limbah->id_limbah)
            ->where('id_user', $penghasil->id_user)
            ->first();
        $this->assertNotNull($tagihanPenghasil);
        $this->assertEquals(2500000.0, (float) $tagihanPenghasil->jumlah_tagihan);
        $this->assertSame('Terolah', $limbah->fresh()->status);

        // Tagihan transporter (PAD & Retribusi yang harus disetor ke UPT)
        foreach (['PAD', 'Retribusi'] as $jenis) {
            $t = Tagihan::where('id_limbah', $limbah->id_limbah)
                ->where('id_user', $transporter->id_user)
                ->where('jenis_tagihan', $jenis)
                ->first();
            $this->assertNotNull($t, "Tagihan transporter $jenis harus dibuat");
            $this->assertEquals(2500000.0, (float) $t->jumlah_tagihan);
            $this->assertSame('Belum Dibayar', $t->status_pembayaran);
        }
    }

    public function test_total_tagihan_fallback_via_kode_untuk_data_lama(): void
    {
        $admin = User::factory()->admin()->create();
        $penghasil = User::factory()->penghasil()->create();
        MasterLimbah::factory()->create(['kode_limbah' => 'B999z', 'tarif' => 800000]);

        $limbah = Limbah::create([
            'id_penghasil' => $penghasil->id_user,
            'id_master_limbah' => null,
            'kode_limbah' => 'B999z',
            'jumlah_limbah' => 2,
            'satuan' => 'TON',
            'status' => 'Diterima',
            'tgl_rencana' => now(),
        ]);

        $this->actingAs($admin)->post(route('admin.penerimaan.olah', $limbah->id_limbah), [
            'tgl_diolah' => now()->toDateString(),
        ])->assertSessionHas('success');

        $tagihan = Tagihan::where('id_limbah', $limbah->id_limbah)
            ->where('id_user', $penghasil->id_user)
            ->first();
        $this->assertEquals(1600000.0, (float) $tagihan->jumlah_tagihan);
    }
}
