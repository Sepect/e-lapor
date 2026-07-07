<?php

namespace Tests\Feature;

use App\Models\KontrakKerjasama;
use App\Models\PerizinanPenghasilModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KontrakCetakTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_kontrak_menyimpan_isian_draft_tripartid(): void
    {
        $penghasil = User::factory()->penghasil()->create();
        $transporter = User::factory()->transporter()->create();

        $this->actingAs($penghasil)->post(route('penghasil.kontrak.store'), [
            'id_transporter' => $transporter->id_user,
            'nomor_kontrak' => 'MOU-2026-001',
            'tgl_terbit' => now()->toDateString(),
            'masa_berlaku_dari' => now()->toDateString(),
            'masa_berlaku_sampai' => now()->addYear()->toDateString(),
            'nama_perusahaan' => 'PT Medika Sentosa',
            'jenis_usaha' => 'Rumah Sakit',
            'nama_ttd' => 'dr. Budi',
            'jabatan_ttd' => 'Direktur',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('kontrak_kerjasamas', [
            'nomor_kontrak' => 'MOU-2026-001',
            'nama_perusahaan' => 'PT Medika Sentosa',
            'nama_ttd' => 'dr. Budi',
        ]);
    }

    public function test_penghasil_dapat_mencetak_draft_kontrak_tripartid(): void
    {
        $penghasil = User::factory()->penghasil()->create();
        $transporter = User::factory()->transporter()->create();

        $kontrak = KontrakKerjasama::create([
            'id_penghasil' => $penghasil->id_user,
            'id_transporter' => $transporter->id_user,
            'nomor_kontrak' => '001/PKS/2026',
            'tgl_terbit' => now(),
            'masa_berlaku_dari' => now(),
            'masa_berlaku_sampai' => now()->addYear(),
            'status' => 'Aktif',
            'nama_perusahaan' => 'PT Medika Sentosa',
            'nama_ttd' => 'dr. Budi',
        ]);

        $response = $this->actingAs($penghasil)->get(route('penghasil.kontrak.cetak', $kontrak->id_kontrak_kerjasama));

        $response->assertOk();
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type'));
        $this->assertStringStartsWith('%PDF', $response->getContent());
        // Nama file di Content-Disposition tidak boleh mengandung "/" dari nomor kontrak.
        $this->assertStringContainsString('draft-kontrak-001-PKS-2026.pdf', $response->headers->get('content-disposition'));
    }

    public function test_cetak_kontrak_dengan_perizinan_penghasil_tetap_render(): void
    {
        $penghasil = User::factory()->penghasil()->create();
        $transporter = User::factory()->transporter()->create();

        // Perizinan penghasil menyimpan tanggal sebagai string (model tanpa date cast).
        PerizinanPenghasilModel::create([
            'id_user' => $penghasil->id_user,
            'no_akta' => 'AKTA-001',
            'tgl_terbit' => '2020-01-15',
            'lampiran' => 'akta.pdf',
            'no_perling' => 'PERLING-001',
            'tgl_terbit_perling' => '2021-02-20',
            'masa_berlaku_perling_dari' => '2021-02-20',
            'masa_berlaku_perling_sampai' => '2026-02-20',
            'limbah_dihasilkan' => 'Limbah Medis',
            'lampiran_perling' => 'perling.pdf',
        ]);

        $kontrak = KontrakKerjasama::create([
            'id_penghasil' => $penghasil->id_user,
            'id_transporter' => $transporter->id_user,
            'nomor_kontrak' => 'MOU-2026-004',
            'tgl_terbit' => now(),
            'masa_berlaku_dari' => now(),
            'masa_berlaku_sampai' => now()->addYear(),
            'status' => 'Aktif',
        ]);

        $response = $this->actingAs($penghasil)->get(route('penghasil.kontrak.cetak', $kontrak->id_kontrak_kerjasama));

        $response->assertOk();
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_penghasil_tidak_bisa_mencetak_kontrak_milik_orang_lain(): void
    {
        $penghasil = User::factory()->penghasil()->create();
        $lain = User::factory()->penghasil()->create();
        $transporter = User::factory()->transporter()->create();

        $kontrak = KontrakKerjasama::create([
            'id_penghasil' => $lain->id_user,
            'id_transporter' => $transporter->id_user,
            'nomor_kontrak' => 'MOU-2026-003',
            'tgl_terbit' => now(),
            'masa_berlaku_dari' => now(),
            'masa_berlaku_sampai' => now()->addYear(),
            'status' => 'Aktif',
        ]);

        $this->actingAs($penghasil)->get(route('penghasil.kontrak.cetak', $kontrak->id_kontrak_kerjasama))
            ->assertNotFound();
    }
}
