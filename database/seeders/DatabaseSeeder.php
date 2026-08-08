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

        // 3. Buat 4 Jenis Layanan BPS Sesuai Permintaan
        $layanans = [
            ['kode_layanan' => 'A', 'nama_layanan' => 'Layanan PST', 'status' => true],
            ['kode_layanan' => 'B', 'nama_layanan' => 'Layanan Khusus Disabilitas', 'status' => true],
            ['kode_layanan' => 'C', 'nama_layanan' => 'Layanan Pengaduan', 'status' => true],
            ['kode_layanan' => 'D', 'nama_layanan' => 'Layanan PPID', 'status' => true],
        ];

        foreach ($layanans as $layanan) {
            Layanan::create($layanan);
        }
    }
}