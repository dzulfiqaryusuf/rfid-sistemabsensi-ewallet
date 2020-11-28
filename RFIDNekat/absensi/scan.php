<!DOCTYPE html>
<html>
<head >
	<?php include "header.php"; ?>
	<style>
		body {
			background-image: url(images/Background/Background.jpg); 
			background-size:cover;
			background-repeat: no-repeat;
		}
	</style>
	<title>Scan Kartu</title>

	<!-- scanning membaca kartu RFID -->
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval(function(){
				$("#cekkartu").load('bacakartu.php')
			}, 2000);
		});	
	</script>

</head>
<body>

	<?php include "navbar.php"; ?>

	<!-- isi -->
	<div class="container-fluid">
		<div id="cekkartu"></div>
	</div>
	<br>

	<?php include "footer.php"; ?>

</body>
</html>