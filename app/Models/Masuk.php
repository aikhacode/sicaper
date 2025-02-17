<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masuk extends Model {
	use HasFactory;

	protected $fillable = ['jumlah', 'sub_id', 'user_id', 'harga_baru', 'tgl_masuk', 'keterangan'];
}
