<?php

namespace App\Http\Controllers;

use App\Models\Masuk;
use Illuminate\Http\Request;

class MasukController extends Controller {
	public function index() {

		$masuk = Masuk::join('barangs', 'barangs.sub_id', '=', 'masuks.sub_id')->join('users', 'users.id', '=', 'masuks.user_id')->get([
			'masuks.id as id', 'masuks.user_id', 'masuks.tgl_masuk', 'barangs.category', 'barangs.nama_barang', 'barangs.sub_id', 'barangs.barcode', 'barangs.uraian',
			'barangs.id_category', 'barangs.id_barang', 'masuks.jumlah', 'barangs.satuan', 'barangs.harga_satuan', 'masuks.keterangan',
			'users.email',
		]);
		// $masuk = Masuk::all();
		return response($masuk);
	}

	public function create(Request $request) {
		$request->validate([
			'jumlah' => 'required',
			'sub_id' => 'required',
			'user_id' => 'required',
			'tgl_masuk' => 'required',
			'keterangan' => 'required',
		]);

		$fields = $request->all();

		return Masuk::create($fields);

	}

	public function update(Request $request) {
		$request->validate([
			'jumlah' => 'required',
			'sub_id' => 'required',
			'user_id' => 'required',
			'keterangan' => 'required',
		]);

		$fields = $request->all();
		$masuk = Masuk::find($fields['id']);

		return $masuk->update($fields);
	}

	public function destroy($id) {
		return Masuk::destroy($id);
	}

}
