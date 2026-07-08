<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Sapi;
use App\Models\Kesehatan;
use App\Models\Produksi;
use App\Models\Penjualan;
use Carbon\Carbon;

class ProduksiController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $selectedDate = $request->query('tanggal') ? Carbon::parse($request->query('tanggal')) : Carbon::today();
        
        $sapis = Sapi::with(['produksi' => function($q) use ($selectedDate) {
            $q->whereDate('tanggal', $selectedDate);
        }])->get();

        // Stat cards
        $totalSapi = Sapi::count();
        $sapiSehat = Sapi::where('status', 'normal')->count();
        $persenSehat = $totalSapi > 0 ? round(($sapiSehat / $totalSapi) * 100) : 0;

        $sudahDiperah = Produksi::whereDate('tanggal', $selectedDate)
            ->where('status', 'Tersimpan')
            ->distinct('sapi_id')
            ->count('sapi_id');
        $persenDiperah = $totalSapi > 0 ? round(($sudahDiperah / $totalSapi) * 100) : 0;

        // Card 4: Terjual volume and pendapatan (sum instead of value)
        $terjualHariIniVolume = (float) Penjualan::whereDate('tanggal', $selectedDate)->sum('jumlah_terjual') ?? 0;
        $terjualHariIniPendapatan = (float) Penjualan::whereDate('tanggal', $selectedDate)->sum('total_pendapatan') ?? 0;

        // 7 days chart ending at $selectedDate
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $selectedDate->copy()->subDays($i);
            $chartLabels[] = $date->locale('id')->isoFormat('D MMM');
            $chartData[] = (float) Produksi::whereDate('tanggal', $date)
                ->where('status', 'Tersimpan')
                ->sum('jumlah_susu');
        }

        // Ringkasan Produksi
        $totalProduksiHariIni = (float) Produksi::whereDate('tanggal', $selectedDate)
            ->where('status', 'Tersimpan')
            ->sum('jumlah_susu');

        $rataRataPerSapi = $sudahDiperah > 0 ? round($totalProduksiHariIni / $sudahDiperah, 1) : 0;

        // Highest / Lowest cow today
        $highestCowProd = Produksi::whereDate('tanggal', $selectedDate)
            ->where('status', 'Tersimpan')
            ->selectRaw('sapi_id, SUM(jumlah_susu) as total_susu')
            ->groupBy('sapi_id')
            ->with('sapi')
            ->orderByDesc('total_susu')
            ->first();

        $lowestCowProd = Produksi::whereDate('tanggal', $selectedDate)
            ->where('status', 'Tersimpan')
            ->selectRaw('sapi_id, SUM(jumlah_susu) as total_susu')
            ->groupBy('sapi_id')
            ->with('sapi')
            ->orderBy('total_susu')
            ->first();

        $belumDiperahCount = $totalSapi - $sudahDiperah;

        return view('owner.produksi.index', compact(
            'sapis',
            'totalSapi',
            'sapiSehat',
            'persenSehat',
            'sudahDiperah',
            'persenDiperah',
            'terjualHariIniVolume',
            'terjualHariIniPendapatan',
            'chartLabels',
            'chartData',
            'totalProduksiHariIni',
            'rataRataPerSapi',
            'highestCowProd',
            'lowestCowProd',
            'belumDiperahCount',
            'selectedDate'
        ));
    }

    public function create() { return view('owner.produksi.create'); }
    
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'sapi_id'     => 'required|exists:sapi,id',
            'jumlah_susu' => 'required|numeric|min:0',
            'sesi'        => 'required|string|in:pagi,sore,Pagi,Sore',
            'tanggal'     => 'required|date',
        ]);

        $tanggal = Carbon::parse($request->tanggal);

        Produksi::updateOrCreate(
            [
                'sapi_id' => $request->sapi_id,
                'sesi' => strtolower($request->sesi),
                'tanggal' => $tanggal
            ],
            [
                'jumlah_susu' => $request->jumlah_susu,
                'status' => 'Tersimpan'
            ]
        );

        return redirect()->route('owner.produksi.index', ['tanggal' => $tanggal->format('Y-m-d')])->with('success', 'Data produksi susu berhasil diperbarui.');
    }

    public function show($id) { return view('owner.produksi.show', compact('id')); }
    public function edit($id) { return view('owner.produksi.edit', compact('id')); }
    public function update(\Illuminate\Http\Request $request, $id) { return redirect()->route('owner.produksi.index'); }
    public function destroy($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produksi->delete();

        $tanggalParam = request('tanggal', \Carbon\Carbon::today()->format('Y-m-d'));
        return redirect()->route('owner.produksi.index', ['tanggal' => $tanggalParam])->with('success', 'Data produksi berhasil dihapus.');
    }

    /**
     * Live JSON API — called by JS polling every 20s.
     * Returns fresh production data for the given date.
     */
    public function liveData(\Illuminate\Http\Request $request)
    {
        $selectedDate = $request->query('tanggal') ? Carbon::parse($request->query('tanggal')) : Carbon::today();

        $sapis = Sapi::with(['produksi' => function($q) use ($selectedDate) {
            $q->whereDate('tanggal', $selectedDate)->where('status', 'Tersimpan');
        }])->get();

        $totalSapi = $sapis->count();

        $sudahDiperah = Produksi::whereDate('tanggal', $selectedDate)
            ->where('status', 'Tersimpan')
            ->distinct('sapi_id')
            ->count('sapi_id');

        $totalProduksiHariIni = (float) Produksi::whereDate('tanggal', $selectedDate)
            ->where('status', 'Tersimpan')
            ->sum('jumlah_susu');

        $rataRataPerSapi = $sudahDiperah > 0 ? round($totalProduksiHariIni / $sudahDiperah, 1) : 0;

        $highestCowProd = Produksi::whereDate('tanggal', $selectedDate)
            ->where('status', 'Tersimpan')
            ->selectRaw('sapi_id, SUM(jumlah_susu) as total_susu')
            ->groupBy('sapi_id')
            ->with('sapi')
            ->orderByDesc('total_susu')
            ->first();

        $lowestCowProd = Produksi::whereDate('tanggal', $selectedDate)
            ->where('status', 'Tersimpan')
            ->selectRaw('sapi_id, SUM(jumlah_susu) as total_susu')
            ->groupBy('sapi_id')
            ->with('sapi')
            ->orderBy('total_susu')
            ->first();

        $sapiData = $sapis->map(function($sapi) {
            $pagiRec = $sapi->produksi->where('sesi', 'pagi')->first();
            $soreRec = $sapi->produksi->where('sesi', 'sore')->first();
            $pagi = $pagiRec?->jumlah_susu;
            $sore = $soreRec?->jumlah_susu;
            $total = ($pagi ?? 0) + ($sore ?? 0);

            $sessionAttr = 'none';
            if (!is_null($pagi) && !is_null($sore)) $sessionAttr = 'both';
            elseif (!is_null($pagi)) $sessionAttr = 'pagi';
            elseif (!is_null($sore)) $sessionAttr = 'sore';

            return [
                'id'       => $sapi->id,
                'name'     => $sapi->name,
                'code'     => $sapi->code,
                'pagi'     => $pagi,
                'sore'     => $sore,
                'total'    => $total,
                'session'  => $sessionAttr,
                'pagi_id'  => $pagiRec?->id ?? '',
                'sore_id'  => $soreRec?->id ?? '',
                'status'   => (!is_null($pagi) || !is_null($sore)) ? 'Sudah' : 'Belum',
            ];
        });

        return response()->json([
            'timestamp'    => now()->toISOString(),
            'sapis'        => $sapiData,
            'stats' => [
                'total_sapi'         => $totalSapi,
                'sudah_diperah'      => $sudahDiperah,
                'belum_diperah'      => $totalSapi - $sudahDiperah,
                'persen_diperah'     => $totalSapi > 0 ? round(($sudahDiperah / $totalSapi) * 100) : 0,
                'total_produksi'     => $totalProduksiHariIni,
                'rata_rata'          => $rataRataPerSapi,
                'tertinggi_name'     => $highestCowProd ? $highestCowProd->sapi->name . ' (' . round($highestCowProd->total_susu) . ' Liter)' : '—',
                'terendah_name'      => $lowestCowProd  ? $lowestCowProd->sapi->name  . ' (' . round($lowestCowProd->total_susu)  . ' Liter)' : '—',
            ],
        ]);
    }
}
