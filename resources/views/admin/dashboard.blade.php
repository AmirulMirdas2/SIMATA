@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-3xl font-bold text-blue-900">Dashboard Sistem (Global)</h2>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-blue-600 text-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-2">Total PO Bus</h3>
        <p class="text-4xl font-bold">{{ $totalPO }}</p>
    </div>
    
    <div class="bg-emerald-600 text-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-2">Total Rute</h3>
        <p class="text-4xl font-bold">{{ $totalRute }}</p>
    </div>

    <div class="bg-amber-600 text-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-2">Total Transaksi</h3>
        <p class="text-4xl font-bold">{{ $totalTransaksi }}</p>
    </div>

    <div class="bg-purple-600 text-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-2">Total Pendapatan</h3>
        <p class="text-3xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Manajemen PO Bus</h3>
        <p class="text-gray-600 mb-4">Daftarkan mitra perusahaan otobus baru agar mereka bisa mengelola rute operasional mereka.</p>
        <a href="{{ route('admin.po.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">Kelola PO Bus</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Manajemen Rute Utama</h3>
        <p class="text-gray-600 mb-4">Kelola kota keberangkatan dan tujuan yang diizinkan beroperasi di terminal.</p>
        <a href="{{ route('admin.rute.index') }}" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded transition">Kelola Rute</a>
    </div>
</div>
@endsection
