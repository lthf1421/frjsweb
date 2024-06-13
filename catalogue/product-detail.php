<?php
require "../koneksi.php";

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $queryProdukDetail = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                             JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                             WHERE produk.id='$productId'");
    $produk = mysqli_fetch_assoc($queryProdukDetail);

    // Retrieve product images from the database
    $queryProductImages = mysqli_query($con, "SELECT foto FROM produk WHERE id='$productId'");
    $productImages = [];
    while ($row = mysqli_fetch_assoc($queryProductImages)) {
        $productImages[] = $row['foto'];
    }
} else {
    // Redirect to the homepage or an error page if no product ID is provided
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- My custom CSS -->
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark transparent-navbar"> <!-- Added 'transparent-navbar' class -->
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

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6">
                <!-- Carousel for product images -->
                <div id="productCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($productImages as $index => $image) : ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo $image; ?>" class="d-block w-100" alt="Product Image">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="display-4"><?php echo $produk['nama']; ?></h1>
                <p class="lead">Rp. <?php echo $produk['harga']; ?></p>
                <p class="text-muted"><?php echo $produk['panjang'] . ' cm x ' . $produk['lebar'] . ' cm'; ?></p>
                <p><?php echo $produk['detail']; ?></p>
                <a href="#" class="btn btn-primary">Order via Whatsapp</a>
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
