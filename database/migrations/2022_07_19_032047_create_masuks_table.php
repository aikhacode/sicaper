<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasuksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('masuks', function (Blueprint $table) {
			$table->id();
			$table->integer('jumlah');
			$table->integer('user_id');
			$table->string('sub_id');
			$table->decimal('harga_baru', 12, 2)->nullable();
			$table->date('tgl_masuk');
			$table->text('keterangan');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('masuks');
	}
}
