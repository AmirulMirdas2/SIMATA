@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-center mb-6">Daftar Penumpang</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full border p-2 rounded focus:ring outline-none">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2 rounded focus:ring outline-none">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Nomor Telepon</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border p-2 rounded focus:ring outline-none">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required class="w-full border p-2 rounded focus:ring outline-none">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required class="w-full border p-2 rounded focus:ring outline-none">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">Daftar</button>
    </form>

    <p class="mt-4 text-center text-sm">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login di sini</a>
    </p>
</div>
@endsection
