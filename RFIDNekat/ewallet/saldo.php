<?php

include "koneksi.php";

mysqli_query($connect, "delete from tmprfid");
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/saldo.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Spectral+SC:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: url(images/Background/Background.jpg);
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
    <title> Isi Saldo</title>
    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(function() {
                $("#norfid").load('nokartu.php')
            }, 0); //pembacaan file nokartu.php, tiap 1 detik = 1000
        });
    </script>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="main">
        <h1>
            Isi Saldo
        </h1>
        <br>
        <?php
        if (isset($_POST["deposit"])) {
            $nokartu = $_POST['nokartu'];
            $deposit = $_POST['deposit'];
            $another_query = "UPDATE siswa SET saldo = saldo + $deposit WHERE nokartu = $nokartu";
            $another_result = mysqli_query($connect, $another_query);

            if ($another_result) {
                echo "
                    <script>
                        alert('Isi saldo sukses, Saldo anda telah ditambah sebanyak $deposit');
                        location.replace('saldo.php');
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Gagal Tersimpan');
                        location.replace('saldo.php');
                    </script>
                ";
            }
        }
        ?>
        <form method="post">
            <div class="form">
                <label> Tempelkan Kartu RFID Anda</label>
                <br>
                <!-- <input type="text" name="nokartu" id="nokartu" placeholder="Tempelkan kartu RFID Anda" class="form-control" style="width: 240px"> -->
                <div id="norfid"></div>
            </div>
            <div class="form">
                <label>Masukkan nominal untuk di deposit</label>
                <br>
                <input type="text" name="deposit" id="deposit" placeholder="Nominal untuk deposit" class="form-control" style="width: 205px"><input type="submit" name="btnDeposit" value="Submit">
            </div>
        </form>
    </div>
</body>

</html>