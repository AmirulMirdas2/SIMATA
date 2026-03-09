<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rute;
use App\Models\Armada;
use App\Models\Jadwal;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Rute Realistis Antarkota
        $rutes = [
            Rute::firstOrCreate(['kota_asal' => 'Banda Aceh', 'kota_tujuan' => 'Medan']),
            Rute::firstOrCreate(['kota_asal' => 'Lhokseumawe', 'kota_tujuan' => 'Medan']),
            Rute::firstOrCreate(['kota_asal' => 'Sigli', 'kota_tujuan' => 'Banda Aceh']),
            Rute::firstOrCreate(['kota_asal' => 'Banda Aceh', 'kota_tujuan' => 'Takengon']),
        ];

        $armadas = Armada::all();
        if ($armadas->isEmpty()) return;

        // Generate Jadwal keberangkatan 3-7 hari ke depan
        foreach ($armadas as $armada) {
            // Setiap armada diberi 2 jadwal acak rutenya
            for ($i = 0; $i < 2; $i++) {
                $rute = collect($rutes)->random();
                
                // Menghasilkan hari antara 3 sampai 7 ke depan
                $daysAhead = rand(3, 7);
                $waktuBerangkat = Carbon::now()->addDays($daysAhead)->setHour(rand(18, 22))->setMinute(0)->setSecond(0);
                
                // Harga disesuaikan kelas
                $hargaDasar = ($armada->kelas == 'Patas Executive') ? 280000 : 200000;

                Jadwal::firstOrCreate([
                    'armada_id' => $armada->id,
                    'rute_id' => $rute->id,
                    'waktu_berangkat' => $waktuBerangkat->toDateTimeString()
                ], [
                    'harga_dasar' => $hargaDasar
                ]);
            }
        }
    }
}
