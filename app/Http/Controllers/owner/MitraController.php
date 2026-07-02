<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $mitras = Mitra::all();
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($mitras);
        }
        return view('owner.mitra.index', compact('mitras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $mitra = Mitra::create($request->all());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mitra berhasil ditambahkan.',
                'data' => $mitra
            ]);
        }

        return redirect()->route('owner.mitra.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $mitra = Mitra::findOrFail($id);
        $mitra->update($request->all());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mitra berhasil diperbarui.',
                'data' => $mitra
            ]);
        }

        return redirect()->route('owner.mitra.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Mitra berhasil dihapus.'
            ]);
        }

        return redirect()->route('owner.mitra.index')->with('success', 'Mitra berhasil dihapus.');
    }
}
