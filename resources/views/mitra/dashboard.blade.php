@extends('layouts.app')

@section('title', 'Dashboard Mitra')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Dashboard Mitra PO Bus</h2>
    <p class="text-gray-600">Selamat datang, {{ Auth::user()->name }}. Anda login sebagai Mitra PO Bus. Di sini Anda dapat mengelola armada bus Anda, jadwal keberangkatan, serta mengecek pemesanan tiket untuk layanan Anda.</p>
</div>
@endsection
