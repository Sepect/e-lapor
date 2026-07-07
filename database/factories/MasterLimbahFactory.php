<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MasterLimbah>
 */
class MasterLimbahFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kode_limbah' => strtoupper(fake()->unique()->bothify('?###?')),
            'jenis_limbah' => fake()->words(2, true),
            'sifat_limbah' => fake()->randomElement(['Mudah Menyala', 'Korosif', 'Beracun', 'Reaktif', 'Infeksius']),
            'tarif' => fake()->numberBetween(500000, 3000000),
            'satuan' => 'TON',
        ];
    }
}
