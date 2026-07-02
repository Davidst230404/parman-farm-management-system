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

class MockDataSeeder extends Seeder
{
    /**
     * Seed the application's database with mock data.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // Clean tables
        Produksi::truncate();
        Kesehatan::truncate();
        Sapi::truncate();
        Penjualan::truncate();
        Mitra::truncate();

        Schema::enableForeignKeyConstraints();

        // Seed 20 Cows
        for ($i = 1; $i <= 20; $i++) {
            $status = 'normal';
            if ($i === 3 || $i === 8) {
                $status = 'perlu_pemantauan';
            }
            Sapi::create([
                'name'   => 'Sapi ' . $i,
                'code'   => 'SP' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => $status,
            ]);
        }

        // Seed health observations
        for ($i = 1; $i <= 20; $i++) {
            $sapi = Sapi::where('code', 'SP' . str_pad($i, 3, '0', STR_PAD_LEFT))->first();
            if ($i === 3) {
                Kesehatan::create([
                    'sapi_id'      => $sapi->id,
                    'nafsu_makan'  => 'Kurang',
                    'kondisi_susu' => 'Normal',
                    'perilaku'     => 'Lesu',
                    'catatan'      => 'Terlihat kurang aktif',
                    'status'       => 'Perlu Pemantauan',
                    'created_at'   => now()->subDays(1),
                ]);
            } elseif ($i === 8) {
                Kesehatan::create([
                    'sapi_id'      => $sapi->id,
                    'nafsu_makan'  => 'Kurang',
                    'kondisi_susu' => 'Normal',
                    'perilaku'     => 'Lesu',
                    'catatan'      => 'Nafsu makan menurun',
                    'status'       => 'Perlu Pemantauan',
                    'created_at'   => now()->subDays(1),
                ]);
            } else {
                Kesehatan::create([
                    'sapi_id'      => $sapi->id,
                    'nafsu_makan'  => 'Baik',
                    'kondisi_susu' => 'Normal',
                    'perilaku'     => 'Aktif',
                    'catatan'      => 'Keadaan Normal',
                    'status'       => 'Normal',
                    'created_at'   => now()->subDays(rand(0, 3)),
                ]);
            }
        }

        // Seed 7 days milk production
        for ($day = 6; $day >= 0; $day--) {
            $date = \Carbon\Carbon::today()->subDays($day);
            foreach (Sapi::all() as $sapi) {
                Produksi::create([
                    'sapi_id'     => $sapi->id,
                    'jumlah_susu' => rand(6, 12),
                    'sesi'        => 'pagi',
                    'tanggal'     => $date,
                    'status'      => 'Tersimpan',
                ]);
                Produksi::create([
                    'sapi_id'     => $sapi->id,
                    'jumlah_susu' => rand(4, 9),
                    'sesi'        => 'sore',
                    'tanggal'     => $date,
                    'status'      => 'Tersimpan',
                ]);
            }
        }

        // Seed Mitras
        $mitra1 = Mitra::create([
            'nama' => 'UD. Maju Jaya',
            'kontak' => '0812-3456-7890',
            'alamat' => 'Jl. Raya Solo Km. 12',
            'catatan' => 'Mitra tetap utama'
        ]);
        $mitra2 = Mitra::create([
            'nama' => 'Koperasi Tani',
            'kontak' => '0821-2345-6789',
            'alamat' => 'Jl. Desa Makmur No. 5',
            'catatan' => ''
        ]);
        $mitra3 = Mitra::create([
            'nama' => 'Susu Sehat',
            'kontak' => '0813-4455-6677',
            'alamat' => 'Jl. Kaliurang Km. 15',
            'catatan' => ''
        ]);
        $mitra4 = Mitra::create([
            'nama' => 'Greenfields Dairy',
            'kontak' => '0812-7788-9900',
            'alamat' => 'Jl. Ringroad Utara',
            'catatan' => ''
        ]);
        $mitra5 = Mitra::create([
            'nama' => 'Toko Sehat',
            'kontak' => '0856-1234-5678',
            'alamat' => 'Jl. Magelang Km. 7',
            'catatan' => ''
        ]);
        
        $mitraIds = [$mitra1->id, $mitra2->id, $mitra3->id, $mitra4->id, $mitra5->id];

        // Seed 7 days sales
        for ($day = 6; $day >= 0; $day--) {
            $date = \Carbon\Carbon::today()->subDays($day);
            $jumlahTerjual = rand(130, 160);
            Penjualan::create([
                'jumlah_terjual'   => $jumlahTerjual,
                'total_pendapatan' => $jumlahTerjual * 15000,
                'mitra_id'         => $mitraIds[array_rand($mitraIds)],
                'tanggal'          => $date,
            ]);
        }
    }
}
