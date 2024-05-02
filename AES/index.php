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
                <div class="row justify-content-center" style="margin-top: 10%">
                  <div class="col-xl-9 col-lg-12 col-md-9">
                    <div class="card mb-3 shadow-lg" style="max-width: 300%">
                      <div class="row g-0">
                        <div class="col-md-4">
                          <img src="gambar/<?= $pengguna['gambar']; ?>" class="img-fluid rounded-start" alt="..." />
                        </div>
                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title">Profil</h5>
                            <table class="table">
                              <thead>
                                <tr>
                                  <th scope="col">NIK</th>
                                  <th scope="col"><?= $pengguna['nik']; ?></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td scope="row">Username</td>
                                  <td><?= $pengguna['username']; ?></td>
                                </tr>
                                <tr>
                                  <td scope="row">Nama</td>
                                  <td><?= $pengguna['nama']; ?></td>
                                </tr>
                                <tr>
                                  <td scope="row">No HP</td>
                                  <td colspan="2"><?= $pengguna['no_hp']; ?></td>
                                </tr>
                                <tr>
                                  <td scope="row">Alamat</td>
                                  <td colspan="2"><?= $pengguna['alamat']; ?></td>
                                </tr>
                                <tr>
                                  <td scope="row">Status</td>
                                  <td colspan="2"><?= $pengguna['level']; ?></td>
                                </tr>
                              </tbody>
                            </table>
                            <a href="edit_profil.php?username=<?= $pengguna['username']; ?>" type="button" class="btn btn-outline-dark">Edit Profil</a>
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