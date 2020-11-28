<?php 
	include "koneksi.php";
	//baca tabel status untuk mode absensi
	$sql = mysqli_query($konek, "select * from status");
	$data = mysqli_fetch_array($sql);
	$mode_absen = $data['mode'];

	//uji mode absen
	$mode = "";
	if($mode_absen==1)
		$mode = "Masuk";
	else if($mode_absen==2)
		$mode = "Istirahat";
	else if($mode_absen==3)
		$mode = "Kembali";
	else if($mode_absen==4)
		$mode = "Pulang";

	//baca tabel tmprfid
	$baca_kartu = mysqli_query($konek, "select * from tmprfid");
	$data_kartu = mysqli_fetch_array($baca_kartu);
	echo($data_kartu);
	$nokartu    = $data_kartu['nokartu'];
?>

<style>
	.container-fluid {
		color: white;
		text-align: center; 
		font-family: 'Spectral SC', serif; 
	}
	.container-fluid img {
		width: 200px;
		padding-top: 21px;
	}
</style>
<div class="container-fluid">
	<?php if($nokartu=="") { ?>

	<h3>Absen : <?php echo $mode; ?> </h3>
	<h3>Silahkan Tempelkan Kartu RFID Anda</h3>
	<img src="images/Logo/rfidw.png"> <br>
	<img src="images/Animasi/animasi99.gif">

	<?php } else {
		//cek nomor kartu RFID tersebut apakah terdaftar di tabel siswa
		$cari_siswa = mysqli_query($konek, "select * from siswa where nokartu='$nokartu'");
		$jumlah_data = mysqli_num_rows($cari_siswa);

		if($jumlah_data==0)
			echo "<h1>Maaf! Kartu Tidak Dikenali</h1>";
		else
		{
			//ambil nama siswa
			$data_siswa = mysqli_fetch_array($cari_siswa);
			$nama = $data_siswa['nama'];

			//tanggal dan jam hari ini
			date_default_timezone_set('Asia/Makassar') ;
			$tanggal = date('Y-m-d');
			$jam     = date('H:i:s');

			//cek di tabel absensi, apakah nomor kartu tersebut sudah ada sesuai tanggal saat ini. Apabila belum ada, maka dianggap absen masuk, tapi kalau sudah ada, maka update data sesuai mode absensi
			$cari_absen = mysqli_query($konek, "select * from absensi where nokartu='$nokartu' and tanggal='$tanggal'");
			//hitung jumlah datanya
			$jumlah_absen = mysqli_num_rows($cari_absen);
			if($jumlah_absen == 0)
			{
				echo "<h1>Selamat Datang <br> $nama</h1>";
				mysqli_query($konek, "insert into absensi(nokartu, tanggal, jam_masuk)values('$nokartu', '$tanggal', '$jam')");
			}
			else
			{
				//update sesuai pilihan mode absen
				if($mode_absen == 2)
				{
					echo "<h1>Selamat Istirahat <br> $nama</h1>";
					mysqli_query($konek, "update absensi set jam_istirahat='$jam' where nokartu='$nokartu' and tanggal='$tanggal'");
				}
				else if($mode_absen == 3)
				{
					echo "<h1>Selamat Datang Kembali <br> $nama</h1>";
					mysqli_query($konek, "update absensi set jam_kembali='$jam' where nokartu='$nokartu' and tanggal='$tanggal'");
				}
				else if($mode_absen == 4)
				{
					echo "<h1>Selamat Jalan <br> $nama</h1>";
					mysqli_query($konek, "update absensi set jam_pulang='$jam' where nokartu='$nokartu' and tanggal='$tanggal'");
				}
			}
		}

		//kosongkan tabel tmprfid
		mysqli_query($konek, "delete from tmprfid");
	} ?>

</div>