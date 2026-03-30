<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'kasir') {
    header("Location: index.php");
    exit;
}

include "koneksi.php";

/* ===== FILTER ===== */
$start = $_GET['start'] ?? '';
$end   = $_GET['end'] ?? '';

if($start && $end){
    $query = mysqli_query($conn,
        "SELECT * FROM riwayat_transaksi_kasir 
         WHERE tanggal BETWEEN '$start' AND '$end'
         ORDER BY id DESC"
    );
}elseif($start){
    $query = mysqli_query($conn,
        "SELECT * FROM riwayat_transaksi_kasir 
         WHERE tanggal >= '$start'
         ORDER BY id DESC"
    );
}elseif($end){
    $query = mysqli_query($conn,
        "SELECT * FROM riwayat_transaksi_kasir 
         WHERE tanggal <= '$end'
         ORDER BY id DESC"
    );
}else{
    $query = mysqli_query($conn,
        "SELECT * FROM riwayat_transaksi_kasir ORDER BY id DESC"
    );
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Riwayat Transaksi</title>
<link rel="stylesheet" href="css/riwayat_transaksi_kasir.css">
</head>

<body>

<div class="container">

<br>

<!-- ===== TOP BAR ===== -->
<div class="top-bar">

    <button class="calendar-btn" onclick="openCalendar()">📅</button>

    <div class="datetime">
        <div id="dayDate"></div>
        <div id="clock"></div>
    </div>

</div>

<!-- ===== TAMBAH DOKUMEN ===== -->
<div class="add-box">
    <div class="add-text">
        <h3>Tambah Dokumen</h3>
        <p>Tambah dokumen anda</p>
    </div>

    <a href="dokumen_kasir.php" class="plus-box">+</a>
</div>

<!-- ===== LIST ===== -->
<?php while($data = mysqli_fetch_assoc($query)): ?>

<div class="doc-card">
    <div>
        <h4><?= $data['nama_dokumen']; ?></h4>
        <p>
            <?= $data['tanggal']; ?> |
            <?= date("H:i:s", strtotime($data['jam'])); ?>
        </p>
    </div>

   <a href="cek_laporan_transaksi.php?id=<?= $data['id']; ?>" class="search-btn">
        <img src="img/search.png">
    </a>
</div>

<?php endwhile; ?>

</div>

<!-- ===== OVERLAY ===== -->
<div id="calendarOverlay" class="overlay">

    <div class="calendar-popup">

        <h3>Filter Tanggal</h3>

        <label>Tanggal Mulai</label>
        <input type="date" id="startDate">

        <label>Tanggal Selesai</label>
        <input type="date" id="endDate">

        <div class="calendar-actions">
            <button onclick="resetFilter()">Reset</button>
            <button onclick="applyFilter()">Mulai</button>
            <button onclick="closeCalendar()">Close</button>
        </div>

    </div>

</div>

<script>

/* ===== JAM ===== */
function updateTime(){
    const now = new Date();

    const hari = now.toLocaleDateString('id-ID',{
        weekday:'long',
        day:'numeric',
        month:'long',
        year:'numeric'
    });

    const jam =
        String(now.getHours()).padStart(2,'0') + ":" +
        String(now.getMinutes()).padStart(2,'0') + ":" +
        String(now.getSeconds()).padStart(2,'0');

    document.getElementById("dayDate").innerText = hari;
    document.getElementById("clock").innerText = jam;
}

setInterval(updateTime,1000);
updateTime();

/* ===== OVERLAY ===== */
function openCalendar(){
    document.getElementById("calendarOverlay").style.display="flex";
}

function closeCalendar(){
    document.getElementById("calendarOverlay").style.display="none";
}

/* ===== FILTER ===== */
function applyFilter(){
    const start = document.getElementById("startDate").value;
    const end   = document.getElementById("endDate").value;

    let url = "riwayat_transaksi.php?";

    if(start) url += "start=" + start + "&";
    if(end)   url += "end=" + end;

    window.location.href = url;
}

function resetFilter(){
    document.getElementById("startDate").value="";
    document.getElementById("endDate").value="";
    window.location.href = "riwayat_transaksi.php";
}

/* ===== AUTO ISI INPUT ===== */
window.onload = function(){
    const params = new URLSearchParams(window.location.search);

    if(params.get("start")){
        document.getElementById("startDate").value = params.get("start");
    }

    if(params.get("end")){
        document.getElementById("endDate").value = params.get("end");
    }
}

</script>

</body>
</html>