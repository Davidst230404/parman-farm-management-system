<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;

class KesehatanController extends Controller
{
    public function index()
    {
        $sapis = \App\Models\Sapi::with(['kesehatan' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();

        $countSemua = $sapis->count();
        $countNormal = $sapis->where('status', 'normal')->count();
        $countPemantauan = $sapis->where('status', 'perlu_pemantauan')->count();
        $countTindakan = $sapis->where('status', 'perlu_tindakan')->count();

        return view('karyawan.kesehatan.index', compact(
            'sapis',
            'countSemua',
            'countNormal',
            'countPemantauan',
            'countTindakan'
        ));
    }
    public function create() { return view('karyawan.kesehatan.create'); }

    public function store(\Illuminate\Http\Request $request)
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

        \App\Models\Kesehatan::create([
            'sapi_id'      => $request->sapi_id,
            'nafsu_makan'  => $request->nafsu_makan,
            'kondisi_susu' => $request->kondisi_susu,
            'perilaku'     => $request->perilaku,
            'catatan'      => $request->catatan,
            'status'       => $request->status,
            'created_at'   => $dateTime,
            'updated_at'   => $dateTime,
        ]);

        // Sync cow status
        $sapi = \App\Models\Sapi::find($request->sapi_id);
        if ($sapi) {
            $normalizedStatus = 'normal';
            if ($request->status === 'Perlu Pemantauan') $normalizedStatus = 'perlu_pemantauan';
            if ($request->status === 'Perlu Tindakan')   $normalizedStatus = 'perlu_tindakan';
            $sapi->update(['status' => $normalizedStatus]);
        }

        return redirect()->route('karyawan.kesehatan.index')->with('success', 'Observasi kesehatan berhasil dicatat.');
    }

    public function show($id) { return view('karyawan.kesehatan.show', compact('id')); }
    public function edit($id) { return view('karyawan.kesehatan.edit', compact('id')); }

    public function update(\Illuminate\Http\Request $request, $id)
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

        $kesehatan = \App\Models\Kesehatan::findOrFail($id);
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

        // Sync cow status
        $sapi = \App\Models\Sapi::find($request->sapi_id);
        if ($sapi) {
            $normalizedStatus = 'normal';
            if ($request->status === 'Perlu Pemantauan') $normalizedStatus = 'perlu_pemantauan';
            if ($request->status === 'Perlu Tindakan')   $normalizedStatus = 'perlu_tindakan';
            $sapi->update(['status' => $normalizedStatus]);
        }

        return redirect()->route('karyawan.kesehatan.index')->with('success', 'Observasi kesehatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kesehatan = \App\Models\Kesehatan::findOrFail($id);
        $sapiId = $kesehatan->sapi_id;
        $kesehatan->delete();

        // Recalculate cow status
        $sapi = \App\Models\Sapi::find($sapiId);
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

        return redirect()->route('karyawan.kesehatan.index')->with('success', 'Observasi kesehatan berhasil dihapus.');
    }
}
