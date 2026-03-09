<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pemesanan;

class CheckExpiredBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ubah status tiket Pending menjadi Expired jika melewati batas waktu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredCount = Pemesanan::where('status_bayar', 'Pending')
            ->where('batas_waktu_bayar', '<', now())
            ->update(['status_bayar' => 'Expired']);

        $this->info("Berhasil mengupdate {$expiredCount} pemesanan menjadi Expired.");
    }
}
