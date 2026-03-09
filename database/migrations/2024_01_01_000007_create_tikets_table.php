<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tikets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pemesanan_id')->constrained('pemesanans')->cascadeOnDelete();
            $table->foreignId('kursi_id')->constrained('kursis')->cascadeOnDelete();
            $table->string('nama_penumpang');
            $table->string('nik_penumpang')->nullable();
            $table->text('qr_code')->nullable();
            $table->boolean('status_checkin')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
