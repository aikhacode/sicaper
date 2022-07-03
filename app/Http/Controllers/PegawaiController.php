<?php

namespace App\Http\Controllers;

use App\Imports\PegawaisImport;
use App\Models\Pegawai;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

// use App\Exports\UsersExport;

class PegawaiController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return Pegawai::all();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// public function create()
	// {
	//     //
	// }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$request->validate([
			'nama' => 'required',
		]);

		return Pegawai::create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\pegawai  $pegawai
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		return Pegawai::find($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\pegawai  $pegawai
	 * @return \Illuminate\Http\Response
	 */
	// public function edit(pegawai $pegawai)
	// {
	//     //
	// }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\pegawai  $pegawai
	 * @return \Illuminate\Http\Response
	 */

	public function update(Request $request, $id) {
		$pegawai = Pegawai::find($id);
		$pegawai->update($request->all());
		return response($pegawai, 200);
	}

	/**
	 * Search for a name
	 *
	 * @param  str  $name
	 * @return \Illuminate\Http\Response
	 */
	public function search($name) {
		return Pegawai::where('nama', 'like', '%' . $name . '%')->get();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\pegawai  $pegawai
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		return Pegawai::destroy($id);
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	// public function fileImportExport()
	// {
	//    return view('file-import');
	// }

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function fileImport(Request $request) {
		Excel::import(new PegawaisImport, $request->file('file')->store('temp'));
        return response('import sukses',200);
	}
	/**
	 * @return \Illuminate\Support\Collection
	 */
	// public function fileExport()
	// {
	//     return Excel::download(new UsersExport, 'users-collection.xlsx');
	// }
}
