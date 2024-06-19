<?php
require "../koneksi.php";

$query = mysqli_query($con, "SELECT * FROM produk");
$jumlahProduk = mysqli_num_rows($query);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori");
$queryUkuran = mysqli_query($con, "SELECT * FROM ukuran");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <script src="https://kit.fontawesome.com/296a2adfbf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

    form div {
        margin-bottom: 10px;
    }

    .file-upload {
        margin-bottom: 15px;
    }

    .input-group {
        position: relative;
    }

    .delete-btn {
        background-color: #dc3545;
        color: #fff;
        border: none;
    }

    .delete-btn:hover {
        background-color: #c82333;
    }

    /* Custom CSS for additional styling */
    .btn-custom {
        padding: 10px 20px;
        /* Adjust padding as needed */
        border-radius: 5px;
        /* Rounded corners */
    }

    .btn-custom a {
        text-decoration: none;
        /* Remove underline */
    }

    .btn-custom a:hover {
        text-decoration: none;
        /* Remove underline on hover */
        opacity: 0.8;
        /* Reduce opacity on hover */
    }

    .btn-custom i {
        color: #fff;
        margin-right: 5px;
        /* Adjust spacing between icon and text */
    }

    /* Custom CSS for paper-like appearance */
    .card {
        border: none;
        border-radius: 12px;
        /* Adjust border radius as needed */
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        /* Adjust shadow as needed */
        width: 100%;
        /* Ensure the card spans full width of its container */
        max-width: 800px;
        /* Limit card width if needed */
    }

    .alert-custom {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
        padding: 10px;
        border-radius: 5px;
    }


    .file-upload {
        /* Adjust padding as needed */
        border-radius: 8px;
        /* Adjust border radius as needed */
        margin-bottom: 20px;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel" class="no-decoration text-muted">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="../adminpanel/produk.php" class="no-decoration text-muted">
                        Produk
                    </a>
                </li>
                <li class="breadcrumb-item active aria-current-page">
                    Tambah Kategori
                </li>
            </ol>
        </nav>

        <a href="../adminpanel/kategori.php" class="no-decoration text-white">
            <div class="btn btn-primary mb-3">
                <i class="fas fa-long-arrow-alt-left"></i> Kembali
            </div>
        </a>


        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4 shadow">
                        <h3 class="mb-4">Tambah Kategori</h3>

                        <?php
                        if (isset($_POST['simpan'])) {
                            $nama = htmlspecialchars($_POST['nama']);

                            $target_dir = "../img/";
                            $nama_file = basename($_FILES["bg"]["name"]);
                            $target_file = $target_dir . $nama_file;
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                            $image_size = $_FILES["bg"]["size"];
                            $random_name = generateRandomString(20);
                            $new_name = $random_name . "." . $imageFileType;

                            if ($nama == '') {
                        ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    Nama kategori wajib diisi
                                </div>
                                <?php
                            } else {
                                if ($nama_file != '') {
                                    if ($image_size > 10000000) {
                                ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            File tidak boleh lebih dari 10 mb
                                        </div>
                                        <?php
                                    } else {
                                        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                                        ?>
                                            <div class="alert alert-warning mt-3" role="alert">
                                                Format file harus jpg, png atau gif
                                            </div>
                                    <?php
                                        } else {
                                            move_uploaded_file($_FILES["bg"]["tmp_name"], $target_dir . $new_name);
                                        }
                                    }
                                }
                                $queryTambah = mysqli_query($con, "INSERT INTO kategori (nama, bg)
                                VALUES ('$nama', '$new_name')");

                                if ($queryTambah) {
                                    ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Kategori baru berhasil disimpan
                                    </div>
                                    <meta http-equiv="refresh" content="2; url=kategori.php" />
                        <?php
                                } else {
                                    echo mysqli_error($con);
                                }
                            }
                        }
                        ?>

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nama">Nama Kategori</label>
                                <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" placeholder="SB99C" required>
                            </div>

                            <!-- File Upload Section -->
                            <div class="file-upload mb-4" id="file-upload-1">
                                <label for="foto">Background</label>
                                <div class="input-group">
                                    <input type="file" name="bg" id="bg" class="form-control" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger delete-btn" type="button" style="display:none;">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3" name="simpan">Simpan</button>
                        </form>
                    </div>
                </div>

            </div>
            <!--End of tambah produk -->

            <!-- Delete files on foto form-->

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Select all file upload containers
                    const fileUploads = document.querySelectorAll('.file-upload');

                    // Iterate over each file upload container
                    fileUploads.forEach(function(upload) {
                        const fileInput = upload.querySelector('input[type="file"]');
                        const deleteBtn = upload.querySelector('.delete-btn');

                        fileInput.addEventListener('change', function() {
                            const fileName = this.files[0].name;
                            deleteBtn.style.display = 'inline-block'; // Show delete button
                            deleteBtn.addEventListener('click', function() {
                                fileInput.value = ''; // Clear the file input
                                deleteBtn.style.display = 'none'; // Hide the delete button
                            });
                        });
                    });
                });
            </script>
            <!-- End of Delete files on foto form-->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>
