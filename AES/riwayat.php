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

            if ($lvl == "karyawan") {
                $historys = query("SELECT * FROM file WHERE username = '$masuk'");
            } else {
                $historys = query("SELECT * FROM file");
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
                                             <div class="col-xl-12 col-lg-12 col-md-9">
                                                 <div class="card o-hidden border-0 shadow-lg my-5">
                                                     <div class="card-body p-0">
                                                         <!-- Nested Row within Card Body -->
                                                         <div class="row">
                                                             <div class="col-lg-1 d-none d-lg-block"></div>
                                                             <div class="col-lg-12">
                                                                 <div class="p-5">
                                                                     <div class="text-center">
                                                                         <h1 class="h4 text-gray-900 mb-4">Riwayat</h1>
                                                                     </div>
                                                                     <div class="table-responsive">
                                                                         <table class="table" width="100%" cellspacing="0">
                                                                             <thead>
                                                                                 <tr>
                                                                                     <th scope="col" width="10px">No</th>
                                                                                     <th scope="col">Username</th>
                                                                                     <th scope="col" width="300px">Nama File</th>
                                                                                     <th scope="col">Ukuran File</th>
                                                                                     <th scope="col">Tanggal aktivitas</th>
                                                                                     <th scope="col">Catatan</th>
                                                                                     <th scope="col">Status</th>
                                                                                 </tr>
                                                                             </thead>
                                                                             <tbody>
                                                                                 <?php $i = 1; ?>
                                                                                 <?php foreach ($historys as $history) : ?>
                                                                                     <tr>
                                                                                         <td><?= $i ?></td>
                                                                                         <td><?= $history['username']; ?></td>
                                                                                         <td><?= $history['nama_file']; ?></td>
                                                                                         <td><?= $history['ukuran_file']; ?></td>
                                                                                         <td><?= $history['tanggal']; ?></td>
                                                                                         <td><?= $history['catatan']; ?></td>
                                                                                         <td>
                                                                                             <?php
                                                                                                if ($history['status'] == '1') {
                                                                                                    echo "Enkripsi";
                                                                                                } else {
                                                                                                    echo "Dekripsi";
                                                                                                }
                                                                                                ?>
                                                                                         </td>
                                                                                     </tr>
                                                                                     <?php $i++; ?>
                                                                                 <?php endforeach; ?>
                                                                             </tbody>
                                                                         </table>
                                                                     </div>
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