<?php
	include "koneksi.php";

	//baca nomor kartu 
	$nokartu = $_GET['nokartu'];
	//kosongkan tabel tmprfid
	mysqli_query($connect, "delete from tmprfid");

	//simpan nomor kartu yang baru ke tabel tmprfid
	$simpan = mysqli_query($connect, "insert into tmprfid(nokartu)values('$nokartu')");
	if($simpan)
		echo "Berhasil";
	else
		echo "Gagal";
?>