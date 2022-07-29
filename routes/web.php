<?php

use App\Models\Barang;
use App\Models\Keluar;
use App\Models\Masuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
	// return view('app');
});

Route::get('/print/stok', function () {

	$barang = Barang::all();
	$header = Schema::getColumnListing(Barang::first()->getTable());

	$pdf = PDF::loadview('stok', ['data' => $barang, 'header' => $header]);
	return $pdf->inline();

	// return response($obj);

});

Route::get('/preview/stok', function () {

	$barang = Barang::all();
	$header = Schema::getColumnListing(Barang::first()->getTable());

	return view('stok', ['data' => $barang, 'header' => $header]);
});

Route::get('/preview/masuk', function (Request $request) {
	$periode = array('start' => $request->query('start'), 'end' => $request->query('end'));
	$from = date($periode['start']);
	$to = date($periode['end']);

	$masuk = Masuk::join('barangs', 'barangs.sub_id', '=', 'masuks.sub_id')->whereBetween('tgl_masuk', [$from, $to])->get(['tgl_masuk', 'barcode', 'uraian', 'jumlah', 'harga_satuan', 'keterangan']);

	$no = 1;
	$jumlah_ = 0;
	$total_ = 0;
	$harga_satuan_ = 0;

	foreach ($masuk as &$key) {
		$key['no'] = $no++;
		$jumlah_ = $jumlah_ + $key['jumlah'];
		$total_ = $total_ + ($key['jumlah'] * $key['harga_satuan']);
		$harga_satuan_ = $harga_satuan_ + $key['harga_satuan'];

		//formatting
		$key['tgl_masuk'] = Carbon::parse($key['tgl_masuk'])->format('d-m-Y');
		$key['total'] = number_format($key['jumlah'] * $key['harga_satuan'], 2);
		$key['harga_satuan'] = number_format($key['harga_satuan'], 2);
	}

	$header = array(
		['No', 'no'],
		['Tanggal', 'tgl_masuk'],
		['Barcode', 'barcode'],
		['Uraian', 'uraian'],
		['Jumlah', 'jumlah'],
		['Harga Satuan', 'harga_satuan'],
		['Total', 'total'],
		['Keterangan', 'keterangan'],
	);

	$judul = 'PERIODE ' . Carbon::parse($from)->format('d F Y') . ' S/D ' . Carbon::parse($to)->format('d F Y');
	$summary = ['jumlah' => $jumlah_, 'harga_satuan' => number_format($harga_satuan_, 2), 'total' => number_format($total_, 2)];

	return view('masuk', ['data' => $masuk, 'header' => $header, 'periode' => $judul, 'summary' => $summary]);
	// return $summary;
});

Route::get('/print/masuk', function (Request $request) {
	$periode = array('start' => $request->query('start'), 'end' => $request->query('end'));
	$from = date($periode['start']);
	$to = date($periode['end']);

	$masuk = Masuk::join('barangs', 'barangs.sub_id', '=', 'masuks.sub_id')->whereBetween('tgl_masuk', [$from, $to])->get(['tgl_masuk', 'barcode', 'uraian', 'jumlah', 'harga_satuan', 'keterangan']);

	$no = 1;
	$jumlah_ = 0;
	$total_ = 0;
	$harga_satuan_ = 0;

	foreach ($masuk as &$key) {
		$key['no'] = $no++;
		$jumlah_ = $jumlah_ + $key['jumlah'];
		$total_ = $total_ + ($key['jumlah'] * $key['harga_satuan']);
		$harga_satuan_ = $harga_satuan_ + $key['harga_satuan'];

		//formatting
		$key['tgl_masuk'] = Carbon::parse($key['tgl_masuk'])->format('d-m-Y');
		$key['total'] = number_format($key['jumlah'] * $key['harga_satuan'], 2);
		$key['harga_satuan'] = number_format($key['harga_satuan'], 2);
	}

	$header = array(
		['No', 'no'],
		['Tanggal', 'tgl_masuk'],
		['Barcode', 'barcode'],
		['Uraian', 'uraian'],
		['Jumlah', 'jumlah'],
		['Harga Satuan', 'harga_satuan'],
		['Total', 'total'],
		['Keterangan', 'keterangan'],
	);

	$judul = 'PERIODE ' . Carbon::parse($from)->format('d F Y') . ' S/D ' . Carbon::parse($to)->format('d F Y');
	$summary = ['jumlah' => $jumlah_, 'harga_satuan' => number_format($harga_satuan_, 2), 'total' => number_format($total_, 2)];

	$pdf = PDF::loadview('masuk', ['data' => $masuk, 'header' => $header, 'periode' => $judul, 'summary' => $summary]);
	return $pdf->inline();

	// return response($obj);

});

