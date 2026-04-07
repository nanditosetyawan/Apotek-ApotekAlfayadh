<?php
include "koneksi.php";

$id = $_GET['id'] ?? 0;

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM laporan_obat_masuk WHERE id_laporan='$id'
"));

if(!$data){
    die("Data tidak ditemukan");
}

$file = $data['file_path'];

if(!file_exists($file)){
    die("File tidak ditemukan");
}

$isi = file_get_contents($file);

/* ===== PARSE ===== */
$lines = explode("\n", $isi);

$total = 0;
$detail = [];
$mulai_detail = false;

foreach($lines as $line){

    $line = trim($line);

    if($line == "") continue;

    if(strpos($line,"Total") !== false){
        $total = trim(explode(":", $line)[1]);
    }

    if(stripos($line,"DETAIL") !== false){
        $mulai_detail = true;
        continue;
    }

    if($mulai_detail){

        if(strpos($line,"|") !== false && stripos($line,"id") !== false){
            continue;
        }

        if(preg_match('/^\d+ \|/', $line)){
            $d = explode("|", $line);

            $detail[] = [
                "id" => trim($d[0]),
                "nama" => trim($d[1]),
                "jumlah" => trim($d[2]),
                "harga" => trim($d[3]),
                "subtotal" => trim($d[4] ?? 0),
            ];
        }
    }
}

/* ===== BULAN INDONESIA ===== */
$bulanList = [
    1=>"JANUARI", 2=>"FEBRUARI", 3=>"MARET", 4=>"APRIL",
    5=>"MEI", 6=>"JUNI", 7=>"JULI", 8=>"AGUSTUS",
    9=>"SEPTEMBER", 10=>"OKTOBER", 11=>"NOVEMBER", 12=>"DESEMBER"
];

$bulan = $bulanList[(int)$data['bulan']];
$tahun = $data['tahun'];
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cek Riwayat Obat</title>
<link rel="stylesheet" href="css/cek_riwayat_obat_cabang.css">
</head>

<body>

<br>
<div class="container">

<!-- TOP BAR -->
<div class="top-bar">

    <!-- BACK -->
    <a href="laporan_obat.php" class="back-btn">←</a>

    <!-- WAKTU -->
    <div class="top-text">
        <div id="dayDate" class="line1"></div>
        <div id="clock" class="line2"></div>
    </div>

</div>

<!-- PREVIEW -->
<div class="preview-wrapper">

    <div class="preview-paper">

        <div class="preview-header">Preview</div>
        <br><br>

        <h2>
            RIWAYAT OBAT <br>
            BULAN <?= $bulan ?> <?= $tahun ?>
        </h2>

        <br>

        <p><strong>Total Data:</strong> <?= $total ?></p>

        <br><hr><br>

        <div style="padding:0 20px 20px 20px;">

        <table style="width:100%; border-collapse:collapse; font-size:14px;">

            <tr style="background:#eee;">
                <th style="padding:8px; border:1px solid #ccc;">ID</th>
                <th style="padding:8px; border:1px solid #ccc;">Nama</th>
                <th style="padding:8px; border:1px solid #ccc;">Jumlah</th>
                <th style="padding:8px; border:1px solid #ccc;">Harga</th>
                <th style="padding:8px; border:1px solid #ccc;">Subtotal</th>
            </tr>

            <?php foreach($detail as $d): ?>
            <tr>
                <td style="padding:6px; border:1px solid #ccc;"><?= $d['id'] ?></td>
                <td style="padding:6px; border:1px solid #ccc;"><?= $d['nama'] ?></td>
                <td style="padding:6px; border:1px solid #ccc;"><?= $d['jumlah'] ?></td>
                <td style="padding:6px; border:1px solid #ccc;">
                    Rp <?= number_format($d['harga'],0,',','.') ?>
                </td>
                <td style="padding:6px; border:1px solid #ccc;">
                    Rp <?= number_format($d['subtotal'],0,',','.') ?>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>

        </div>

    </div>

</div>

<!-- BUTTON -->
<div style="margin-top:20px;">
    <a href="<?= $file ?>" download class="btn-kirim" style="display:flex; justify-content:center; align-items:center; text-decoration:none; color:#000;">
        DOWNLOAD
    </a>
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