<?php
require "../koneksi.php";

$id = $_GET['p'];

$query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori, c.panjang AS panjang_ukuran, c.lebar AS lebar_ukuran 
                             FROM produk a 
                             INNER JOIN kategori b ON a.kategori_id = b.id
                             INNER JOIN ukuran c ON a.ukuran_id = c.id
                             WHERE a.id='$id'");
$data = mysqli_fetch_array($query);
$queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");
$queryUkuran = mysqli_query($con, "SELECT * FROM ukuran WHERE id!='$data[ukuran_id]'");

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
                    Tambah Produk
                </li>
            </ol>
        </nav>

        <a href="../adminpanel/produk.php" class="no-decoration text-white">
            <div class="btn btn-primary mb-3">
                <i class="fas fa-long-arrow-alt-left"></i> Kembali
            </div>
        </a>


        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4 shadow">

                        <h3 class="mb-4">Edit Data Produk</h3>

                        <?php
                        if (isset($_POST['simpan'])) {
                            $nama = htmlspecialchars($_POST['nama']);
                            $kategori = htmlspecialchars($_POST['kategori']);
                            $ukuran = htmlspecialchars($_POST['ukuran']);
                            $harga = htmlspecialchars($_POST['harga']);
                            $detail = htmlspecialchars($_POST['detail']);
                            $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);

                            if ($nama == '' || $harga == '') {
                        ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    Nama dan Harga wajib diisi
                                </div>
                                <?php
                            } else {
                                $queryUpdate = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', ukuran_id='$ukuran', nama='$nama', harga='$harga', detail='$detail',
                                    ketersediaan_stok='$ketersediaan_stok' WHERE id=$id");

                                if ($queryUpdate) {
                                ?>
                                    <div class="alert alert-primary mt-3" role="alert">
                                        Produk berhasil diupdate
                                    </div>

                                    <meta http-equiv="refresh" content="2" ; url="adminpanel/produk.php" ; />

                                <?php
                                } else {
                                    echo mysqli_error($con);
                                }
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

                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" autocomplete="off" placeholder="SB99C">
                            </div>

                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="<?php echo $data['kategori_id']; ?>"><?php echo $data['nama_kategori']; ?></option>
                                    <?php while ($kategoriData = mysqli_fetch_array($queryKategori)) { ?>
                                        <option value="<?php echo $kategoriData['id']; ?>"><?php echo $kategoriData['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="ukuran">Ukuran</label>
                                <select name="ukuran" id="ukuran" class="form-control">
                                    <option value="<?php echo $data['ukuran_id']; ?>"><?php echo $data['panjang_ukuran']; ?>cm x <?php echo $data['lebar_ukuran']; ?>cm</option>
                                    <?php while ($ukuranData = mysqli_fetch_array($queryUkuran)) : ?>
                                        <option value="<?php echo $ukuranData['id']; ?>"><?php echo $ukuranData['panjang']; ?> cm x <?php echo $ukuranData['lebar']; ?> cm</option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="harga">Harga <span class="text-muted text-small">*isi hanya dengan angka, hindari koma / titik</span></label>
                                <input type="number" id="harga" name="harga" value="<?php echo $data['harga']; ?>" class="form-control" autocomplete="off" placeholder="999999">
                            </div>

                            <!-- File Upload Section -->

                            <!--

                            <div>
                                <div>
                                    <label for="currentFoto">Foto Utama awal=</label>
                                    <img src="../img/<?php // echo $data['foto1'] 
                                                        ?>" height="100px" width="100px">
                                </div>
                                <div>
                                    <label for="currentFoto">Foto Alternatif awal =</label>
                                    <?php //if (!empty($data['foto1'])) : 
                                    ?>
                                        <img src="../img/<? //php echo $data['foto1'] 
                                                            ?>" height="100px" width="100px">
                                    <?php // endif; 
                                    ?>
                                    <?php // if (!empty($data['foto2'])) : 
                                    ?>
                                        <img src="../img/<?php // echo $data['foto2'] 
                                                            ?>" height="100px" width="100px">
                                    <?php // endif; 
                                    ?>
                                    <?php // if (!empty($data['foto3'])) : 
                                    ?>
                                        <img src="../img/<?php // echo $data['foto3'] 
                                                            ?>" height="100px" width="100px">
                                    <?php // endif; 
                                    ?>
                                    <?php // if (!empty($data['foto4'])) : 
                                    ?>
                                        <img src="../img/<?php echo $data['foto4'] ?>" height="100px" width="100px">
                                    <?php // endif; 
                                    ?>
                                </div>
                            </div>

                            <div class="file-upload mb-4" id="file-upload-1">
                                <label for="foto">Masukan Foto Utama baru :</label>
                                <div>
                                    <div class="input-group">
                                        <input type="file" name="foto" id="foto" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-danger delete-btn" type="button" style="display:none;"><i class="bi bi-trash-fill"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="file-upload mb-4" id="file-upload-3">
                                    <label for="fotoalt1">Foto Alternatif 1</label>
                                    <div class="input-group">
                                        <input type="file" name="fotoalt1" id="fotoalt1" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-danger delete-btn" type="button" style="display:none;">Delete</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="file-upload mb-4" id="file-upload-3">
                                    <label for="fotoalt2">Foto Alternatif 2</label>
                                    <div class="input-group">
                                        <input type="file" name="fotoalt2" id="fotoalt2" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-danger delete-btn" type="button" style="display:none;">Delete</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="file-upload mb-4" id="file-upload-4">
                                    <label for="fotoalt3">Foto Alternatif 3</label>
                                    <div class="input-group">
                                        <input type="file" name="fotoalt3" id="fotoalt3" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-danger delete-btn" type="button" style="display:none;">Delete</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="file-upload mb-4" id="file-upload-5">
                                    <label for="fotoalt4">Foto Alternatif 4</label>
                                    <div class="input-group">
                                        <input type="file" name="fotoalt4" id="fotoalt4" class="form-control">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-danger delete-btn" type="button" style="display:none;">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                    -->

                            <div>
                                <label for="detail">Deskripsi Produk</label>
                                <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"><?php echo $data['detail'] ?></textarea>
                                </textarea>
                            </div>

                            <div>
                                <label for="ketersediaan_stok">Ketersediaan Stok</label>
                                <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                                    <option value="<?php echo $data['ketersediaan_stok'] ?>"><?php echo $data['ketersediaan_stok'] ?></option>
                                    <?php
                                    if ($data['ketersediaan_stok'] == 'pre-order') {
                                    ?>
                                        <option value="ready stock">Ready Stock</option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="pre-order">Pre-order</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary mt-3" name="simpan">Simpan</button>
                                <button type="submit" class="btn btn-danger mt-3" name="hapus">Hapus Produk</button>
                            </div>
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
