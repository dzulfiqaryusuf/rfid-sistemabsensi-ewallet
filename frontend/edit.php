<!-- proses penyimpanan -->

<?php 
	include "koneksi.php";

	//baca ID data yang akan di edit
	$id = $_GET['id'];

	//baca data siswa berdasarkan id
	$cari = mysqli_query($konek, "select * from siswa where id='$id'");
	$hasil = mysqli_fetch_array($cari);


	//jika tombol simpan diklik
	if(isset($_POST['btnSimpan']))
	{
		//baca isi inputan form
		$nokartu = $_POST['nokartu'];
		$nama    = $_POST['nama'];
		$alamat  = $_POST['kelas'];

		//simpan ke tabel karyawan
		$simpan = mysqli_query($konek, "update siswa set nokartu='$nokartu', nama='$nama', kelas='$kelas' where id='$id'");
		//jika berhasil tersimpan, tampilkan pesan Tersimpan,
		//kembali ke data siswa
		if($simpan)
		{
			echo "
				<script>
					alert('Tersimpan');
					location.replace('datasiswa.php');
				</script>
			";
		}
		else
		{
			echo "
				<script>
					alert('Gagal Tersimpan');
					location.replace('datasiswa.php');
				</script>
			";
		}

	}
?>

<!DOCTYPE html>
<html>
<head>
	<?php include "header.php"; ?>
	<title>Tambah Data Siswa</title>
</head>
<body>

	<?php include "menu.php"; ?>

	<!-- isi -->
	<div class="container-fluid">
		<h3>Tambah Data Siswa</h3>

		<!-- form input -->
		<form method="POST">
			<div class="form-group">
				<label>No.Kartu</label>
				<input type="text" name="nokartu" id="nokartu" placeholder="nomor kartu RFID" class="form-control" style="width: 200px" value="<?php echo $hasil['nokartu']; ?>">
			</div>
			<div class="form-group">
				<label>Nama Siswa</label>
				<input type="text" name="nama" id="nama" placeholder="nama siswa" class="form-control" style="width: 400px" value="<?php echo $hasil['nama']; ?>">
			</div>
			<div class="form-group">
				<label>Kelas</label>
				<textarea class="form-control" name="kelas" id="kelas" placeholder="kelas" style="width: 400px"><?php echo $hasil['kelas']; ?></textarea>
			</div>

			<button class="btn btn-primary" name="btnSimpan" id="btnSimpan">Simpan</button>
		</form>
	</div>

	<?php include "footer.php"; ?>

</body>
</html>