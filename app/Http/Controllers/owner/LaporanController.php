<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Produksi;
use App\Models\Penjualan;
use App\Models\Kesehatan;
use App\Models\Sapi;
use App\Models\Mitra;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Dynamic cows statistics for Laporan page cards
        $totalSapi = Sapi::count();
        $sapiSehat = Sapi::where('status', 'normal')->count();
        $persenSehat = $totalSapi > 0 ? round(($sapiSehat / $totalSapi) * 100) : 0;

        // Stat cards: Total volume and sales in current month
        $produksiSusuBulanIni = (float) Produksi::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->where('status', 'Tersimpan')
            ->sum('jumlah_susu');

        $totalPenjualanBulanIni = (float) Penjualan::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('total_pendapatan');

        // Fetch dynamic mitras
        $mitras = Mitra::all();

        // Merged daily logs for the last 30 days
        $dates = [];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::today()->subDays($i);
            
            $prodVol = (float) Produksi::whereDate('tanggal', $date)
                ->where('status', 'Tersimpan')
                ->sum('jumlah_susu');

            $saleVal = (float) Penjualan::whereDate('tanggal', $date)
                ->sum('total_pendapatan');

            $firstSale = Penjualan::with('mitra')->whereDate('tanggal', $date)->first();
            $mitra = $firstSale && $firstSale->mitra ? $firstSale->mitra->nama : '—';

            $healthCount = Kesehatan::whereDate('created_at', $date)
                ->where('status', 'Perlu Pemantauan')
                ->count();

            $healthNote = 'Normal';
            $status = 'Normal';
            if ($healthCount > 0) {
                $healthNote = $healthCount . ' Sapi Pantau';
                $status = 'Perlu Pantau';
            }

            // Only include in the report list if there's any record / action on that day
            if ($prodVol > 0 || $saleVal > 0 || $healthCount > 0) {
                $dates[] = [
                    'tanggal' => $date->locale('id')->isoFormat('D MMMM YYYY'),
                    'produksi' => $prodVol,
                    'penjualan' => $saleVal,
                    'mitra' => $mitra,
                    'catatan' => $healthNote,
                    'status' => $status
                ];
            }
        }

        return view('owner.laporan.index', compact(
            'totalSapi',
            'sapiSehat',
            'persenSehat',
            'produksiSusuBulanIni',
            'totalPenjualanBulanIni',
            'mitras',
            'dates'
        ));
    }
}
