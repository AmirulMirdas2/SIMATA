<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('armadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('po_bus_id')->constrained('po_bus')->cascadeOnDelete();
            $table->string('plat_nomor');
            $table->string('kelas');
            $table->text('fasilitas')->nullable();
            $table->integer('total_kursi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('armadas');
    }
};
