<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket SIMATA #{{ $pemesanan->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            body { background: white; }
            .no-print { display: none; }
            .print-border { border: 2px dashed #ccc; }
        }
    </style>
</head>
<body class="bg-gray-100 p-6 md:p-12 font-sans text-gray-800">

    <div class="max-w-3xl mx-auto mb-6 no-print flex justify-between items-center">
        <a href="{{ route('penumpang.pemesanan.detail', $pemesanan->id) }}" class="text-blue-600 hover:text-blue-800 transition font-medium">
            &larr; Kembali ke Detail Pesanan
        </a>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow font-bold transition">
            <i class="fas fa-print mr-2"></i> Cetak / Simpan PDF
        </button>
    </div>

    <!-- Main Ticket Card -->
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-2xl overflow-hidden print-border relative">
        <!-- Ticket Header -->
        <div class="bg-blue-900 text-white p-6 md:p-8 flex flex-col md:flex-row justify-between md:items-center">
            <div>
                <h1 class="text-3xl font-extrabold tracking-wider">SIMATA<span class="text-blue-300">TICKET</span></h1>
                <p class="text-blue-200 text-sm mt-1">Sistem Manajemen Tiket Terminal Aceh</p>
            </div>
            <div class="mt-4 md:mt-0 text-left md:text-right">
                <p class="text-sm text-blue-200">ID Pesanan</p>
                <p class="font-mono font-bold text-lg max-w-[200px] truncate" title="{{ $pemesanan->id }}">{{ substr($pemesanan->id, 0, 10) }}***</p>
            </div>
        </div>

        <!-- Ticket Body -->
        <div class="p-6 md:p-8 relative">
            <div class="absolute right-8 top-8 py-1 px-3 bg-green-100 text-green-800 font-bold border-2 border-green-500 rounded transform rotate-12 opacity-80 text-xl tracking-widest hidden md:block">
                PAID
            </div>

            <!-- Operator & Route -->
            <div class="flex flex-col md:flex-row justify-between mb-8 pb-8 border-b border-dashed border-gray-300">
                <div class="mb-6 md:mb-0">
                    <p class="text-sm text-gray-500 font-semibold mb-1 uppercase tracking-wider">PO Bus / Operator</p>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $pemesanan->jadwal->armada->poBus->nama_po }}</h2>
                    <p class="text-gray-600 font-medium">{{ $pemesanan->jadwal->armada->kelas }} - {{ $pemesanan->jadwal->armada->plat_nomor }}</p>
                </div>
                
                <div class="md:text-right">
                    <p class="text-sm text-gray-500 font-semibold mb-1 uppercase tracking-wider">Keberangkatan</p>
                    <div class="flex items-center md:justify-end text-xl font-bold bg-gray-50 p-2 rounded inline-block">
                        <span class="text-blue-700">{{ $pemesanan->jadwal->rute->kota_asal }}</span>
                        <i class="fas fa-long-arrow-alt-right mx-3 text-gray-400"></i>
                        <span class="text-emerald-700">{{ $pemesanan->jadwal->rute->kota_tujuan }}</span>
                    </div>
                    <p class="text-gray-800 font-bold text-lg mt-2"><i class="far fa-calendar-alt mr-2 text-blue-600"></i> {{ \Carbon\Carbon::parse($pemesanan->jadwal->waktu_berangkat)->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>

            <!-- Passenger Details Table -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi Penumpang & Kursi</h3>
                <div class="overflow-hidden border border-gray-200 rounded-lg">
                    <table class="w-full text-left bg-white">
                        <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                            <tr>
                                <th class="p-3 w-16 text-center border-r">No</th>
                                <th class="p-3 border-r">Nama Penumpang</th>
                                <th class="p-3 w-32 border-r text-center">No Kursi</th>
                                <th class="p-3 text-right">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 font-medium text-sm md:text-base">
                            @foreach($pemesanan->tikets as $index => $tiket)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 text-center border-r">{{ $index + 1 }}</td>
                                <td class="p-3 border-r">{{ $tiket->nama_penumpang }}</td>
                                <td class="p-3 border-r text-center">
                                    <span class="bg-blue-100 text-blue-800 border border-blue-300 py-1 px-3 rounded font-bold text-lg">
                                        {{ $tiket->kursi->nomor_kursi }}
                                    </span>
                                </td>
                                <td class="p-3 text-right">Rp {{ number_format($pemesanan->jadwal->harga_dasar, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t-2 border-gray-300 font-bold bg-gray-50">
                            <tr>
                                <td colspan="3" class="p-3 text-right text-gray-600 uppercase">Total Dibayar</td>
                                <td class="p-3 text-right text-xl text-blue-900">Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Warning/Note -->
            <div class="mt-8 bg-amber-50 border-l-4 border-amber-500 p-4 rounded text-sm text-amber-800 flex items-start shadow-sm">
                <i class="fas fa-exclamation-circle text-amber-500 mt-1 mr-3 text-lg"></i>
                <p>Harap tunjukkan E-Ticket ini secara digital (di layar HP) atau dicetak kepada petugas loket/kondektur {{ $pemesanan->jadwal->armada->poBus->nama_po }} setidaknya 30 menit sebelum waktu keberangkatan. Pastikan tidak terlambat.</p>
            </div>
        </div>
        
        <!-- Ticket Footer barcode mockup -->
        <div class="bg-gray-900 border-t border-gray-200 p-4 text-center">
            <p class="mt-2 text-xs text-gray-400">Valid Boarding Pass. Scan by system only.</p>
        </div>
    </div>

</body>
</html>
