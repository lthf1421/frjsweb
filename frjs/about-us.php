<?php
require "../koneksi.php";
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalogue</title>
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/296a2adfbf.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
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
                        <a class="nav-link" href="../frjs/about-us.php#garansi">Warranty Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../frjs/about-us.php#hto"><i class="bi bi-bag"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <style>
        /* Custom Styles */
        body {
            background-image: url('../img/bg.png');
            background-size: cover;
            background-position: 50% 44%;
            /* Centered position */
            background-attachment: fixed;
            /* Ensures the background image remains fixed as the user scrolls */
            font-family: "Kanit", sans-serif;
            background-color: #2b2a46;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    </style>


    <div class=" about container text-center">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <style>
                    .about h2 {
                        font-weight: 200;
                        text-align: center;
                        font-size: 2.6rem;
                        margin-bottom: 3rem;
                    }

                    .about h2 span {
                        font-weight: 500;
                    }

                    .about p {
                        margin-bottom: 1.5rem;
                        /* Adjust spacing between paragraphs */
                    }
                </style>
                <h2 class="text-center mb-4">About <span>Us</span></h2>
                <p class="lead text-center">FRJS Scoreboard & LED Display adalah perusahaan terkemuka dalam memproduksi papan skor digital berkualitas tinggi untuk berbagai macam acara dan olahraga.
                    Dengan pengalaman menyediakan Scoreboard untuk event-event besar di Indonesia.</p>
                <p class="text-center"> kami bangga dapat menyediakan solusi tampilan berkualitas tinggi yang memungkinkan penyelenggara acara dan tim olahraga untuk memberikan pengalaman yang tak terlupakan.
                    Dengan fokus pada kejelasan, dan kemudahan penggunaan, produk papan skor digital kami dirancang dengan mempertimbangkan arena dan peraturan beragam jenis olahraga. Jika Anda mencari solusi papan skor digital yang inovatif dan handal, jangan ragu untuk menghubungi tim kami. Kami siap membantu Anda dalam merencanakan dan mewujudkan tampilan yang spektakuler untuk acara atau tim olahraga Anda.</p>
            </div>
        </div>

        <style>
            /* Optional: Basic styling */
            body {

                line-height: 1.6;
                padding-top: 50px;
                /* For demo space */
            }

            .contact {
                padding: 50px 0;
                /* Padding top and bottom for space */
                background-color: transparent;
            }

            .contact-box {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 2px;
                max-width: 400px;
                margin: 0 auto;
                text-align: center;
            }

            .contact h2 {
                font-weight: 200;
                font-size: 2.6rem;
                margin-bottom: 3rem;
            }

            .contact h2 span {
                font-weight: 500;
            }

            .map {
                width: 100%;
                height: 400px;
                /* Adjust height as needed */
                border: none;
                /* Remove border for iframe */
                border-radius: 8px;
                margin-bottom: 30px;
            }

            .social {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-size: 25px;
            }

            .social-ig {
                font-size: 16px;
                color: white;
                text-decoration: none;
                margin-top: 40px;
                margin-bottom: 10px;
            }

            .social-ig:hover {
                color: white;
                text-decoration: none;
            }

            .social-ig span {
                margin-left: 10px;
                font-size: 20px;
                font-weight: normal;
            }

            .social-wa {
                font-size: 16px;
                color: white;
                text-decoration: none;
                margin-top: 5px;
                margin-bottom: 10px;
            }

            .social-wa:hover {
                color: white;
                text-decoration: none;
            }

            .social-wa span {
                margin-left: 10px;
                font-size: 20px;
                font-weight: normal;
            }
        </style>

        <section id="hto" class="hto">
            <header class="text-white text-center text-lg-start mt-5">
                <div class="container d-flex justify-content-between align-items-center py-3">
                    <a href="#hto" class="text-white">How To Order</a>
                    <span><i class="bi bi-bag" style="margin-right: 6px;"></i><i class="bi bi-question-square"></i></span>
                </div>
            </header>
            <div class="container text-center">
                <div class="hto">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <style>
                                .hto h2 {
                                    font-weight: 200;
                                    text-align: center;
                                    font-size: 7rem;
                                    margin-bottom: 3rem;
                                    margin-top: 2rem;
                                }

                                .hto h2 span {
                                    font-weight: 500;
                                }

                                .hto p {
                                    margin-bottom: 1.5rem;
                                    /* Adjust spacing between paragraphs */
                                }

                                .warr {
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 25px;
                                }

                                .warr-icon {
                                    font-size: 50px;
                                    color: white;
                                    text-decoration: none;
                                    margin-top: 40px;
                                    margin-bottom: 10px;
                                }

                                .warr-icon:hover {
                                    color: white;
                                    text-decoration: none;
                                }

                                .warr-icon span {
                                    text-align: left;
                                    margin-left: 10px;
                                    font-size: 18px;
                                    font-weight: normal;
                                }
                            </style>
                            <h2 class="text-center mb-4"><i class="bi bi-tv"></i></h2>
                            <p class="lead text-center">1. Pilih produk yang Anda inginkan melalui katalog produk yang tersedia di situs kami. Klik "View Details" untuk melihat detail produk.</p>
                            <h2 class="text-center mb-4"><i class="bi bi-chat-left-text" style="font-size: 6.5rem;"></i></h2>
                            <p class="lead text-center">2. Klik tombol "Order Sekarang" pada halaman detail produk agar diarahkan ke halaman Whatsapp Admin FRJS, untuk melakukan pemesanan.</p>
                            <h2 class="text-center mb-4"><i class="fa-regular fa-file-lines" style="font-size: 7rem;"></i></h2>
                            <p class="lead text-center">3. Admin akan memberikan invoice pembelian beserta pengiriman, Silahkan lakukan pembayaran melalui transfer ke rekening yang tertera pada invoice.</p>
                            <h2 class="text-center mb-4"><i class="bi bi-truck"></i></h2>
                            <p class="lead text-center">4. Setelah pembayaran terkonfirmasi, pesanan akan dibuat selama waktu yang ditentukan dan produk akan dikirimkan ke lokasi anda melalui ekspedisi yang sudah disepakati.</p>

                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <section id="garansi" class="garansi">
        <header class="text-white text-center text-lg-start mt-5">
            <div class="container d-flex justify-content-between align-items-center py-3 mb-5">
                <a href="#garansi" class="text-white">Warranty Terms</a>
                <span>Kebijakan Garansi</span>
            </div>
        </header>


        <p class="lead text-center" style="font-weight: 600; margin-bottom:4px;">
            6 Bulan <span style="font-weight: 200;">Garansi Sparepart</span>
        </p>
        <p class="lead text-center" style="font-weight: 600;">
            12 Bulan <span style="font-weight: 200;">Garansi Service</span>
        </p>

        <h2 class="text-center mb-4" style="font-size:3rem;">
            <i class="fa-solid fa-screwdriver-wrench" style="margin-right: 15px;"></i><i class="bi bi-calendar-week" style="margin-right: 12px;"></i><i class="bi bi-hand-thumbs-up-fill"></i>
        </h2>

        <p class="text-center">
            Syarat & ketentuan berlaku. untuk info lebih lanjut, silahkan hubungi kontak di bawah ini.
        </p>
    </section>

    <footer class="text-white text-center text-lg-start mt-5">
        <div class="container d-flex justify-content-between align-items-center py-3">
            <a href="#contact" class="text-white">Contact</a>
            <span>© 2024 FRJS Scoreboard & LED</span>

        </div>
    </footer>

    <section id="contact" class="contact">
        <div class="container">
            <div class="row">

                <div class="col-md-6">

                    <!-- Map Section -->
                    <div class="map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.6946472080144!2d106.85877551413715!3d-6.171623962196151!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f506393c48b1%3A0xe8dc439c3edd9f4b!2sScoreboard%20%26%20LED%20Display!5e0!3m2!1sen!2sid!4v1679825900376!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Instagram -->
                    <div class="social mb-3">
                        <h2 class="text-center mb-4"><span>Our </span>Socials</h2>
                        <a href="#" class="social-ig">
                            <i class="bi bi-instagram"></i><span>@username</span>
                        </a>
                    </div>
                    <!-- WhatsApp -->
                    <div class="social">
                        <a href="https://wa.me/6287838137197?text=Halo%2C%20admin%20frjs" class="social-wa">
                            <i class="bi bi-whatsapp"></i><span>+6287838137197</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    <!-- Bootstrap JS dan dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
