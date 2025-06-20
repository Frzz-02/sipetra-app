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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pesanan')
                ->constrained('pesanans')
                ->onDelete('cascade'); //->onDelete('cascade') ini akan menghapus data pembayaran jika data user dihapus

            $table->string('metode_pembayaran', 50); 
            $table->enum('status', ['menunggu', 'lunas', 'gagal']); 
            $table->string('bukti_bayar'); 
            $table->timestamps('created_at'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
