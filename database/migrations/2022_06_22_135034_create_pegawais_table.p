<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nik',50)->nullable();
            $table->string('nip',50)->nullable();
            $table->string('nama',100);
            $table->string('sex',2)->nullable();
            $table->string('status',100)->nullable();
            $table->string('pangkat',100)->nullable();
            $table->string('gol',10)->nullable();
            $table->string('jabatan_anjab',100)->nullable();
            $table->dateTime('tmt_skcpns')->nullable();
            $table->dateTime('tmt_pensiun')->nullable();
            $table->string('pendidikan',100)->nullable();
            $table->string('perguruan_tinggi',100)->nullable();
            $table->integer('tahun_lulus')->nullable();
            $table->string('sip_sik',100)->nullable();
            $table->dateTime('tgl_sipsik')->nullable();
            $table->string('no_str',100)->nullable();
            $table->dateTime('tgl_str')->nullable();
            $table->string('avatar')->nullable();
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
        Schema::dropIfExists('pegawais');
    }
}
