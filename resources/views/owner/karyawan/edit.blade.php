@extends('layouts.owner')

@section('title', 'Ubah Karyawan')
@section('page-title', 'Ubah Karyawan')
@section('page-subtitle', 'Sunting informasi atau reset password akun karyawan')

@push('styles')
<style>
.form-card {
    background: #FFFFFF;
    border-radius: 16px;
    border: 1px solid #E5E7EB;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    max-width: 600px;
    padding: 32px;
}
.form-group {
    margin-bottom: 20px;
}
.form-label {
    display: block;
    font-size: 13.5px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 6px;
}
.form-input {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    font-size: 14.5px;
    font-family: 'Manrope', sans-serif;
    font-weight: 600;
    color: #111827;
    background: #FFFFFF;
    box-sizing: border-box;
    transition: border-color 0.15s;
}
.form-input:focus {
    outline: none;
    border-color: #124827;
}
.text-error {
    color: #EF4444;
    font-size: 12px;
    font-weight: 600;
    margin-top: 4px;
    display: block;
}
.info-box {
    background: #F3F4F6;
    border-left: 4px solid #9CA3AF;
    padding: 12px 16px;
    border-radius: 4px;
    font-size: 13px;
    color: #4B5563;
    margin-bottom: 20px;
}
</style>
@endpush

@section('content')
<div style="font-family: 'Manrope', sans-serif;">

    <div class="form-card">
        <form action="{{ route('owner.karyawan.update', $karyawan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-input" placeholder="Masukkan nama karyawan" value="{{ old('name', $karyawan->name) }}" required>
                @error('name')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-input" placeholder="Masukkan alamat email" value="{{ old('email', $karyawan->email) }}" required>
                @error('email')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Username -->
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-input" placeholder="Masukkan username unik untuk login" value="{{ old('username', $karyawan->username) }}" required>
                @error('username')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Reset Section -->
            <div class="info-box">
                Kosongkan input password di bawah ini jika tidak ingin merubah password karyawan.
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password Baru (Opsional)</label>
                <input type="password" name="password" id="password" class="form-input" placeholder="Masukkan password baru jika ingin mereset">
                @error('password')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Masukkan kembali password baru">
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 12px; margin-top: 32px;">
                <a href="{{ route('owner.karyawan.index') }}" class="pj-btn pj-btn--secondary" style="text-decoration: none;">
                    Batal
                </a>
                <button type="submit" class="pj-btn pj-btn--primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
