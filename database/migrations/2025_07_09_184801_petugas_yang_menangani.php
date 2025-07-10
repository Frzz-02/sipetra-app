<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('petugas_yang_menangani', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_sedang_proses');
            $table->foreign('id_sedang_proses')->references('id')->on('sedang_proses')->onDelete('cascade');

            $table->unsignedBigInteger('id_karyawan');
            $table->foreign('id_karyawan')->references('id')->on('karyawans')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('petugas_yang_menangani');
    }
};
