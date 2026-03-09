@extends('layouts.app')

@section('title', 'Dashboard Mitra PO Bus')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-3xl font-bold text-blue-900">Dashboard {{ $poBus->nama_po }}</h2>
</div>

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-blue-600 text-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-2">Total Armada</h3>
        <p class="text-4xl font-bold">{{ $totalArmada }}</p>
    </div>
    
    <div class="bg-emerald-600 text-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-2">Jadwal Keberangkatan</h3>
        <p class="text-4xl font-bold">{{ $totalJadwal }}</p>
    </div>

    <div class="bg-purple-600 text-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-2">Total Pemasukan</h3>
        <p class="text-3xl font-bold">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Manajemen Armada</h3>
        <p class="text-gray-600 mb-4">Kelola armada bus, kelas, dan jumlah kursi.</p>
        <a href="{{ route('mitra.armada.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">Kelola Armada</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Manajemen Jadwal</h3>
        <p class="text-gray-600 mb-4">Buat dan atur jadwal keberangkatan armada bus Anda.</p>
        <a href="{{ route('mitra.jadwal.index') }}" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded transition">Kelola Jadwal</a>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
        <h3 class="text-xl font-bold mb-4 border-b pb-2">Laporan Manifest</h3>
        <p class="text-gray-600 mb-4">Cek daftar penumpang yang telah membayar tiket.</p>
        <a href="{{ route('mitra.manifest') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded transition">Lihat Manifest</a>
    </div>
</div>
@endsection
