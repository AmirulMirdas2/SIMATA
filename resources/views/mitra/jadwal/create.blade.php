@extends('layouts.app')

@section('title', 'Tambah Jadwal Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Buat Jadwal Keberangkatan Baru</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('mitra.jadwal.store') }}">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Armada Kendaraan</label>
            <select name="armada_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                <option value="">-- Pilih Armada Bus --</option>
                @foreach($armadas as $armada)
                    <option value="{{ $armada->id }}" {{ old('armada_id') == $armada->id ? 'selected' : '' }}>
                        {{ $armada->plat_nomor }} ({{ $armada->kelas }} - {{ $armada->total_kursi }} Kursi)
                    </option>
                @endforeach
            </select>
            @if($armadas->isEmpty())
                <p class="text-red-500 text-xs mt-1">Anda belum memiliki armada. Harap buat armada terlebih dahulu.</p>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Rute Perjalanan</label>
            <select name="rute_id" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                <option value="">-- Pilih Rute --</option>
                @foreach($rutes as $rute)
                    <option value="{{ $rute->id }}" {{ old('rute_id') == $rute->id ? 'selected' : '' }}>
                        {{ $rute->kota_asal }} &rarr; {{ $rute->kota_tujuan }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Waktu Keberangkatan</label>
            <input type="datetime-local" name="waktu_berangkat" value="{{ old('waktu_berangkat') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Harga Tiket per Kursi (Rp)</label>
            <input type="number" name="harga_dasar" value="{{ old('harga_dasar') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required placeholder="Contoh: 150000" min="1000">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none transition shadow w-full md:w-auto">Publikasikan Jadwal</button>
            <a href="{{ route('mitra.jadwal.index') }}" class="text-gray-600 hover:underline mt-4 md:mt-0 inline-block text-center w-full md:w-auto">Batal</a>
        </div>
    </form>
</div>
@endsection
