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
    <title>Ukuran</title>
    <script src="https://kit.fontawesome.com/296a2adfbf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

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
                <li class="breadcrumb-item active aria-current-page">
                    Ukuran
                </li>
            </ol>
        </nav>
        <a href="../adminpanel/index.php" class="no-decoration text-white">
            <div class="btn btn-primary mb-3">
                <i class="fas fa-long-arrow-alt-left"></i> Kembali
            </div>
        </a>
        <h2>List Ukuran</h2>
        <div class="table-responsive mt-5">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. </th>
                        <th>Panjang</th>
                        <th>Lebar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $number = 1;
                    while ($data = mysqli_fetch_array($queryUkuran)) {
                        if ($jumlahUkuran == 0) {
                    ?>
                            <tr>
                                <td>Tidak ada data kategori</td>
                            </tr>
                        <?php
                        } else {
                        ?>
                            <tr>
                                <td><?php echo $number; ?></td>
                                <td><?php echo $data['panjang']; ?> cm</td>
                                <td><?php echo $data['lebar']; ?> cm</td>

                            </tr>
                    <?php
                        }
                        $number++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>
