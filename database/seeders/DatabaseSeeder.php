<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@tramadol.test',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Pelanggan Demo',
            'email' => 'customer@tramadol.test',
            'role' => 'user',
        ]);

        Service::create([
            'name' => 'Servis & Tune Up Motor',
            'slug' => 'servis-tune-up-motor',
            'category' => 'motor',
            'description' => 'Pemeriksaan oli, rem, transmisi, dan komponen mesin agar motor selalu nyaman dipakai.',
            'price' => 250000,
            'duration_minutes' => 90,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Mesin & Kaki-kaki Mobil',
            'slug' => 'mesin-kaki-kaki-mobil',
            'category' => 'mobil',
            'description' => 'Diagnosa menyeluruh untuk mesin, suspensi, dan komponennya agar mobil lebih stabil.',
            'price' => 500000,
            'duration_minutes' => 120,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Detailing Interior & Eksterior',
            'slug' => 'detailing-interior-eksterior',
            'category' => 'detailing',
            'description' => 'Perawatan kebersihan dan tampilan kendaraan agar tetap rapi dan terawat.',
            'price' => 350000,
            'duration_minutes' => 75,
            'is_active' => true,
        ]);
    }
}
