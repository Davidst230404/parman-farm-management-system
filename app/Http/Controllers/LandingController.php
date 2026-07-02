<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use App\Models\Produksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Compute production stats from the database.
     */
    private function getStats(): array
    {
        $today = Carbon::today();

        // Total sapi terdaftar
        $totalSapi = Sapi::count();

        // Rata-rata produksi harian (30 hari terakhir) per hari kalender
        $last30Days = Produksi::where('status', 'Tersimpan')
            ->whereDate('tanggal', '>=', $today->copy()->subDays(29))
            ->selectRaw('tanggal, SUM(jumlah_susu) as total_per_hari')
            ->groupBy('tanggal')
            ->get();

        $avgDaily = $last30Days->count() > 0
            ? round($last30Days->avg('total_per_hari'), 1)
            : 0;

        // Total produksi bulan berjalan
        $monthlyProduction = Produksi::where('status', 'Tersimpan')
            ->whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('jumlah_susu');

        return [
            'totalSapi'         => $totalSapi,
            'avgDaily'          => $avgDaily,
            'monthlyProduction' => $monthlyProduction,
        ];
    }

    /**
     * Display the landing page.
     */
    public function index()
    {
        $stats = $this->getStats();

        return view('landing.index', [
            'totalSapi'         => $stats['totalSapi'],
            'avgDaily'          => $stats['avgDaily'],
            'monthlyProduction' => $stats['monthlyProduction'],
        ]);
    }

    /**
     * Public JSON API for real-time stat refresh (no auth required).
     * Called every 5 minutes by the landing page via fetch().
     */
    public function stats()
    {
        $stats = $this->getStats();

        return response()->json([
            'totalSapi'         => $stats['totalSapi'],
            'avgDaily'          => round($stats['avgDaily']),
            'monthlyProduction' => $stats['monthlyProduction'],
            'updatedAt'         => now()->toIso8601String(),
        ]);
    }
}
