<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PoBus;
use App\Models\Rute;
use App\Models\Armada;
use App\Models\Kursi;
use App\Models\Jadwal;
use Carbon\Carbon;

class Tahap3Seeder extends Seeder
{
    public function run(): void
    {
        $mitra = User::where('role', 'mitra')->first();

        // 1. Buat PO Bus
        $poBus = PoBus::create([
            'user_id' => $mitra->id,
            'nama_po' => 'PO Sejahtera',
            'deskripsi' => 'Melayani sepenuh hati',
        ]);

        // 2. Buat Rute
        $rute1 = Rute::create(['kota_asal' => 'Banda Aceh', 'kota_tujuan' => 'Medan']);
        $rute2 = Rute::create(['kota_asal' => 'Banda Aceh', 'kota_tujuan' => 'Lhokseumawe']);

        // 3. Buat Armada
        $armada = Armada::create([
            'po_bus_id' => $poBus->id,
            'plat_nomor' => 'BL 1234 AB',
            'kelas' => 'Eksekutif',
            'fasilitas' => 'AC, WiFi, Toilet',
            'total_kursi' => 10,
        ]);

        // 4. Buat Kursi (10 Kursi)
        $kursis = [];
        for ($i = 1; $i <= 10; $i++) {
            $kursis[] = ['armada_id' => $armada->id, 'nomor_kursi' => $i . 'A', 'created_at' => now(), 'updated_at' => now()];
        }
        Kursi::insert($kursis);

        // 5. Buat Jadwal
        Jadwal::create([
            'armada_id' => $armada->id,
            'rute_id' => $rute1->id,
            // Perbaikan agar timestamp compatible dg string SQLite dan Laravel auto-parse
            'waktu_berangkat' => Carbon::tomorrow()->setHour(20)->setMinute(0)->toDateTimeString(),
            'harga_dasar' => 250000,
        ]);
    }
}
