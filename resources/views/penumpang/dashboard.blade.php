@extends('layouts.app')

@section('title', 'Dashboard Penumpang')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Dashboard Penumpang</h2>
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}. Anda dapat mencari jadwal bus, melakukan pemesanan tiket, dan melihat tiket yang telah Anda beli di sini.</p>
</div>
@endsection
