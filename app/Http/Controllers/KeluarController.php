<?php

namespace App\Http\Controllers;

use App\Models\Keluar;
use Illuminate\Http\Request;

class KeluarController extends Controller {
	public function index() {

		$keluar = Keluar::join('barangs', 'barangs.sub_id', '=', 'keluars.sub_id')->join('users', 'users.id', '=', 'keluars.user_id')->get([
			'keluars.id as id', 'keluars.user_id', 'keluars.tgl_keluar', 'barangs.category', 'barangs.nama_barang', 'barangs.sub_id', 'barangs.barcode', 'barangs.uraian',
			'barangs.id_category', 'barangs.id_barang', 'keluars.jumlah', 'barangs.satuan', 'barangs.harga_satuan', 'keluars.keterangan',
			'users.email', 'users.name',
		]);
		// $Keluar = Keluar::all();
		return response($keluar);
	}

	public function create(Request $request) {
		$request->validate([
			'jumlah' => 'required',
			'sub_id' => 'required',
			'user_id' => 'required',
			'tgl_keluar' => 'required',
			'keterangan' => 'required',
		]);

		$fields = $request->all();

		return Keluar::create($fields);

	}

	public function update(Request $request) {
		$request->validate([
			'jumlah' => 'required',
			'sub_id' => 'required',
			'user_id' => 'required',
			'keterangan' => 'required',
		]);

		$fields = $request->all();
		$Keluar = Keluar::find($fields['id']);

		return $Keluar->update($fields);
	}

	public function destroy($id) {
		return Keluar::destroy($id);
	}

}
