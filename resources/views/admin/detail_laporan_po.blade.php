@extends('layouts.app')

@section('title', 'Detail Laporan Pendapatan')

@section('content')
<div class="flex items-center mb-6">
    <a href="{{ route('admin.laporan.po') }}" class="text-blue-600 hover:text-blue-800 font-semibold mr-4">
        &larr; Kembali
    </a>
    <h2 class="text-2xl font-bold text-gray-800">Detail Laporan: {{ $poBus->nama_po }}</h2>
</div>

<div class="bg-white p-6 md:p-8 rounded-lg shadow-md mb-8">
    <!-- Filter Section -->
    <form method="GET" action="{{ route('admin.laporan.po.detail', $poBus->id) }}" class="flex flex-col md:flex-row items-end gap-4 bg-gray-50 p-6 rounded-lg border border-gray-200">
        <div class="w-full md:w-1/3">
            <label class="block text-gray-700 text-sm font-bold mb-2">Filter Tanggal Transaksi</label>
            <div class="relative">
                <input type="text" id="tanggal" name="tanggal" value="{{ $tanggal }}" class="w-full border p-3 rounded focus:ring outline-none bg-white cursor-pointer shadow-sm" placeholder="Pilih Tanggal">
                <i class="far fa-calendar-alt absolute right-3 top-3.5 text-gray-400"></i>
            </div>
        </div>
        <div class="w-full md:w-auto">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded shadow transition">
                Tampilkan Laporan
            </button>
        </div>
    </form>
</div>

<!-- Laporan Pendapatan Summary -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-sm">
        <p class="text-sm font-bold text-blue-800 uppercase tracking-widest mb-1">Tanggal Laporan</p>
        <p class="text-2xl font-bold text-gray-800">{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</p>
    </div>
    
    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-lg shadow-sm">
        <p class="text-sm font-bold text-emerald-800 uppercase tracking-widest mb-1">Total Pendapatan Harian</p>
        <p class="text-3xl font-extrabold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
</div>

<!-- Rincian Transaksi -->
<div class="bg-white p-6 md:p-8 rounded-lg shadow-md">
    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Rincian Transaksi (Paid)</h3>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b-2 border-gray-300">
                    <th class="p-3">Waktu Transaksi</th>
                    <th class="p-3">ID Pesanan</th>
                    <th class="p-3">Akun Penumpang</th>
                    <th class="p-3">Rute & Armada</th>
                    <th class="p-3 text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemesanans as $pesan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 text-sm text-gray-600">{{ $pesan->created_at->format('H:i') }} WIB</td>
                    <td class="p-3 font-mono text-sm text-gray-700">{{ substr($pesan->id, 0, 8) }}</td>
                    <td class="p-3 font-semibold">{{ $pesan->user->name }}</td>
                    <td class="p-3">
                        <div class="text-sm">{{ $pesan->jadwal->rute->kota_asal }} &rarr; {{ $pesan->jadwal->rute->kota_tujuan }}</div>
                        <div class="text-xs text-gray-500">{{ $pesan->jadwal->armada->plat_nomor }} - {{ $pesan->jadwal->armada->kelas }}</div>
                    </td>
                    <td class="p-3 text-right font-bold text-emerald-600">Rp {{ number_format($pesan->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500 py-8">
                        <div class="mb-2 text-2xl">📊</div>
                        Tidak ada transaksi keuangan pada tanggal ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Flatpickr for Date Filter -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#tanggal", {
            dateFormat: "Y-m-d",
            defaultDate: "{{ $tanggal }}",
            disableMobile: "true"
        });
        
        // Auto-submit form when date is changed
        const form = document.querySelector('form');
        const tanggalInput = document.getElementById('tanggal');
        let initialDate = tanggalInput.value;
        
        tanggalInput.addEventListener('change', function() {
            if(this.value && this.value !== initialDate) {
                form.submit();
            }
        });
    });
</script>
@endsection
