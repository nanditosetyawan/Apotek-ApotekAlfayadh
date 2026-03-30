<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managergudang') {
    header("Location: index.php");
    exit;
}

/* SIMPAN DATA */
if(isset($_POST['tambah'])){
    $nama   = $_POST['nama'];
    $harga  = $_POST['harga'];
    $stok   = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    mysqli_query($conn,"INSERT INTO obat (nama,harga,stok,deskripsi) 
        VALUES ('$nama','$harga','$stok','$deskripsi')");

    header("Location: daftar_obat.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tambah Obat</title>
<link rel="stylesheet" href="css/tambah_obat.css">
</head>

<body>

<div class="container">

<!-- TOP -->
<div class="top-bar">
    <a href="mengelola_obat.php" class="back">←</a>

    <div class="top-text">
        <div id="dayDate" class="bg"></div>
        <div id="clock" class="bg"></div>
    </div>
</div>

<form method="POST">

<!-- HEADER -->
<div class="header-box">

    <!-- GAMBAR -->
    <img src="img/default.png" class="img">

    <!-- INPUT -->
    <div class="info">
        <input type="text" name="nama" placeholder="Nama obat" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <input type="number" name="stok" placeholder="Stok" required>
    </div>

</div>

<!-- DESKRIPSI -->
<textarea name="deskripsi" placeholder="Deskripsi obat..."></textarea>

<!-- BUTTON -->
<button name="tambah" class="btn-tambah">TAMBAH</button>

</form>

</div>

<script>
function updateTime(){
    const now = new Date();

    document.getElementById("dayDate").innerText =
        now.toLocaleDateString('id-ID',{
            weekday:'long',
            day:'numeric',
            month:'long',
            year:'numeric'
        });

    document.getElementById("clock").innerText =
        now.toLocaleTimeString();
}

setInterval(updateTime,1000);
updateTime();
</script>

</body>
</html>