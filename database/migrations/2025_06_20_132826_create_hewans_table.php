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
        Schema::create('hewans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nama_hewan', 100);
            $table->string('jenis_hewan', 50);
            $table->string('foto_hewan');
            $table->string('umur')->nullable(); // umur bisa disimpan dalam format "2 tahun", "6 bulan", dll
            $table->text('deskripsi')->nullable(); // deskripsi tidak wajib
            $table->string('berat')->nullable(); // berat tidak wajib
            $table->date('tanggal_lahir'); // tanggal lahir
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hewans');
    }
};
