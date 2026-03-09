<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PoBus;
use App\Models\Armada;
use App\Models\Kursi;

class MitraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mitra = User::where('role', 'mitra')->first();
        if (!$mitra) return;

        // 1. PO Sempati Star
        $po1 = PoBus::firstOrCreate(['nama_po' => 'PO Sempati Star'], [
            'user_id' => $mitra->id,
            'deskripsi' => 'Melayani rute Sumatera dengan armada premium dan fasilitas terbaik.'
        ]);
        $this->createArmadasAndKursi($po1, 'BL 7777 AA', 'Patas Executive', 30);
        $this->createArmadasAndKursi($po1, 'BL 7778 AA', 'Non-Stop', 40);
        $this->createArmadasAndKursi($po1, 'BL 7779 AA', 'Patas Executive', 30);

        // 2. PO Kurnia
        $po2 = PoBus::firstOrCreate(['nama_po' => 'PO Kurnia'], [
            'user_id' => $mitra->id,
            'deskripsi' => 'Kenyamanan perjalanan Anda adalah prioritas kami sejak lama.'
        ]);
        $this->createArmadasAndKursi($po2, 'BL 6661 BB', 'Non-Stop', 40);
        $this->createArmadasAndKursi($po2, 'BL 6662 BB', 'Patas Executive', 30);
        $this->createArmadasAndKursi($po2, 'BL 6663 BB', 'Non-Stop', 40);
    }

    private function createArmadasAndKursi($poBus, $platNomor, $kelas, $totalKursi) 
    {
        $armada = Armada::firstOrCreate(['plat_nomor' => $platNomor], [
            'po_bus_id' => $poBus->id,
            'kelas' => $kelas,
            'fasilitas' => 'AC, TV, Toilet, Snack, Recleaning Seat',
            'total_kursi' => $totalKursi
        ]);

        // Create seats only if this armada has no seats
        if ($armada->kursis()->count() == 0) {
            $kursis = [];
            // Assume 4 seats per row (A, B, C, D)
            $cols = ['A', 'B', 'C', 'D'];
            $colIdx = 0;
            $rowIdx = 1;

            for ($i = 0; $i < $totalKursi; $i++) {
                $kursis[] = [
                    'armada_id' => $armada->id,
                    'nomor_kursi' => $rowIdx . $cols[$colIdx],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                
                $colIdx++;
                if ($colIdx >= 4) {
                    $colIdx = 0;
                    $rowIdx++;
                }
            }
            Kursi::insert($kursis);
        }
    }
}
