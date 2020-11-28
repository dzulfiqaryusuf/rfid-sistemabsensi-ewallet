<?php
session_start();

include "koneksi.php";


if (isset($_POST["add_to_cart"])) {
    if ($_POST["quantity"] == null) {
        echo "<script>alert('maaf anda harus memilih jumlah barang terlebih dahulu') </script>";
    } else {
        if (isset($_SESSION["shopping_cart"])) {
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            if (!in_array($_GET["id"], $item_array_id)) {
                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                    'item_id'            =>    $_GET["id"],
                    'item_name'            =>    $_POST["hidden_name"],
                    'item_price'        =>    $_POST["hidden_price"],
                    'item_quantity'        =>    $_POST["quantity"]
                );
                $_SESSION["shopping_cart"][$count] = $item_array;
            } else {
                echo '<script>alert("Item Already Added")</script>';
            }
        } else {
            $item_array = array(
                'item_id'            =>    $_GET["id"],
                'item_name'            =>    $_POST["hidden_name"],
                'item_price'        =>    $_POST["hidden_price"],
                'item_quantity'        =>    $_POST["quantity"]
            );
            $_SESSION["shopping_cart"][0] = $item_array;
        }
    }
}

if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                // echo '<script>alert("Item Removed")</script>';
                // echo '<script>window.location="belanja.php"</script>';
            }
        }
    }
}

mysqli_query($connect, "delete from tmprfid");
?>


<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/belanja.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Spectral+SC:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600&display=swap" rel="stylesheet">
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-image: url(images/Background/Background.jpg);
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
    <title> Belanja </title>
    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(function() {
                $("#norfid").load('nokartu.php')
            }, 0); //pembacaan file nokartu.php, tiap 1 detik = 1000
        });
    </script>
</head>

<body>
    <?php include "navbar2.php";
    $query = "SELECT * FROM tbl_product ORDER BY price ASC";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
    ?>
            <div class="col-md-4">
                <form action="belanja.php?action=add&id=<?php echo $row["id"]; ?>" method="POST">
                    <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
                        <img src="<?php echo $row["image"]; ?>" style="height:200px;">
                        <h4 class="text-info"><?php echo $row["name"]; ?></h4>
                        <h4 class="text-danger"><?php echo $row["price"]; ?></h4>
                        <input type="text" name="quantity" class="form-control" placeholder="masukkan banyak barang yang akan anda beli" />
                        <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
                        <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
                        <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
                    </div>
                </form>
            </div>
    <?php
        }
    }
    ?>
    <div style="clear:both"></div>
    <br />
    <h3>Detail Order</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th width="40%">Nama Barang</th>
                <th width="10%">Jumlah</th>
                <th width="20%">Harga</th>
                <th width="15%">Total Harga</th>
                <th width="5%">Action</th>
            </tr>
            <?php
            if (!empty($_SESSION["shopping_cart"])) {
                $total = 0;
                foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            ?>
                    <tr>
                        <td><?php echo $values["item_name"]; ?></td>
                        <td><?php echo $values["item_quantity"]; ?></td>
                        <td>Rp. <?php echo $values["item_price"]; ?></td>
                        <td>Rp. <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                        <td><a href="belanja.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                    </tr>
                <?php
                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                }
                ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right">Rp. <?php echo number_format($total, 2); ?></td>
                    <td></td>
                </tr>
            <?php
            }
            ?>

        </table>

    </div>
    </div>
    <?php
    if (isset($_POST["checkout"])) {
        $nokartu = $_POST['nokartu'];
        $another_query = "UPDATE siswa SET saldo = saldo - $total WHERE nokartu = $nokartu";
        $another_result = mysqli_query($connect, $another_query);

        if ($another_result) {
            echo "
            <script>
                alert('Checkout sukses, Saldo anda telah dikurang sebanyak $total');
                location.replace('belanja.php');
            </script>
        ";
        } else {
            echo "
            <script>
                alert('Gagal Tersimpan');
                location.replace('belanja.php');
            </script>
        ";
        }
    }
    ?>
    <form method="post">
        <div id="norfid"></div>
        <button type="submit" name="checkout" class="btn btn-primary">Checkout</button>
    </form>
    </div>
</body>

</html>