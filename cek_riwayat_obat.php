<?php
include "koneksi.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM laporan_obat_masuk WHERE id_laporan='$id'
"));

$file = $data['file_path'];

if(!file_exists($file)){
    die("File tidak ditemukan");
}

$isi = file_get_contents($file);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/cek_riwayat_obat.css">
</head>

<body>

<div class="container">

<pre><?= $isi ?></pre>

<a href="<?= $file ?>" download class="btn-download">
DOWNLOAD
</a>

</div>

</body>
</html>