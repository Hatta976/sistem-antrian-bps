<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Layanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Role
        $adminRole = Role::create(['nama_role' => 'Admin']);
        $petugasRole = Role::create(['nama_role' => 'Petugas']);

        // 2. Buat User Admin & Petugas
        User::create([
            'role_id'  => $adminRole->id,
            'name'     => 'Administrator BPS',
            'email'    => 'admin@bpsprabumulih.go.id',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'role_id'  => $petugasRole->id,
            'name'     => 'Petugas Loket 1',
            'email'    => 'petugas@bpsprabumulih.go.id',
            'password' => Hash::make('password123'),
        ]);

        // 3. Buat Jenis Layanan BPS
        $layanans = [
            ['kode_layanan' => 'A', 'nama_layanan' => 'Konsultasi Statistik', 'status' => true],
            ['kode_layanan' => 'B', 'nama_layanan' => 'Pelayanan Statistik Terpadu (PST)', 'status' => true],
            ['kode_layanan' => 'C', 'nama_layanan' => 'Permintaan Data', 'status' => true],
            ['kode_layanan' => 'D', 'nama_layanan' => 'Rekomendasi Statistik', 'status' => true],
            ['kode_layanan' => 'E', 'nama_layanan' => 'Lainnya', 'status' => true],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}