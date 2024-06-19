<?php
require "../koneksi.php";

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $queryProdukDetail = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                             JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                             WHERE produk.id='$productId'");
    $produk = mysqli_fetch_assoc($queryProdukDetail);

    if (!$produk) {
        // Redirect to an error page or handle the case where product ID is not found
        header("Location: ../error.php");
        exit();
    }

    // Retrieve product images from the database
    $queryProductImages = mysqli_query($con, "SELECT foto FROM produk WHERE id='$productId'");
    $productImages = [];
    while ($row = mysqli_fetch_assoc($queryProductImages)) {
        $productImages[] = $row['foto'];
    }

    // Fetch ketersediaan_stok
    $ketersediaan_stok = $produk['ketersediaan_stok'];
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
    <title><?= $produk['nama']; ?> - Product Detail</title>
    <!-- Bootstrap CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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
                        <a class="nav-link" href="../frjs/about-us.php#contact">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-bag"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

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
            min-width: 450px;
            min-height: 420px;
            max-height: 420px;
            /* Adjust maximum height to control size */
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6">
                <!-- Main product image -->
                <div class="main-product-image aspect-ratio-container">
                    <img src="../img/<?= $produk['foto']; ?>" id="main-product-image" class="img-fluid rounded-5" alt="Product Image">
                </div>

                <!-- Small box containers for pictures -->
                <div class="row" id="small-images-container">
                    <?php
                    $foto_array = array($produk['foto'], $produk['foto1'], $produk['foto2'], $produk['foto3'], $produk['foto4'], $produk['foto5'], $produk['foto6'], $produk['foto7'], $produk['foto8'], $produk['foto9'], $produk['foto10'], $produk['foto11']);
                    foreach ($foto_array as $key => $foto) :
                        if (!empty($foto)) :
                    ?>
                            <div class="col-2">
                                <div class="small-box-container">
                                    <a href="#" class="small-image-link" data-index="<?= $key ?>">
                                        <img src="../img/<?= $foto; ?>" class="small-product-image" alt="Small Image <?= $key + 1 ?>">
                                    </a>
                                </div>
                            </div>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>


            </div>

            <div class="col-lg-6">
                <!-- Product details -->
                <div class="product-details">
                    <h1 class="display-4"><?php echo $produk['nama']; ?></h1>
                    <p class="lead">Rp. <?php echo number_format($produk['harga'], 0, '.', ','); ?></p>
                    <p class="text-muted"><?php echo $produk['panjang'] . ' cm x ' . $produk['lebar'] . ' cm'; ?></p>
                    <p style="font-style: italic;"><?php echo trim($ketersediaan_stok == 'pre-order' ? 'Pre Order' : 'Ready Stock'); ?></p>
                    <a href="
                    https://wa.me/6287838137197?text=Halo%2C%20admin.%0ASaya%20ingin%20memesan%20produk%20<?php echo $produk['nama']; ?>
                    " class="btn btn-primary">Order Sekarang</a>
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

                        .whatsapp-share-button i:hover {
                            color: white;
                        }

                        .whatsapp-share-button:hover {
                            color: white;
                        }

                        .whatsapp-share-button:hover {
                            color: white;
                            text-decoration: none;
                        }
                    </style>
                    <a href="https://api.whatsapp.com/send?text=Lihat%20produk%20ini%20deh,%20mungkin%20tertarik%20www.frjs.id/catalogue/product-detail.php?id=<?= $produk['id']; ?>" class="whatsapp-share-button">
                        <i class="fa-solid fa-share"></i>
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
                <h5 class="mt-2">Deskripsi Produk</h5>
                <p><?php echo $produk['detail']; ?></p>
            </div>


            <!-- Footer -->
            <footer class="text-white text-center text-lg-start mt-5">
                <div class="container d-flex justify-content-between align-items-center py-3">
                    <a href="../frjs/about-us.php#garansi" class="text-white">Kebijakan Garansi</a>
                    <span>© 2024 FRJS Scoreboard & LED</span>
                    <div>
                        <a href="#" class="text-white mr-2">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://wa.me/6287838137197?text=Halo%2C%20admin%20FRJS" class="text-white">
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

            <script>
                $('#myModal').on('shown.bs.modal', function() {
                    $('#myInput').trigger('focus')
                })
            </script>

            <!-- Bootstrap JS and dependencies -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
