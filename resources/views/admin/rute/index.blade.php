@extends('layouts.app')

@section('title', 'Data Rute')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Rute</h2>
        <a href="{{ route('admin.rute.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow transition">
            + Tambah Rute
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b-2 border-gray-300">
                    <th class="p-3">ID</th>
                    <th class="p-3">Asal</th>
                    <th class="p-3">Tujuan</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rutes as $rute)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $rute->id }}</td>
                    <td class="p-3 font-semibold">{{ $rute->kota_asal }}</td>
                    <td class="p-3 font-semibold">{{ $rute->kota_tujuan }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('admin.rute.edit', $rute->id) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                        <form action="{{ route('admin.rute.destroy', $rute->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus rute ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">Belum ada rute terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
