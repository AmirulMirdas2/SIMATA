@extends('layouts.app')

@section('title', 'Laporan Pendapatan PO Bus')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Laporan Pendapatan PO Bus</h2>
    <p class="text-gray-600 mb-6">Pilih salah satu PO Bus di bawah ini untuk melihat detail laporan pendapatannya.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($poBuses as $po)
        <div class="border rounded-lg p-6 hover:shadow-lg transition bg-gray-50 flex flex-col justify-between">
            <div>
                <h3 class="text-xl font-bold text-blue-900 mb-2">{{ $po->nama_po }}</h3>
                <p class="text-sm text-gray-600 mb-1"><i class="fas fa-user-tie mr-2"></i> Mitra: {{ $po->user->name }}</p>
                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $po->deskripsi ?? 'Tidak ada deskripsi' }}</p>
            </div>
            
            <a href="{{ route('admin.laporan.po.detail', $po->id) }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition w-full">
                Lihat Laporan Keuangan
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
