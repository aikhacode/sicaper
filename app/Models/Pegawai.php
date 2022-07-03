<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model {
	use HasFactory;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'nik', 'nip', 'nama', 'sex', 'status', 'pangkat', 'gol', 'jabatan_anjab',
		'tmt_skcpns', 'tmt_pensiun', 'pendidikan', 'perguruan_tinggi',
		'tahun_lulus', 'sip_sik', 'tgl_sipsik', 'no_str', 'tgl_str',
	];
}
