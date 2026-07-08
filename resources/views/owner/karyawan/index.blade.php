@extends('layouts.owner')

@section('title', 'Kelola Karyawan')
@section('page-title', 'Kelola Karyawan')
@section('page-subtitle', 'Manajemen akun karyawan lapangan')

@push('styles')
<style>
.karyawan-card {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 24px;
}
.karyawan-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 32px;
    border-bottom: 1px solid #E5E7EB;
}
.karyawan-title {
    font-size: 20px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}
.karyawan-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}
.karyawan-table th {
    background: #F9FAFB;
    padding: 16px 32px;
    font-size: 13px;
    font-weight: 700;
    color: #4B5563;
    border-bottom: 1px solid #E5E7EB;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.karyawan-table td {
    padding: 18px 32px;
    font-size: 14.5px;
    color: #111827;
    border-bottom: 1px solid #E5E7EB;
    vertical-align: middle;
}
.karyawan-table tr:last-child td {
    border-bottom: none;
}
.karyawan-name-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
}
.karyawan-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #E8F5E9;
    color: #124827;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
}
.karyawan-name {
    font-weight: 700;
    color: #111827;
}
.karyawan-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1.5px solid #E5E7EB;
    background: #FFFFFF;
    cursor: pointer;
    transition: all 0.15s;
    text-decoration: none;
}
.karyawan-action-btn:hover {
    border-color: #9CA3AF;
    background: #F9FAFB;
}
.karyawan-action-btn--delete:hover {
    border-color: #FCA5A5;
    background: #FEF2F2;
}
.alert-success {
    background: #DEF7EC;
    color: #03543F;
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 14.5px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}
</style>
@endpush

@section('content')
<div style="padding: 0 4px; font-family: 'Manrope', sans-serif;">

    @if(session('success'))
        <div class="alert-success">
            <svg viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px;">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #FEF2F2; color: #991B1B; padding: 16px 24px; border-radius: 12px; margin-bottom: 20px; font-size: 14.5px; font-weight: 700; display: flex; align-items: center; gap: 10px; border: 1px solid #FCA5A5;">
            <svg viewBox="0 0 20 20" fill="currentColor" style="width: 20px; height: 20px; flex-shrink: 0;">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="karyawan-card">
        <div class="karyawan-header">
            <h2 class="karyawan-title">Daftar Karyawan</h2>
            <a href="{{ route('owner.karyawan.create') }}" class="pj-btn pj-btn--primary" style="text-decoration: none; display: inline-flex; align-items: center;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16" style="margin-right: 6px;">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Karyawan Baru
            </a>
        </div>

        <table class="karyawan-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Tanggal Terdaftar</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawans as $karyawan)
                    <tr>
                        <td>
                            <div class="karyawan-name-wrapper">
                                <div class="karyawan-avatar">
                                    {{ strtoupper(substr($karyawan->name, 0, 1)) }}
                                </div>
                                <span class="karyawan-name">{{ $karyawan->name }}</span>
                            </div>
                        </td>
                        <td>{{ $karyawan->email }}</td>
                        <td><code>{{ $karyawan->username }}</code></td>
                        <td>{{ $karyawan->created_at ? $karyawan->created_at->locale('id')->isoFormat('D MMMM YYYY') : '—' }}</td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <a href="{{ route('owner.karyawan.edit', $karyawan->id) }}" class="karyawan-action-btn" title="Edit Karyawan">
                                    <img src="{{ asset('images/icons/iconpensil2.svg') }}" style="width: 18px; height: 18px;" alt="Edit">
                                </a>
                                <form action="{{ route('owner.karyawan.destroy', $karyawan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun karyawan {{ $karyawan->name }}? Karyawan ini tidak akan bisa login kembali.')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="karyawan-action-btn karyawan-action-btn--delete" title="Hapus Karyawan">
                                        <img src="{{ asset('images/icons/icontrashmerah.svg') }}" style="width: 18px; height: 18px;" alt="Hapus">
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px 0; color: #6B7280;">
                            Belum ada data karyawan terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
