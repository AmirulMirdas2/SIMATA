@extends('layouts.app')

@section('title', 'Edit PO Bus')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Data PO Bus</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.po.update', $po->id) }}">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Perusahaan (PO Bus)</label>
            <input type="text" name="nama_po" value="{{ old('nama_po', $po->nama_po) }}" class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="deskripsi" class="shadow border rounded w-full py-2 px-3 text-gray-700 h-24">{{ old('deskripsi', $po->deskripsi) }}</textarea>
        </div>

        <div class="bg-gray-50 p-4 border rounded mb-6 text-sm text-gray-600">
            <p><span class="font-bold">Info:</span> Untuk mengubah password atau email akun mitra <strong>{{ $po->user->email ?? 'N/A' }}</strong>, pengguna harus melakukannya melalui menu profil pribadi.</p>
        </div>

        <div class="flex items-center justify-between border-t pt-6">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none transition shadow">Update PO Bus</button>
            <a href="{{ route('admin.po.index') }}" class="text-gray-600 hover:underline">Batal</a>
        </div>
    </form>
</div>
@endsection
