<!-- <?php
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


$users = query("SELECT * FROM pengguna");

if (isset($_POST["submit"])) {

    if (tambah_pengguna($_POST) > 0) {
        echo "
        <script> 
            alert('data berhasil ditambahkan');
            document.location.href = '#';
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

?> -->

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
                  <div class="row justify-content-center" style="margin-top: 10%">
                    <div class="col-xl-9 col-lg-12 col-md-9">
                    <form method="post">
                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" id="inputPassword" name="password1" placeholder="Masukkan Password" autocomplete="off">
                                    </div>
                                </div><br>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <legend class="col-form-label col-sm-2 pt-0">Status Pengguna</legend>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="gridRadios1" value="admin" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Admin
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" id="gridRadios2" value="karyawan">
                                                <label class="form-check-label" for="gridRadios2">
                                                    Karyawan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <center><button class="btn btn-primary btn-block w-50 " type="submit" name="submit">Simpan</button>
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
