@extends('layouts.app')

@section('title', 'Tambah Armada')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Tambah Armada Bus Baru</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('mitra.armada.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Plat Nomor Kendaraan</label>
            <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required placeholder="Contoh: B 1234 XA">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kelas Bus</label>
            <select name="kelas" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                <option value="Ekonomi">Ekonomi</option>
                <option value="Patas">Patas</option>
                <option value="VIP">VIP</option>
                <option value="Executive">Executive</option>
                <option value="Super Executive">Super Executive</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Total Kursi Penumpang</label>
            <input type="number" name="total_kursi" value="{{ old('total_kursi') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required min="10" max="60" placeholder="Maks. 60 Kursi">
            <p class="text-xs text-gray-500 mt-1">Nomor kursi akan digenerate otomatis (1A, 1B, dst).</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Fasilitas Lengkap (Opsional)</label>
            <textarea name="fasilitas" class="shadow border rounded w-full py-2 px-3 text-gray-700 h-24" placeholder="AC, Toilet, TV, dll.">{{ old('fasilitas') }}</textarea>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none transition shadow">Simpan Armada</button>
            <a href="{{ route('mitra.armada.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
