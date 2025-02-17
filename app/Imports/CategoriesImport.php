<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow {
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row) {
		return new Category([
			'id_category' => $row['id_category'],
			'category' => $row['category'],
			'id_barang' => $row['id_barang'],
			'nama_barang' => $row['nama_barang'],

		]);
	}
}
