<?php
session_start();

require 'koneksi.php';


if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $sql = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$username' AND password1 = '$password'");
    $result = mysqli_fetch_array($sql);
    $cek_user = mysqli_num_rows($sql);


    if ($cek_user > 0) {
        $_SESSION['masuk'] = $result['username'];
        header("location: index.php");
        exit;
    } else {
        $error = true;
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
    <style>
        body {
            background-image: url(bg/bg4.jpg);
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
        }

        .trasnparan{
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
  </head>
  <body>
  <div class="container-fluid">
                <!-- Page Heading -->
                <div class="container">
                  <!-- Outer Row -->
                  <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-12 col-md-9">
                      <div class="card o-hidden border-0 shadow-lg my-5 trasnparan">
                        <div class="card-body p-4">
                          <!-- Nested Row within Card Body -->
                          <div class="row">
                            <div class="col-lg-1 d-none d-lg-block"></div>
                            <div class="col-lg-10">
                              <div class="p-5">
                                <div class="text-center">
                                <i class="fa fa-user fa-5x" aria-hidden="true"></i>
                                  <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>
                                <form method="post">
                                    <div class="row mb-4">
                                        <label for="username" class="col-sm-3 col-form-label">Username</label>
                                        <div class="col-sm-12">
                                             <input type="text" class="form-control trasnparan" name="username" id="username" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-12">
                                            <input type="password" class="form-control trasnparan" id="password" name="password">
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <?php if (isset($error)) : ?>
                                        <p style=" color: red; font-style: italic;"> Username atau Password salah! </p>
                                        <?php endif; ?>
                                        <button class="btn btn-outline-dark" type="submit" name="login">Login</button>
                                    </div>                                
                                </form>
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

    <script src="js/bootstrap.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>