<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>

	<p><center>Bukti Pembayaran</center></p>

	<table class='table table-bordered' style="margin-top: 20px">
		<thead>
			<tr>
				<th>Order ID</th>
				<th>Lapangan</th>
				<th>waktu</th>
				<th>DP</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $bookings->order_id }}</td>
				<td>{{ $bookings->kode_lapangan }}</td>
				<td>{{ $bookings->jam }}</td>
				<td>{{ $bookings->dp }}</td>
			</tr>
		</tbody>
	</table>

</body>
</html>