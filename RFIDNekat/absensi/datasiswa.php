<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/datasiswa.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Spectral+SC:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
	<title>Data Siswa</title>
	<style>
		body {
		background-image: url(images/Background/Background.jpg); 
		background-size:cover; 
		background-repeat: no-repeat;
		}
	</style>
</head>
<body>

	<?php include "navbar.php"; ?>

	<!--isi -->
	<div class="container-fluid">
		<h3>Data Siswa</h3>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No.</th>
					<th>No.Kartu</th>
					<th>Nama</th>
					<th>Kelas</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>

				<?php
					//koneksi ke database
					include "koneksi.php";

					//baca data siswa
					$sql = mysqli_query($konek, "select * from siswa");
					$no = 0;
					while($data = mysqli_fetch_array($sql))
					{
						$no++;
				?>

				<tr>
					<td> <?php echo $no; ?> </td>
					<td> <?php echo $data['nokartu']; ?> </td>
					<td> <?php echo $data['nama']; ?> </td>
					<td> <?php echo $data['kelas']; ?> </td>
					<td>
						<a href="edit.php?id=<?php echo $data['id']; ?>"> Edit</a> | <a href="hapus.php?id=<?php echo $data['id']; ?>"> Hapus</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<!-- tombol tambah data siswa-->
		<a href="tambah.php"> <button class="btn btn-primary">Tambah Data Siswa</button> </a>
	</div>

	<?php include "footer.php"; ?>

</body>
</html>