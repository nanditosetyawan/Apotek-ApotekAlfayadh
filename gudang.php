<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if ($_SESSION['jabatan'] != 'managergudang') {
    echo "Akses ditolak!";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard Gudang</title>
<link rel="stylesheet" href="css/gudang.css">
</head>

<body>

<div class="container">

    <!-- PROFILE -->
    <div class="profile-box">
        <img src="img/kasir.png" class="profile-img">

        <div class="profile-text">
            <h3><?= $_SESSION['username']; ?></h3>
            <p>Manager Gudang</p>
            <span id="clock"></span>
        </div>
    </div>

    <!-- MENU 1 -->
    <div class="menu-card">

        <div class="menu-content">
            <div class="icon-box">
                <img src="img/obat.png" alt="">
            </div>

            <div class="menu-text">
                <h3>Mengelola Obat</h3>
                <p>Mengelola daftar obat</p>
            </div>
        </div>

        <a href="mengelola_obat.php" class="btn btn-dark">Masuk</a>
    </div>

    <!-- MENU 2 -->
    <div class="menu-card">

        <div class="menu-content">
            <div class="icon-box">
                <img src="img/obat.png" alt="">
            </div>

            <div class="menu-text">
                <h3>Riwayat Obat Masuk</h3>
                <p>Daftar obat masuk</p>
            </div>
        </div>

        <a href="#" class="btn btn-dark">Lihat</a>
    </div>

    <!-- MENU 3 -->
    <div class="menu-card">

        <div class="menu-content">
            <div class="icon-box">
                <img src="img/logout.png" alt="">
            </div>

            <div class="menu-text">
                <h3>Logout</h3>
                <p>Keluar dari sistem</p>
            </div>
        </div>

        <a href="logout.php" class="btn btn-red">Logout</a>
    </div>

</div>

<!-- JAM REALTIME -->
<script>
function updateClock(){
    const now = new Date();

    const jam = String(now.getHours()).padStart(2,'0');
    const menit = String(now.getMinutes()).padStart(2,'0');
    const detik = String(now.getSeconds()).padStart(2,'0');

    document.getElementById("clock").innerText =
        jam + ":" + menit + ":" + detik;
}

setInterval(updateClock,1000);
updateClock();
</script>

</body>
</html>