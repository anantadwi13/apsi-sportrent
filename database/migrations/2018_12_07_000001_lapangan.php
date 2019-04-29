<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Lapangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lapangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
            $table->unsignedInteger('id_kategori');
            $table->string('kode',10)->nullable();
            $table->string('nama');
            $table->string('deskripsi');
            $table->string('alamat_jalan')->nullable();
            $table->unsignedInteger('alamat_kecamatan')->nullable();
            $table->double('map_lat');
            $table->double('map_long');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_kategori')->references('id')->on('kategori');
            $table->foreign('alamat_kecamatan')->references('id')->on('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lapangan');
    }
}
