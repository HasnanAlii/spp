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
        Schema::create('spp_siswas', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel siswa
            $table->unsignedBigInteger('siswa_id');

            // Nama SPP (contoh: SPP Januari 2025)
            $table->string('nama_spp');

            // Jenis SPP : bulanan, tahunan, lainnya
            $table->enum('tipe', ['bulanan', 'tahunan', 'lainnya']);

            // Total nominal tagihan
            $table->integer('total_tagihan');
            $table->string('tahun_ajaran')->nullable();


            // Sisa yang harus dibayar
            $table->integer('sisa_tagihan');

            // Status pelunasan
            $table->enum('status', ['belum lunas', 'lunas'])->default('belum lunas');

            $table->timestamps();

            // Foreign key
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_siswa');
    }
};
