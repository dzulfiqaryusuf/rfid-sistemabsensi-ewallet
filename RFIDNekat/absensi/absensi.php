<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/absensi.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Spectral+SC:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
	<style> 
	body {
		background-image: url(images/Background/Background.jpg); 
		background-size:cover; 
		background-repeat: no-repeat;
	}
	@media screen and (max-width: 576px){
	.container-fluid .table thead tr th {
		vertical-align: middle;	
	}
}
	</style>
	<title>Rekap Absensi</title>
</head>
<body class="absen">
	<?php include "navbar.php"; ?>
	<!-- isi -->
	<div class="container-fluid">
		<h3>Rekap Absensi</h3>
		<table class="table table-bordered">
			<thead class="table-body">
				<tr>
					<th>No.</th>
					<th>Nama</th>
					<th>Tanggal</th>
					<th>Jam Masuk</th>
					<th>Jam Istirahat</th>
					<th>Jam Kembali</th>
					<th>Jam Pulang</th>
				</tr>
			</thead>
			<tbody>
				<?php
					include "koneksi.php";
					//baca tabel absensi dan relasikan dengan tabel siswa berdasarkan nomor kartu RFID untuk tanggal hari ini
					//baca tanggal saat ini
					date_default_timezone_set('Asia/Jakarta');
					$tanggal = date('Y-m-d');
					//filter absensi berdasarkan tanggal saat ini
					$sql = mysqli_query($konek, "select b.nama, a.tanggal, a.jam_masuk, a.jam_istirahat, a.jam_kembali, a.jam_pulang from absensi a, siswa b where a.nokartu=b.nokartu and a.tanggal='$tanggal'");
					$no = 0;
					while($data = mysqli_fetch_array($sql))
					{
						$no++;
				?>
				<tr>
					<td> <?php echo $no; ?> </td>
					<td> <?php echo $data['nama']; ?> </td>
					<td> <?php echo $data['tanggal']; ?> </td>
					<td> <?php echo $data['jam_masuk']; ?> </td>
					<td> <?php echo $data['jam_istirahat']; ?> </td>
					<td> <?php echo $data['jam_kembali']; ?> </td>
					<td> <?php echo $data['jam_pulang']; ?> </td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php include "footer.php"; ?>
<script type="text/javascript" src="jquery/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>