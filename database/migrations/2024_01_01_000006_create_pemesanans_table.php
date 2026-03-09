<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('jadwal_id')->constrained('jadwals')->cascadeOnDelete();
            $table->timestamp('waktu_pesan')->useCurrent();
            $table->timestamp('batas_waktu_bayar')->nullable();
            $table->decimal('total_harga', 15, 2);
            $table->enum('status_bayar', ['Draft', 'Pending', 'Paid', 'Expired', 'Cancelled'])->default('Draft');
            $table->string('metode_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
