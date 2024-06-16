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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
            width: 100%;
            /* Ensure image takes full width of its container */
            min-height: 450px;
            max-height: 450px;
            /* Adjust maximum height to control size */
        }

        .main-product-image img:hover {
            transform: scale(1.05);
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6">
                <!-- Main product image -->
                <div class="main-product-image aspect-ratio-container">
                    <a href="#" data-toggle="modal" data-target="#imageModal">
                        <img src="../img/<?= $produk['foto']; ?>" id="main-product-image" class="img-fluid rounded-5" alt="Product Image">
                    </a>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="<?= $produk['foto']; ?>" id="modal-image" class="img-fluid rounded" alt="Product Image">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Small box containers for pictures -->
                <div class="row mt-3" id="small-images-container">
                    <?php if (!empty($produk['foto'])) : ?>
                        <div class="col-2">
                            <div class="small-box-container">
                                <a href="#">
                                    <img src="../img/<?php echo $produk['foto']; ?>" id="1" class="small-product-image" alt="Image 1">
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($produk['foto1'])) : ?>
                        <div class="col-2">
                            <div class="small-box-container">
                                <a href="#">
                                    <img src="../img/<?php echo $produk['foto1']; ?>" id="2" class="small-product-image" alt="Image 2">
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($produk['foto2'])) : ?>
                        <div class="col-2">
                            <div class="small-box-container">
                                <a href="#">
                                    <img src="../img/<?php echo $produk['foto2']; ?>" id="3" class="small-product-image" alt="Image 3">
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($produk['foto3'])) : ?>
                        <div class="col-2">
                            <div class="small-box-container">
                                <a href="#">
                                    <img src="../img/<?php echo $produk['foto3']; ?>" id="4" class="small-product-image" alt="Image 4">
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($produk['foto4'])) : ?>
                        <div class="col-2">
                            <div class="small-box-container">
                                <a href="#">
                                    <img src="../img/<?php echo $produk['foto4']; ?>" id="5" class="small-product-image rounded-5" alt="Image 5">
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <div class="col-lg-6">
                <!-- Product details -->
                <div class="product-details">
                    <h1 class="display-4"><?php echo $produk['nama']; ?></h1>
                    <p class="lead">Rp. <?php echo number_format($produk['harga'], 0, '.', ','); ?></p>
                    <p class="text-muted"><?php echo $produk['panjang'] . ' cm x ' . $produk['lebar'] . ' cm'; ?></p>
                    <a href="#" class="btn btn-primary">Order Now</a>
                    <!-- WhatsApp share icon -->

                    <style>
                        .whatsapp-share-button {
                            display: inline-flex;
                            align-items: center;
                            background-color: transparent;
                            color: white;
                            padding: 5px 10px;
                            /* Padding inside the button */
                            border-radius: 5px;
                            /* Rounded corners */
                            text-decoration: none;
                            /* Remove underline */
                            margin-left: 5px;
                            /* Margin to the left */
                            font-size: 1rem;
                            /* Larger icon size */
                        }

                        .whatsapp-share-button i {
                            font-size: 1.4rem;
                            /* Larger icon size */
                            margin-left: 6px;
                            /* Space between text and icon */
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
                <h5>Deskripsi Produk</h5>
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

            <script>
                function updateMainImage(imageSrc) {
                    var mainImage = document.getElementById('modal-image');
                    mainImage.src = imageSrc;
                }
            </script>


            <!-- Java Script for Switch Main foto with smaller foto-->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Get all small product images
                    const smallImages = document.querySelectorAll('.small-product-image');

                    // Get the main product image element
                    const mainImage = document.getElementById('main-product-image');

                    // Loop through each small image and add click event listener
                    smallImages.forEach(function(smallImage) {
                        smallImage.addEventListener('click', function(event) {
                            event.preventDefault(); // Prevent the default action of anchor tag

                            // Update main product image src with clicked small image src
                            mainImage.src = this.src;
                        });
                    });
                });
            </script>

            <!-- Bootstrap JS and dependencies -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-n1J5GVJiw7s1sMszBkb3UwBLzQNMDUQsY+Em5V/Qz7/K5YgmHvoL0voG2BzMS6vm" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+8BGRD1WqXu7B8jG/6F7p5qUovyJ2FwNX5u" crossorigin="anonymous"></script>
</body>

</html>
