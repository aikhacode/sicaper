<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::post('/import-xls', [PegawaiController::class, 'fileImport']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {

	Route::get('/barang', [BarangController::class, 'index']);
	Route::get('/barang/barcode/{barcode}', [BarangController::class, 'get_by_barcode']);
	Route::get('/barang/category/all', [BarangController::class, 'get_all_category']);
	Route::post('/barang', [BarangController::class, 'create']);
	Route::put('/barang', [BarangController::class, 'store']);
	Route::delete('/barang/{id}', [BarangController::class, 'destroy']);

	// Route::post('/pegawai/create',[PegawaiController::class,'store']);
	// Route::put('/pegawai/{id}',[PegawaiController::class,'update']);
	// Route::delete('/pegawai/{id}',[PegawaiController::class,'destroy']);

	// Route::get('/pegawai',[PegawaiController::class,'index']);
	// Route::get('/pegawai/search/{name}',[PegawaiController::class,'search']);

	Route::post('/logout', [AuthController::class, 'logout']);

});

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
