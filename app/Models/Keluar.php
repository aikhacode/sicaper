<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluar extends Model {
	use HasFactory;
	protected $fillable = ['jumlah', 'sub_id', 'user_id', 'tgl_keluar', 'keterangan'];
}
