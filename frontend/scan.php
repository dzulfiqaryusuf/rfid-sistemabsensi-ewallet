<!DOCTYPE html>
<html>
<head >
	<?php include "header.php"; ?>
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
<body style="background-image: url(Background.jpg); background-size:cover; background-repeat: no-repeat;">

	<?php include "menu.php"; ?>

	<!-- isi -->
	<div class="container-fluid" style="padding-top: 10%">
		<div id="cekkartu"></div>
	</div>
	<br>

	<?php include "footer.php"; ?>

</body>
</html>