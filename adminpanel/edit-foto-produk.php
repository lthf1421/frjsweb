<?php
require "../koneksi.php";

$id = $_GET['p'];

$query = mysqli_query($con, "SELECT * FROM produk WHERE id='$id'");
$data = mysqli_fetch_array($query);

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
    <title>Edit Kategori</title>
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
                    Gallery
                </li>
            </ol>
        </nav>

        <style>
            .bold-label {
                font-weight: bold;
            }

            .uploaded-img {
                width: 420px;
                height: 280px;
                /* Adjust image width as needed */
                display: block;
                margin-bottom: 10px;
                /* Optional: Add margin bottom for spacing */
            }

            .delete-btn {
                background-color: transparent;
                border-color: red;
                color: black;
            }

            .delete-btn:hover {
                background-color: yellow;
                border-color: red;
                color: rebeccapurple;
            }

            .delete-btn .bi-trash-fill {
                color: red;
            }
        </style>


        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4 shadow">
                        <h3 class="mb-4">Gallery</h3>
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="mb-4 ">
                                <label for="currentFoto" class="bold-label">Foto Utama</label>
                                <br>
                                <img src="../img/<?php echo $data['foto'] ?>" alt="" class="uploaded-img" width="150px">
                            </div>
                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="foto" class="text-center">Edit Foto Utama</label>
                                <div class="input-group">
                                    <input type="file" name="foto" id="foto" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none;">Undo</button>
                                    </div>
                                </div>
                            </div>

                            <form method="post" action="">
                                <div class="mb-4">
                                    <label for="currentFoto" class="bold-label">Foto Alternatif 1</label>
                                    <br>
                                    <?php if (!empty($data['foto1'])) : ?>
                                        <img src="../img/<?php echo $data['foto1'] ?>" alt="" class="uploaded-img" width="150px">
                                        <div>
                                            <button class="btn btn-outline-warning delete-btn" name="hapusfoto1" data-foto="foto1" type="submit"><i class="bi bi-trash-fill"></i> Delete</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['hapusfoto1'])) {
                                $id = mysqli_real_escape_string($con, $_GET['p']);

                                // Execute delete query
                                $queryHapus = mysqli_query($con, "UPDATE produk SET foto1 = NULL WHERE id='$id'");

                                if ($queryHapus) {
                            ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Foto Alternatif berhasil dihapus
                                    </div>
                                    <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?php echo $data['id']; ?>" />
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        Terjadi kesalahan saat menghapus foto alternatif.
                                    </div>
                            <?php
                                }
                            }
                            ?>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt1">Edit Foto Alternatif 1</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt1" id="fotoalt1" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                            </div>

                            <form method="post" action="">
                                <div class="mb-4">
                                    <label for="currentFoto" class="bold-label">Foto Alternatif 2</label>
                                    <br>
                                    <?php if (!empty($data['foto2'])) : ?>
                                        <img src="../img/<?php echo $data['foto2'] ?>" alt="" class="uploaded-img" width="150px">
                                        <div>
                                            <button class="btn btn-outline-warning delete-btn" name="hapusfoto2" data-foto="foto1" type="submit"><i class="bi bi-trash-fill"></i> Delete</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['hapusfoto2'])) {
                                $id = mysqli_real_escape_string($con, $_GET['p']);

                                // Execute delete query
                                $queryHapus = mysqli_query($con, "UPDATE produk SET foto2 = NULL WHERE id='$id'");

                                if ($queryHapus) {
                            ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Foto Alternatif berhasil dihapus
                                    </div>
                                    <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?php echo $data['id']; ?>" />
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        Terjadi kesalahan saat menghapus foto alternatif.
                                    </div>
                            <?php
                                }
                            }
                            ?>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt2">Edit Foto Alternatif 2</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt2" id="fotoalt2" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                            </div>

                            <form method="post" action="">
                                <div class="mb-4">
                                    <label for="currentFoto" class="bold-label">Foto Alternatif 3</label>
                                    <br>
                                    <?php if (!empty($data['foto3'])) : ?>
                                        <img src="../img/<?php echo $data['foto3'] ?>" alt="" class="uploaded-img" width="150px">
                                        <div>
                                            <button class="btn btn-outline-warning delete-btn" name="hapusfoto3" data-foto="foto1" type="submit"><i class="bi bi-trash-fill"></i> Delete</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['hapusfoto3'])) {
                                $id = mysqli_real_escape_string($con, $_GET['p']);

                                // Execute delete query
                                $queryHapus = mysqli_query($con, "UPDATE produk SET foto3 = NULL WHERE id='$id'");

                                if ($queryHapus) {
                            ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Foto Alternatif berhasil dihapus
                                    </div>
                                    <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?php echo $data['id']; ?>" />
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        Terjadi kesalahan saat menghapus foto alternatif.
                                    </div>
                            <?php
                                }
                            }
                            ?>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt3">Edit Foto Alternatif 3</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt3" id="fotoalt3" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                            </div>

                            <form method="post" action="">
                                <div class="mb-4">
                                    <label for="currentFoto" class="bold-label">Foto Alternatif 4</label>
                                    <br>
                                    <?php if (!empty($data['foto4'])) : ?>
                                        <img src="../img/<?php echo $data['foto4'] ?>" alt="" class="uploaded-img" width="150px">
                                        <div>
                                            <button class="btn btn-outline-warning delete-btn" name="hapusfoto4" data-foto="foto1" type="submit"><i class="bi bi-trash-fill"></i> Delete</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </form>
                            <?php
                            if (isset($_POST['hapusfoto4'])) {
                                $id = mysqli_real_escape_string($con, $_GET['p']);

                                // Execute delete query
                                $queryHapus = mysqli_query($con, "UPDATE produk SET foto4 = NULL WHERE id='$id'");

                                if ($queryHapus) {
                            ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        Foto Alternatif berhasil dihapus
                                    </div>
                                    <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?php echo $data['id']; ?>" />
                                <?php
                                } else {
                                ?>
                                    <div class="alert alert-danger mt-3" role="alert">
                                        Terjadi kesalahan saat menghapus foto alternatif.
                                    </div>
                            <?php
                                }
                            }
                            ?>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt4">Edit Foto Alternatif 4</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt4" id="fotoalt4" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3" name="simpan">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <?php
        if (isset($_POST['simpan'])) {

            // Check if a file was uploaded
            if (!empty($_FILES['bg']['name'])) {
                $target_dir = "../img/";
                $nama_file = basename($_FILES["bg"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["bg"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if ($image_size > 10000000) {
        ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        File tidak boleh lebih dari 10 mb
                    </div>
                <?php
                } elseif (!in_array($imageFileType, ['jpg', 'png', 'gif'])) {
                ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Format file harus jpg, png atau gif
                    </div>
                    <?php
                } else {
                    // Upload the file
                    if (move_uploaded_file($_FILES["bg"]["tmp_name"], $target_dir . $new_name)) {
                        // Update both nama and bg fields in database
                        $queryUpdate = mysqli_query($con, "UPDATE kategori SET nama='$nama', bg='$new_name' WHERE id='$id'");
                    } else {
                    ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Gagal mengunggah file
                        </div>
                <?php
                    }
                }
            } else {
                // Only update the nama field in database
                $queryUpdate = mysqli_query($con, "UPDATE kategori SET nama='$nama' WHERE id='$id'");
            }

            if (isset($queryUpdate) && $queryUpdate) {
                ?>
                <div class="alert alert-primary mt-3" role="alert">
                    Kategori berhasil diupdate
                </div>
                <meta http-equiv="refresh" content="2; url=kategori.php" />
            <?php
            } else {
                echo mysqli_error($con);
            }
        }

        if (isset($_POST['hapus'])) {
            $queryHapus = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");

            if ($queryHapus) {
            ?>
                <div class="alert alert-success mt-3" role="alert">
                    Produk berhasil dihapus
                </div>
                <meta http-equiv="refresh" content="2; url=produk.php" />
        <?php
            }
        }
        ?>
        <!--End of tambah produk -->

        <!-- Include jQuery library -->


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