Route::get('/preview/keluar', function (Request $request) {
	$periode = array('start' => $request->query('start'), 'end' => $request->query('end'));
	$from = date($periode['start']);
	$to = date($periode['end']);

	$keluar = Keluar::join('barangs', 'barangs.sub_id', '=', 'keluars.sub_id')->whereBetween('tgl_keluar', [$from, $to])->get(['tgl_keluar', 'barcode', 'uraian', 'jumlah', 'harga_satuan', 'keterangan']);

	$no = 1;
	$jumlah_ = 0;
	$total_ = 0;
	$harga_satuan_ = 0;

	foreach ($keluar as &$key) {
		$key['no'] = $no++;
		$jumlah_ = $jumlah_ + $key['jumlah'];
		$total_ = $total_ + ($key['jumlah'] * $key['harga_satuan']);
		$harga_satuan_ = $harga_satuan_ + $key['harga_satuan'];

		//formatting
		$key['tgl_keluar'] = Carbon::parse($key['tgl_keluar'])->format('d-m-Y');
		$key['total'] = number_format($key['jumlah'] * $key['harga_satuan'], 2);
		$key['harga_satuan'] = number_format($key['harga_satuan'], 2);
	}

	$header = array(
		['No', 'no'],
		['Tanggal', 'tgl_keluar'],
		['Barcode', 'barcode'],
		['Uraian', 'uraian'],
		['Jumlah', 'jumlah'],
		['Harga Satuan', 'harga_satuan'],
		['Total', 'total'],
		['Keterangan', 'keterangan'],
	);

	$judul = 'PERIODE ' . Carbon::parse($from)->format('d F Y') . ' S/D ' . Carbon::parse($to)->format('d F Y');
	$summary = ['jumlah' => $jumlah_, 'harga_satuan' => number_format($harga_satuan_, 2), 'total' => number_format($total_, 2)];

	return view('keluar', ['data' => $keluar, 'header' => $header, 'periode' => $judul, 'summary' => $summary]);
	// return $keluar;
});

Route::get('/print/keluar', function (Request $request) {
	$periode = array('start' => $request->query('start'), 'end' => $request->query('end'));
	$from = date($periode['start']);
	$to = date($periode['end']);

	$keluar = Keluar::join('barangs', 'barangs.sub_id', '=', 'keluars.sub_id')->whereBetween('tgl_keluar', [$from, $to])->get(['tgl_keluar', 'barcode', 'uraian', 'jumlah', 'harga_satuan', 'keterangan']);

	$no = 1;
	$jumlah_ = 0;
	$total_ = 0;
	$harga_satuan_ = 0;

	foreach ($keluar as &$key) {
		$key['no'] = $no++;
		$jumlah_ = $jumlah_ + $key['jumlah'];
		$total_ = $total_ + ($key['jumlah'] * $key['harga_satuan']);
		$harga_satuan_ = $harga_satuan_ + $key['harga_satuan'];

		//formatting
		$key['tgl_keluar'] = Carbon::parse($key['tgl_keluar'])->format('d-m-Y');
		$key['total'] = number_format($key['jumlah'] * $key['harga_satuan'], 2);
		$key['harga_satuan'] = number_format($key['harga_satuan'], 2);
	}

	$header = array(
		['No', 'no'],
		['Tanggal', 'tgl_keluar'],
		['Barcode', 'barcode'],
		['Uraian', 'uraian'],
		['Jumlah', 'jumlah'],
		['Harga Satuan', 'harga_satuan'],
		['Total', 'total'],
		['Keterangan', 'keterangan'],
	);

	$judul = 'PERIODE ' . Carbon::parse($from)->format('d F Y') . ' S/D ' . Carbon::parse($to)->format('d F Y');
	$summary = ['jumlah' => $jumlah_, 'harga_satuan' => number_format($harga_satuan_, 2), 'total' => number_format($total_, 2)];

	$pdf = PDF::loadview('keluar', ['data' => $keluar, 'header' => $header, 'periode' => $judul, 'summary' => $summary]);
	return $pdf->inline();

	// return $keluar;
});

