<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

	<meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<style>
	.fbutton{
		background-color: #F16125;
		color: #fff;
	}
</style>

<body>

	<div class="container">
		<h3>Hi, {{ $nama }}</h3>

		<p>Terimakasih telah menggunakan Fitgo</p>

		<p>Silahkan klik link berikut untuk melakukan verifikasi data</p>

		<p><center><a href="<?php echo url('/verifikasi/?q='.$link); ?>"><?php echo url('/verifikasi/?q='.$link); ?></a></center></p>

	</div>

</body>
</html>