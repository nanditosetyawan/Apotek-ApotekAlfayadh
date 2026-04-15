<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managergudang') {
    header("Location: index.php");
    exit;
}

/* ===== TAMBAH ===== */
if(isset($_POST['tambah'])){

    $nama   = $_POST['nama'];
    $harga  = $_POST['harga'];
    $stok   = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    /* ===== GAMBAR ===== */
    $gambar = "img/obat/default.png";

    if(isset($_FILES['gambar']) && $_FILES['gambar']['name'] != ""){
        $nama_file = time()."_".$_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "img/obat/".$nama_file);
        $gambar = "img/obat/".$nama_file;
    }

    /* ===== INSERT OBAT ===== */
    mysqli_query($conn,"INSERT INTO obat (nama,harga,stok,deskripsi,gambar) 
    VALUES ('$nama','$harga','$stok','$deskripsi','$gambar')");

    /* ===== AMBIL ID BARU ===== */
    $id_baru = mysqli_insert_id($conn);

    /* ===== LOG MASUK ===== */
    mysqli_query($conn,"INSERT INTO log_stok 
(id_obat, jenis, jumlah, stok_sebelum, stok_sesudah, tanggal)
VALUES ('$id_baru','tambah','$stok','0','$stok',NOW())");

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

<!-- INPUT -->
<div class="header-box">

    <div class="info">
        <input type="file" name="gambar">
        <input type="text" name="nama" placeholder="Nama obat" required>
        <input type="number" name="harga" placeholder="Harga" required>
        <input type="number" name="stok" placeholder="Stok" required>
    </div>

</div>

<textarea name="deskripsi" placeholder="Deskripsi obat..."></textarea>

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