<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asets', function (Blueprint $table) {
            $table->id('id_aset');
            $table->integer('id_ruangan');
            $table->string('kode_aset');
            $table->string('nama')->nullable();
            $table->string('id_sumber')->nullable();
            $table->integer('jumlah')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('tahun_pengadaan')->nullable(); 
            $table->string('foto_aset')->nullable();
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
        Schema::dropIfExists('asets');
    }
}
