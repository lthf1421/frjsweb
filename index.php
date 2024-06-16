<?php
require "../koneksi.php";

$query = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($query);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$jumlahKategori = mysqli_num_rows($queryKategori);
$queryUkuran = mysqli_query($con, "SELECT * FROM ukuran");
$jumlahUkuran = mysqli_num_rows($queryUkuran);

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <script src="https://kit.fontawesome.com/296a2adfbf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    .summary-produk {
        background-color: #9eb99b;
        border-radius: 15px;
    }

    .summary-kategori {
        background-color: #DCDF77;
        border-radius: 15px;
    }

    .summary-ukuran {
        background-color: #A5B4C3;
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
            </ol>
        </nav>
        <h2>
            Halo, admin
        </h2>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="summary-produk p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa fa-box fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?php echo $jumlahProduk ?>Produk</p>
                                <p><a href="produk.php" class="text-white btn btn-success no-decoration fs-4">Lihat
                                        Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="summary-kategori p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-list fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?php echo $jumlahKategori ?> Kategori</p>
                                <p><a href="kategori.php" class="text-white btn btn-success no-decoration fs-4">Lihat
                                        Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-4">
                    <div class="summary-ukuran p-3">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-expand fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">Ukuran</h3>
                                <p class="fs-4"><?php echo $jumlahUkuran ?> Ukuran</p>
                                <p><a href="ukuran.php" class="text-white btn btn-success no-decoration fs-4">Lihat
                                        Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="../fontawesome/js/all.min.js"></script>

</body>

</html>