Route::get('/preview/kartustok', function (Request $request) {
	$periode = array('start' => $request->query('start'), 'end' => $request->query('end'));
	$periode_start = $periode['start'];
	$barcode = $request->query('barcode');
	$brg = Barang::where('barcode', '=', $barcode)->get()[0];
	$nama_barang = $brg->uraian;
	$harga_satuan = $brg->harga_satuan;

	$from = date($periode['start']);
	$to = date($periode['end']);

	$awal = Barang::selectRaw("stok,barangs.sub_id,barangs.barcode,barangs.harga_satuan, (SELECT SUM(jumlah) from masuks WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '$periode_start' ) as jml_msk, (SELECT SUM(jumlah) from keluars WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '$periode_start' ) as jml_klr")
		->where('barcode', $barcode)
		->get();
	// return response([$awal]);

	$masuk = Masuk::join('barangs', 'barangs.sub_id', '=', 'masuks.sub_id')
		->where('barcode', $barcode)
		->whereBetween('tgl_masuk', [$from, $to])
		->get(['tgl_masuk', 'barcode', 'uraian', 'jumlah', 'harga_satuan', 'keterangan']);

	$keluar = Keluar::join('barangs', 'barangs.sub_id', '=', 'keluars.sub_id')
		->where('barcode', $barcode)
		->whereBetween('tgl_keluar', [$from, $to])
		->get(['tgl_keluar', 'barcode', 'uraian', 'jumlah', 'harga_satuan', 'keterangan']);

	// return response([$awal,$masuk,$keluar]);

	$masuk_arr = json_decode(json_encode($masuk), true);
	foreach ($masuk_arr as &$key) {
		$key['tgl'] = $key['tgl_masuk'];
		$key['type'] = 'masuk';
	}

	$keluar_arr = json_decode(json_encode($keluar), true);
	foreach ($keluar_arr as &$key) {
		$key['tgl'] = $key['tgl_keluar'];
		$key['type'] = 'keluar';
	}

	$masuk_keluar = collect(array_merge($masuk_arr, $keluar_arr));
	$sorted = ($masuk_keluar->sortBy('tgl'))->values()->all();
	// $sorted = $sorted->toArray();
	// return response([$sorted]);

	$header = array(
		['No', 'no'],
		['Tanggal', 'tgl'],
		['Uraian', 'uraian'],
		['Jumlah', 'awal_jumlah'],
		['Harga', 'awal_rupiah'],
		['Pengeluaran', 'keluar'],
		['Jumlah', 'saldo_jumlah'],
		['Rupiah', 'saldo_rupiah'],
		// ['paraf', 'paraf']
	);

	$kartu_stok = [];

	$defs = array(
		'no' => '1',
		'tgl' => '',
		'uraian' => '',
		'awal_jumlah' => 0,
		'awal_rupiah' => 0,
		'keluar' => 0,
		'saldo_jumlah' => 0,
		'saldo_rupiah' => 0,
		'paraf' => '',
	);

	//awal
	$no = 1;
	$saldo_jumlah__ = 0;
	$saldo_rupiah__ = 0;
	foreach ($awal as $key) {
		$tmp_rupiah = ($key['jml_msk'] + $key['stok']) * $key['harga_satuan'];
		$tmp_jumlah = $key['jml_msk'] + $key['stok'] - $key['jml_klr'];
		$saldo_jumlah__ = $saldo_jumlah__ + 0 + $tmp_jumlah;
		$saldo_rupiah__ = $saldo_rupiah__ + ($tmp_jumlah * $key['harga_satuan']);

		$kartu_stok[] = array(
			'no' => $no++,
			'tgl' => Carbon::parse($periode_start)->format('d-m-Y'),
			'uraian' => "Saldo Awal ({$key['sub_id']})",
			'awal_jumlah' => $tmp_jumlah,
			'awal_rupiah' => number_format($key['harga_satuan'], 1),
			'keluar' => '-',
			'saldo_jumlah' => $saldo_jumlah__,
			'saldo_rupiah' => number_format($saldo_rupiah__, 1),
			// 'paraf' => ''
		);
	}
	// return response([$sorted]);
	//data
	foreach ($sorted as $key) {
		// $tmp_rupiah = ($key['jumlah'] * $key['harga_satuan']);
		// $tmp_jumlah = $key['jumlah']-$key['jml_klr'];
		if ($key['type'] == 'keluar') {
			$add = -$key['jumlah'];
		}
		if ($key['type'] == 'masuk') {
			$add = $key['jumlah'];
		}

		$saldo_jumlah__ = $saldo_jumlah__ + $add;
		$saldo_rupiah__ = $saldo_rupiah__ + ($add * $key['harga_satuan']);

		$kartu_stok[] = array(
			'no' => $no++,
			'tgl' => Carbon::parse($key['tgl'])->format('d-m-Y'),
			'uraian' => $key['keterangan'],
			'awal_jumlah' => ($key['type'] == 'masuk') ? $key['jumlah'] : '-',
			'awal_rupiah' => number_format($key['harga_satuan'], 1),
			'keluar' => ($key['type'] == 'keluar') ? $key['jumlah'] : '-',
			'saldo_jumlah' => $saldo_jumlah__,
			'saldo_rupiah' => number_format($saldo_rupiah__, 1),
			// 'paraf' => ''
		);
	}

	$judul = 'PERIODE ' . Carbon::parse($from)->format('d F Y') . ' S/D ' . Carbon::parse($to)->format('d F Y');

	return view(
		'kartustok',
		[
			'data' => $kartu_stok,
			'header' => $header,
			'periode' => $judul,
			'barcode' => $barcode,
			'nama_barang' => $nama_barang,

		]

	);
	// return $keluar;
});

