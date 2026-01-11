<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id(); // primary key pembayaran
            $table->unsignedBigInteger('transaksi_id');
            $table->date('tanggal_pembayaran');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->string('metode_pembayaran', 50);
            $table->string('status_pembayaran', 20)->default('pending');
            $table->timestamps();

            // foreign key ke transaksi_barang
            $table->foreign('transaksi_id')
                  ->references('id')
                  ->on('transaksi_barang')
                  ->onDelete('cascade');
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
