<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use App\Models\Sapi;
use App\Models\Kesehatan;
use App\Models\Produksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Stats
        $totalSapi = Sapi::count();
        $sapiSehat = Sapi::where('status', 'normal')->count();
        $persenSehat = $totalSapi > 0 ? round(($sapiSehat / $totalSapi) * 100) : 0;

        // Cows milked today
        $sudahDiperah = Produksi::whereDate('tanggal', $today)
            ->where('status', 'Tersimpan')
            ->distinct('sapi_id')
            ->count('sapi_id');
        $persenDiperah = $totalSapi > 0 ? round(($sudahDiperah / $totalSapi) * 100) : 0;

        // Milk production today
        $produksiSusuHariIni = (float) Produksi::whereDate('tanggal', $today)
            ->where('status', 'Tersimpan')
            ->sum('jumlah_susu');

        // 2. Sesi Produksi
        $pagiCount = Produksi::whereDate('tanggal', $today)->where('sesi', 'pagi')->count();
        $pagiVol = (float) Produksi::whereDate('tanggal', $today)->where('sesi', 'pagi')->sum('jumlah_susu');
        $soreCount = Produksi::whereDate('tanggal', $today)->where('sesi', 'sore')->count();
        $soreVol = (float) Produksi::whereDate('tanggal', $today)->where('sesi', 'sore')->sum('jumlah_susu');

        // 3. Catatan Kesehatan Hari Ini
        $latestActivities = Kesehatan::with('sapi')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('karyawan.dashboard.index', compact(
            'totalSapi',
            'sapiSehat',
            'persenSehat',
            'sudahDiperah',
            'persenDiperah',
            'produksiSusuHariIni',
            'pagiCount',
            'pagiVol',
            'soreCount',
            'soreVol',
            'latestActivities'
        ));
    }
}
