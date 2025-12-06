<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('spps', function (Blueprint $table) {
            $table->id();

            // Nama SPP (contoh: SPP Januari 2025, SPP Tahunan 2025)
            $table->string('nama_spp');

            // Tipe SPP: bulanan / tahunan / lainnya
            $table->enum('tipe', ['bulanan', 'tahunan', 'lainnya']);

            // Nominal biaya SPP
            $table->integer('nominal');

            // Tahun ajaran (contoh: 2024/2025)
            $table->string('tahun_ajaran')->nullable();

            // Berlaku untuk kelas tertentu (10, 11, 12)
            $table->string('kelas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_master');
    }
};
