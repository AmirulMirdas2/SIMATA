@extends('layouts.app')

@section('title', 'Tambah Mitra PO Bus')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Registrasi Mitra PO Bus Baru</h2>
    <p class="text-sm text-gray-600 mb-6">Mendaftarkan PO Bus di sini akan otomatis membuatkan akun dengan role "Mitra" agar pemilik PO bisa melakukan login.</p>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.po.store') }}">
        @csrf
        
        <h3 class="text-lg font-bold mb-3 text-blue-800">1. Data PO Bus</h3>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Perusahaan (PO Bus)</label>
            <input type="text" name="nama_po" value="{{ old('nama_po') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        <div class="mb-8">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
            <textarea name="deskripsi" class="shadow border rounded w-full py-2 px-3 text-gray-700 h-24">{{ old('deskripsi') }}</textarea>
        </div>

        <h3 class="text-lg font-bold mb-3 text-blue-800 border-t pt-4">2. Akun Akses Mitra</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pengelola / Admin Mitra</label>
                <input type="text" name="mitra_name" value="{{ old('mitra_name') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Email Login Mitra</label>
                <input type="email" name="mitra_email" value="{{ old('mitra_email') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password Akses</label>
            <input type="password" name="mitra_password" class="shadow border rounded w-full py-2 px-3 text-gray-700" required minlength="6" placeholder="Minimal 6 karakter">
        </div>

        <div class="flex items-center justify-between border-t pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none transition shadow">Daftarkan PO Bus & Akun</button>
            <a href="{{ route('admin.po.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
