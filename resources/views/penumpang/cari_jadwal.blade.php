@extends('layouts.app')

@section('title', 'Cari Jadwal')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-bold mb-6 text-blue-800">Cari Tiket Bus</h2>

    <form method="GET" action="{{ route('penumpang.cari') }}" class="flex flex-wrap gap-4 mb-8 bg-gray-50 p-6 rounded border">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-gray-700 mb-1 font-semibold">Kota Asal</label>
            <select name="kota_asal" class="w-full border p-2 rounded focus:ring outline-none" required>
                <option value="">-- Pilih Asal --</option>
                @foreach($kotaAsals as $kota)
                    <option value="{{ $kota }}" {{ request('kota_asal') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex-1 min-w-[200px]">
            <label class="block text-gray-700 mb-1 font-semibold">Kota Tujuan</label>
            <select name="kota_tujuan" class="w-full border p-2 rounded focus:ring outline-none" required>
                <option value="">-- Pilih Tujuan --</option>
                @foreach($kotaTujuans as $kota)
                    <option value="{{ $kota }}" {{ request('kota_tujuan') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 min-w-[200px]">
            <label class="block text-gray-700 mb-1 font-semibold">Tanggal Berangkat</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') ?? now()->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" class="w-full border p-2 rounded focus:ring outline-none" required>
        </div>
        
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-semibold">Cari</button>
        </div>
    </form>

    @if(request()->has('kota_asal'))
        <h3 class="text-xl font-bold mb-4">Hasil Pencarian</h3>
        
        @if($jadwals->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded text-center">
                Maaf, tidak ada jadwal bus yang tersedia untuk rute dan tanggal tersebut.
            </div>
        @else
            <div class="space-y-4">
                @foreach($jadwals as $jadwal)
                <div class="border rounded-lg p-5 flex flex-col md:flex-row justify-between items-center hover:shadow-lg transition">
                    <div>
                        <h4 class="text-lg font-bold text-blue-900">{{ $jadwal->armada->poBus->nama_po }} - {{ $jadwal->armada->kelas }}</h4>
                        <p class="text-gray-600 font-semibold">{{ $jadwal->waktu_berangkat->format('d M Y, H:i') }} WIB</p>
                        <p class="text-sm text-gray-500 mt-1">Plat: {{ $jadwal->armada->plat_nomor }} | Fasilitas: {{ $jadwal->armada->fasilitas }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 text-right">
                        <p class="text-2xl font-bold text-orange-600 mb-2">Rp {{ number_format($jadwal->harga_dasar, 0, ',', '.') }}</p>
                        <a href="{{ route('penumpang.pilih_kursi', $jadwal->id) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded font-semibold transition">
                            Pilih Kursi
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    @endif
</div>
@endsection