Route::get('/print/kartustok', function (Request $request) {
	$periode = array('start' => $request->query('start'), 'end' => $request->query('end'));
	$periode_start = $periode['start'];
	$barcode = $request->query('barcode');
	$brg = Barang::where('barcode', '=', $barcode)->get()[0];
	$nama_barang = $brg->uraian;
	$harga_satuan = $brg->harga_satuan;

	$from = date($periode['start']);
	$to = date($periode['end']);

	$awal = Barang::selectRaw("barangs.stok,barangs.sub_id,barangs.barcode,barangs.harga_satuan, (SELECT SUM(jumlah) from masuks WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '$periode_start' ) as jml_msk, (SELECT SUM(jumlah) from keluars WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '$periode_start' ) as jml_klr")
		->where('barcode', $barcode)
		->get();
	// return response([$awal]);

	$masuk = Masuk::join('barangs', 'barangs.sub_id', '=', 'masuks.sub_id')
		->where('barcode', $barcode)
		->whereBetween('tgl_masuk', [$from, $to])
		->get(['tgl_masuk', 'barcode', 'uraian', 'jumlah', 'harga_satuan', 'keterangan']);

	$keluar = Keluar::join('barangs', 'barangs.sub_id', '=', 'keluars.sub_id')
		->where('barcode', $barcode)
		->whereBetween('tgl_keluar', [$from, $to])
		->get(['tgl_keluar', 'barcode', 'uraian', 'jumlah', 'harga_satuan', 'keterangan']);

	// return response([$awal,$masuk,$keluar]);

	$masuk_arr = json_decode(json_encode($masuk), true);
	foreach ($masuk_arr as &$key) {
		$key['tgl'] = $key['tgl_masuk'];
		$key['type'] = 'masuk';
	}

	$keluar_arr = json_decode(json_encode($keluar), true);
	foreach ($keluar_arr as &$key) {
		$key['tgl'] = $key['tgl_keluar'];
		$key['type'] = 'keluar';
	}

	$masuk_keluar = collect(array_merge($masuk_arr, $keluar_arr));
	$sorted = ($masuk_keluar->sortBy('tgl'))->values()->all();
	// $sorted = $sorted->toArray();
	// return response([$sorted]);

	$header = array(
		['No', 'no'],
		['Tanggal', 'tgl'],
		['Uraian', 'uraian'],
		['Jumlah', 'awal_jumlah'],
		['Harga', 'awal_rupiah'],
		['Pengeluaran', 'keluar'],
		['Jumlah', 'saldo_jumlah'],
		['Rupiah', 'saldo_rupiah'],
		// ['paraf', 'paraf']
	);

	$kartu_stok = [];

	$defs = array(
		'no' => '1',
		'tgl' => '',
		'uraian' => '',
		'awal_jumlah' => 0,
		'awal_rupiah' => 0,
		'keluar' => 0,
		'saldo_jumlah' => 0,
		'saldo_rupiah' => 0,
		'paraf' => '',
	);

	//awal
	$no = 1;
	$saldo_jumlah__ = 0;
	$saldo_rupiah__ = 0;
	foreach ($awal as $key) {
		$tmp_rupiah = ($key['jml_msk'] + $key['stok']) * $key['harga_satuan'];
		$tmp_jumlah = $key['jml_msk'] + $key['stok'] - $key['jml_klr'];
		$saldo_jumlah__ = $saldo_jumlah__ + 0 + $tmp_jumlah;
		$saldo_rupiah__ = $saldo_rupiah__ + ($tmp_jumlah * $key['harga_satuan']);

		$kartu_stok[] = array(
			'no' => $no++,
			'tgl' => Carbon::parse($periode_start)->format('d-m-Y'),
			'uraian' => "Saldo Awal ({$key['sub_id']})",
			'awal_jumlah' => $tmp_jumlah,
			'awal_rupiah' => number_format($key['harga_satuan'], 1),
			'keluar' => '-',
			'saldo_jumlah' => $saldo_jumlah__,
			'saldo_rupiah' => number_format($saldo_rupiah__, 1),
			// 'paraf' => ''
		);
	}
	// return response([$sorted]);
	//data
	foreach ($sorted as $key) {
		// $tmp_rupiah = ($key['jumlah'] * $key['harga_satuan']);
		// $tmp_jumlah = $key['jumlah']-$key['jml_klr'];
		if ($key['type'] == 'keluar') {
			$add = -$key['jumlah'];
		}
		if ($key['type'] == 'masuk') {
			$add = $key['jumlah'];
		}

		$saldo_jumlah__ = $saldo_jumlah__ + $add;
		$saldo_rupiah__ = $saldo_rupiah__ + ($add * $key['harga_satuan']);

		$kartu_stok[] = array(
			'no' => $no++,
			'tgl' => Carbon::parse($key['tgl'])->format('d-m-Y'),
			'uraian' => $key['keterangan'],
			'awal_jumlah' => ($key['type'] == 'masuk') ? $key['jumlah'] : '-',
			'awal_rupiah' => number_format($key['harga_satuan'], 1),
			'keluar' => ($key['type'] == 'keluar') ? $key['jumlah'] : '-',
			'saldo_jumlah' => $saldo_jumlah__,
			'saldo_rupiah' => number_format($saldo_rupiah__, 1),
			// 'paraf' => ''
		);
	}

	$judul = 'PERIODE ' . Carbon::parse($from)->format('d F Y') . ' S/D ' . Carbon::parse($to)->format('d F Y');

	$pdf = PDF::loadview('kartustok', [
		'data' => $kartu_stok,
		'header' => $header,
		'periode' => $judul,
		'barcode' => $barcode,
		'nama_barang' => $nama_barang,

	]);
	return $pdf->inline();

	// return $keluar;
});

