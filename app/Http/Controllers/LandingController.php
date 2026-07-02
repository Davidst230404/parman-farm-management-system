<?php

namespace App\Http\Controllers;

use App\Models\Sapi;
use App\Models\Produksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display the landing page.
     */
    public function index()
    {
        $totalSapi = Sapi::count();

        // Calculate average daily milk volume
        $avgDaily = Produksi::where('status', 'Tersimpan')
            ->groupBy('tanggal')
            ->selectRaw('SUM(jumlah_susu) as total')
            ->get()
            ->avg('total') ?? 0;

        // Calculate monthly production (last 30 days)
        $monthlyProduction = Produksi::where('status', 'Tersimpan')
            ->whereDate('tanggal', '>=', Carbon::today()->subDays(30))
            ->sum('jumlah_susu');

        return view('landing.index', compact('totalSapi', 'avgDaily', 'monthlyProduction'));
    }
}
