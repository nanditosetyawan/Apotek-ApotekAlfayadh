<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managergudang') {
    header("Location: index.php");
    exit;
}

/* 🔥 ambil hanya stok <= 5 */
$data = mysqli_query($conn,"SELECT * FROM obat WHERE stok <= 5 ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Stok Habis / Tipis</title>
<link rel="stylesheet" href="css/habis.css">
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

<!-- SEARCH -->
<div class="search-box">
    <input type="text" id="search" placeholder="Cari obat..." onkeyup="searchObat()">
</div>

<!-- LIST -->
<div class="list">

<?php while($o=mysqli_fetch_assoc($data)): ?>
<div class="item" data-nama="<?= strtolower($o['nama']) ?>">

    <!-- GAMBAR -->
        <img src="<?= !empty($o['gambar']) ? $o['gambar'] : 'img/obat/default.png' ?>" class="img">

    <!-- INFO -->
    <div class="info">
        <b><?= $o['nama'] ?></b>
        <small>Rp <?= number_format($o['harga'],0,',','.') ?></small>
<br>
        <?php if($o['stok'] <= 5 && $o['stok'] > 0): ?>
            <span class="tipis">stok tipis</span>
        <?php endif; ?>
    </div>

    <!-- STOK -->
    <div class="stok-box">
        <small>stok</small>
        <div class="stok"><?= $o['stok'] ?></div>
    </div>

</div>
<?php endwhile; ?>

</div>

</div>

<script>
function updateTime(){
    const now = new Date();

    document.getElementById("dayDate").innerText =
        now.toLocaleDateString('id-ID');

    document.getElementById("clock").innerText =
        now.toLocaleTimeString();
}
setInterval(updateTime,1000);
updateTime();

/* SEARCH */
function searchObat(){
    let val=document.getElementById("search").value.toLowerCase();

    document.querySelectorAll(".item").forEach(el=>{
        el.style.display = el.dataset.nama.includes(val) ? "flex" : "none";
    });
}
</script>

</body>
</html>