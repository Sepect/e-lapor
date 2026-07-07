<?php

namespace Tests\Feature;

use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TransporterSetorTest extends TestCase
{
    use RefreshDatabase;

    private function buatTagihan(User $transporter, string $jenis): Tagihan
    {
        return Tagihan::create([
            'id_user' => $transporter->id_user,
            'nomor_tagihan' => $jenis.'-0001/2026',
            'jenis_tagihan' => $jenis,
            'jumlah_tagihan' => 2500000,
            'status_pembayaran' => 'Belum Dibayar',
            'tgl_tagihan' => today(),
            'tgl_jatuh_tempo' => today()->addDays(30),
        ]);
    }

    public function test_transporter_dapat_setor_pad(): void
    {
        Storage::fake('public');
        $transporter = User::factory()->transporter()->create();
        $tagihan = $this->buatTagihan($transporter, 'PAD');

        $this->actingAs($transporter)->post(route('transporter.tagihan.setor', $tagihan->id_tagihan), [
            'metode_pembayaran' => 'Transfer Bank',
            'no_referensi' => 'TRF-001',
            'tgl_bayar' => now()->toDateString(),
            'bukti_pembayaran' => UploadedFile::fake()->create('bukti.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('transporter.pad'))->assertSessionHas('success');

        $tagihan->refresh();
        $this->assertSame('Lunas', $tagihan->status_pembayaran);
        $this->assertSame('TRF-001', $tagihan->no_referensi);
        $this->assertNotNull($tagihan->bukti_pembayaran);
        Storage::disk('public')->assertExists($tagihan->bukti_pembayaran);
    }

    public function test_transporter_dapat_setor_retribusi(): void
    {
        Storage::fake('public');
        $transporter = User::factory()->transporter()->create();
        $tagihan = $this->buatTagihan($transporter, 'Retribusi');

        $this->actingAs($transporter)->post(route('transporter.tagihan.setor', $tagihan->id_tagihan), [
            'metode_pembayaran' => 'Transfer Bank',
            'no_referensi' => 'TRF-002',
            'tgl_bayar' => now()->toDateString(),
            'bukti_pembayaran' => UploadedFile::fake()->create('bukti.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('transporter.retribusi'))->assertSessionHas('success');

        $this->assertSame('Lunas', $tagihan->fresh()->status_pembayaran);
    }

    public function test_transporter_tidak_bisa_setor_tagihan_milik_orang_lain(): void
    {
        Storage::fake('public');
        $transporter = User::factory()->transporter()->create();
        $lain = User::factory()->transporter()->create();
        $tagihan = $this->buatTagihan($lain, 'PAD');

        $this->actingAs($transporter)->post(route('transporter.tagihan.setor', $tagihan->id_tagihan), [
            'metode_pembayaran' => 'Transfer Bank',
            'no_referensi' => 'TRF-003',
            'tgl_bayar' => now()->toDateString(),
            'bukti_pembayaran' => UploadedFile::fake()->create('bukti.pdf', 100, 'application/pdf'),
        ])->assertNotFound();

        $this->assertSame('Belum Dibayar', $tagihan->fresh()->status_pembayaran);
    }
}
