<?php
require "../koneksi.php";

// Fetch categories and sizes
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$queryUkuran = mysqli_query($con, "SELECT * FROM ukuran");

// Initialize variables
$bg = ''; // Initialize $bg variable to store background image path
$nama = ''; // Initialize $nama variable to store background image path

// Handle the selected category and size
if (isset($_GET['kategori'])) {
    $kategori = mysqli_real_escape_string($con, $_GET['kategori']); // Sanitize input
    $queryGetKategoriId = mysqli_query($con, "SELECT id, bg, nama FROM kategori WHERE nama='$kategori'");

    if ($queryGetKategoriId && mysqli_num_rows($queryGetKategoriId) > 0) {
        $kategoriData = mysqli_fetch_assoc($queryGetKategoriId);
        $kategoriId = $kategoriData['id'];
        $bg = $kategoriData['bg'];
        $nama = $kategoriData['nama'];


        // Handle the selected category and size
        if (isset($_GET['kategori'])) {
            // existing code...

            // Determine the sorting order
            if (isset($_GET['sort'])) {
                switch ($_GET['sort']) {
                    case 'asc':
                        $sortQuery = 'ORDER BY ukuran.panjang ASC, ukuran.lebar ASC';
                        break;
                    case 'desc':
                        $sortQuery = 'ORDER BY ukuran.panjang DESC, ukuran.lebar DESC';
                        break;
                    case 'harga_asc':
                        $sortQuery = 'ORDER BY produk.harga ASC';
                        break;
                    case 'harga_desc':
                        $sortQuery = 'ORDER BY produk.harga DESC';
                        break;
                    case 'dimensi_asc':
                        $sortQuery = 'ORDER BY ukuran.panjang * ukuran.lebar ASC';
                        break;
                    case 'dimensi_desc':
                        $sortQuery = 'ORDER BY ukuran.panjang * ukuran.lebar DESC';
                        break;
                    default:
                        $sortQuery = 'ORDER BY RAND()'; // Default to random order
                        break;
                }
            } else {
                $sortQuery = 'ORDER BY RAND()'; // Default to random order            
            }

            // Query products within the selected category and sorted criteria
            $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                            JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                            WHERE produk.kategori_id='$kategoriId' 
                                            $sortQuery");
        } else {
            // existing code...

            // Fetch all products for the initial load
            if (isset($_GET['sort'])) {
                switch ($_GET['sort']) {
                        // existing cases...

                        // Add case for sorting by dimensions
                    case 'dimensi_asc':
                        $sortQuery = 'ORDER BY ukuran.panjang * ukuran.lebar ASC';
                        break;
                    case 'dimensi_desc':
                        $sortQuery = 'ORDER BY ukuran.panjang * ukuran.lebar DESC';
                        break;
                    default:
                        $sortQuery = 'ORDER BY RAND()'; // Default to random order
                        break;
                }
            } else {
                $sortQuery = 'ORDER BY RAND()'; // Default to random order
            }

            $queryProdukCards = mysqli_query($con, "SELECT produk.*, ukuran.panjang, ukuran.lebar FROM produk 
                                            JOIN ukuran ON produk.ukuran_id = ukuran.id 
                                            $sortQuery");
        }

        // Fetch distinct categories and sizes for menu
        $queryProdukMenu = mysqli_query($con, "SELECT DISTINCT produk.kategori_id, produk.ukuran_id, kategori.nama AS kategori_nama, ukuran.panjang, ukuran.lebar 
                                           FROM produk 
                                           JOIN ukuran ON produk.ukuran_id = ukuran.id
                                           JOIN kategori ON produk.kategori_id = kategori.id");
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalogue for <?= $nama ?></title>
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/296a2adfbf.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        .product-card {
            height: 100%;
            /* Ensures each card is the same height */
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
                        <a class="nav-link" href="../frjs/about-us.php#contact">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../frjs/about-us.php#hto"><i class="bi bi-bag"></i></a>
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
                <li class="breadcrumb-item active aria-current-page">
                    <?= $nama ?>
                </li>
            </div>
        </ol>
    </nav>

    <!-- Header Image -->
    <div class="container mt-3">
        <div class="header-image">
            <img src="../img/<?php echo $bg; ?>" class="img-fluid" alt="Header Image">
        </div>
    </div>

    <!-- Sort Links -->
    <div class="container mt-3 d-inline-block">
        <div class="btn-group custom-dropdown">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sort by
            </button>
            <div class="dropdown-menu w-120">
                <?php
                // Current URL parameters
                $currentUrl = isset($_GET['kategori']) ? "?kategori=$_GET[kategori]" : "";

                // Sorting URLs
                $sortHargaAscUrl = $currentUrl . "&sort=harga_asc";
                $sortHargaDescUrl = $currentUrl . "&sort=harga_desc";
                $sortDimensiAscUrl = $currentUrl . "&sort=dimensi_asc";
                $sortDimensiDescUrl = $currentUrl . "&sort=dimensi_desc";
                ?>
                <a class="dropdown-item" href="<?php echo $sortDimensiAscUrl; ?>" onclick="sortProducts('dimensi_asc')">Dimensi, kecil ke besar</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $sortDimensiDescUrl; ?>" onclick="sortProducts('dimensi_desc')">Dimensi, besar ke kecil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $sortHargaAscUrl; ?>" onclick="sortProducts('harga_asc')">Harga, rendah ke tinggi</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $sortHargaDescUrl; ?>" onclick="sortProducts('harga_desc')">Harga, tinggi ke rendah</a>
            </div>
        </div>
    </div>


    <!-- Icons Style-->
    <style>
        .product-link {
            padding: 10px;
            background-color: #327B9B;
            color: white;
            border-radius: 5px;
            /* Remove underline */
            transition: background-color 0.3s ease;
        }

        .product-link:hover {
            background-color: #2E708D;
        }

        .whatsapp-share-button {
            padding: 10px;
            background-color: #128C7E;
            /* WhatsApp green color */
            color: white;
            border-radius: 5px;
            text-decoration: none;
            /* Remove underline */
            transition: background-color 0.3s ease;
            margin-left: 3px;
        }

        .whatsapp-share-button:hover {
            background-color: #298047;
            color: white;
            /* Darker shade of WhatsApp green on hover */
        }

        .whatsapp-share-button i {
            font-size: 1.5rem;
            /* Adjust icon size if needed */
            vertical-align: middle;
            /* Center the icon vertically */
        }
    </style>


    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
            <!-- Product Cards Section -->
            <?php while ($produk = mysqli_fetch_array($queryProdukCards)) { ?>
                <div class="col mb-4">
                    <div class="card h-100 product-card bg-dark text-white">
                        <a href="product-detail.php?id=<?php echo $produk['id']; ?>">
                            <div class="card-img-container">
                                <img src="../img/<?= $produk['foto']; ?>" class="card-img-top" alt="<?= $produk['foto']; ?>">
                            </div>
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produk['nama']; ?> <span class="text-muted"><?php echo $produk['panjang'] . 'cm x ' . $produk['lebar'] . 'cm'; ?></span></h5>
                            <p class="card-text">Rp. <?php echo number_format($produk['harga'], 0, '.', ','); ?></p>
                            <a href="product-detail.php?id=<?php echo $produk['id']; ?>" class="product-link">View Details</a>
                            <a href="https://api.whatsapp.com/send?text=Lihat%20produk%20<?php echo $produk['nama']; ?>%20ini%20deh,%20mungkin%20tertarik%20www.frjs.id/catalogue/product-detail.php?id=<?= $produk['id']; ?>" target="_blank" class="whatsapp-share-button">
                                <i class="bi bi-whatsapp"></i>
                            </a>
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
            <a href="../frjs/about-us.php#garansi" class="text-white">Kebijakan Garansi</a>
            <span>© 2024 FRJS Scoreboard & LED</span>
            <div>
                <a href="#" class="text-white mr-2">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://wa.me/6287838137197?text=Halo%2C%20admin%20FRJS." class="text-white" target="_blank">
                    <i class="bi bi-whatsapp"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
