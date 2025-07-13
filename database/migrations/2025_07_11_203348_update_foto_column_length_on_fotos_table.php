<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFotoColumnLengthOnFotosTable extends Migration
{
    public function up()
    {
        Schema::table('foto_penyedia_layanans', function (Blueprint $table) {
            $table->string('foto')->change(); // ubah panjang kolom menjadi 500 karakter
        });
    }

    public function down()
    {
        Schema::table('foto_penyedia_layanans', function (Blueprint $table) {
            $table->string('foto', 50)->change(); // balik ke panjang 255 jika rollback
        });
    }
}
