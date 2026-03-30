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

<div class="container">

<div class="top-bar">
    <a href="mengelola_obat.php" class="back">←</a>

    <div class="top-text">
        <div id="dayDate" class="bg"></div>
        <div id="clock" class="bg"></div>
    </div>
</div>

<div class="search-box">
    <input type="text" id="search" placeholder="Cari obat..." onkeyup="searchObat()">
</div>

<div class="list">

<?php while($o=mysqli_fetch_assoc($data)): ?>
<div class="item" data-nama="<?= strtolower($o['nama']) ?>">

    <img src="img/default.png" class="img">

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
    document.getElementById("dayDate").innerText =
        now.toLocaleDateString('id-ID');
    document.getElementById("clock").innerText =
        now.toLocaleTimeString();
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