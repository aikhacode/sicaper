<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_category', 'category', 'barcode', 'id_barang', 'nama_barang', 'code_barang', 'uraian', 'stok', 'satuan', 'harga_satuan'

    ];
}
