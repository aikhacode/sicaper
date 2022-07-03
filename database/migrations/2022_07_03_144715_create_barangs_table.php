<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            // $table->timestamps();
            $table->string('id_category');
            $table->string('category');
            $table->string('barcode')->nullable();
            $table->string('id_barang');
            $table->string('nama_barang');
            $table->string('code_barang');
            $table->string('uraian')->default('-');
            $table->integer('stok')->default(0);
            $table->string('satuan')->default('bj');
            $table->decimal('harga_satuan',12,2)->default(0);
            $table->unique('code_barang');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
