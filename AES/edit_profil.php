<?php
require 'koneksi.php';
session_start();

if (!isset($_SESSION["masuk"])) {
    header("Location: login.php ");
    exit;
} else {
    $masuk = $_SESSION['masuk'];
    $sql_masuk = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$masuk'");
    $update = mysqli_query($conn, "UPDATE pengguna SET waktu_terakhir=now() WHERE username = '$masuk'");
    $vusr = mysqli_fetch_array($sql_masuk);
    $lvl = $vusr['level'];
}

$pengguna = query("SELECT * FROM info_pengguna 
INNER JOIN pengguna ON info_pengguna.username = pengguna.username 
WHERE info_pengguna.username = '$masuk'")[0];


if (isset($_POST["submit"])) {

    if (tambah_info($_POST) > 0) {
        echo "
        <script> 
            alert('data berhasil ditambahkan');
            document.location.href = 'index.php';
        </script>    
    ";
    } else {

        echo "
    <script> 
            alert('data gagal ditambahkan');
            document.location.href = '#';
        </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
    <title>Enkriptor</title>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="index.php">Hello <?= $vusr['username'] ?></a>
                    <p style="color: gray">______________________</p>
                </div>
                <ul class="sidebar-nav">
                    <li class="sidebar-header"><i class="fa fa-bars" aria-hidden="true"></i> MENU</li>
                    <li class="sidebar-item">
                        <i class="fa fa-address-card" aria-hidden="true"></i>
                        <a href="index.php" class="sidebar-link">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            Halaman Utama
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="enkripsi.php" class="sidebar-link">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            Enkripsi Dokumen
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="dekripsi.php" class="sidebar-link">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            Dekripsi Dokumen
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="riwayat.php" class="sidebar-link">
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                            Riwayat
                        </a>
                    </li>
                    <?php if ($lvl == 'admin') : ?>
                        <li class="sidebar-item">
                            <a href="tambah.php" class="sidebar-link">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Tambah Pengguna
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" type="button" data-bs-theme="light">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="nav justify-content-end ml-auto">
                    <li class="nav-item">
                        <a class="dropdown-item" href="logout.php" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            Keluar
                        </a>
                    </li>
                </ul>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <!-- card start -->
                        <div class="container-fluid">
                            <!-- Page Heading -->
                            <div class="container">
                                <!-- Outer Row -->
                                <div class="row justify-content-center">
                                    <div class="col-xl-9 col-lg-12 col-md-9">
                                        <div class="card o-hidden border-0 shadow-lg my-5">
                                            <div class="card-body p-0">
                                                <!-- Nested Row within Card Body -->
                                                <div class="row">
                                                    <div class="col-lg-1 d-none d-lg-block"></div>
                                                    <div class="col-lg-10">
                                                        <div class="p-5">
                                                            <div class="text-center">
                                                                <h1 class="h4 text-gray-900 mb-4">Ubah Profil</h1>
                                                            </div>
                                                            <form action="" method="post" enctype="multipart/form-data">
                                                                <!-- <div class="form-group">
                                                            <div class="custom-file">
                                                                <label for="password">File</label>
                                                                <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                                                                <label class="custom-file-label" for="validatedCustomFile">Pilih file</label>
                                                            </div>
                                                        </div> -->
                                                        <center><img src="gambar/<?= $pengguna['gambar']; ?>" class="" alt="..." width="150">
                                                                    <div class="col-sm-6">
                                                                    <input type="file" class="form-control" name="gambar" id="gambar" value="<?= $pengguna['gambar']; ?>">
                                                                        <input type="hidden" name="gambarLama" value="<?= $pengguna['gambar']; ?>">
                                                                    </div>
                                                                <br>
                                                                <div class="form-group row">
                                                                    <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" name="nik" id="nik" value="<?= $pengguna['nik']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" name="username" id="username" value="<?= $pengguna['username']; ?>" readonly required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $pengguna['nama']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="no_hp" class="col-sm-3 col-form-label">No HP</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" name="no_hp" id="no_hp" value="<?= $pengguna['no_hp']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" name="alamat" id="alamat" value="<?= $pengguna['alamat']; ?>" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" name="status" id="status" value="<?= $pengguna['level']; ?>" readonly required>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <center><button class="btn btn-primary btn-block" type="submit" name="submit">Simpan Perubahan</button>
                                                                    <hr>
                                                            </form>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.container-fluid -->
                            <!-- End of Main Content -->
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Anda yakin ingin keluar?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a class="btn btn-danger" href="logout.php">Keluar</a>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>