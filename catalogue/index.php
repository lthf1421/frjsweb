<?php
require "../koneksi.php";

// Fetch categories and sizes
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$queryUkuran = mysqli_query($con, "SELECT * FROM ukuran");

// Initialize the menu query variable
$queryProdukMenu = null;

// Handle the selected category and size
if (isset($_GET['kategori'])) {
    $kategori = mysqli_real_escape_string($con, $_GET['kategori']); // Sanitize input
    $queryGetKategoriId = mysqli_query($con, "SELECT id FROM kategori WHERE nama='$kategori'");

    if ($queryGetKategoriId && mysqli_num_rows($queryGetKategoriId) > 0) {
        $kategoriId = mysqli_fetch_array($queryGetKategoriId)['id'];

        // Determine the sorting order
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // Default to ascending order if sort parameter is not set
        $sortQuery = ($sort == 'asc') ? 'ORDER BY ukuran.panjang ASC' : 'ORDER BY ukuran.panjang DESC';

        // Query products within the selected category and sorted by 'panjang'
        $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                                JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                                WHERE produk.kategori_id='$kategoriId' 
                                                $sortQuery");
    }
} else {
    // Fetch all products for the initial load
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // Default to ascending order if sort parameter is not set

    $sortQuery = ($sort == 'asc') ? 'ORDER BY ukuran.panjang ASC' : 'ORDER BY ukuran.panjang DESC';

    $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                            JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                            $sortQuery");

    $queryProdukMenu = mysqli_query($con, "SELECT DISTINCT produk.kategori_id, produk.ukuran_id, ukuran.panjang, ukuran.lebar FROM produk 
                                           JOIN ukuran ON produk.ukuran_id = ukuran.id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalogue</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@100..900&family=Kanit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        .product-card {
            height: 100%; /* Ensures each card is the same height */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark transparent-navbar custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#"><span class="bold-text">FRJS</span> Scoreboard & LED</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">All Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-bag"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header Image -->
    <div class="container mt-3">
        <div class="header-image">
            <img src="../img/night court.jpg" class="img-fluid" alt="Header Image">
        </div>
    </div>

    <!-- Sort Links -->
    <div class="container mt-3 d-inline-block">
        <div class="btn-group custom-dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sort by
            </button>
            <div class="dropdown-menu w-100">
                <?php
                $sortAscUrl = isset($_GET['kategori']) ? "?kategori=$_GET[kategori]&sort=asc" : "?sort=asc";
                $sortDescUrl = isset($_GET['kategori']) ? "?kategori=$_GET[kategori]&sort=desc" : "?sort=desc";
                ?>
                <a class="dropdown-item" href="<?php echo $sortAscUrl; ?>" onclick="sortProducts('asc')">Besar - Kecil</a>
                <a class="dropdown-item" href="<?php echo $sortDescUrl; ?>" onclick="sortProducts('desc')">Kecil - Besar</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4">
            <!-- Product Cards Section -->
            <?php while ($produk = mysqli_fetch_array($queryProdukCards)) { ?>
                <div class="col mb-4">
                    <div class="card h-100 product-card bg-dark text-white">
                        <div class="card-img-container">
                            <img src="../img/edgar-chaparro--axLDDU97I0-unsplash.jpg" class="card-img-top" alt="Product 1">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produk['id']; ?> <span class="text-muted"><?php echo $produk['panjang'] . 'cm x ' . $produk['lebar'] . 'cm'; ?></span></h5>
                            <p class="card-text">Rp. <?php echo $produk['harga']; ?></p>
                            <a href="product-detail.php?id=<?php echo $produk['id']; ?>" class="product-link">View Details</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End of Product Card loop -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white text-center text-lg-start mt-5">
        <div class="container d-flex justify-content-between align-items-center py-3">
            <a href="#" class="text-white">Contact Us</a>
            <span>© 2024 Your Company</span>
            <div>
                <a href="#" class="text-white mr-2">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="#" class="text-white">
                    <i class="bi bi-whatsapp"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
