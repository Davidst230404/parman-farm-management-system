<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Sapi;
use App\Models\Kesehatan;
use App\Models\Produksi;
use App\Models\Penjualan;
use App\Models\Mitra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database for clean production/hosting.
     */
    public function run(): void
    {
        // Disable FK checks to truncate cleanly
        Schema::disableForeignKeyConstraints();

        // Clean tables
        User::whereIn('email', ['owner', 'karyawan', 'owner2', 'karyawan2', 'owner@parmanfarm.com', 'karyawan@parmanfarm.com'])
            ->orWhereIn('username', ['owner', 'karyawan'])
            ->delete();
        Produksi::truncate();
        Kesehatan::truncate();
        Sapi::truncate();
        Penjualan::truncate();
        Mitra::truncate();

        Schema::enableForeignKeyConstraints();

        // Seed basic users
        User::create([
            'name'              => 'Owner',
            'email'             => 'owner@parmanfarm.com',
            'username'          => 'owner',
            'role'              => 'owner',
            'password'          => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Budi',
            'email'             => 'karyawan@parmanfarm.com',
            'username'          => 'karyawan',
            'role'              => 'karyawan',
            'password'          => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);
    }
}
