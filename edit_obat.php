<?php
session_start();
include "koneksi.php";

$data = mysqli_query($conn,"SELECT * FROM obat ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/edit_obat.css">
</head>

<body>
<br>
<div class="container">

<div class="top-bar">

    <!-- LEFT SIDE -->
    <div class="left-group">
        <a href="mengelola_obat.php" class="back">←</a>
   
    </div>

    <!-- RIGHT SIDE -->
    <div class="top-text">
        <div id="dayDate" class="bg"></div>
        <div id="clock" class="bg"></div>
    </div>

</div>
<br>
<div class="search-box">
    <input type="text" id="search" placeholder="Cari obat..." onkeyup="searchObat()">
</div>

<div class="list">

<?php while($o=mysqli_fetch_assoc($data)): ?>
<div class="item" data-nama="<?= strtolower($o['nama']) ?>">

     <img src="<?= !empty($o['gambar']) ? $o['gambar'] : 'img/obat/default.png' ?>" class="img">

    <div class="info">
        <b><?= $o['nama'] ?></b>
        <small>Rp <?= number_format($o['harga'],0,',','.') ?></small>
    </div>

    <a href="edit_product.php?id=<?= $o['id_obat'] ?>" class="btn-edit">EDIT</a>

</div>
<?php endwhile; ?>

</div>

</div>

<script>
function updateTime(){
    const now = new Date();

    const hari = now.toLocaleDateString('id-ID', { weekday: 'long' });

    const tanggal = now.getDate();

    const bulanList = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    const bulan = bulanList[now.getMonth()];
    const tahun = now.getFullYear();

    const jam = now.toLocaleTimeString();

    document.getElementById("dayDate").innerText =
        `${hari}, ${tanggal} ${bulan} ${tahun}`;

    document.getElementById("clock").innerText = jam;
}
setInterval(updateTime,1000);
updateTime();

function searchObat(){
    let val=document.getElementById("search").value.toLowerCase();
    document.querySelectorAll(".item").forEach(el=>{
        el.style.display=el.dataset.nama.includes(val)?"flex":"none";
    });
}
</script>

</body>
</html>