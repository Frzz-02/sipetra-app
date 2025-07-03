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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
                ->constrained('users')
                ->onDelete('cascade'); // This will delete the order if the user is deleted

            $table->foreignId('id_penyedia_layanan')
                ->constrained('penyedia_layanans')
                ->onDelete('cascade'); // This will delete the order if the service provider is deleted

            $table->dateTime('tanggal_pesan');
            $table->dateTime('tanggal_mulai')->nullable(); // Optional start date for the service
            $table->dateTime('tanggal_selesai')->nullable(); // Optional end date for
            $table->dateTime('tanggal_titip')->nullable();
            $table->dateTime('tanggal_ambil')->nullable();
            $table->string('lokasi_awal')->nullable();
            $table->string('lokasi_tujuan')->nullable();
            $table->decimal('total_biaya', 10, 2);
            $table->enum('status', ['menunggu pembayaran', 'menunggu diproses', 'diproses', 'selesai', 'batal'])
                ->default('menunggu pembayaran'); // Status of the order, default is pending

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
