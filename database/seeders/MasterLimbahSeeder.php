<?php

namespace Database\Seeders;

use App\Models\MasterLimbah;
use Illuminate\Database\Seeder;

class MasterLimbahSeeder extends Seeder
{
    /**
     * Seed the master limbah B3 reference data.
     *
     * @var array<int, array{kode: string, jenis: string, sifat: string, tarif: int}>
     */
    private array $data = [
        ['kode' => 'B105d', 'jenis' => 'Oli Bekas', 'sifat' => 'Mudah Menyala', 'tarif' => 1500000],
        ['kode' => 'B109d', 'jenis' => 'Filter Oli Bekas', 'sifat' => 'Mudah Menyala', 'tarif' => 1100000],
        ['kode' => 'B110d', 'jenis' => 'Majun Terkontaminasi', 'sifat' => 'Mudah Menyala', 'tarif' => 1000000],
        ['kode' => 'A102d', 'jenis' => 'Aki/Baterai Bekas', 'sifat' => 'Korosif', 'tarif' => 2000000],
        ['kode' => 'B104d', 'jenis' => 'Kemasan Bekas B3', 'sifat' => 'Beracun', 'tarif' => 1200000],
        ['kode' => 'B107d', 'jenis' => 'Lampu TL Bekas', 'sifat' => 'Beracun', 'tarif' => 1750000],
        ['kode' => 'B321-4', 'jenis' => 'Sludge IPAL', 'sifat' => 'Beracun', 'tarif' => 900000],
        ['kode' => 'A337-1', 'jenis' => 'Limbah Medis', 'sifat' => 'Infeksius', 'tarif' => 2500000],
        ['kode' => 'A337-2', 'jenis' => 'Limbah Farmasi Kadaluarsa', 'sifat' => 'Beracun', 'tarif' => 2300000],
        ['kode' => 'A346-1', 'jenis' => 'Limbah Laboratorium', 'sifat' => 'Reaktif', 'tarif' => 2100000],
    ];

    public function run(): void
    {
        foreach ($this->data as $row) {
            MasterLimbah::updateOrCreate(
                ['kode_limbah' => $row['kode']],
                [
                    'jenis_limbah' => $row['jenis'],
                    'sifat_limbah' => $row['sifat'],
                    'tarif' => $row['tarif'],
                    'satuan' => 'TON',
                ]
            );
        }
    }
}
