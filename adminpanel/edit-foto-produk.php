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
    <title>Galeri <?= $data['nama'] ?></title>
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
                    Galeri <?= $data['nama'] ?>
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
        </style>

        <a href="../adminpanel/produk.php" class="no-decoration text-white">
            <div class="btn btn-primary mb-3">
                <i class="fas fa-long-arrow-alt-left"></i> Kembali
            </div>
        </a>

        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4 shadow">
                        <h3 class="mb-4">Galeri <?= $data['nama'] ?></h3>
                        <p class="text-muted"> *Note : selalu klik "Update" sebelum menginput file foto selanjutnya.</p>

                        <!-- Command SQL untuk update foto utama & alternatif -->

                        <?php
                        if (isset($_POST['simpanfotoutama'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['foto'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["foto"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["foto"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 10000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 10 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Utama berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />

                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }

                        ?>

                        <!-- Update foto alternatif 1 -->

                        <?php
                        if (isset($_POST['simpanfotoalt1'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt1'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt1"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["foto"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 50 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt1"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto1='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 1 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />

                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }



                        ?>

                        <!-- Update foto alternatif 2 -->

                        <?php
                        if (isset($_POST['simpanfotoalt2'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt2'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt2"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt2"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt2"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto2='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 2 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />

                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }



                        ?>

                        <!-- Update foto alternatif 3 -->

                        <?php
                        if (isset($_POST['simpanfotoalt3'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt3'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt3"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt3"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt3"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto3='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 3 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />

                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }



                        ?>

                        <!-- Update foto alternatif 4 -->

                        <?php
                        if (isset($_POST['simpanfotoalt4'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt4'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt4"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt4"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 10000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 10 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt4"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto4='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 4 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />

                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }

                        ?>

                        <!-- Update foto alternatif 5 -->

                        <?php
                        if (isset($_POST['simpanfotoalt5'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt5'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt5"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt5"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt5"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto5='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 5 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />
                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }


                        ?>

                        <!-- Update foto alternatif 5 -->

                        <?php
                        if (isset($_POST['simpanfotoalt6'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt6'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt6"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt6"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt6"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto6='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 6 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />
                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }


                        ?>

                        <!-- Update foto alternatif 7 -->

                        <?php
                        if (isset($_POST['simpanfotoalt7'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt7'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt7"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt7"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt7"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto7='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 7 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />
                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }


                        ?>

                        <!-- Update foto alternatif 8 -->

                        <?php
                        if (isset($_POST['simpanfotoalt8'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt8'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt8"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt8"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt8"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto8='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 8 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />
                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }


                        ?>

                        <!-- Update foto alternatif 9 -->

                        <?php
                        if (isset($_POST['simpanfotoalt9'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt9'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt9"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt9"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt9"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto9='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 9 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />
                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }

                        ?>

                        <!-- Update foto alternatif 10 -->

                        <?php
                        if (isset($_POST['simpanfotoalt10'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt10'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt10"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt10"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt10"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto10='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 10 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />
                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }

                        ?>

                        <!-- Update foto alternatif 11 -->

                        <?php
                        if (isset($_POST['simpanfotoalt11'])) {

                            // Check if a file was uploaded
                            if (!empty($_FILES['fotoalt11'])) {
                                $target_dir = "../img/";
                                $nama_file = basename($_FILES["fotoalt11"]["name"]);
                                $target_file = $target_dir . $nama_file;
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                $image_size = $_FILES["fotoalt11"]["size"];
                                $random_name = generateRandomString(20);
                                $new_name = $random_name . "." . $imageFileType;

                                if ($image_size > 5000000) {
                        ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        File tidak boleh lebih dari 5 mb
                                    </div>
                                <?php
                                } elseif (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
                                ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Format file harus jpg, png atau jpeg
                                    </div>
                                    <?php
                                } else {
                                    // Upload the file
                                    if (move_uploaded_file($_FILES["fotoalt11"]["tmp_name"], $target_dir . $new_name)) {
                                        // Update both nama and bg fields in database
                                        $queryUpdate = mysqli_query($con, "UPDATE produk SET foto11='$new_name' WHERE id='$id'");
                                    } else {
                                    ?>
                                        <div class="alert alert-warning mt-3" role="alert">
                                            Gagal mengunggah file
                                        </div>
                                <?php
                                    }
                                }
                            }

                            if (isset($queryUpdate) && $queryUpdate) {
                                ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Foto Alternatif 11 berhasil diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=edit-foto-produk.php?p=<?= $data['id']; ?>" />
                        <?php
                            } else {
                                echo mysqli_error($con);
                            }
                        }



                        ?>

                        <!-- End of Command SQL untuk hapus foto utama & alternatif -->

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

                        if (isset($_POST['hapusfoto5'])) {
                            $id = mysqli_real_escape_string($con, $_GET['p']);

                            // Execute delete query
                            $queryHapus = mysqli_query($con, "UPDATE produk SET foto5 = NULL WHERE id='$id'");

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

                        if (isset($_POST['hapusfoto6'])) {
                            $id = mysqli_real_escape_string($con, $_GET['p']);

                            // Execute delete query
                            $queryHapus = mysqli_query($con, "UPDATE produk SET foto6 = NULL WHERE id='$id'");

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

                        if (isset($_POST['hapusfoto7'])) {
                            $id = mysqli_real_escape_string($con, $_GET['p']);

                            // Execute delete query
                            $queryHapus = mysqli_query($con, "UPDATE produk SET foto7 = NULL WHERE id='$id'");

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


                        if (isset($_POST['hapusfoto8'])) {
                            $id = mysqli_real_escape_string($con, $_GET['p']);

                            // Execute delete query
                            $queryHapus = mysqli_query($con, "UPDATE produk SET foto8 = NULL WHERE id='$id'");

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

                        if (isset($_POST['hapusfoto9'])) {
                            $id = mysqli_real_escape_string($con, $_GET['p']);

                            // Execute delete query
                            $queryHapus = mysqli_query($con, "UPDATE produk SET foto9 = NULL WHERE id='$id'");

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

                        if (isset($_POST['hapusfoto10'])) {
                            $id = mysqli_real_escape_string($con, $_GET['p']);

                            // Execute delete query
                            $queryHapus = mysqli_query($con, "UPDATE produk SET foto10 = NULL WHERE id='$id'");

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

                        if (isset($_POST['hapusfoto11'])) {
                            $id = mysqli_real_escape_string($con, $_GET['p']);

                            // Execute delete query
                            $queryHapus = mysqli_query($con, "UPDATE produk SET foto11 = NULL WHERE id='$id'");

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
                        <!-- End of Command SQL untuk hapus foto utama & alternatif -->

                        <!-- End of Command SQL untuk update foto utama & alternatif -->



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
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoutama"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                </div>
                            </div>


                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 1</label>
                                <br>
                                <?php if (!empty($data['foto1'])) : ?>
                                    <img src="../img/<?php echo $data['foto1'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>


                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt1">Edit Foto Alternatif 1</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt1" id="fotoalt1" class="form-control">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt1"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto1"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>


                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 2</label>
                                <br>
                                <?php if (!empty($data['foto2'])) : ?>
                                    <img src="../img/<?php echo $data['foto2'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>


                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt2">Edit Foto Alternatif 2</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt2" id="fotoalt2" class="form-control">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt2"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto2"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 3</label>
                                <br>
                                <?php if (!empty($data['foto3'])) : ?>
                                    <img src="../img/<?php echo $data['foto3'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>


                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt3">Edit Foto Alternatif 3</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt3" id="fotoalt3" class="form-control">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt3"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto3"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 4</label>
                                <br>
                                <?php if (!empty($data['foto4'])) : ?>
                                    <img src="../img/<?php echo $data['foto4'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt4">Edit Foto Alternatif 4</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt4" id="fotoalt4" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt4"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto4"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 5</label>
                                <br>
                                <?php if (!empty($data['foto5'])) : ?>
                                    <img src="../img/<?php echo $data['foto5'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt5">Edit Foto Alternatif 5</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt5" id="fotoalt5" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt5"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto5"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 6</label>
                                <br>
                                <?php if (!empty($data['foto6'])) : ?>
                                    <img src="../img/<?php echo $data['foto6'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt6">Edit Foto Alternatif 6</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt6" id="fotoalt6" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt6"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto6"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 7</label>
                                <br>
                                <?php if (!empty($data['foto7'])) : ?>
                                    <img src="../img/<?php echo $data['foto7'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt7">Edit Foto Alternatif 7</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt7" id="fotoalt7" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt7"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto7"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 8</label>
                                <br>
                                <?php if (!empty($data['foto8'])) : ?>
                                    <img src="../img/<?php echo $data['foto8'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt8">Edit Foto Alternatif 8</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt8" id="fotoalt8" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt8"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto8"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 9</label>
                                <br>
                                <?php if (!empty($data['foto9'])) : ?>
                                    <img src="../img/<?php echo $data['foto9'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt9">Edit Foto Alternatif 9</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt9" id="fotoalt9" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt9"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto9"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 10</label>
                                <br>
                                <?php if (!empty($data['foto10'])) : ?>
                                    <img src="../img/<?php echo $data['foto10'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt10">Edit Foto Alternatif 10</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt10" id="fotoalt10" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt10"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto11"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="currentFoto" class="bold-label">Foto Alternatif 11</label>
                                <br>
                                <?php if (!empty($data['foto11'])) : ?>
                                    <img src="../img/<?php echo $data['foto11'] ?>" alt="" class="uploaded-img" width="150px">
                                <?php endif; ?>
                            </div>

                            <div class="file-upload mb-4 border-bottom pb-3">
                                <label for="fotoalt11">Edit Foto Alternatif 11</label>
                                <div class="input-group">
                                    <input type="file" name="fotoalt11" id="fotoalt11" class="form-control">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-warning delete-btn" type="button" style="display:none; background-color:darkkhaki;">Undo</button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary mt-3" name="simpanfotoalt11"><i class="bi bi-arrow-bar-up" style="color:white;"></i> Update</button>
                                    <button type="submit" class="btn btn-danger mt-3 delete-btn" name="hapusfoto11"><i class="bi bi-trash" style="color:white;"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
