<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managergudang') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mengelola Obat</title>
<link rel="stylesheet" href="css/mengelola_obat.css">
</head>

<body>
<br>
<div class="container">

<!-- TOP -->
<div class="top-bar">
    <a href="gudang.php" class="back">←</a>

    <div class="top-text">
        <div id="dayDate" class="bg"></div>
        <div id="clock" class="bg"></div>
    </div>
</div>
<br>
<!-- MENU -->
<div class="menu-wrapper">

    <a href="daftar_obat.php" class="menu-box">
        <img src="img/list.png" class="menu-img">
        <span>DAFTAR</span>
    </a>

    <a href="edit_obat.php" class="menu-box">
        <img src="img/edit.png" class="menu-img">
        <span>EDIT</span>
    </a>

    <a href="habis.php" class="menu-box">
        <img src="img/habis.png" class="menu-img">
        <span>HABIS</span>
    </a>

</div>

<!-- BUTTON -->
<a href="tambah_obat.php" class="btn">TAMBAH</a>

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