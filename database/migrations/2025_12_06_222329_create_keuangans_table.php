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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_pembayaran')->nullable();

            $table->bigInteger('jumlah');
            $table->string('keterangan')->nullable();
            $table->enum('arus_dana', ['masuk', 'keluar']);
            $table->timestamps();

            // foreign key
            $table->foreign('id_pembayaran')
                ->references('id')
                ->on('pembayarans')
                ->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
