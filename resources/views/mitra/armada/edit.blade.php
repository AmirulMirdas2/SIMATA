@extends('layouts.app')

@section('title', 'Edit Armada')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Data Armada Bus</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('mitra.armada.update', $armada->id) }}">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Plat Nomor Kendaraan</label>
            <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $armada->plat_nomor) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kelas Bus</label>
            <input type="text" name="kelas" value="{{ old('kelas', $armada->kelas) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Total Kursi Penumpang (Terkunci)</label>
            <input type="number" value="{{ $armada->total_kursi }}" class="shadow border rounded w-full py-2 px-3 text-gray-500 bg-gray-100 cursor-not-allowed" disabled>
            <p class="text-xs text-red-500 mt-1">Kapasitas kursi tidak dapat diubah setelah armada digunakan karena relasi tiket yang sudah terbentuk.</p>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Fasilitas Lengkap</label>
            <textarea name="fasilitas" class="shadow border rounded w-full py-2 px-3 text-gray-700 h-24">{{ old('fasilitas', $armada->fasilitas) }}</textarea>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none transition shadow">Update Armada</button>
            <a href="{{ route('mitra.armada.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
