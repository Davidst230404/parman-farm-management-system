<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Sapi;
use Illuminate\Http\Request;

class SapiController extends Controller
{
    public function index() { return view('owner.kesehatan.index'); }
    public function create() { return view('owner.kesehatan.index'); }
    
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'code'   => 'required|string|unique:sapi,code|max:50',
            'status' => 'required|string',
        ]);

        $dbStatus = 'normal';
        if ($request->status === 'Perlu Pemantauan') $dbStatus = 'perlu_pemantauan';
        if ($request->status === 'Perlu Tindakan') $dbStatus = 'perlu_tindakan';

        $sapi = Sapi::create([
            'name'   => $request->name,
            'code'   => $request->code,
            'status' => $dbStatus,
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

        return redirect()->route('owner.kesehatan.index')->with('success', 'Sapi berhasil ditambahkan.');
    }

    public function show($id) { return view('owner.sapi.show', compact('id')); }
    public function edit($id) { return view('owner.sapi.edit', compact('id')); }
    public function update(Request $request, $id) { return redirect()->route('owner.sapi.index'); }
    public function destroy($id) { return redirect()->route('owner.sapi.index'); }
}
