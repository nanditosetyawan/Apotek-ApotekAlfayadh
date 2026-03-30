<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managertoko') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kasir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/cabang.css">
</head>

<body>

<div class="container">

    <!-- PROFILE -->
    <div class="profile-box">
        <img src="img/kasir.png" class="profile-img">

        <div class="profile-text">
            <h3><?= $_SESSION['username']; ?></h3>
            <p>Manager Cabang</p>
            <span id="clock"></span>
        </div>
    </div>

    <!-- MENU 1 -->
    <div class="menu-card">

        <div class="menu-content">
            <div class="icon-box">
                <img src="img/riwayat_transaksi.png" alt="">
            </div>

            <div class="menu-text">
                <h3>Laporan Obat</h3>
                <p>Rincian Obat Masuk</p>
            </div>
        </div>

        <a href="laporan_obat.php" class="btn btn-dark">Lihat</a>
    </div>

    <!-- MENU 2 -->
    <div class="menu-card">

        <div class="menu-content">
            <div class="icon-box">
                <img src="img/transaksi.png" alt="">
            </div>

            <div class="menu-text">
                <h3>Laporan Pemasukan</h3>
                <p>Rincian Pendapatan</p>
            </div>
        </div>

        <a href="laporan_pemasukan.php" class="btn btn-dark">Lihat</a>
    </div>

    <!-- MENU 3 -->
    <div class="menu-card">

        <div class="menu-content">
            <div class="icon-box">
                <img src="img/logout.png" alt="">
            </div>

            <div class="menu-text">
                <h3>Terima Kasih</h3>
                <p>Terimakasih menggunakan layanan kami</p>
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
