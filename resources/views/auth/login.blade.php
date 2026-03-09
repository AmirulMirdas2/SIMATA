@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-center mb-6">Login SIMATA</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2 rounded focus:ring focus:ring-blue-300 outline-none">
        </div>
        <div>
            <label class="block text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required class="w-full border p-2 rounded focus:ring focus:ring-blue-300 outline-none">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">Login</button>
    </form>
    
    <p class="mt-4 text-center text-sm">
        Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar sekarang</a>
    </p>
</div>
@endsection
