<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kendaraan;
use App\Models\Driver;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Dewata',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'approver_level' => null,
        ]);

        // Approver Level 1
        User::create([
            'name' => 'Zein',
            'email' => 'approver1@example.com',
            'password' => Hash::make('approver123'),
            'role' => 'approver',
            'approver_level' => 1,
        ]);

        // Approver Level 2
        User::create([
            'name' => 'Donna',
            'email' => 'approver2@example.com',
            'password' => Hash::make('approver123'),
            'role' => 'approver',
            'approver_level' => 2,
        ]);

        // Kendaraan
        Kendaraan::create([
            'nomor_plat' => 'N 1234 AB',
            'jenis' => 'angkutan orang',
            'merk' => 'Toyota Hiace',
            'tahun' => 2021,
            'lokasi' => 'Tambang Sumatra',
            'tanggal_terakhir_bbm' => now()->subDays(2),
            'tanggal_terakhir_service' => now()->subMonth(),
            'km_terakhir' => 0,
            'jadwal_service_berikutnya' => now()->addMonths(3),
            'status' => 'servis',
        ]);

        Kendaraan::create([
            'nomor_plat' => 'N 5678 CD',
            'jenis' => 'angkutan barang',
            'merk' => 'Mitsubishi Colt Diesel',
            'tahun' => 2019,
            'lokasi' => 'Kantor Pusat',
            'tanggal_terakhir_bbm' => now()->subDays(1),
            'tanggal_terakhir_service' => now()->subMonth(),
            'km_terakhir' => 0,
            'jadwal_service_berikutnya' => now()->addMonths(3),
            'status' => 'aktif',
        ]);

        // Driver
        Driver::create([
            'nama' => 'Sean',
            'telp' => '081234567890'
        ]);

        Driver::create([
            'nama' => 'Dean',
            'telp' => '082112345678'
        ]);
    }
}
