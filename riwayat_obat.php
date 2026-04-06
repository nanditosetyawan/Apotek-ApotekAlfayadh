<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managergudang') {
    header("Location: index.php");
    exit;
}

include "koneksi.php";

/* FILTER */
$start = $_GET['start'] ?? '';
$end   = $_GET['end'] ?? '';

if($start && $end){
    $data = mysqli_query($conn,"
        SELECT * FROM laporan_obat_masuk
        WHERE DATE(dibuat_pada) BETWEEN '$start' AND '$end'
        ORDER BY id_laporan DESC
    ");
}else{
    $data = mysqli_query($conn,"
        SELECT * FROM laporan_obat_masuk
        ORDER BY id_laporan DESC
    ");
}

/* BULAN */
$bulan_nama = [
"01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April",
"05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus",
"09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember"
];
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/riwayat_obat.css">
</head>

<body>
<br>
<div class="container">

<!-- TOP -->
<div class="top-bar">

    <!-- LEFT SIDE -->
    <div class="left-group">
        <a href="gudang.php" class="back">←</a>
        <button class="calendar-btn" onclick="openCalendar()">📅</button>
    </div>

    <!-- RIGHT SIDE -->
    <div class="top-text">
        <div id="dayDate" class="bg"></div>
        <div id="clock" class="bg"></div>
    </div>

</div>
<br><br>
<!-- ADD -->
<div class="add-box">
    <div>
        <h3>Riwayat Obat Masuk</h3>
        <p>Buat laporan bulanan</p>
    </div>

    <form method="POST" action="generate_riwayat_obat.php">
        <button class="plus-box">+</button>
    </form>
</div>

<!-- LIST -->
<?php while($d=mysqli_fetch_assoc($data)): ?>
<div class="doc-card">

    <div>
        <h4>
            Laporan <?= $bulan_nama[str_pad($d['bulan'],2,"0",STR_PAD_LEFT)] ?> <?= $d['tahun'] ?>
            <?= $d['versi'] > 1 ? " v".$d['versi'] : "" ?>
        </h4>
        <p>Total: <?= $d['total_masuk'] ?> pcs</p>
        <small><?= $d['dibuat_pada'] ?></small>
    </div>

    <a href="cek_riwayat_obat.php?id=<?= $d['id_laporan'] ?>" class="search-btn">
        🔍
    </a>

</div>
<?php endwhile; ?>

</div>

<!-- OVERLAY CALENDAR -->
<div id="calendarOverlay" class="overlay">
    <div class="calendar-popup">
        <h3>Filter Tanggal</h3>

        <input type="date" id="startDate">
        <input type="date" id="endDate">

        <div class="calendar-actions">
            <button onclick="applyFilter()">OK</button>
            <button onclick="closeCalendar()">Close</button>
        </div>
    </div>
</div>

<script>
function updateTime(){
    const now = new Date();

    document.getElementById("dayDate").innerText =
        now.toLocaleDateString('id-ID',{
            weekday:'long',day:'numeric',month:'long',year:'numeric'
        });

    document.getElementById("clock").innerText =
        now.toLocaleTimeString();
}
setInterval(updateTime,1000);
updateTime();

/* CALENDAR */
function openCalendar(){
    document.getElementById("calendarOverlay").style.display="flex";
}
function closeCalendar(){
    document.getElementById("calendarOverlay").style.display="none";
}
function applyFilter(){
    let s=document.getElementById("startDate").value;
    let e=document.getElementById("endDate").value;
    window.location.href=`?start=${s}&end=${e}`;
}
</script>

</body>
</html>