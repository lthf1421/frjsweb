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

        $queryProdukMenu = mysqli_query($con, "SELECT DISTINCT produk.kategori_id, produk.ukuran_id, ukuran.panjang, ukuran.lebar FROM produk 
                                               JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                               WHERE kategori_id='$kategoriId'");

        // Handle size filter within the selected category
        if (isset($_GET['ukuran'])) {
            $ukuran = mysqli_real_escape_string($con, $_GET['ukuran']); // Sanitize input
            $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                                    JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                                    WHERE produk.kategori_id='$kategoriId' AND produk.ukuran_id='$ukuran'");
        } else {
            $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                                    JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                                    WHERE produk.kategori_id='$kategoriId'");
        }
    }
} else {
    // Fetch all products for the initial load
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc'; // Default to ascending order if sort parameter is not set

    if ($sort == 'asc') {
        $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                                JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                                ORDER BY ukuran.lebar DESC");
    } else {
        $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                                JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                                ORDER BY ukuran.lebar ASC");
    }

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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@100..900&family=Kanit:wght@100..900&display=swap" rel="stylesheet">
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

    <!-- Sort Links Style -->
    <style>
    .sorting-heading {
    font-size: 1.2em; /* Adjust font size as needed */
    color: #d6d6d6; /* Default text color */
    text-align: center; /* Center align the text */
    margin-top: 7px; /* Bottom margin for spacing */
    }

    .sort-link {
        color: #d6d6d6;
        text-decoration: underline; /* Underline link */
        cursor: pointer; /* Pointer cursor on hover */
    }

    .sort-link:hover {
        color: rgb(238, 255, 7); /* Hover color */
        text-decoration: underline; /* Maintain underline on hover */
    }
    </style>

     <!-- Sort Links -->
     <div class="container mt-3">
    <div class="d-flex justify-content-center align-items-center">
        <h3 class="sorting-heading">
            <i class="bi bi-sort-numeric-up"></i>
            <a href="?sort=asc" class="sort-link mx-2" onclick="sortProducts('asc')">Besar - Kecil</a>
            <i class="bi bi-sort-numeric-down"></i>
            <a href="?sort=desc" class="sort-link mx-2" onclick="sortProducts('desc')">Kecil - Besar</a>
        </h3>
    </div>
</div>
    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Product Cards Section -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Product Card  -->
                    <?php while ($produk = mysqli_fetch_array($queryProdukCards)) { ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card h-100 product-card bg-dark text-white">
                                <div class="card-img-container">
                                    <img src="img/product1.jpg" class="card-img-top" alt="Product 1">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $produk['id']; ?> <span class="text-muted"><?php echo $produk['panjang'] . 'cm x ' . $produk['lebar'] . 'cm'; ?></span></h5>
                                    <p class="card-text">Rp. <?php echo $produk['harga']; ?></p>
                                    <a href="product-detail.php?id=<?php echo $produk['id']; ?>" class="product-link">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
