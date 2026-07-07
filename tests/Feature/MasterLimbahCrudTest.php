<?php

namespace Tests\Feature;

use App\Models\MasterLimbah;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterLimbahCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_store_master_limbah(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.master-limbah.store'), [
            'kode_limbah' => 'B105d',
            'jenis_limbah' => 'Oli Bekas',
            'sifat_limbah' => 'Mudah Menyala',
            'tarif' => 1500000,
            'satuan' => 'TON',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('master_limbahs', [
            'kode_limbah' => 'B105d',
            'jenis_limbah' => 'Oli Bekas',
            'tarif' => 1500000,
        ]);
    }

    public function test_admin_can_update_master_limbah(): void
    {
        $admin = User::factory()->admin()->create();
        $master = MasterLimbah::factory()->create(['tarif' => 1000000]);

        $this->actingAs($admin)->put(route('admin.master-limbah.update', $master->id_master_limbah), [
            'kode_limbah' => $master->kode_limbah,
            'jenis_limbah' => $master->jenis_limbah,
            'sifat_limbah' => $master->sifat_limbah,
            'tarif' => 2000000,
            'satuan' => 'TON',
        ])->assertSessionHas('success');

        $this->assertEquals(2000000, (float) $master->fresh()->tarif);
    }

    public function test_admin_can_delete_unused_master_limbah(): void
    {
        $admin = User::factory()->admin()->create();
        $master = MasterLimbah::factory()->create();

        $this->actingAs($admin)->delete(route('admin.master-limbah.destroy', $master->id_master_limbah))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('master_limbahs', ['id_master_limbah' => $master->id_master_limbah]);
    }

    public function test_duplicate_kode_is_rejected(): void
    {
        $admin = User::factory()->admin()->create();
        MasterLimbah::factory()->create(['kode_limbah' => 'B105d']);

        $this->actingAs($admin)->post(route('admin.master-limbah.store'), [
            'kode_limbah' => 'B105d',
            'jenis_limbah' => 'Lain',
            'sifat_limbah' => 'Beracun',
            'tarif' => 100000,
            'satuan' => 'TON',
        ])->assertSessionHasErrors('kode_limbah');
    }

    public function test_non_admin_cannot_access_master_limbah(): void
    {
        $penghasil = User::factory()->penghasil()->create();

        $this->actingAs($penghasil)->get(route('admin.master-limbah.index'))->assertForbidden();
    }
}
