<?php
session_start();
include "koneksi.php";   //memasukan koneksi
include "AES.php"; //memasukan file AES

$shfile = $_COOKIE['id'];

if (isset($_POST['decrypt_now'])) {
    $privateKeyFile = 'private_key.pem';
    $ambilKunci = $_POST["kunci"];
    $hash = hash('sha256', $ambilKunci, true);
    $kunci = substr(base64_encode($hash), 0, 16);
    $idfile    = mysqli_escape_string($conn, $_POST['kode_file']);
    $query = "SELECT kunci FROM file WHERE kode_file = '$idfile'";
    $sql = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($sql);
    $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyFile));
    $dekripkunci = $row['kunci'];
    openssl_private_decrypt(base64_decode($dekripkunci), $decryptedData, $privateKey);


    if ($ambilKunci === $decryptedData) {

        $query1     = "SELECT * FROM file WHERE kode_file='$idfile'";
        $sql1       = mysqli_query($conn, $query1);
        $data       = mysqli_fetch_assoc($sql1);

        $file_path  = $data["url_file"];
        $key        = mysqli_escape_string($conn, $kunci);
        $file_name  = $data["nama_file"];
        $size       = $data["ukuran_file"];

        $file_size  = filesize($file_path);

        $query2     = "UPDATE file SET status='2' WHERE kode_file='$idfile'";
        //query2 = INSERT INTO file VALUES ('', '$user', '$final_file', '$finalfile.txt', '', '$size2', '$key', now(), '1', '$deskripsi')
        $sql2       = mysqli_query($conn, $query2);

        $mod        = $file_size % 16;

        $aes        = new AES($key);
        $fopen1     = fopen($file_path, "rb");
        $plain      = "";
        $cache      = "file_dekripsi/$file_name";
        $fopen2     = fopen($cache, "wb");

        if ($mod == 0) {
            $banyak = $file_size / 16;
        } else {
            $banyak = ($file_size - $mod) / 16;
            $banyak = $banyak + 1;
        }

        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        for ($bawah = 0; $bawah < $banyak; $bawah++) {

            $filedata    = fread($fopen1, 16);
            $plain       = $aes->decrypt($filedata);
            fwrite($fopen2, $plain);
        }
        $_SESSION["download"] = $cache;

        echo ("<script language='javascript'>
           window.open('download.php', '_blank');
           window.location.href='dekripsi.php';
           window.alert('Berhasil mendekripsi file.');
           </script>
           ");
    } else {
        echo ("<script language='javascript'>
        window.location.href='';
        window.location.href='dekripsi_doc.php?id=$shfile';
        window.alert('Kunci yang anda masukkan salah, periksa kembali!');

        </script>");
    }
}
