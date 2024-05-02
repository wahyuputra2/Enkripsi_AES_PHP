<?php
session_start();
include "koneksi.php";   //memasukan koneksi
include "AES.php"; //memasukan file AES

if (isset($_POST['encrypt_now'])) {
    $publicKeyFile = 'public_key.pem';
    $ambilKunci = $_POST["pwdfile"];
    $hash = hash('sha256', $ambilKunci, true);
    $kunci = substr(base64_encode($hash), 0, 16);
    $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyFile));
    $encryptedData = '';
    $enkkunci = openssl_public_encrypt($ambilKunci, $encryptedData, $publicKey);
    $encryptedData = base64_encode($encryptedData);


    $user          = $_SESSION['masuk'];
    $key           = mysqli_escape_string($conn, $kunci);
    $deskripsi = mysqli_escape_string($conn, $_POST['catatan']);

    $file_tmpname   = $_FILES['file']['tmp_name'];
    //untuk nama file url
    date_default_timezone_set('Asia/Jakarta');
    $file           = date("d_His") . "-" . $_FILES['file']['name'];
    $new_file_name  = strtolower($file);
    $final_file     = str_replace(' ', '-', $new_file_name);
    //untuk nama file
    $filename       = rand(1000, 100000) . "-" . pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
    $new_filename  = strtolower($filename);
    $finalfile     = str_replace(' ', '-', $new_filename);
    $size           = filesize($file_tmpname);
    $size2          = (filesize($file_tmpname)) / 1024;
    $info           = pathinfo($final_file);
    $file_source        = fopen($file_tmpname, 'rb');
    $ext            = $info["extension"];

    if ($ext == "pdf" || $ext == "docx" || $ext == "pptx" || $ext == "txt") {
    } else {
        echo ("<script language='javascript'>
        window.location.href='encrypt.php';
        window.alert('Maaf, file yang bisa dienkrip hanya word, text, ppt ataupun pdf.');
        </script>");
        exit();
    }

    if ($size2 > 3084) {
        echo ("<script language='javascript'>
        window.location.href='home.php?encrypt';
        window.alert('Maaf, file tidak bisa lebih besar dari 3MB.');
        </script>");
        exit();
    }

    $sql1   = "INSERT INTO file VALUES ('', '$user', '$final_file', '$finalfile.txt', '', '$size2', '$encryptedData', now(), '1', '$deskripsi')";
    $query1  = mysqli_query($conn, $sql1) or die(mysqli_error($conn));

    $sql2   = "select * from file where url_file =''";
    $query2  = mysqli_query($conn, $sql2) or die(mysqli_error($conn));

    $url   = $finalfile . ".txt";
    $file_url = "file_enkripsi/$url";

    $sql3   = "UPDATE file SET url_file ='$file_url' WHERE url_file=''";
    $query3  = mysqli_query($conn, $sql3) or die(mysqli_error($conn));

    $file_output        = fopen($file_url, 'wb');

    $mod    = $size % 16;
    if ($mod == 0) {
        $banyak = $size / 16;
    } else {
        $banyak = ($size - $mod) / 16;
        $banyak = $banyak + 1;
    }

    if (is_uploaded_file($file_tmpname)) {
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        $aes = new AES($key);

        for ($bawah = 0; $bawah < $banyak; $bawah++) {
            $data    = fread($file_source, 16);
            $cipher  = $aes->encrypt($data);
            fwrite($file_output, $cipher);
        }
        fclose($file_source);
        fclose($file_output);

        echo ("<script language='javascript'>
        window.location.href='enkripsi.php';
        window.alert('Enkripsi Berhasil..');
        </script>");
    } else {
        echo ("<script language='javascript'>
        window.location.href='enkripsi.php';
        window.alert('Encrypt file mengalami masalah..');
        </script>");
    }
}
