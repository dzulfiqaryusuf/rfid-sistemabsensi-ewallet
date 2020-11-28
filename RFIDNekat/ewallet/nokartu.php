<?php
	include "koneksi.php";
	//baca isi tabel tmprfid
	$sql = mysqli_query($connect, "select * from tmprfid");
	$data = mysqli_fetch_array($sql);
	//baca nokartu
	$nokartu = $data['nokartu'];
?>
<style>
	.form-group input {
		width: 205px;
	}
</style>
<div class="form-group">
	<label>No.Kartu</label>
	<input type="text" name="nokartu" id="nokartu" placeholder="Tempelkan kartu RFID Anda" class="form-control" value="<?php echo $nokartu; ?>">
</div>