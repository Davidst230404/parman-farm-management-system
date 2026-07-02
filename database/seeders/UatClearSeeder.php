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

class UatClearSeeder extends Seeder
{
    /**
     * Clear all tables for UAT session.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Clean tables
        User::whereIn('email', ['owner2', 'karyawan2'])->delete();
        Produksi::truncate();
        Kesehatan::truncate();
        Sapi::truncate();
        Penjualan::truncate();
        Mitra::truncate();

        Schema::enableForeignKeyConstraints();

        // Seed basic users
        User::create([
            'name'              => 'Owner',
            'email'             => 'owner2',
            'role'              => 'owner',
            'password'          => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Budi',
            'email'             => 'karyawan2',
            'role'              => 'karyawan',
            'password'          => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);
    }
}
