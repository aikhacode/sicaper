
	<link rel="stylesheet" href="{{ asset('css/bootstrap-4.6.2/css/bootstrap.min.css')}}">
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	.header{
		width:80%;
        margin-left: 10%;
        text-align: center;
	}
	.underline{
	text-decoration:underline;
	}

    .table{
        width:80%;

    }
    .table td {
        border:solid 1px black;
    }

    ol{
        padding-left: 12pt;
    }

    h5,p{
        margin:0;
    }
	h6{
		margin-left:10%;
	}
.deskripsi{
	margin-left:10%;
}
.deskripsi td {
        border:solid 1px black;

    }
table.deksripsi{
	width:80%;
}
table.deskripsi td {

}

.w-6rem{
	width:6rem;
}
.w-12rem{
	width:12rem;
}
.w-1-6rem{
	width:0.1rem;
}

.v-middle{
	vertical-align:middle!important;
}
.text-bold{
	font-weight: bold;
}


	</style>
	<div class="d-flex justify-content-center flex-column">

		<img class="header" src="{{ url('/images/header-pusk.jpg') }}"/>
		<h5 class=" text-center mb-2">LAPORAN RINCIAN PERSEDIAAN </h5>
		<h5 class="text-center mb-4">{{$periode}}</h5>



	<table class='mx-auto table '>

		<tbody>
		    <tr>
				<td rowspan="2" class="text-center  v-middle">
				  Barcode
				</td>
				<td rowspan="2" class="text-center v-middle">
				 Uraian
				</td>
				<td colspan="2" class="text-center v-middle">
				Stok Awal
				</td>
				<td rowspan="2" class="text-center v-middle">
				  Penerimaan
				</td>
				<td rowspan="2" class="text-center v-middle">
				  Pengeluaran
				</td>
				<td colspan="2" class="text-center v-middle">
				Sisa
				</td>


			</tr>
			<tr>
			<td>Jumlah</td>
			<td>Rupiah</td>
			<td>Jumlah Stok</td>
			<td>Rupiah</td>



			</tr>

			@foreach($data as $item)
			<tr>
				@foreach($header as $key)
				<td @class([
					'text-bold'=> $item['barcode']=="" ,
					'text-center' => ($key[1] != "awal_rupiah") && ($key[1] != "subtotal") && ($key[1] != "uraian"),
					'text-right' => ($key[1] == "awal_rupiah") || ($key[1] == "subtotal")
					])>

					{{$item[$key[1]]}}


				</td>
				@endforeach

			</tr>
			@endforeach




		</tbody>
	</table>

</div>

