<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('foto_penyedia_layanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penyedia_layanan');
            $table->string('foto'); // path atau nama file foto
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_penyedia_layanan')
                  ->references('id')
                  ->on('penyedia_layanans')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('foto_penyedia_layanans');
    }
};