Route::get('/preview/rincianstok', function (Request $request) {
	$periode = array('start' => $request->query('start'), 'end' => $request->query('end'));
	$periode_start = $periode['start'];
	// $barcode = $request->query('barcode');
	// $brg = Barang::where('barcode', '=', $barcode)->get()[0];
	// $nama_barang = $brg->nama_barang;
	// $harga_satuan = $brg->harga_satuan;

	$from = date($periode['start']);
	$to = date($periode['end']);

	// $awal = Barang::selectRaw("*, (SELECT SUM(jumlah) from masuks WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '$periode_start' ) as jml_msk, (SELECT SUM(jumlah) from keluars WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '$periode_start' ) as jml_klr")
	// ->groupBy('jml_msk')

	// ->where('',$barcode)
	// ->get();
	// $awal = DB::select("SELECT *, (SELECT SUM(jumlah) from masuks WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '2022-08-01' ) as jml_msk, (SELECT SUM(jumlah) from keluars WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '2022-08-01' ) as jml_klr FROM barangs GROUP BY jml_msk,jml_klr HAVING jml_msk>0 OR jml_klr>0");

	$awal = DB::select("SELECT *,SUM(jml_msk) as jumlah_masuk,SUM(total_msk) as total_masuk,SUM(jml_klr) as jumlah_keluar,SUM(total_klr) as total_keluar FROM (SELECT *,(SELECT SUM(jumlah) from masuks
			WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '{$periode_start}' ) as jml_msk,
			(SELECT SUM(jumlah*harga_satuan) from masuks
			WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '{$periode_start}' ) as total_msk,
 			(SELECT SUM(jumlah) from keluars
			WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '{$periode_start}' ) as jml_klr,
			(SELECT SUM(jumlah*harga_satuan) from keluars
			WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '{$periode_start}' ) as total_klr
  			FROM barangs
			HAVING jml_msk>0 OR jml_klr>0) AS b
			GROUP BY barcode");

	// return response($awal);

	// $cat = DB::select("SELECT id_category,category FROM (SELECT *, (SELECT SUM(jumlah) from masuks WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '2022-08-01' ) as jml_msk, (SELECT SUM(jumlah) from keluars WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '2022-08-01' ) as jml_klr FROM barangs GROUP BY jml_msk,jml_klr HAVING jml_msk>0 OR jml_klr>0) AS b GROUP BY id_category");
	$arr = [];
	// $nop = 0;
	foreach ($awal as $item) {
		$arr[$item->category][$item->nama_barang][$item->uraian]['barcode'] = $item->barcode;
		$arr[$item->category][$item->nama_barang][$item->uraian]['uraian'] = $item->uraian;
		$arr[$item->category][$item->nama_barang][$item->uraian]['awal_jumlah'] = $item->jumlah_masuk - $item->jumlah_keluar;
		$arr[$item->category][$item->nama_barang][$item->uraian]['awal_rupiah'] = $item->total_masuk - $item->total_keluar;
		// $nop++;
	}
	// return $nop;
	// return response($arr);

	$masuk = DB::select("SELECT *,SUM(jumlah) AS jumlah_masuk,SUM(total) AS total_masuk FROM (SELECT barcode,uraian,jumlah,harga_satuan,category,nama_barang,(harga_satuan*jumlah)AS total from masuks
		JOIN barangs on barangs.sub_id=masuks.sub_id
		WHERE (masuks.tgl_masuk BETWEEN '{$from}' AND '{$to}') ) AS b
		GROUP BY barcode
");

	$keluar = DB::select("SELECT *,SUM(jumlah) AS jumlah_keluar,SUM(total) AS total_keluar FROM (SELECT barcode,uraian,jumlah,harga_satuan,category,nama_barang,(harga_satuan*jumlah)AS total from keluars
		JOIN barangs on barangs.sub_id=keluars.sub_id
		WHERE (keluars.tgl_keluar BETWEEN '{$from}' AND '{$to}') ) AS b
		GROUP BY barcode
");

	foreach ($masuk as $item) {
		$arr[$item->category][$item->nama_barang][$item->uraian]['barcode'] = $item->barcode;
		$arr[$item->category][$item->nama_barang][$item->uraian]['uraian'] = $item->uraian;
		$arr[$item->category][$item->nama_barang][$item->uraian]['penerimaan'] = $item->jumlah_masuk;
		$arr[$item->category][$item->nama_barang][$item->uraian]['total_penerimaan'] = $item->total_masuk;

	}

	foreach ($keluar as $item) {
		$arr[$item->category][$item->nama_barang][$item->uraian]['barcode'] = $item->barcode;
		$arr[$item->category][$item->nama_barang][$item->uraian]['uraian'] = $item->uraian;
		$arr[$item->category][$item->nama_barang][$item->uraian]['pengeluaran'] = $item->jumlah_keluar;
		$arr[$item->category][$item->nama_barang][$item->uraian]['total_pengeluaran'] = $item->total_keluar;

	}

	$kartu_stok = [];
	$grandtotal = [
		'awal_jumlah' => 0,
		'awal_rupiah' => 0,
		'jumlah_masuk' => 0,
		'jumlah_keluar' => 0,
		'subjumlah' => 0,
		'subtotal' => 0,

	];

	$category_total = [];
	$jenis_barang_total = [];
	$row = -1;
	foreach ($arr as &$key1) {
		$kartu_stok[] = array(
			'barcode' => '',
			'uraian' => array_search($key1, $arr),
			'awal_jumlah' => '',
			'awal_rupiah' => '',
			'jumlah_masuk' => '',
			'jumlah_keluar' => '',
			'subjumlah' => '',
			'subtotal' => '',

		);

		$row += 1;

		$category_total[array_search($key1, $arr)]['value'] = 0;
		$category_total[array_search($key1, $arr)]['row'] = $row;

		foreach ($key1 as &$key2) {
			$kartu_stok[] = array(
				'barcode' => '',
				'uraian' => array_search($key2, $key1),
				'awal_jumlah' => '',
				'awal_rupiah' => '',
				'jumlah_masuk' => '',
				'jumlah_keluar' => '',
				'subjumlah' => '',
				'subtotal' => '',

			);
			$row += 1;

			$jenis_barang_total[array_search($key2, $key1)]['value'] = 0;
			$jenis_barang_total[array_search($key2, $key1)]['row'] = $row;

			foreach ($key2 as &$key3) {
				if (!isset($key3['awal_jumlah'])) {
					$key3['awal_jumlah'] = 0;
				}

				if (!isset($key3['penerimaan'])) {
					$key3['penerimaan'] = 0;
				}

				if (!isset($key3['pengeluaran'])) {
					$key3['pengeluaran'] = 0;
				}

				if (!isset($key3['awal_rupiah'])) {
					$key3['awal_rupiah'] = 0;
				}

				if (!isset($key3['total_penerimaan'])) {
					$key3['total_penerimaan'] = 0;
				}

				if (!isset($key3['total_pengeluaran'])) {
					$key3['total_pengeluaran'] = 0;
				}

				$key3['sisa_jumlah'] = $key3['awal_jumlah'] + $key3['penerimaan'] - $key3['pengeluaran'];
				$key3['sisa_rupiah'] = $key3['awal_rupiah'] + $key3['total_penerimaan'] - $key3['total_pengeluaran'];

				$grandtotal['awal_jumlah'] += $key3['awal_jumlah'];
				$grandtotal['awal_rupiah'] += $key3['awal_rupiah'];
				$grandtotal['jumlah_masuk'] += $key3['penerimaan'];
				$grandtotal['jumlah_keluar'] += $key3['pengeluaran'];
				$grandtotal['subjumlah'] += $key3['sisa_jumlah'];
				$grandtotal['subtotal'] += $key3['sisa_rupiah'];

				$category_total[array_search($key1, $arr)]['value'] += $key3['sisa_rupiah'];
				$jenis_barang_total[array_search($key2, $key1)]['value'] += $key3['sisa_rupiah'];

				$kartu_stok[] = array(
					'barcode' => $key3['barcode'],
					'uraian' => $key3['uraian'],
					'awal_jumlah' => $key3['awal_jumlah'],
					'awal_rupiah' => number_format($key3['awal_rupiah'], 1),
					'jumlah_masuk' => $key3['penerimaan'],
					'jumlah_keluar' => $key3['pengeluaran'],
					'subjumlah' => $key3['sisa_jumlah'],
					'subtotal' => number_format($key3['sisa_rupiah'], 1),

				);
				$row += 1;

			}

		}
	}

	//grand total
	$kartu_stok[] = array(
		'barcode' => '',
		'uraian' => 'Grand Total',
		'awal_jumlah' => $grandtotal['awal_jumlah'],
		'awal_rupiah' => number_format($grandtotal['awal_rupiah'], 1),
		'jumlah_masuk' => $grandtotal['jumlah_masuk'],
		'jumlah_keluar' => $grandtotal['jumlah_keluar'],
		'subjumlah' => $grandtotal['subjumlah'],
		'subtotal' => number_format($grandtotal['subtotal'], 1),

	);

	foreach ($category_total as $item) {
		$kartu_stok[$item['row']]['subtotal'] = number_format($item['value'], 1);
	}

	foreach ($jenis_barang_total as $item) {
		$kartu_stok[$item['row']]['subtotal'] = number_format($item['value'], 1);
	}

	// return response([$awal, $arr, $kartu_stok]);

	$header = array(
		['Barcode', 'barcode'],
		['Uraian', 'uraian'],
		['Jumlah', 'awal_jumlah'],
		['Rupiah', 'awal_rupiah'],
		['Penerimaan', 'jumlah_masuk'],
		['Pengeluaran', 'jumlah_keluar'],
		['Jumlah', 'subjumlah'],
		['Rupiah', 'subtotal'],
		// ['paraf', 'paraf']
	);

	$judul = 'PERIODE ' . Carbon::parse($from)->format('d F Y') . ' S/D ' . Carbon::parse($to)->format('d F Y');

	// return response([$category_total, $jenis_barang_total, $kartu_stok]);
	return view(
		'previewrincianstok',
		[
			'data' => $kartu_stok,
			'header' => $header,
			'periode' => $judul,

		]

	);

	// $pdf = PDF::loadview('kartustok',['data' => $kartu_stok,
	// 		'header' => $header,
	// 		'periode' => $judul,
	// 		'barcode' => $barcode,
	// 		'nama_barang' => $nama_barang,

	// 	]);
	// return $pdf->inline();

});

