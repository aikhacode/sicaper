<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KeluarController;
use App\Http\Controllers\MasukController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
Route::get('/test', function () {
	return 'haloo';
});

// Route::post('/import-xls', [PegawaiController::class, 'fileImport']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {
	Route::delete('/bro/delete/{email}',function(Request $request , $email){
			$f = $request->all();
			$usr = \App\Models\User::where('email','=',$email)->delete();
			return response([$usr,$email,$f]);

	});
	Route::post('/bro/update', function(Request $request){
		$request->validate([
			'name' => 'required',
			'email' => 'required|email',
			'password' =>'required',
			'password_confirmation' => 'required',
			'role' => 'required'
		]);

		$fields = $request->all();

		$email = $fields['email'];

		
		$data = ['name' => $fields['name'],
				 'password' => bcrypt($fields['password']),
				 			
				];

		if ($fields['mode'] == 'old') {

			$user = DB::table("users")->where('email','=',$email);
			
			if (!empty($user)) {
				$ret=true;
				$user->update($data);
				
			} else {
				$ret = false;
			}
		} elseif ($fields['mode'] == 'new'){
			$user = \App\Models\User::create([
				'name' => $fields['name'],
				'email' => $fields['email'],
				'password' => bcrypt($fields['password']),
				'role' => $fields['role']
			]);
			
			$ret = $fields;
			$token = $user->createToken('myapptoken')->plainTextToken;
		}
		

		return response($ret,(!empty($user)) ? 200 : 400);

	});

	Route::get('/dashboard', function () {
		$barang = \Illuminate\Support\Facades\DB::select("SELECT COUNT(id) AS count FROM (SELECT id from barangs ) AS b")[0];
		$masuk = \Illuminate\Support\Facades\DB::select("SELECT COUNT(id) AS count FROM (SELECT id from masuks ) AS b")[0];
		$keluar = \Illuminate\Support\Facades\DB::select("SELECT COUNT(id) AS count FROM (SELECT id from keluars ) AS b")[0];

		return response(array(
			'barang' => $barang,
			'stok' => array('masuk' => $masuk, 'keluar' => $keluar),
		));
	});

	Route::get('/bro', [AuthController::class, 'index']);

	Route::get('/categories', function () {

		$cat = Category::orderBy('id_category', 'DESC')
			->orderBy('id_barang', 'DESC')
			->get();
		$max_category = Category::max('id_category') + 1;
		$max_barang = Category::max('id_barang') + 1;

		return response(array(
			'category' => $cat,
			'max' => array('category' => $max_category, 'barang' => $max_barang),

		));
	});

	Route::get('/categories/barang/{id}', function ($cat) {

		return Category::select(['id_barang', 'nama_barang'])
			->where('id_category', '=', $cat)
			->groupBy(['id_barang', 'nama_barang'])
			->get();
	});

	Route::get('/categories/category', function () {
		return Category::select(['id_category', 'category'])->groupBy(['id_category', 'category'])->get();
	});

	Route::post('/categories', function (Request $request) {
		$request->validate([
			'id_category' => 'required',
			'category' => 'required',
			'id_barang' => 'required',
			'nama_barang' => 'required',
		]);

		return Category::create($request->all());
	});

	Route::put('/categories/{id}', function (Request $request, $id) {
		$request->validate([
			'id_category' => 'required',
			'category' => 'required',
			'id_barang' => 'required',
			'nama_barang' => 'required',
		]);

		$cat = Category::find($id);

		return $cat->update($request->all());
	});

	Route::get('/barang', [BarangController::class, 'index']);
	Route::get('/barang/barcode/{barcode}', [BarangController::class, 'get_by_barcode']);
	Route::get('/barang/category', [BarangController::class, 'get_all_category']);
	Route::get('/barang/list/category/{id}', [BarangController::class, 'get_barang_by_category']);
	Route::post('/barang', [BarangController::class, 'create']);
	Route::put('/barang', [BarangController::class, 'store']);
	Route::delete('/barang/{id}', [BarangController::class, 'destroy']);

	Route::get('/masuk/all', [MasukController::class, 'index']);
	Route::post('/masuk', [MasukController::class, 'create']);
	Route::put('/masuk', [MasukController::class, 'update']);
	Route::delete('/masuk/{id}', [MasukController::class, 'destroy']);

	Route::get('/keluar/all', [KeluarController::class, 'index']);
	Route::post('/keluar', [KeluarController::class, 'create']);
	Route::put('/keluar', [KeluarController::class, 'update']);
	Route::delete('/keluar/{id}', [KeluarController::class, 'destroy']);

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
