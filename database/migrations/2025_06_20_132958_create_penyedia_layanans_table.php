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
        Schema::create('penyedia_layanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')
                ->constrained('users')
                ->onDelete('cascade');

            $table->string('nama_toko', 100);
            $table->text('alamat_toko');
            $table->text('deskripsi')->nullable();
            $table->string('color_heading')->nullable();
            $table->string('color_font_judul')->nullable();
            $table->string('color_font')->nullable();
            $table->string('color_button')->nullable();
            $table->string('logo_toko')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'ditangguhkan', 'dibekukan', 'ditampilkan'])
                ->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_layanans');
    }
};
