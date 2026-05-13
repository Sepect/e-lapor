<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama_user' => 'Admin UPT',
            'username' => 'admin_upt',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => 'password123'
        ]);
    }
}
