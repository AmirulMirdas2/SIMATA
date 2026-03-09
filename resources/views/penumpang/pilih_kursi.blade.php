@extends('layouts.app')

@section('title', 'Pilih Kursi')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6">
    <h2 class="text-2xl font-bold mb-4 text-blue-800">Pilih Kursi</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 p-4 bg-gray-50 rounded border">
        <h3 class="text-lg font-bold mb-2">{{ $jadwal->armada->poBus->nama_po }} - {{ $jadwal->rute->kota_asal }} ke {{ $jadwal->rute->kota_tujuan }}</h3>
        <p class="text-gray-700">Waktu Berangkat: <span class="font-semibold">{{ $jadwal->waktu_berangkat->format('d M Y, H:i') }} WIB</span></p>
        <p class="text-gray-700">Harga per Kursi: <span class="font-semibold text-orange-600">Rp {{ number_format($jadwal->harga_dasar, 0, ',', '.') }}</span></p>
    </div>

    <form method="POST" action="{{ route('penumpang.pesan', $jadwal->id) }}">
        @csrf
        <div class="mb-6">
            <h4 class="font-semibold mb-3">Denah Kursi</h4>
            <div class="grid grid-cols-4 gap-4 bg-gray-100 p-6 rounded-lg inline-block text-center border">
                @foreach($jadwal->armada->kursis as $kursi)
                    @php
                        $terkunci = in_array($kursi->id, $kursiTerkunci);
                    @endphp
                    <div>
                        <input type="checkbox" name="kursi[]" id="kursi_{{ $kursi->id }}" value="{{ $kursi->id }}" class="peer hidden" {{ $terkunci ? 'disabled' : '' }}>
                        <label for="kursi_{{ $kursi->id }}" class="block w-12 h-12 flex items-center justify-center rounded cursor-pointer font-bold border transition duration-200
                            {{ $terkunci 
                                ? 'bg-gray-400 text-white cursor-not-allowed border-gray-500' 
                                : 'bg-white text-gray-700 border-gray-300 hover:bg-blue-100 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-700' }}">
                            {{ $kursi->nomor_kursi }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="flex gap-4 mt-4 text-sm font-semibold">
                <span class="flex items-center gap-1"><div class="w-4 h-4 bg-white border border-gray-300 rounded"></div> Tersedia</span>
                <span class="flex items-center gap-1"><div class="w-4 h-4 bg-blue-600 rounded"></div> Dipilih</span>
                <span class="flex items-center gap-1"><div class="w-4 h-4 bg-gray-400 rounded cursor-not-allowed"></div> Terisi / Terkunci</span>
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 font-bold transition">
            Pesan Kursi Dipilih
        </button>
    </form>
</div>
@endsection
