<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'kasir') {
    header("Location: index.php");
    exit;
}

include "koneksi.php";

/* ===== BULAN INDONESIA ===== */
$bulan_indonesia = [
    "01"=>"januari",
    "02"=>"februari",
    "03"=>"maret",
    "04"=>"april",
    "05"=>"mei",
    "06"=>"juni",
    "07"=>"juli",
    "08"=>"agustus",
    "09"=>"september",
    "10"=>"oktober",
    "11"=>"november",
    "12"=>"desember"
];

/* ===== NILAI BULAN SEKARANG ===== */
$bulan = date("m");
$tahun = date("Y");

$nama_bulan_file = $bulan_indonesia[$bulan];
$nama_bulan = strtoupper($nama_bulan_file);

/* ===== GENERATE LAPORAN ===== */
if(isset($_POST['kirim'])){

    /* ===== AMBIL DATA DENGAN JOIN ===== */
    $query = mysqli_query($conn,"
        SELECT 
            d.id_detail,
            d.id_transaksi,
            d.id_obat,
            o.nama,
            d.jumlah,
            d.harga,
            d.subtotal
        FROM detail_transaksi d
JOIN transaksi t 
    ON d.id_transaksi = t.id_transaksi
JOIN obat o
    ON d.id_obat = o.id_obat
        WHERE MONTH(t.tanggal)='$bulan'
        AND YEAR(t.tanggal)='$tahun'
    ");

    if(!$query){
        die(mysqli_error($conn));
    }

    $total_pemasukan = 0;
    $transaksi_unik = [];
    $data_all = [];

    /* ===== HITUNG TOTAL ===== */
    while($d=mysqli_fetch_assoc($query)){

        $total_pemasukan += $d['subtotal'];
        $transaksi_unik[] = $d['id_transaksi'];

        $data_all[] = $d;
    }

    /* total transaksi asli */
    $total_transaksi = count(array_unique($transaksi_unik));

    $isi = "LAPORAN BULAN $nama_bulan\n";
    $isi .= "------------------------\n";
    $isi .= "Total transaksi : $total_transaksi\n";
    $isi .= "Total pemasukan : $total_pemasukan\n\n";

    $isi .= "DETAIL:\n";
    $isi .= "id_obat | nama | jumlah | harga | subtotal\n";

    foreach($data_all as $d){
        $isi .= "{$d['id_obat']} | {$d['nama']} | {$d['jumlah']} | {$d['harga']} | {$d['subtotal']}\n";
    }

    /* ===== SIMPAN FILE ===== */
    if(!is_dir("laporan")){
        mkdir("laporan");
    }

    $nama_file = "laporan/laporan_"
                .$tahun."_"
                .$nama_bulan_file."_"
                .time().".txt";

    file_put_contents($nama_file,$isi);

    /* ===== SIMPAN DATABASE ===== */
    mysqli_query($conn,"
        INSERT INTO riwayat_transaksi_kasir
        (nama_dokumen,tanggal,jam,file_path)
        VALUES
        ('Laporan Bulan $nama_bulan',CURDATE(),NOW(),'$nama_file')
    ");

    header("Location: riwayat_transaksi.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kirim Dokumen</title>
<link rel="stylesheet" href="css/dokumen_kasir.css">
</head>

<body>

<br>
<div class="container">

    <!-- TOP -->
    <div class="top-bar">
        <a href="riwayat_transaksi.php" class="back-btn">←</a>

        <div class="top-text">
            <div id="dayDate" class="line1"></div>
            <div id="clock" class="line2"></div>
        </div>
    </div>

    <!-- PREVIEW -->
    <div class="preview-wrapper">

        <div class="preview-paper">
    <div class="preview-header">Preview</div><br><br><br>
            <img src="img/logo.png" class="preview-logo">

            <h2>
    TRANSAKSI <br>
    BULAN <?= strtoupper($bulan_indonesia[date("m")]); ?> <br>
    <?= date("Y"); ?>
</h2>

        </div>

    </div>

    <!-- BUTTON -->
    <form method="POST">
        <button name="kirim" class="btn-kirim">
            <strong>KIRIM</strong>
        </button>
    </form>

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
