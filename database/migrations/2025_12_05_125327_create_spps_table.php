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
            $table->string('nama_spp');
            $table->enum('tipe', ['bulanan', 'tahunan', 'lainnya']);
            $table->integer('nominal');
            $table->string('gelombang')->nullable();
            $table->string('tahun_ajaran')->nullable();
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
