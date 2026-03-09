@extends('layouts.app')

@section('title', 'Detail Pemesanan')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">Detail Pemesanan</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 space-y-2">
        <p class="text-gray-700"><span class="font-semibold inline-block w-32">ID Pesanan</span>: {{ substr($pemesanan->id, 0, 8) }}...</p>
        <p class="text-gray-700"><span class="font-semibold inline-block w-32">Status Bayar</span>: 
            <span class="px-2 py-1 rounded text-sm font-bold text-white
                {{ $pemesanan->status_bayar == 'Paid' ? 'bg-green-500' : ($pemesanan->status_bayar == 'Pending' ? 'bg-yellow-500' : 'bg-red-500') }}">
                {{ $pemesanan->status_bayar }}
            </span>
        </p>
        
        <div class="mt-4 p-4 bg-gray-50 rounded border">
            <h3 class="font-bold text-lg mb-2">Informasi Rute</h3>
            <p>{{ $pemesanan->jadwal->armada->poBus->nama_po }} - {{ $pemesanan->jadwal->rute->kota_asal }} ke {{ $pemesanan->jadwal->rute->kota_tujuan }}</p>
            <p class="font-semibold">{{ $pemesanan->jadwal->waktu_berangkat->format('d M Y, H:i') }} WIB</p>
        </div>

        <div class="mt-4">
            <h3 class="font-bold mb-2">Daftar Kursi</h3>
            <ul class="list-disc pl-5">
                @foreach($pemesanan->tikets as $tiket)
                    <li>Kursi: <span class="font-bold">{{ $tiket->kursi->nomor_kursi }}</span> (Atas nama: {{ $tiket->nama_penumpang }})</li>
                @endforeach
            </ul>
        </div>
        
        <div class="mt-4 text-xl bg-gray-100 p-4 rounded text-right font-bold text-blue-900 border">
            Total Harga: Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
        </div>
    </div>

    @if($pemesanan->status_bayar == 'Pending')
        <div class="bg-blue-50 border border-blue-200 p-4 rounded text-center mb-6">
            <p class="text-sm text-gray-700 mb-2">Silakan selesaikan pembayaran sebelum:</p>
            <p class="text-xl font-bold text-red-600">{{ $pemesanan->batas_waktu_bayar->format('d M Y, H:i') }} WIB</p>
        </div>

        <form method="POST" action="{{ route('penumpang.bayar', $pemesanan->id) }}">
            @csrf
            <button type="submit" class="w-full bg-green-600 text-white p-3 rounded-lg hover:bg-green-700 font-bold transition text-lg shadow">
                Mock Bayar Sekarang
            </button>
        </form>
    @elseif($pemesanan->status_bayar == 'Paid')
         <div class="bg-green-50 p-6 rounded-lg text-center border border-green-200">
             <h3 class="text-2xl font-bold text-green-700 mb-2">Tiket Lunas!</h3>
             <p class="text-gray-700 mb-6">Terima kasih, pembayaran Anda telah kami terima.</p>
             <a href="{{ route('penumpang.pemesanan.eticket', $pemesanan->id) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition">
                 <i class="fas fa-ticket-alt mr-2"></i> Lihat E-Ticket
             </a>
         </div>
    @endif
</div>
@endsection