Route::get('/print/rincianstok', function (Request $request) {
	$periode = array('start' => $request->query('start'), 'end' => $request->query('end'));
	$periode_start = $periode['start'];
	// $barcode = $request->query('barcode');
	// $brg = Barang::where('barcode', '=', $barcode)->get()[0];
	// $nama_barang = $brg->nama_barang;
	// $harga_satuan = $brg->harga_satuan;

	$from = date($periode['start']);
	$to = date($periode['end']);

	// $awal = Barang::selectRaw("*, (SELECT SUM(jumlah) from masuks WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '$periode_start' ) as jml_msk, (SELECT SUM(jumlah) from keluars WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '$periode_start' ) as jml_klr")
	// ->groupBy('jml_msk')

	// ->where('',$barcode)
	// ->get();
	// $awal = DB::select("SELECT *, (SELECT SUM(jumlah) from masuks WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '2022-08-01' ) as jml_msk, (SELECT SUM(jumlah) from keluars WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '2022-08-01' ) as jml_klr FROM barangs GROUP BY jml_msk,jml_klr HAVING jml_msk>0 OR jml_klr>0");

	$awal = DB::select("SELECT *,
IFNULL(SUM(jml_msk),0) as jumlah_masuk,IFNULL(SUM(total_msk),0) as total_masuk,
IFNULL(SUM(jml_klr),0) as jumlah_keluar,IFNULL(SUM(total_klr),0) as total_keluar
	FROM (SELECT *,(SELECT IFNULL(SUM(jumlah),0) from masuks
			WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '{$periode_start}' )+stok as jml_msk,
			(SELECT IFNULL(SUM(jumlah*harga_satuan),0) from masuks
			WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '{$periode_start}' )+(stok*harga_satuan) as total_msk,
 			(SELECT IFNULL(SUM(jumlah),0) from keluars
			WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '{$periode_start}' ) as jml_klr,
			(SELECT IFNULL(SUM(jumlah*harga_satuan),0) from keluars
			WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '{$periode_start}' ) as total_klr
  			FROM barangs
			HAVING barangs.stok>0 OR jml_msk>0 OR jml_klr>0) AS b
GROUP BY barcode");

	// return response($awal);

	// $cat = DB::select("SELECT id_category,category FROM (SELECT *, (SELECT SUM(jumlah) from masuks WHERE masuks.sub_id=barangs.sub_id AND DATE(masuks.tgl_masuk) < '2022-08-01' ) as jml_msk, (SELECT SUM(jumlah) from keluars WHERE keluars.sub_id=barangs.sub_id AND DATE(keluars.tgl_keluar) < '2022-08-01' ) as jml_klr FROM barangs GROUP BY jml_msk,jml_klr HAVING jml_msk>0 OR jml_klr>0) AS b GROUP BY id_category");
	$arr = [];
	// $nop = 0;
	foreach ($awal as $item) {
		$arr[$item->category][$item->nama_barang][$item->uraian]['barcode'] = $item->barcode;
		$arr[$item->category][$item->nama_barang][$item->uraian]['uraian'] = $item->uraian;
		$arr[$item->category][$item->nama_barang][$item->uraian]['awal_jumlah'] = $item->jumlah_masuk - $item->jumlah_keluar;
		$arr[$item->category][$item->nama_barang][$item->uraian]['awal_rupiah'] = $item->total_masuk - $item->total_keluar;
		// $nop++;
	}
	// return $nop;
	// return response($arr);

	$masuk = DB::select("SELECT *,SUM(jumlah) AS jumlah_masuk,SUM(total) AS total_masuk FROM (SELECT barcode,uraian,jumlah,harga_satuan,category,nama_barang,(harga_satuan*jumlah)AS total from masuks
		JOIN barangs on barangs.sub_id=masuks.sub_id
		WHERE (masuks.tgl_masuk BETWEEN '{$from}' AND '{$to}') ) AS b
		GROUP BY barcode
");

	$keluar = DB::select("SELECT *,SUM(jumlah) AS jumlah_keluar,SUM(total) AS total_keluar FROM (SELECT barcode,uraian,jumlah,harga_satuan,category,nama_barang,(harga_satuan*jumlah)AS total from keluars
		JOIN barangs on barangs.sub_id=keluars.sub_id
		WHERE (keluars.tgl_keluar BETWEEN '{$from}' AND '{$to}') ) AS b
		GROUP BY barcode
");

	foreach ($masuk as $item) {
		$arr[$item->category][$item->nama_barang][$item->uraian]['barcode'] = $item->barcode;
		$arr[$item->category][$item->nama_barang][$item->uraian]['uraian'] = $item->uraian;
		$arr[$item->category][$item->nama_barang][$item->uraian]['penerimaan'] = $item->jumlah_masuk;
		$arr[$item->category][$item->nama_barang][$item->uraian]['total_penerimaan'] = $item->total_masuk;

	}

	foreach ($keluar as $item) {
		$arr[$item->category][$item->nama_barang][$item->uraian]['barcode'] = $item->barcode;
		$arr[$item->category][$item->nama_barang][$item->uraian]['uraian'] = $item->uraian;
		$arr[$item->category][$item->nama_barang][$item->uraian]['pengeluaran'] = $item->jumlah_keluar;
		$arr[$item->category][$item->nama_barang][$item->uraian]['total_pengeluaran'] = $item->total_keluar;

	}

	$kartu_stok = [];
	$grandtotal = [
		'awal_jumlah' => 0,
		'awal_rupiah' => 0,
		'jumlah_masuk' => 0,
		'jumlah_keluar' => 0,
		'subjumlah' => 0,
		'subtotal' => 0,

	];

	$category_total = [];
	$jenis_barang_total = [];
	$row = -1;
	foreach ($arr as &$key1) {
		$kartu_stok[] = array(
			'barcode' => '',
			'uraian' => array_search($key1, $arr),
			'awal_jumlah' => '',
			'awal_rupiah' => '',
			'jumlah_masuk' => '',
			'jumlah_keluar' => '',
			'subjumlah' => '',
			'subtotal' => '',

		);

		$row += 1;

		$category_total[array_search($key1, $arr)]['value'] = 0;
		$category_total[array_search($key1, $arr)]['row'] = $row;

		foreach ($key1 as &$key2) {
			$kartu_stok[] = array(
				'barcode' => '',
				'uraian' => array_search($key2, $key1),
				'awal_jumlah' => '',
				'awal_rupiah' => '',
				'jumlah_masuk' => '',
				'jumlah_keluar' => '',
				'subjumlah' => '',
				'subtotal' => '',

			);
			$row += 1;

			$jenis_barang_total[array_search($key2, $key1)]['value'] = 0;
			$jenis_barang_total[array_search($key2, $key1)]['row'] = $row;

			foreach ($key2 as &$key3) {
				if (!isset($key3['awal_jumlah'])) {
					$key3['awal_jumlah'] = 0;
				}

				if (!isset($key3['penerimaan'])) {
					$key3['penerimaan'] = 0;
				}

				if (!isset($key3['pengeluaran'])) {
					$key3['pengeluaran'] = 0;
				}

				if (!isset($key3['awal_rupiah'])) {
					$key3['awal_rupiah'] = 0;
				}

				if (!isset($key3['total_penerimaan'])) {
					$key3['total_penerimaan'] = 0;
				}

				if (!isset($key3['total_pengeluaran'])) {
					$key3['total_pengeluaran'] = 0;
				}

				$key3['sisa_jumlah'] = $key3['awal_jumlah'] + $key3['penerimaan'] - $key3['pengeluaran'];
				$key3['sisa_rupiah'] = $key3['awal_rupiah'] + $key3['total_penerimaan'] - $key3['total_pengeluaran'];

				$grandtotal['awal_jumlah'] += $key3['awal_jumlah'];
				$grandtotal['awal_rupiah'] += $key3['awal_rupiah'];
				$grandtotal['jumlah_masuk'] += $key3['penerimaan'];
				$grandtotal['jumlah_keluar'] += $key3['pengeluaran'];
				$grandtotal['subjumlah'] += $key3['sisa_jumlah'];
				$grandtotal['subtotal'] += $key3['sisa_rupiah'];

				$category_total[array_search($key1, $arr)]['value'] += $key3['sisa_rupiah'];
				$jenis_barang_total[array_search($key2, $key1)]['value'] += $key3['sisa_rupiah'];

				$kartu_stok[] = array(
					'barcode' => $key3['barcode'],
					'uraian' => $key3['uraian'],
					'awal_jumlah' => $key3['awal_jumlah'],
					'awal_rupiah' => number_format($key3['awal_rupiah'], 1),
					'jumlah_masuk' => $key3['penerimaan'],
					'jumlah_keluar' => $key3['pengeluaran'],
					'subjumlah' => $key3['sisa_jumlah'],
					'subtotal' => number_format($key3['sisa_rupiah'], 1),

				);
				$row += 1;

			}

		}
	}

	//grand total
	$kartu_stok[] = array(
		'barcode' => '',
		'uraian' => 'Grand Total',
		'awal_jumlah' => $grandtotal['awal_jumlah'],
		'awal_rupiah' => number_format($grandtotal['awal_rupiah'], 1),
		'jumlah_masuk' => $grandtotal['jumlah_masuk'],
		'jumlah_keluar' => $grandtotal['jumlah_keluar'],
		'subjumlah' => $grandtotal['subjumlah'],
		'subtotal' => number_format($grandtotal['subtotal'], 1),

	);

	foreach ($category_total as $item) {
		$kartu_stok[$item['row']]['subtotal'] = number_format($item['value'], 1);
	}

	foreach ($jenis_barang_total as $item) {
		$kartu_stok[$item['row']]['subtotal'] = number_format($item['value'], 1);
	}

	// return response([$awal, $arr, $kartu_stok]);

	$header = array(
		['Barcode', 'barcode'],
		['Uraian', 'uraian'],
		['Jumlah', 'awal_jumlah'],
		['Rupiah', 'awal_rupiah'],
		['Penerimaan', 'jumlah_masuk'],
		['Pengeluaran', 'jumlah_keluar'],
		['Jumlah', 'subjumlah'],
		['Rupiah', 'subtotal'],
		// ['paraf', 'paraf']
	);

	$judul = 'PERIODE ' . Carbon::parse($from)->format('d F Y') . ' S/D ' . Carbon::parse($to)->format('d F Y');

	// return response([$category_total, $jenis_barang_total, $kartu_stok]);
	// return view(
	// 	'rincianstok',
	// 	[
	// 		'data' => $kartu_stok,
	// 		'header' => $header,
	// 		'periode' => $judul,

	// 	]

	// );

	$pdf = PDF::loadview('rincianstok',
		[
			'data' => $kartu_stok,
			'header' => $header,
			'periode' => $judul,

		]);
	return $pdf->inline();

});
