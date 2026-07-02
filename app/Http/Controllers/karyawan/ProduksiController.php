<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use App\Models\Sapi;
use App\Models\Produksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function index()
    {
        $sapis = Sapi::orderBy('name')->get();
        $totalSapi = Sapi::count();

        // Calculate statistics
        $today = Carbon::today();
        
        $weeklyProduction = Produksi::whereBetween('tanggal', [
            $today->copy()->subDays(6),
            $today
        ])->sum('jumlah_susu');

        $monthlyProduction = Produksi::whereBetween('tanggal', [
            $today->copy()->subDays(29),
            $today
        ])->sum('jumlah_susu');

        $todayProduction = Produksi::where('tanggal', $today)->sum('jumlah_susu');

        // Fetch all production history for table list
        $produksis = Produksi::with('sapi')
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('karyawan.produksi.index', compact(
            'sapis',
            'totalSapi',
            'weeklyProduction',
            'monthlyProduction',
            'todayProduction',
            'produksis'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sapi_id'     => 'required|exists:sapi,id',
            'jumlah_susu' => 'required|numeric|min:0',
            'sesi'        => 'required|string|in:pagi,sore,Pagi,Sore',
            'tanggal'     => 'required|date',
        ]);

        Produksi::create([
            'sapi_id'     => $request->sapi_id,
            'jumlah_susu' => $request->jumlah_susu,
            'sesi'        => strtolower($request->sesi),
            'tanggal'     => $request->tanggal,
            'status'      => 'Tersimpan',
        ]);

        return redirect()->route('karyawan.produksi.index')->with('success', 'Data produksi susu berhasil dicatat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sapi_id'     => 'required|exists:sapi,id',
            'jumlah_susu' => 'required|numeric|min:0',
            'sesi'        => 'required|string|in:pagi,sore,Pagi,Sore',
            'tanggal'     => 'required|date',
        ]);

        $produksi = Produksi::findOrFail($id);

        $produksi->update([
            'sapi_id'     => $request->sapi_id,
            'jumlah_susu' => $request->jumlah_susu,
            'sesi'        => strtolower($request->sesi),
            'tanggal'     => $request->tanggal,
        ]);

        return redirect()->route('karyawan.produksi.index')->with('success', 'Data produksi susu berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produksi = Produksi::findOrFail($id);
        $produksi->delete();

        return redirect()->route('karyawan.produksi.index')->with('success', 'Data produksi susu berhasil dihapus.');
    }
}
