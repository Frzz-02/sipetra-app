<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();

            // Relasi ke penyedia layanan
            $table->unsignedBigInteger('id_penyedia_layanan');
            $table->foreign('id_penyedia_layanan')
                  ->references('id')->on('penyedia_layanans')
                  ->onDelete('cascade');

            // Informasi karyawan
            $table->string('foto_karyawan',100)->nullable();   // path foto
            $table->string('nama', 45);
            $table->string('email', 35)->unique();
            $table->string('no_telephone',15);
            $table->text('alamat',);

            // tipe_karyawan diubah jadi string max 20 karakter (bisa: dokter, driver, dll)
            $table->string('tipe_karyawan', 20)->nullable();
            $table->enum('status', ['sedang bertugas' , 'tidak bertugas'])
                  ->default('tidak bertugas'); // status karyawan

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('karyawans');
    }
};
