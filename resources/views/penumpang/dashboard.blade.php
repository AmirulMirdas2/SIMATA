@extends('layouts.app')

@section('title', 'Dashboard Penumpang')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-bold mb-2 text-blue-900 border-b pb-2">Selamat Datang, {{ Auth::user()->name }}!</h2>
    <p class="text-gray-600 mt-2">Gunakan menu di atas untuk mulai mencari tiket, atau periksa riwayat tiket perjalananmu di bawah ini.</p>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Riwayat Pemesanan & Tiket Saya</h3>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b-2 border-gray-300">
                    <th class="p-3">Tanggal Pesan</th>
                    <th class="p-3">Rute & PO Bus</th>
                    <th class="p-3">Jadwal Berangkat</th>
                    <th class="p-3">Total Harga</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatPemesanan as $pesan)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 text-sm">{{ $pesan->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-3">
                        <div class="font-bold text-gray-800">{{ $pesan->jadwal->rute->kota_asal }} &rarr; {{ $pesan->jadwal->rute->kota_tujuan }}</div>
                        <div class="text-xs text-gray-500">{{ $pesan->jadwal->armada->poBus->nama_po }}</div>
                    </td>
                    <td class="p-3 font-semibold text-blue-800">
                        {{ \Carbon\Carbon::parse($pesan->jadwal->waktu_berangkat)->format('d M Y, H:i') }} WIB
                    </td>
                    <td class="p-3 text-sm">Rp {{ number_format($pesan->total_harga, 0, ',', '.') }}</td>
                    <td class="p-3">
                        @if($pesan->status_bayar == 'Paid')
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">Lunas</span>
                        @elseif($pesan->status_bayar == 'Pending')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">Menunggu</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded">{{ $pesan->status_bayar }}</span>
                        @endif
                    </td>
                    <td class="p-3 text-center space-y-1 md:space-y-0">
                        @if($pesan->status_bayar == 'Paid')
                            <a href="{{ route('penumpang.pemesanan.eticket', $pesan->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded shadow" title="Lihat E-Ticket">
                                <i class="fas fa-ticket-alt mr-1"></i> E-Ticket
                            </a>
                        @endif
                        <a href="{{ route('penumpang.pemesanan.detail', $pesan->id) }}" class="inline-block bg-gray-600 hover:bg-gray-700 text-white text-xs font-bold py-1 px-3 rounded shadow">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500 py-8">
                        <div class="mb-2 text-2xl">🎫</div>
                        Anda belum memiliki riwayat pemesanan tiket.
                        <div class="mt-3">
                            <a href="{{ route('penumpang.cari') }}" class="text-blue-600 hover:underline">Cari Tiket Sekarang</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
