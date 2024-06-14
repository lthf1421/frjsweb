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
    
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/296a2adfbf.js" crossorigin="anonymous"></script>

    <!-- My custom CSS -->
    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"></head>

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

    <!-- Main Content -->
     <style>
     .main-product-image {
    display: flex;
    justify-content: center;
    align-items: center;
}

.main-product-image img {
    max-width: 100%;
    height: auto;
    border: 2px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    width: 100%; /* Ensure image takes full width of its container */
    min-height: 450px;
    max-height: 450px; /* Adjust maximum height to control size */
}

.main-product-image img:hover {
    transform: scale(1.05);
}
     </style>

    <div class="container mt-5">
    <div class="row">
        <div class="col-lg-6">
            <!-- Main product image -->
            <div class="main-product-image">
                <img src="../img/night court.jpg" class="img-fluid rounded" alt="Product Image">
            </div> 
             <!-- Small box containers for pictures -->
             <div class="row mt-3">
                    <div class="col-2">
                        <div class="small-box-container">
                            <a href="path/to/image1.jpg">
                                <img src="../img/IMG-20190906-WA0009.jpg" alt="Image 1">
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="small-box-container">
                            <a href="path/to/image1.jpg">
                                <img src="../img/IMG-20190906-WA0009.jpg" alt="Image 1">
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="small-box-container">
                            <a href="path/to/image1.jpg">
                                <img src="../img/IMG-20190906-WA0009.jpg" alt="Image 1">
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="small-box-container">
                            <a href="path/to/image1.jpg">
                                <img src="../img/IMG-20190906-WA0009.jpg" alt="Image 1">
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="small-box-container">
                            <a href="path/to/image2.jpg">
                                <img src="../img/night court.jpg" alt="Image 2">
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="small-box-container">
                            <a href="path/to/image3.jpg">
                                <img src="../img/IMG-20190906-WA0009.jpg" alt="Image 3">
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="small-box-container">
                            <a href="path/to/image4.jpg">
                                <img src="../img/edgar-chaparro--axLDDU97I0-unsplash.jpg" alt="Image 4">
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="small-box-container">
                            <a href="path/to/image5.jpg">
                                <img src="../img/night court.jpg" alt="Image 5">
                            </a>
                        </div>
                    </div>
                </div>
  
        </div>
        <div class="col-lg-6">
            <!-- Product details -->
            <div class="product-details">
                <h1 class="display-4"><?php echo $produk['nama']; ?></h1>
                <p class="lead">Rp. <?php echo $produk['harga']; ?></p>
                <p class="text-muted"><?php echo $produk['panjang'] . ' cm x ' . $produk['lebar'] . ' cm'; ?></p>
                <a href="#" class="btn btn-primary">Order Now</a>
                <!-- WhatsApp share icon -->

                <style>
                    .whatsapp-share-button {
                        display: inline-flex;
                        align-items: center;
                        background-color: transparent;
                        color: white;
                        padding: 5px 10px; /* Padding inside the button */
                        border-radius: 5px; /* Rounded corners */
                        text-decoration: none; /* Remove underline */
                        margin-left: 5px; /* Margin to the left */
                        font-size: 1rem; /* Larger icon size */
                    }

                    .whatsapp-share-button i {
                        font-size: 1.4rem; /* Larger icon size */
                        margin-left: 6px; /* Space between text and icon */
                    }

                    .whatsapp-share-button:hover {
                        color: white;
                        text-decoration: none;
                    }
                </style>
                <a href="whatsapp://send?text=<?php echo urlencode('Check out this product: ' . $produk['nama'] . ' - Rp. ' . $produk['harga']); ?>" class="whatsapp-share-button">
                <i class="fa-solid fa-share"></i>
                    <i class="bi bi-whatsapp"></i>
                </a>
            </div>

            

                   

                    <p><?php echo $produk['detail']; ?></p>
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
</body>

</html>
