<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow {
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row) {
		return new User([
			'name' => $row['nama'],
			'username' => $row['username'],
			'email' => $row['email'],
			'email_verified_at' => now(),
			'role' => $row['role'],
			'password' => bcrypt($row['password']), // password
			'remember_token' => \Illuminate\Support\Str::random(10),
		]);
	}
}
