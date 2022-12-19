<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_ruangans', function (Blueprint $table) {
            $table->id('id_histori_ruangan');
            $table->integer('id_user')->nullable();
            $table->integer('kode_jurusan')->nullable();
            $table->integer('id_ruangan')->nullable();
            $table->timestamp('mulai')->nullable();
            $table->timestamp('selesai')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histori_ruangans');
    }
}
