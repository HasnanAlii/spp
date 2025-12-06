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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            // Relasi ke siswa
            $table->unsignedBigInteger('siswa_id');

            // Relasi ke SPP siswa
            $table->unsignedBigInteger('spp_siswa_id');

            // Tanggal pembayaran
            $table->date('tanggal_bayar');

            // Nominal pembayaran
            $table->integer('jumlah_bayar');

            // Metode pembayaran
            $table->enum('metode', ['tunai', 'transfer'])->default('tunai');

            // Catatan opsional
            $table->text('keterangan')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');
            $table->foreign('spp_siswa_id')->references('id')->on('spp_siswas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
