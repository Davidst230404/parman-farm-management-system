<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')->get();
        return view('owner.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('owner.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'lowercase', 'alpha_dash', 'min:3', 'max:50', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'username.unique' => 'Username ini sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan underscore.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'role' => 'karyawan',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('owner.karyawan.index')->with('success', 'Akun karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = User::where('role', 'karyawan')->findOrFail($id);
        return view('owner.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = User::where('role', 'karyawan')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$karyawan->id],
            'username' => ['required', 'string', 'lowercase', 'alpha_dash', 'min:3', 'max:50', 'unique:users,username,'.$karyawan->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'username.unique' => 'Username ini sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan underscore.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $karyawan->update($data);

        return redirect()->route('owner.karyawan.index')->with('success', 'Akun karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $karyawan = User::where('role', 'karyawan')->findOrFail($id);
        $karyawan->delete();

        return redirect()->route('owner.karyawan.index')->with('success', 'Akun karyawan berhasil dihapus.');
    }
}
