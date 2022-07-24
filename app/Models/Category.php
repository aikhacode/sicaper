<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	use HasFactory;
	protected $fillable = [
		'id_category', 'category', 'id_barang', 'nama_barang',

	];
}
