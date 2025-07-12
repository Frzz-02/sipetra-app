<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status_proses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_sedang_proses');
            $table->foreign('id_sedang_proses')->references('id')->on('sedang_proses')->onDelete('cascade');

            $table->string('status', 30)->default('diproses'); // ganti dari enum jadi string
            $table->dateTime('waktu');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('status_proses');
    }
};
