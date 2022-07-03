<?php

namespace App\Imports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;

class PegawaisImport implements ToModel {
	/**
	 * @param array $row
	 *
	 * @return \Illuminate\Database\Eloquent\Model|null
	 */
	public function model(array $row) {
		return new Pegawai([
			'nik' => $row[0],
			'nip' => $row[1],
			'nama' => $row[2],
			'sex' => $row[3],
			'status' => $row[4],
			'pangkat' => $row[5],
			'gol' => $row[6],
			'jabatan_anjab' => $row[7],
			'tmt_skcpns' => $row[8],
			'tmt_pensiun' => $row[9],
			'pendidikan' => $row[10],
			'perguruan_tinggi' => $row[11],
			'tahun_lulus' => $row[12],
			'sip_sik' => $row[13],
			'tgl_sipsik' => $row[14],
			'no_str' => $row[15],
			'tgl_str' => $row[16],
		]);
	}
}
