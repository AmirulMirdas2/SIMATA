<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kursis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('armada_id')->constrained('armadas')->cascadeOnDelete();
            $table->string('nomor_kursi'); // Contoh: 1A, 1B
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kursis');
    }
};
