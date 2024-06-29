<?php
require "../koneksi.php";

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
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
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
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
                <li class="breadcrumb-item active aria-current-page">
                    Produk
                </li>
            </ol>
        </nav>

        <a href="../adminpanel/index.php" class="no-decoration text-white">
            <div class="btn btn-primary mb-3">
                <i class="fas fa-long-arrow-alt-left"></i> Kembali
            </div>
        </a>

        <a href="../adminpanel/tambah-produk.php" class="no-decoration text-white">
            <div class="btn btn-success mb-3">
                <i class="fa-regular fa-square-plus"></i> Tambah Produk Baru
            </div>
        </a>

        <style>
            /* Default font size for the table */
            .table {
                font-size: 100%;
            }

            /* Media query for smaller screens */
            @media (max-width: 450px) {

                /* Reduce font size to 70% of the original size */
                .table {
                    font-size: 65%;
                }

                .search-bar button {
                    padding: 4px 6px;
                    /* Reduce padding for smaller size */
                    font-size: 9px;
                    /* Reduce font size */
                }
            }

            /* Default search bar style */
            .search-bar {
                display: flex;
                align-items: center;
                background-color: #f0f0f0;
                border: 1px solid #ccc;
                border-radius: 4px;
                overflow: hidden;
                max-width: 100%;
                /* Ensure it takes full width */
            }

            .search-bar input[type="text"] {
                flex: 1;
                /* Take remaining space */
                padding: 6px 8px;
                /* Adjust padding as needed */
                font-size: 14px;
                border: none;
                background: none;
                outline: none;
            }

            .search-bar button {
                padding: 6px 8px;
                /* Adjust padding as needed */
                font-size: 14px;
                background-color: #007bff;
                color: white;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .search-bar button:hover {
                background-color: #0056b3;
            }

            /* Default button style */
            .smaller-button {
                padding: 6px 8px;
                /* Adjust padding as needed */
                font-size: 14px;
            }

            /* Media query for smaller screens */
            @media (max-width: 450px) {
                .search-bar input[type="text"] {
                    font-size: 12px;
                    /* Reduce font size */
                    padding: 5px;
                    /* Adjust padding */
                }

                .search-bar button {
                    padding: 5px 8px;
                    /* Adjust padding */
                    font-size: 12px;
                    /* Reduce font size */
                }

                .smaller-button {
                    padding: 5px 8px;
                    /* Adjust padding */
                    font-size: 12px;
                    /* Reduce font size */
                }
            }
        </style>

        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center">
                <h2>List Produk</h2>
                <form action="" method="GET" class="search-form">
                    <div class="search-bar">
                        <input type="text" name="search" placeholder="Search...">
                        <button type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="table-responsive mt-3" style="overflow-x: auto;">
                <table class="table" id="responsive-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Ketersediaan Stok</th>
                            <th>Action</th>
                            <th>Galeri</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Handle search query
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $sql = "SELECT a.*, b.nama AS nama_kategori 
                        FROM produk a 
                        JOIN kategori b ON a.kategori_id=b.id 
                        WHERE a.nama LIKE '%$search%'
                        OR b.nama LIKE '%$search%'
                        ORDER BY a.id DESC";

                        $query = mysqli_query($con, $sql);
                        $jumlahProduk = mysqli_num_rows($query);

                        if ($jumlahProduk == 0) {
                        ?>
                            <tr>
                                <td colspan="6" class="text-center">Data produk tidak tersedia</td>
                            </tr>
                            <?php
                        } else {
                            while ($data = mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td>Rp. <?php echo number_format($data['harga'], 0, '.', ','); ?></td>
                                    <td><?php echo $data['ketersediaan_stok']; ?></td>
                                    <td>
                                        <a href="edit-produk.php?p=<?php echo $data['id']; ?>" class="btn btn-info smaller-button"><i class="fas fa-pen" title="Edit"></i></a>
                                    </td>
                                    <td>
                                        <a href="edit-foto-produk.php?p=<?php echo $data['id']; ?>" class="btn btn-warning smaller-button" style="color: white;"><i class="bi bi-image"></i></a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>




    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
