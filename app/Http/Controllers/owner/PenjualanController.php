<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\Mitra;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $sales = Penjualan::with('mitra')->orderByDesc('tanggal')->get()->map(function($sale) {
            return [
                'id' => $sale->id,
                'tanggal' => Carbon::parse($sale->tanggal)->locale('id')->isoFormat('D MMMM YYYY'),
                'pembeli' => $sale->mitra ? $sale->mitra->nama : 'Umum',
                'volume' => (float) $sale->jumlah_terjual,
                'harga' => (float) ($sale->jumlah_terjual > 0 ? round($sale->total_pendapatan / $sale->jumlah_terjual) : 0),
                'metode' => $sale->metode,
                'status' => $sale->status,
                'catatan' => $sale->catatan
            ];
        });

        $mitras = Mitra::all()->map(function($m) {
            return [
                'id' => $m->id,
                'nama' => $m->nama,
                'kontak' => $m->kontak,
                'alamat' => $m->alamat,
                'catatan' => $m->catatan
            ];
        });

        // Calculate comparison statistics dynamically
        $today = Carbon::today();

        $currentMonthSales = (float) Penjualan::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('total_pendapatan');

        $currentMonthVol = (float) Penjualan::whereMonth('tanggal', $today->month)
            ->whereYear('tanggal', $today->year)
            ->sum('jumlah_terjual');

        $lastMonth = Carbon::today()->subMonth();
        
        $lastMonthSales = (float) Penjualan::whereMonth('tanggal', $lastMonth->month)
            ->whereYear('tanggal', $lastMonth->year)
            ->sum('total_pendapatan');

        $lastMonthVol = (float) Penjualan::whereMonth('tanggal', $lastMonth->month)
            ->whereYear('tanggal', $lastMonth->year)
            ->sum('jumlah_terjual');

        $salesGrowth = 0;
        if ($lastMonthSales > 0) {
            $salesGrowth = round((($currentMonthSales - $lastMonthSales) / $lastMonthSales) * 100);
        }

        $volumeGrowth = 0;
        if ($lastMonthVol > 0) {
            $volumeGrowth = round((($currentMonthVol - $lastMonthVol) / $lastMonthVol) * 100);
        }

        return view('owner.penjualan.index', compact('sales', 'mitras', 'salesGrowth', 'volumeGrowth'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'mitra_id' => 'required|exists:mitras,id',
            'volume' => 'required|numeric|min:0.01',
            'harga' => 'required|numeric|min:0',
            'metode' => 'required|string',
            'status' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $sale = Penjualan::create([
            'tanggal' => $request->tanggal,
            'mitra_id' => $request->mitra_id,
            'jumlah_terjual' => $request->volume,
            'total_pendapatan' => $request->volume * $request->harga,
            'metode' => $request->metode,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Penjualan berhasil disimpan.',
                'data' => [
                    'id' => $sale->id,
                    'tanggal' => Carbon::parse($sale->tanggal)->locale('id')->isoFormat('D MMMM YYYY'),
                    'pembeli' => $sale->mitra ? $sale->mitra->nama : 'Umum',
                    'volume' => (float) $sale->jumlah_terjual,
                    'harga' => (float) $request->harga,
                    'metode' => $sale->metode,
                    'status' => $sale->status,
                    'catatan' => $sale->catatan
                ]
            ]);
        }

        return redirect()->route('owner.penjualan.index')->with('success', 'Penjualan berhasil disimpan.');
    }

    public function show($id) { return view('owner.penjualan.show', compact('id')); }
    public function edit($id) { return view('owner.penjualan.edit', compact('id')); }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'mitra_id' => 'required|exists:mitras,id',
            'volume' => 'required|numeric|min:0.01',
            'harga' => 'required|numeric|min:0',
            'metode' => 'required|string',
            'status' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $sale = Penjualan::findOrFail($id);
        $sale->update([
            'tanggal' => $request->tanggal,
            'mitra_id' => $request->mitra_id,
            'jumlah_terjual' => $request->volume,
            'total_pendapatan' => $request->volume * $request->harga,
            'metode' => $request->metode,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Penjualan berhasil diperbarui.',
                'data' => [
                    'id' => $sale->id,
                    'tanggal' => Carbon::parse($sale->tanggal)->locale('id')->isoFormat('D MMMM YYYY'),
                    'pembeli' => $sale->mitra ? $sale->mitra->nama : 'Umum',
                    'volume' => (float) $sale->jumlah_terjual,
                    'harga' => (float) $request->harga,
                    'metode' => $sale->metode,
                    'status' => $sale->status,
                    'catatan' => $sale->catatan
                ]
            ]);
        }

        return redirect()->route('owner.penjualan.index')->with('success', 'Penjualan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sale = Penjualan::findOrFail($id);
        $sale->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Penjualan berhasil dihapus.'
            ]);
        }

        return redirect()->route('owner.penjualan.index')->with('success', 'Penjualan berhasil dihapus.');
    }
}
