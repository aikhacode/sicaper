<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPORAN STOK</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" /> -->
</head>
<body>
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

    h5{
        margin:0;
    }




	</style>
	<div class="d-flex justify-content-center flex-column">

		<img class="header" src="{{ url('/images/header-pusk.jpg') }}"/>
		<h5 class="underline text-center mb-4">LAPORAN SELURUH STOK </h5>

	<table class='mx-auto table '>

		<tbody>
			<tr>
				@foreach($header as $key)
				<td>{{ $key }}</td>
				@endforeach
			</tr>
			@foreach($data as $item)
			<tr>
				@foreach($header as $key)
				<td>{{ $item[$key] }}</td>
				@endforeach
			</tr>
			@endforeach



		</tbody>
	</table>

</div>

</body>
</html>