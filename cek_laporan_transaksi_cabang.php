<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managertoko') {
    header("Location: index.php");
    exit;
}

include "koneksi.php";

$id = $_GET['id'] ?? 0;

$data_dokumen = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM riwayat_transaksi_kasir WHERE id='$id'"
));

if(!$data_dokumen){
    die("Data tidak ditemukan");
}

/* ===== AMBIL FILE TXT ===== */
$file = $data_dokumen['file_path'];

if(!file_exists($file)){
    die("File laporan tidak ditemukan");
}

if(isset($_GET['download'])){
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    readfile($file);
    exit;
}

$isi = file_get_contents($file);

/* ===== PARSE DATA ===== */
$lines = explode("\n", $isi);

$total_transaksi = 0;
$total_pemasukan = 0;
$detail = [];

foreach($lines as $line){

    if(strpos($line,"Total transaksi") !== false){
        $total_transaksi = trim(explode(":", $line)[1]);
    }

    if(strpos($line,"Total pemasukan") !== false){
        $total_pemasukan = trim(explode(":", $line)[1]);
    }

    if(preg_match('/^\d+ \|/', $line)){
        $d = explode("|", $line);

        $detail[] = [
            "id_detail" => trim($d[0]),
            "id_obat" => trim($d[1]),
            "jumlah" => trim($d[2]),
            "harga" => trim($d[3]),
            "subtotal" => trim($d[4]),
        ];
    }
}

/* ===== JUDUL ===== */
$tanggal = $data_dokumen['tanggal'];
$bulan = strtoupper(date("F", strtotime($tanggal)));
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Pemasukan</title>
<link rel="stylesheet" href="css/dokumen_kasir.css">
</head>

<body>

<br>
<div class="container">

    <!-- TOP -->
    <div class="top-bar">
        <a href="cabang.php" class="back-btn">←</a>

        <div class="top-text">
            <div id="dayDate" class="line1"></div>
            <div id="clock" class="line2"></div>
        </div>
    </div>

   <!-- PREVIEW -->
    <div class="preview-wrapper">

    
    <div class="preview-header">Preview </div><br>
    <center>
          <h2>
            TRANSAKSI BULAN <br> <?= $bulan ?>
        </h2>

        <br>
</center> <br> <br>
        <p><strong>Total Transaksi:</strong> <?= $total_transaksi ?></p>
        <p><strong>Total Pemasukan:</strong> Rp <?= number_format($total_pemasukan,0,',','.') ?></p>

        <br><hr><br>

        <strong>DETAIL:</strong><br><br>

       <div style="padding:0 20px 20px 20px;">
<table style="width:100%; border-collapse:collapse; font-size:14px;">
            <tr style="background:#eee;">
                <th style="padding:8px; border:1px solid #ccc;">ID</th>
                <th style="padding:8px; border:1px solid #ccc;">Obat</th>
                <th style="padding:8px; border:1px solid #ccc;">Jumlah</th>
                <th style="padding:8px; border:1px solid #ccc;">Harga</th>
                <th style="padding:8px; border:1px solid #ccc;">Subtotal</th>
            </tr>

            <?php foreach($detail as $d): ?>
            <tr>
                <td style="padding:6px; border:1px solid #ccc;"><?= $d['id_detail'] ?></td>
                <td style="padding:6px; border:1px solid #ccc;"><?= $d['id_obat'] ?></td>
                <td style="padding:6px; border:1px solid #ccc;"><?= $d['jumlah'] ?></td>
                <td style="padding:6px; border:1px solid #ccc;">Rp <?= number_format($d['harga'],0,',','.') ?></td>
                <td style="padding:6px; border:1px solid #ccc;">Rp <?= number_format($d['subtotal'],0,',','.') ?></td>
            </tr>
            <?php endforeach; ?>

        </table>
</div>
    

        </div>
<div style="margin-top:20px;">
    <a href="?id=<?= $id ?>&download=1" class="btn-kirim" style="display:block; text-align:center; line-height:45px; text-decoration:none; color:#000;">
        DOWNLOAD
    </a>
</div>



    </div>


</div>

<script>
function updateTime(){

    const now = new Date();

    const hariTanggal = now.toLocaleDateString('id-ID',{
        weekday:'long',
        day:'numeric',
        month:'long',
        year:'numeric'
    });

    const jam =
        String(now.getHours()).padStart(2,'0') + ":" +
        String(now.getMinutes()).padStart(2,'0') + ":" +
        String(now.getSeconds()).padStart(2,'0');

    document.getElementById("dayDate").innerText = hariTanggal;
    document.getElementById("clock").innerText = jam;
}

setInterval(updateTime,1000);
updateTime();
</script>

</body>
</html>
