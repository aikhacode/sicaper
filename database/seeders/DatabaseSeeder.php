<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		\App\Models\User::factory(1)->create();
		// \App\Models\Pegawai::factory(1)->create();

		\Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\BarangsImport, \Illuminate\Support\Facades\Storage::path('seeder/barang.csv'));
	}
}
