<?php
require "../koneksi.php";

if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $queryProdukDetail = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar, kategori.nama AS nama_kategori 
FROM produk 
JOIN ukuran ON produk.ukuran_id = ukuran.id 
JOIN kategori ON produk.kategori_id = kategori.id
WHERE produk.id = '$productId';
");
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

    <style>
        /* Style for the breadcrumb navigation */
        .breadcrumb {
            background-color: transparent;
            /* Background color */
            padding: 5px 10px;
            /* Padding between items (top and bottom) */
            margin-bottom: 10px;
            /* Margin bottom for the entire breadcrumb */
        }

        /* Style for breadcrumb items */
        .breadcrumb-item {
            display: inline-block;
            /* Display items in a line */
            margin-right: 5px;
            /* Spacing between items */
        }

        /* Style for active breadcrumb item */
        .breadcrumb-item.active {
            color: #fff;
            /* Active item text color */
            font-weight: 400;
            /* Bold text for active item */
        }

        /* Style for links inside breadcrumb items */
        .breadcrumb-item a {
            color: #ccc;
            /* Link text color */
            text-decoration: none;
            /* Remove underline */
            margin-right: 5px;
        }

        /* Style for home icon */
        .breadcrumb-item a i {
            margin-right: 10px;
            /* Spacing between icon and text */
            color: #ccc;
            /* Icon color */
        }
    </style>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb navbar-dark transparent-navbar">
            <div class="container">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../index.php" class="no-decoration text-muted">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../catalogue/index.php?kategori=<?= $produk['nama_kategori']; ?>" class="no-decoration text-muted">
                        <?= $produk['nama_kategori']; ?>
                    </a>
                </li>
                <li class="breadcrumb-item active aria-current-page">
                    <?= $produk['nama']; ?>
                </li>
            </div>
        </ol>
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
            border-radius: 5px;
            border: 2px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            width: 100%;
            min-width: 400px;
            min-height: 450px;
            max-height: 450px;
            object-fit: cover;
            /* Adjust as per your design needs */

        }

        #main-product-image {
            max-width: 100%;
            /* Ensures the image doesn't exceed its container's width */
            height: auto;
            /* Allows the image to scale proportionally */
        }

        /* mobile phone */

        @media (max-width: 450px) {
            html {
                font-size: 75%;
            }
        }

        @media (max-width: 450px) {
            .main-product-image img {
                flex: 0 0 20%;
                /* Adjust width to occupy 1/5th of the container */
                max-width: 30%;
            }

            .video-container iframe {
                width: 80%;
                /* Make the iframe responsive */
                /* Max width for larger screens */
                height: 100px;
                /* Auto height based on width */
                border: none;
                /* Remove iframe border */
                border-radius: 8px;
            }
        }

        @media (max-width: 450px) {
            #small-images-container .col-2 {
                flex: 0 0 20%;
                /* Adjust width to occupy 1/5th of the container */
                max-width: 19%;
            }
        }

        /* Styles for smaller screens */
        @media (max-width: 768px) {
            .main-product-image img {
                min-height: 375px;
                /* Minimum height */
                max-height: 375px;
                /* Maximum height */
            }
        }

        @media (max-width: 1199px) {
            .main-product-image img {
                min-height: 370px;
                /* Minimum height */
                max-height: 370px;
                /* Maximum height */
            }
        }

        @media (min-width: 1200px) {
            .main-product-image img {
                min-height: 430px;
                /* Minimum height */
                max-height: 430px;
                /* Maximum height */
            }
        }
    </style>

    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-6">
                <!-- Main product image -->
                <div class="main-product-image mb-3">
                    <img src="../img/<?= $produk['foto']; ?>" id="main-product-image" class="img-fluid rounded-5" alt="Product Image">

                </div>
                <div class="row" id="small-images-container">
                    <?php
                    $foto_array = array($produk['foto'], $produk['foto1'], $produk['foto2'], $produk['foto3'], $produk['foto4'], $produk['foto5'], $produk['foto6'], $produk['foto7'], $produk['foto8'], $produk['foto9'], $produk['foto10'], $produk['foto11']);
                    foreach ($foto_array as $key => $foto) :
                        if (!empty($foto)) :
                    ?>
                            <div class="col-2" style="justify-content: space-between;">
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
                    <p class="lead" style="font-size: 1.5rem;">Rp. <?php echo number_format($produk['harga'], 0, '.', ','); ?></p>
                    <p class="lead" style="font-size:larger; background-color:white; color:#39385c; padding-left:8px;"> Panjang x Lebar = <?php echo $produk['panjang'] . ' cm x ' . $produk['lebar'] . ' cm'; ?></p>
                    <p style="font-style: italic;"><?php echo trim($ketersediaan_stok == 'pre-order' ? 'Pre Order' : 'Ready Stock'); ?></p>
                    <a href="
                    https://wa.me/6285280038866?text=Halo%2C%20admin.%0ASaya%20ingin%20memesan%20produk%20<?php echo $produk['nama']; ?>
                    " class="btn btn-primary" style="width: 200px;" target="_blank">Order Sekarang</a>
                    <!-- WhatsApp share icon -->

                    <style>
                        .whatsapp-share-button {
                            display: inline-flex;
                            align-items: center;
                            background-color: transparent;
                            color: white;
                            padding: 2px;
                            padding-right: 6px;
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
                    <a href="https://api.whatsapp.com/send?text=Lihat%20produk%20<?php echo $produk['nama']; ?>%20ini%20deh,%20mungkin%20tertarik%20www.frjs.id/catalogue/product-detail.php?id=<?= $produk['id']; ?>" target="_blank" class="whatsapp-share-button">
                        <i class="fa-solid fa-share-nodes"></i>
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>

                <h5 class="mt-2">Deskripsi Produk</h5>

                <!-- Awal Coding Embed Video Youtube-->

                <style>
                    /* Basic styling for the button */
                    .embed-button {
                        background-color: #333152;
                        /* Green background */
                        border: none;
                        /* Remove border */
                        color: white;
                        /* White text */
                        padding: 5px;
                        /* Padding */
                        text-align: center;
                        /* Center text */
                        text-decoration: none;
                        /* Remove underline */
                        display: inline-block;
                        /* Display as block */
                        font-size: 16px;
                        /* Font size */
                        cursor: pointer;
                        /* Pointer cursor */
                        border-radius: 5px;
                        /* Rounded corners */
                        transition: background-color 0.3s ease;
                        /* Smooth transition */
                        outline: none;
                        margin-top: 5px;
                        margin-bottom: 15px;
                    }

                    /* Hover effect */
                    .embed-button:hover {
                        background-color: #2c2b46;
                        /* Darker green */
                    }

                    .embed-button:active,
                    .embed-button:focus {
                        outline: none;
                        /* Remove outline on active and focus states */
                    }

                    /* Styling for video container */
                    .video-container {
                        margin-top: 10px;
                        /* Space above video container */
                        background-color: transparent;
                        border-radius: 8px;
                        text-align: left;
                        display: none;
                        /* Hide video container initially */
                        margin-bottom: 15px;
                    }

                    .video-container iframe {
                        width: 100%;
                        /* Make the iframe responsive */
                        /* Max width for larger screens */
                        height: 300px;
                        /* Auto height based on width */
                        border: none;
                        /* Remove iframe border */
                        border-radius: 8px;
                    }
                </style>
                </head>

                <body>

                    <?php if (!empty($produk['embed_link'])) : ?>
                        <!-- Embed button -->
                        <button class="embed-button" onclick="toggleEmbed()">
                            <i class="bi bi-play-btn-fill"></i> Video Produk <?php echo $produk['nama']; ?>
                        </button>

                        <!-- Container for the embedded video -->
                        <div id="video-container" class="video-container">
                            <!-- Embedded video will be inserted here -->
                            <iframe id="youtube-video" src="" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>

                    <script>
                        var isVideoEmbedded = false;
                        var videoID = ''; // Initialize variable for video ID

                        function toggleEmbed() {
                            var videoContainer = document.getElementById('video-container');

                            if (!isVideoEmbedded) {
                                // Extract video ID from embed link
                                videoID = extractVideoID('<?php echo $produk['embed_link']; ?>');

                                if (videoID) {
                                    var embedCode = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + videoID + '" frameborder="0" allowfullscreen></iframe>';

                                    // Insert the embed code into the video container
                                    videoContainer.innerHTML = embedCode;

                                    // Show the video container
                                    videoContainer.style.display = 'block';

                                    isVideoEmbedded = true;
                                    document.querySelector('.embed-button').innerHTML = '<i class="fa-solid fa-square-minus"></i> Video Produk <?php echo $produk['nama']; ?>';
                                } else {
                                    console.error('Invalid YouTube URL provided.');
                                }
                            } else {
                                // Hide the video container
                                videoContainer.style.display = 'none';

                                isVideoEmbedded = false;
                                document.querySelector('.embed-button').innerHTML = ' <i class="bi bi-play-btn-fill"></i> Video Produk <?php echo $produk['nama']; ?>';
                            }
                        }

                        function extractVideoID(url) {
                            // Regular expression to match YouTube video ID
                            var regExp = /^.*(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;
                            var match = url.match(regExp);
                            if (match && match[1].length === 11) {
                                return match[1];
                            } else {
                                console.error('Invalid YouTube URL format.');
                                return null;
                            }
                        }
                    </script>

                    <!-- Akhir Coding Embed Video Youtube -->

                    <p><?php echo $produk['detail']; ?></p>

            </div>
        </div>
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
                <a href="https://wa.me/6285280038866?text=Halo%2C%20admin%20FRJS" class="text-white">
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
