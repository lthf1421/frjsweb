<?php
require "koneksi.php";
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FRJS Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container text-left">
        <div class="header my-5">
            <h1><span class="bold-text">FRJS</span> Scoreboard & LED</h1>
            <p>Pilih jenis olahraga yang diminati</p>
        </div>
        <div class="row">
            <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <a href="catalogue/index.php?kategori=<?php echo $kategori['nama']; ?>" class="card text-white">
                        <img src="img/<?= $kategori['bg']; ?>" class="card-img" alt="Category 1 Image">
                        <div class="card-img-overlay d-flex justify-content-center align-items-center">
                            <h5 class="card-title font-weight-bold"><?php echo $kategori['nama']; ?></h5>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <a href="./frjs/about-us.php">
            <button class="btn btn-primary mt-3">About Us</button>
        </a>
        <button class="btn btn-primary mt-3"><i class="bi bi-instagram"></i></button>
        <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6946472080144!2d106.85877551413715!3d-6.171623962196151!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f506393c48b1%3A0xe8dc439c3edd9f4b!2sScoreboard%20%26%20LED%20Display!5e0!3m2!1sen!2sid!4v1679825900376!5m2!1sen!2sid">
            <button class="btn btn-primary mt-3"><i class="bi bi-whatsapp"></i></i></button>
        </a>
    </div>
    <!-- Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
