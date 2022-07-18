<?php

use App\Models\Barang;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
	return redirect('/app');
	// return view('welcome');
});

Route::get('/print/stok', function () {
	$barang = Barang::all();
	$header = Schema::getColumnListing(Barang::first()->getTable());

	$pdf = PDF::loadview('stok', ['data' => $barang, 'header' => $header]);
	return $pdf->inline();

	// $pdf = PDF::loadView('stok', ['data' => $barang, 'header' => $header]);
	// return $pdf->inline();

	// $pdf = App::make('dompdf.wrapper');
	// $pdf->loadHTML(view('stok', ['data' => $barang, 'header' => $header]));
	// return $pdf->stream();

});

Route::get('/preview/stok', function () {

	$barang = Barang::all();
	$header = Schema::getColumnListing(Barang::first()->getTable());

	return view('stok', ['data' => $barang, 'header' => $header]);
});
