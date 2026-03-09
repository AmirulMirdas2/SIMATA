@extends('layouts.app')

@section('title', 'Laporan Manifest Penumpang')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md mb-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Laporan Manifest Penumpang</h2>

    <form method="GET" action="{{ route('mitra.manifest') }}" class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="flex-grow">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Jadwal Keberangkatan</label>
            <select name="jadwal_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring focus:border-blue-500" required>
                <option value="">-- Pilih Jadwal Keberangkatan --</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}" {{ request('jadwal_id') == $jadwal->id ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($jadwal->waktu_berangkat)->format('d M Y, H:i') }} - 
                        {{ $jadwal->rute->kota_asal }} &rarr; {{ $jadwal->rute->kota_tujuan }} 
                        ({{ $jadwal->armada->plat_nomor }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition h-10 w-full md:w-auto mt-6 md:mt-0">Tampilkan Manifest</button>
        </div>
    </form>
</div>

@if($selectedJadwal)
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="mb-6 flex justify-between items-start border-b pb-4 border-gray-200">
        <div>
            <h3 class="text-xl font-bold text-blue-900 mb-1">Manifest Armada: {{ $selectedJadwal->armada->plat_nomor }}</h3>
            <p class="text-gray-600 font-semibold">{{ $selectedJadwal->rute->kota_asal }} &rarr; {{ $selectedJadwal->rute->kota_tujuan }}</p>
            <p class="text-sm text-gray-500 mt-1">Berangkat: {{ \Carbon\Carbon::parse($selectedJadwal->waktu_berangkat)->format('d M Y, H:i') }} WIB</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Kapasitas: {{ $selectedJadwal->armada->total_kursi }} Kursi</p>
            <p class="text-sm font-bold text-emerald-600">Terisi Lunas: {{ count($tiketsMapped) }} Kursi</p>
        </div>
    </div>

        <div class="mb-4 text-sm">
            <span class="inline-block w-4 h-4 bg-red-100 border border-red-300 mr-2 rounded"></span> <span class="mr-4">Terisi (Paid)</span>
            <span class="inline-block w-4 h-4 bg-green-100 border border-green-300 mr-2 rounded"></span> <span>Kosong</span>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b-2 border-gray-300">
                    <th class="p-3 w-20">Kursi</th>
                    <th class="p-3">Nama Penumpang</th>
                    <th class="p-3">Akun Pemesan / Kontak</th>
                    <th class="p-3 max-w-[150px]">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kursis as $kursi)
                    @php
                        $isPaid = isset($tiketsMapped[$kursi->id]);
                        $tiket = $isPaid ? $tiketsMapped[$kursi->id] : null;
                    @endphp
                    <tr class="border-b {{ $isPaid ? 'bg-red-50 hover:bg-red-100' : 'bg-green-50 hover:bg-green-100' }}">
                        <td class="p-3 font-bold text-center border-r border-white">{{ $kursi->nomor_kursi }}</td>
                        
                        @if($isPaid)
                            <td class="p-3 font-semibold text-gray-800">{{ $tiket->nama_penumpang }}</td>
                            <td class="p-3 text-gray-700">
                                {{ $tiket->pemesanan->user->name }}
                                <div class="text-xs text-gray-500">{{ $tiket->pemesanan->user->phone ?? '-' }}</div>
                            </td>
                            <td class="p-3">
                                <span class="bg-red-200 text-red-800 text-xs font-bold px-2 py-1 rounded">Terisi</span>
                            </td>
                        @else
                            <td class="p-3 text-gray-400 italic">Kosong</td>
                            <td class="p-3 text-gray-400 italic">-</td>
                            <td class="p-3">
                                <span class="bg-green-200 text-green-800 text-xs font-bold px-2 py-1 rounded">Tersedia</span>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
