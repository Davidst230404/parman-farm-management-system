<?php

namespace App\Http\Controllers\karyawan;

use App\Http\Controllers\Controller;
use App\Models\Sapi;
use Illuminate\Http\Request;

class SapiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:20',
            'code'          => 'required|string|max:10|unique:sapi,code',
            'status'        => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:jantan,betina',
            'catatan'       => 'nullable|string',
        ], [
            'code.unique' => 'Kode / ID Sapi ini sudah terdaftar di database.',
            'code.max' => 'Kode / ID Sapi tidak boleh lebih dari 10 karakter.',
            'name.max' => 'Nama Sapi tidak boleh lebih dari 20 karakter.',
        ]);

        $dbStatus = 'normal';
        if ($request->status === 'Perlu Pemantauan') $dbStatus = 'perlu_pemantauan';
        if ($request->status === 'Perlu Tindakan') $dbStatus = 'perlu_tindakan';

        $sapi = Sapi::create([
            'name'          => $request->name,
            'code'          => $request->code,
            'status'        => $dbStatus,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'catatan'       => $request->catatan,
        ]);

        if ($request->catatan) {
            $sapi->kesehatan()->create([
                'status'       => $dbStatus,
                'nafsu_makan'  => 'Baik',
                'kondisi_susu' => 'Normal',
                'perilaku'     => 'Aktif',
                'catatan'      => $request->catatan,
            ]);
        }

        return redirect()->route('karyawan.kesehatan.index')->with('success', 'Sapi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $sapi = Sapi::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:20',
            'code'          => 'required|string|max:10|unique:sapi,code,' . $sapi->id,
            'status'        => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:jantan,betina',
            'catatan'       => 'nullable|string',
        ], [
            'code.unique' => 'Kode / ID Sapi ini sudah terdaftar di database.',
            'code.max' => 'Kode / ID Sapi tidak boleh lebih dari 10 karakter.',
            'name.max' => 'Nama Sapi tidak boleh lebih dari 20 karakter.',
        ]);

        $dbStatus = 'normal';
        if ($request->status === 'Perlu Pemantauan') $dbStatus = 'perlu_pemantauan';
        if ($request->status === 'Perlu Tindakan') $dbStatus = 'perlu_tindakan';

        $sapi->update([
            'name'          => $request->name,
            'code'          => $request->code,
            'status'        => $dbStatus,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'catatan'       => $request->catatan,
        ]);

        // Update latest kesehatan status if it exists
        $latest = $sapi->kesehatan()->orderBy('created_at', 'desc')->first();
        if ($latest) {
            $latest->update([
                'status' => $request->status,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->route('karyawan.kesehatan.index')->with('success', 'Data sapi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sapi = Sapi::findOrFail($id);
        $sapi->delete();

        return redirect()->route('karyawan.kesehatan.index')->with('success', 'Sapi berhasil dihapus.');
    }
}
