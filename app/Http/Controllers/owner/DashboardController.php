<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Sapi;
use App\Models\Kesehatan;
use App\Models\Produksi;
use App\Models\Penjualan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $dateStr = request('date');
        try {
            $today = $dateStr ? Carbon::parse($dateStr) : Carbon::today();
        } catch (\Exception $e) {
            $today = Carbon::today();
        }

        // 1. Stats (count registered cows up to selected date)
        $totalSapi = Sapi::whereDate('created_at', '<=', $today)->count();
        $sapiSehat = Sapi::whereDate('created_at', '<=', $today)->where('status', 'normal')->count();
        $persenSehat = $totalSapi > 0 ? round(($sapiSehat / $totalSapi) * 100) : 0;

        // Cows milked today (at least one record in 'produksi' table today)
        $sudahDiperah = Produksi::whereDate('tanggal', $today)
            ->where('status', 'Tersimpan')
            ->distinct('sapi_id')
            ->count('sapi_id');
        $persenDiperah = $totalSapi > 0 ? round(($sudahDiperah / $totalSapi) * 100) : 0;

        // Milk volume sold and income today
        $terjualHariIniVolume = (float) Penjualan::whereDate('tanggal', $today)->sum('jumlah_terjual');
        $terjualHariIniPendapatan = (float) Penjualan::whereDate('tanggal', $today)->sum('total_pendapatan');

        // 2. Chart (Last 7 Days)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $chartLabels[] = $date->locale('id')->isoFormat('D MMM');
            $chartData[] = (float) Produksi::whereDate('tanggal', $date)
                ->where('status', 'Tersimpan')
                ->sum('jumlah_susu');
        }

        // 3. Top Producers (Overall Highest Milk Production)
        $topSapi = Produksi::where('status', 'Tersimpan')
            ->selectRaw('sapi_id, SUM(jumlah_susu) as total_susu')
            ->groupBy('sapi_id')
            ->with('sapi')
            ->orderByDesc('total_susu')
            ->take(3)
            ->get();

        // 4. Sales Month Summary
        $currentMonthVol = (float) Penjualan::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('jumlah_terjual');
        $currentMonthRev = (float) Penjualan::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('total_pendapatan');

        $lastMonthVol = (float) Penjualan::whereMonth('tanggal', $today->copy()->subMonth()->month)
            ->whereYear('tanggal', $today->copy()->subMonth()->year)
            ->sum('jumlah_terjual');

        $salesGrowth = 0;
        if ($lastMonthVol > 0) {
            $salesGrowth = round((($currentMonthVol - $lastMonthVol) / $lastMonthVol) * 100);
        }

        // 5. Recent Activities (Latest Health Logs up to selected date)
        $latestActivities = Kesehatan::with('sapi')
            ->whereDate('created_at', '<=', $today)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        // 6. Active Partner (Highest Transaction Volume Overall)
        $activeMitra = Penjualan::with('mitra')
            ->selectRaw('mitra_id, SUM(jumlah_terjual) as total_volume')
            ->groupBy('mitra_id')
            ->orderByDesc('total_volume')
            ->first();

        return view('owner.dashboard.index', compact(
            'totalSapi',
            'sapiSehat',
            'persenSehat',
            'sudahDiperah',
            'persenDiperah',
            'terjualHariIniVolume',
            'terjualHariIniPendapatan',
            'chartLabels',
            'chartData',
            'topSapi',
            'currentMonthVol',
            'currentMonthRev',
            'salesGrowth',
            'latestActivities',
            'activeMitra',
            'today'
        ));
    }

    /**
     * Live JSON API — called by JS polling every 30s.
     * Returns fresh dashboard stats for the given date.
     */
    public function liveStats(\Illuminate\Http\Request $request)
    {
        $dateStr = $request->query('date');
        try {
            $today = $dateStr ? Carbon::parse($dateStr) : Carbon::today();
        } catch (\Exception $e) {
            $today = Carbon::today();
        }

        $totalSapi  = Sapi::count();
        $sapiSehat  = Sapi::where('status', 'normal')->count();
        $persenSehat = $totalSapi > 0 ? round(($sapiSehat / $totalSapi) * 100) : 0;

        $sudahDiperah = Produksi::whereDate('tanggal', $today)
            ->where('status', 'Tersimpan')
            ->distinct('sapi_id')
            ->count('sapi_id');
        $persenDiperah = $totalSapi > 0 ? round(($sudahDiperah / $totalSapi) * 100) : 0;

        $terjualVol = (float) Penjualan::whereDate('tanggal', $today)->sum('jumlah_terjual');
        $terjualRev = (float) Penjualan::whereDate('tanggal', $today)->sum('total_pendapatan');

        $latestActivities = Kesehatan::with('sapi')
            ->whereDate('created_at', '<=', $today)
            ->orderByDesc('created_at')
            ->take(3)
            ->get()
            ->map(function($a) {
                return [
                    'sapi_name' => $a->sapi?->name,
                    'sapi_code' => $a->sapi?->code,
                    'catatan'   => $a->catatan,
                    'status'    => $a->status,
                    'time'      => $a->created_at->format('H:i'),
                ];
            });

        return response()->json([
            'timestamp' => now()->toISOString(),
            'stats' => [
                'total_sapi'          => $totalSapi,
                'sapi_sehat'          => $sapiSehat,
                'persen_sehat'        => $persenSehat,
                'sudah_diperah'       => $sudahDiperah,
                'persen_diperah'      => $persenDiperah,
                'terjual_volume'      => $terjualVol,
                'terjual_pendapatan'  => $terjualRev,
            ],
            'activities' => $latestActivities,
        ]);
    }
}
