<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Sapi;
use App\Models\Kesehatan;
use Illuminate\Http\Request;

class KesehatanController extends Controller
{
    public function index()
    {
        $sapis = Sapi::with(['kesehatan' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        $countSemua = $sapis->count();
        $countNormal = $sapis->where('status', 'normal')->count();
        $countPemantauan = $sapis->where('status', 'perlu_pemantauan')->count();
        $countTindakan = $sapis->where('status', 'perlu_tindakan')->count();

        return view('owner.kesehatan.index', compact(
            'sapis',
            'countSemua',
            'countNormal',
            'countPemantauan',
            'countTindakan'
        ));
    }

    public function observasi()
    {
        $sapis = Sapi::with(['kesehatan' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        $countSemua = $sapis->count();
        $countNormal = $sapis->where('status', 'normal')->count();
        $countPemantauan = $sapis->where('status', 'perlu_pemantauan')->count();
        $countTindakan = $sapis->where('status', 'perlu_tindakan')->count();

        return view('owner.kesehatan.observasi', compact(
            'sapis',
            'countSemua',
            'countNormal',
            'countPemantauan',
            'countTindakan'
        ));
    }

    public function create() { return view('owner.kesehatan.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'sapi_id'      => 'required|exists:sapi,id',
            'nafsu_makan'  => 'required|string',
            'kondisi_susu' => 'required|string',
            'perilaku'     => 'required|string',
            'status'       => 'required|string',
            'tanggal'      => 'required|date',
            'waktu'        => 'required',
        ]);

        $dateTime = \Carbon\Carbon::parse($request->tanggal . ' ' . $request->waktu);

        Kesehatan::create([
            'sapi_id'      => $request->sapi_id,
            'nafsu_makan'  => $request->nafsu_makan,
            'kondisi_susu' => $request->kondisi_susu,
            'perilaku'     => $request->perilaku,
            'catatan'      => $request->catatan,
            'status'       => $request->status,
            'created_at'   => $dateTime,
            'updated_at'   => $dateTime,
        ]);

        $sapi = Sapi::find($request->sapi_id);
        if ($sapi) {
            $normalizedStatus = 'normal';
            if ($request->status === 'Perlu Pemantauan') $normalizedStatus = 'perlu_pemantauan';
            if ($request->status === 'Perlu Tindakan')   $normalizedStatus = 'perlu_tindakan';
            $sapi->update(['status' => $normalizedStatus]);
        }

        // Redirect back to the correct page based on referer
        $referer = request()->headers->get('referer', '');
        if (str_contains($referer, 'observasi')) {
            return redirect()->route('owner.kesehatan.observasi')->with('success', 'Observasi kesehatan berhasil dicatat.');
        }
        return redirect()->route('owner.kesehatan.index')->with('success', 'Observasi kesehatan berhasil dicatat.');
    }

    public function show($id) { return view('owner.kesehatan.show', compact('id')); }
    public function edit($id) { return view('owner.kesehatan.edit', compact('id')); }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sapi_id'      => 'required|exists:sapi,id',
            'nafsu_makan'  => 'required|string',
            'kondisi_susu' => 'required|string',
            'perilaku'     => 'required|string',
            'status'       => 'required|string',
            'tanggal'      => 'required|date',
            'waktu'        => 'required',
        ]);

        $kesehatan = Kesehatan::findOrFail($id);
        $dateTime = \Carbon\Carbon::parse($request->tanggal . ' ' . $request->waktu);

        $kesehatan->update([
            'sapi_id'      => $request->sapi_id,
            'nafsu_makan'  => $request->nafsu_makan,
            'kondisi_susu' => $request->kondisi_susu,
            'perilaku'     => $request->perilaku,
            'catatan'      => $request->catatan,
            'status'       => $request->status,
            'created_at'   => $dateTime,
            'updated_at'   => $dateTime,
        ]);

        $sapi = Sapi::find($request->sapi_id);
        if ($sapi) {
            $normalizedStatus = 'normal';
            if ($request->status === 'Perlu Pemantauan') $normalizedStatus = 'perlu_pemantauan';
            if ($request->status === 'Perlu Tindakan')   $normalizedStatus = 'perlu_tindakan';
            $sapi->update(['status' => $normalizedStatus]);
        }

        // Redirect back to the correct page based on referer
        $referer = request()->headers->get('referer', '');
        if (str_contains($referer, 'observasi')) {
            return redirect()->route('owner.kesehatan.observasi')->with('success', 'Observasi kesehatan berhasil diperbarui.');
        }
        return redirect()->route('owner.kesehatan.index')->with('success', 'Observasi kesehatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kesehatan = Kesehatan::findOrFail($id);
        $sapiId = $kesehatan->sapi_id;
        $kesehatan->delete();

        $sapi = Sapi::find($sapiId);
        if ($sapi) {
            $latest = $sapi->kesehatan()->orderBy('created_at', 'desc')->first();
            if ($latest) {
                $normalizedStatus = 'normal';
                if ($latest->status === 'Perlu Pemantauan') $normalizedStatus = 'perlu_pemantauan';
                if ($latest->status === 'Perlu Tindakan')   $normalizedStatus = 'perlu_tindakan';
                $sapi->update(['status' => $normalizedStatus]);
            } else {
                $sapi->update(['status' => 'normal']);
            }
        }

        $referer = request()->headers->get('referer', '');
        if (str_contains($referer, 'observasi')) {
            return redirect()->route('owner.kesehatan.observasi')->with('success', 'Observasi kesehatan berhasil dihapus.');
        }
        return redirect()->route('owner.kesehatan.index')->with('success', 'Observasi kesehatan berhasil dihapus.');
    }

    /**
     * Live JSON API — called by JS polling every 30s.
     * Returns fresh health status for all sapi.
     */
    public function liveData()
    {
        $sapis = Sapi::with(['kesehatan' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->get();

        $countSemua      = $sapis->count();
        $countNormal     = $sapis->where('status', 'normal')->count();
        $countPemantauan = $sapis->where('status', 'perlu_pemantauan')->count();
        $countTindakan   = $sapis->where('status', 'perlu_tindakan')->count();

        $sapiData = $sapis->map(function($sapi) {
            $latest = $sapi->kesehatan->first();
            return [
                'id'           => $sapi->id,
                'name'         => $sapi->name,
                'code'         => $sapi->code,
                'status'       => $sapi->status,
                'nafsu_makan'  => $latest?->nafsu_makan,
                'kondisi_susu' => $latest?->kondisi_susu,
                'perilaku'     => $latest?->perilaku,
                'catatan'      => $latest ? \Illuminate\Support\Str::limit($latest->catatan, 35) : null,
                'catatan_date' => $latest ? $latest->created_at->locale('id')->isoFormat('D MMM YYYY') : null,
                'latest_id'    => $latest?->id,
            ];
        });

        return response()->json([
            'timestamp' => now()->toISOString(),
            'sapis'     => $sapiData,
            'stats'     => [
                'semua'      => $countSemua,
                'normal'     => $countNormal,
                'pemantauan' => $countPemantauan,
                'tindakan'   => $countTindakan,
            ],
        ]);
    }
}
