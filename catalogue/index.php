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
    $queryProdukMenu = mysqli_query($con, "SELECT DISTINCT produk.kategori_id, produk.ukuran_id, ukuran.panjang, ukuran.lebar FROM produk 
                                           JOIN ukuran ON produk.ukuran_id = ukuran.id");

    $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
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
    <!-- My custom CSS -->
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <!-- Category Button -->
            <div class="col-lg-3 col-md-12 mb-4">
                <button class="btn btn-primary mb-2 d-lg-none" type="button" data-toggle="collapse" data-target="#categoryMenu" aria-expanded="false" aria-controls="categoryMenu">
                    Pilih Dimensi
                </button>
                <div class="collapse d-lg-block" id="categoryMenu">
                    <ul class="category-list">
                        <li class="text-muted specific-text">
                            <?php
                            // Display appropriate message if there are no products
                            if ($queryProdukMenu && mysqli_num_rows($queryProdukMenu) > 0) {
                                echo "Panjang x Lebar";
                            } else {
                                echo "Belum ada data yang dientry.";
                            }
                            ?>
                        </li>
                        <?php
                        if ($queryProdukMenu && mysqli_num_rows($queryProdukMenu) > 0) {
                            while ($produk = mysqli_fetch_array($queryProdukMenu)) { ?>
                                <li><a href="index.php?kategori=<?php echo $produk['kategori_id'] . '&ukuran=' . $produk['ukuran_id']; ?>#" class="category-link"><?php echo $produk['panjang'] . 'cm x ' . $produk['lebar'] . 'cm'; ?></a></li>
                        <?php }
                        }
                        ?>
                        <!-- Add a button to reset the category selection -->
                        <?php if (isset($_GET['kategori']) && isset($_GET['ukuran'])) { ?>
                            <li><a href="index.php?kategori=<?php echo $_GET['kategori']; ?>" class="category-link">Tampilkan semua</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- Product Cards Section -->
            <div class="col-lg-9 col-md-12">
                <div class="row">
                    <!-- Product Card  -->
                    <?php while ($produk = mysqli_fetch_array($queryProdukCards)) { ?>
                        <div class="col-lg-4 col-md-6 col-6 mb-4">
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