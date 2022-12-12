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
            $table->string('kode_aset');
            $table->integer('kode_jurusan');
            $table->integer('id_ruangan');
            $table->integer('id_jenis')->nullable();
            $table->string('nama_aset')->nullable();
            $table->string('tahun_pengadaan')->nullable();
            $table->integer('nup')->nullable();
            $table->string('merk_type')->nullable();
            $table->integer('jumlah')->nullable();
            $table->decimal('nilai_barang')->nullable();
            $table->integer('id_kondisi')->nullable(); 
            $table->string('keterangan')->nullable();
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
