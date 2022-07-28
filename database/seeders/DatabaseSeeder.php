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
		// \App\Models\User::factory(1)->create();
		// \App\Models\Pegawai::factory(1)->create();
		// \App\Models\User::create(['name' => 'tester',
		// 	'email' => 'test@sicaper.ujung',
		// 	'password' => bcrypt('12345'), // password
		// 	'role' => 'user',
		// 	'remember_token' => \Illuminate\Support\Str::random(10)]);

		// \App\Models\User::create(['name' => 'admin',
		// 	'email' => 'admin@sicaper.ujung',
		// 	'password' => bcrypt('12345'), // password
		// 	'role' => 'Admin',
		// 	'remember_token' => \Illuminate\Support\Str::random(10)]);

		\Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\UsersImport, \Illuminate\Support\Facades\Storage::path('seeder/user.xlsx'));

		\Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\BarangsImport, \Illuminate\Support\Facades\Storage::path('seeder/barang.csv'));

		\Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\CategoriesImport, \Illuminate\Support\Facades\Storage::path('seeder/category.csv'));
	}
}
