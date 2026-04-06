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

    /* ===== HANDLE GAMBAR ===== */
    $gambar = "img/obat/default.png";

    if(isset($_FILES['gambar']) && $_FILES['gambar']['name'] != ""){

        $nama_file = time()."_".$_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp, "img/obat/".$nama_file);

        $gambar = "img/obat/".$nama_file;
    }

    /* ===== INSERT ===== */
    mysqli_query($conn,"INSERT INTO obat (nama,harga,stok,deskripsi,gambar) 
        VALUES ('$nama','$harga','$stok','$deskripsi','$gambar')");

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

<form method="POST" enctype="multipart/form-data">

<!-- HEADER -->
<div class="header-box">

    <!-- GAMBAR PREVIEW (sementara default dulu) -->
 

    <!-- INPUT -->
    <div class="info">
        <input type="file" name="gambar">
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