<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managertoko') {
    header("Location: index.php");
    exit;
}

include "koneksi.php";

/* ===== FILTER ===== */
$start = $_GET['start'] ?? '';
$end   = $_GET['end'] ?? '';

/* BULAN INDONESIA */
$bulanList = [
    1=>"Januari",2=>"Februari",3=>"Maret",4=>"April",
    5=>"Mei",6=>"Juni",7=>"Juli",8=>"Agustus",
    9=>"September",10=>"Oktober",11=>"November",12=>"Desember"
];

// Query dengan filter tanggal berdasarkan dibuat_pada
if($start && $end){
    $query = mysqli_query($conn,
        "SELECT * FROM laporan_obat_masuk 
         WHERE DATE(dibuat_pada) BETWEEN '$start' AND '$end'
         ORDER BY dibuat_pada DESC"
    );
}elseif($start){
    $query = mysqli_query($conn,
        "SELECT * FROM laporan_obat_masuk 
         WHERE DATE(dibuat_pada) >= '$start'
         ORDER BY dibuat_pada DESC"
    );
}elseif($end){
    $query = mysqli_query($conn,
        "SELECT * FROM laporan_obat_masuk 
         WHERE DATE(dibuat_pada) <= '$end'
         ORDER BY dibuat_pada DESC"
    );
}else{
    $query = mysqli_query($conn,
        "SELECT * FROM laporan_obat_masuk ORDER BY dibuat_pada DESC"
    );
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Obat Masuk</title>
<link rel="stylesheet" href="css/laporan_pemasukan.css">
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

<!-- BOX -->
<div class="img-box">
    <div class="carousel-track" id="carouselTrack">
        <div class="slide" style="background-image:url('img/banner1.png')"></div>
        <div class="slide" style="background-image:url('img/banner2.png')"></div>
    </div>

    <!-- DOT -->
    <div class="dots">
        <span class="dot active"></span>
        <span class="dot"></span>
    </div>
</div>
<br>

<!-- ===== LIST ===== -->
<?php while($data = mysqli_fetch_assoc($query)): ?>

<div class="doc-card">
    <div>
        <h4>Laporan <?= $bulanList[$data['bulan']] ?> <?= $data['tahun'] ?></h4>
      <p>
    Dibuat: 
    <?= date("d-m-Y", strtotime($data['dibuat_pada'])); ?><br>
    <?= date("H:i:s", strtotime($data['dibuat_pada'])); ?><br>

    Total Item: <?= $data['total_item']; ?> | Total Masuk: <?= $data['total_masuk']; ?>
</p>
    </div>

   <a href="cek_riwayat_obat_cabang.php?id=<?= $data['id_laporan']; ?>" class="search-btn">
        <img src="img/search.png">
    </a>
</div>

<?php endwhile; ?>

</div>

<!-- ===== OVERLAY ===== -->
<div id="calendarOverlay" class="overlay">

    <div class="calendar-popup">

        <h3>Filter Tanggal (dibuat_pada)</h3>

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

/* ===== CAROUSEL ===== */
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const track = document.getElementById('carouselTrack');

function updateCarousel() {
    if (track) {
        track.style.transform = `translateX(-${currentSlide * 100}%)`;
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }
}

function nextSlide() {
    if (slides.length > 0) {
        currentSlide = (currentSlide + 1) % slides.length;
        updateCarousel();
    }
}

if (slides.length > 0) {
    setInterval(nextSlide, 3000);
}

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

    let url = "laporan_obat.php?"; // ⬅️ perbaiki di sini

    if(start) url += "start=" + start + "&";
    if(end)   url += "end=" + end;

    window.location.href = url;
}
function resetFilter(){
    document.getElementById("startDate").value="";
    document.getElementById("endDate").value="";
    window.location.href = "laporan_obat.php"; // ⬅️ perbaiki di sini
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