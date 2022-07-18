<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangsImport implements ToModel, WithHeadingRow {
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row) {
		return new Barang([
			'id_category' => $row['id_category'],
			'category' => $row['category'],
			'barcode' => $row['barcode'],
			'sub_id' => $row['sub_id'],
			'id_barang' => $row['id_barang'],
			'nama_barang' => $row['nama_barang'],
			'uraian' => $row['uraian'],
			'stok' => $row['stok'],
			'satuan' => $row['satuan'],
			'harga_satuan' => $row['harga_satuan'],

		]);
	}
}
