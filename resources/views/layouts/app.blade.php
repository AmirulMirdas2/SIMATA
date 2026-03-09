<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMATA - @yield('title')</title>
    <!-- Tailwind CSS (CDN for quick setup) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    @auth
    <nav class="bg-blue-800 text-white p-4 shadow-md flex justify-between items-center">
        <div class="flex items-center gap-6">
            <h1 class="text-xl font-bold">
                <a href="{{ route(Auth::user()->role . '.dashboard') }}">SIMATA ({{ ucfirst(Auth::user()->role) }})</a>
            </h1>
            
            @if(Auth::user()->role == 'penumpang')
                <a href="{{ route('penumpang.cari') }}" class="hover:text-amber-300 font-semibold transition">Cari Tiket</a>
            @endif
        </div>
        
        <div class="flex gap-4 items-center">
            <span>Halo, {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm transition font-bold">Logout</button>
            </form>
        </div>
    </nav>
    @else
    <nav class="bg-blue-800 text-white p-4 shadow-md">
        <h1 class="text-xl font-bold text-center">SIMATA</h1>
    </nav>
    @endauth

    <main class="flex-grow p-8">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 mt-auto">
        <p>&copy; {{ date('Y') }} SIMATA - Sistem Manajemen Tiket Terminal Aceh</p>
    </footer>

</body>
</html>
