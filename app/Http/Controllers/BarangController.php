<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		return Barang::latest()->get();
		//    return response($data);

	}

	public function get_by_barcode($barcode) {
		return Barang::where('barcode', $barcode)->get();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		$request->validate([
			'id_category' => 'required',
			'category' => 'required',
			// 'barcode' => 'required',
			// 'sub_id' => 'required',
			'id_barang' => 'required',
			'nama_barang' => 'required',
			'uraian' => 'required',
			'stok' => 'required',
			'satuan' => 'required',
			'harga_satuan' => 'required',
		]);

		$fields = $request->all();
		$barang = Barang::create($fields);
		$id = $barang->id;
		$sub_id = sprintf("ID-%1$07d", $id) . "/1";
		$fields['sub_id'] = $sub_id;
		Barang::find($id)->update($fields);
		return Barang::find($id);

	}

	public function get_all_category() {
		// $data = array(
		// 	'category' => Barang::select(['id_category', 'category'])->groupBy(['id_category', 'category'])->get(),
		// 	'nama_barang' => Barang::select(['id_barang', 'nama_barang'])->groupBy(['id_barang', 'nama_barang'])->get(),
		// );
		return Barang::select(['id_category', 'category'])->groupBy(['id_category', 'category'])->get();
	}

	public function get_barang_by_category($category) {
		return Barang::select(['id_barang', 'nama_barang'])->where('id_category', '=', $category)->groupBy(['id_barang', 'nama_barang'])->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$request->validate([
			'id_category' => 'required',
			'category' => 'required',
			// 'barcode' => 'required',
			// 'sub_id' => 'required',
			'id_barang' => 'required',
			'nama_barang' => 'required',
			'uraian' => 'required',
			'stok' => 'required',
			'satuan' => 'required',
			'harga_satuan' => 'required',
		]);

		$fields = $request->all();
		$barang = Barang::find($fields['id']);

		// $barang = Barang::create($fields);
		// $id = $barang->id;
		// $sub_id = sprintf("ID-%1$07d", $id) . "/1";
		// $fields['sub_id'] = $sub_id;
		return $barang->update($fields);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Barang  $barang
	 * @return \Illuminate\Http\Response
	 */
	public function show(Barang $barang) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Barang  $barang
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Barang $barang) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Barang  $barang
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Barang $barang) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Barang  $barang
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		return Barang::destroy($id);
	}
}
