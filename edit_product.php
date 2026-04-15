<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managergudang') {
    header("Location: index.php");
    exit;
}

/* ===== AMBIL ID ===== */
$id = $_POST['id'] ?? $_GET['id'] ?? 0;

/* ===== HAPUS (WAJIB DI ATAS) ===== */
if(isset($_POST['hapus'])){

    $data_hapus = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM obat WHERE id_obat='$id'"));

    if($data_hapus){

        $stok_lama = (int)$data_hapus['stok'];

        mysqli_query($conn,"INSERT INTO log_stok 
        (id_obat, jenis, jumlah, stok_sebelum, stok_sesudah, tanggal)
        VALUES ('$id','kurang','$stok_lama','$stok_lama','0',NOW())");

        /* 🔥 HAPUS LOG DULU */
        mysqli_query($conn,"DELETE FROM log_stok WHERE id_obat='$id'");

        /* 🔥 BARU HAPUS OBAT */
        mysqli_query($conn,"DELETE FROM obat WHERE id_obat='$id'");
    }

    header("Location: edit_obat.php");
    exit;
}

/* ===== AMBIL DATA ===== */
$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM obat WHERE id_obat='$id'"));

if(!$data){
    die("Data tidak ditemukan");
}

/* ===== SIMPAN ===== */
if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = (int)$_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $data['gambar'];

    if($_FILES['gambar']['name'] != ""){
        $nama_file = time()."_".$_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "img/obat/".$nama_file);
        $gambar = "img/obat/".$nama_file;
    }

    $stok_lama = (int)$data['stok'];

    /* ===== TENTUKAN JENIS ===== */
    if($stok > $stok_lama){
        $jenis = "tambah";
    }else if($stok < $stok_lama){
        $jenis = "kurang";
    }else{
        $jenis = "tetap";
    }

    /* ===== UPDATE ===== */
    mysqli_query($conn,"UPDATE obat SET 
        nama='$nama',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi',
        gambar='$gambar'
        WHERE id_obat='$id'
    ");

    /* ===== LOG ===== */
    if($stok != $stok_lama){
    $jumlah = $stok - $stok_lama;

    mysqli_query($conn,"INSERT INTO log_stok 
    (id_obat, jenis, jumlah, stok_sebelum, stok_sesudah, tanggal)
    VALUES ('$id','$jenis','$jumlah','$stok_lama','$stok',NOW())");
}
    header("Location: edit_obat.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Obat</title>
<link rel="stylesheet" href="css/edit_product.css">
</head>

<body>
<br>
<div class="container">

<!-- TOP -->
<div class="top-bar">
    <a href="edit_obat.php" class="back">←</a>

    <div class="top-text">
        <div id="dayDate" class="bg"></div>
        <div id="clock" class="bg"></div>
    </div>
</div>

<form method="POST" enctype="multipart/form-data">

<!-- FIX ID -->
<input type="hidden" name="id" value="<?= $id ?>">

<br>

<!-- HEADER -->
<div class="header-box">

    <div class="img-box" onclick="document.getElementById('file').click()">
        <img id="preview" src="<?= $data['gambar'] ?>" class="img">
    </div>

    <input type="file" name="gambar" id="file" hidden onchange="previewImage(event)">

    <div class="info">
        <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
        <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
        <input type="number" name="stok" value="<?= $data['stok'] ?>" required>
    </div>

</div>

<textarea name="deskripsi"><?= $data['deskripsi'] ?? '' ?></textarea>

<br><br>

<!-- BUTTON -->
<div class="btn-group">
    <button type="button" class="btn-hapus" onclick="openHapus()">HAPUS</button>
    <button type="button" class="btn-simpan" onclick="openSimpan()">SIMPAN</button>
</div>

<!-- POPUP HAPUS -->
<div id="popupHapus" class="popup">
    <div class="popup-box">
        <img src="<?= $data['gambar'] ?>">
        <p>Yakin hapus?</p>

        <div class="popup-btn">
            <button type="submit" name="hapus" class="popup-hapus">HAPUS</button>
            <button type="button" onclick="closePopup()" class="popup-batal">BATAL</button>
        </div>
    </div>
</div>

<!-- POPUP SIMPAN -->
<div id="popupSimpan" class="popup">
    <div class="popup-box">
        <img src="<?= $data['gambar'] ?>">
        <p>Yakin simpan perubahan?</p>

        <div class="popup-btn">
            <button type="submit" name="simpan" class="popup-simpan">SIMPAN</button>
            <button type="button" onclick="closePopup()" class="popup-batal">BATAL</button>
        </div>
    </div>
</div>

</form>

</div>

<script>
function updateTime(){
    const now = new Date();

    document.getElementById("dayDate").innerText =
        now.toLocaleDateString('id-ID',{
            weekday:'long',
            day:'numeric',
            month:'long',
            year:'numeric'
        });

    document.getElementById("clock").innerText =
        now.toLocaleTimeString();
}
setInterval(updateTime,1000);
updateTime();

function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function openHapus(){
    document.getElementById("popupHapus").style.display="flex";
}
function openSimpan(){
    document.getElementById("popupSimpan").style.display="flex";
}
function closePopup(){
    document.getElementById("popupHapus").style.display="none";
    document.getElementById("popupSimpan").style.display="none";
}
</script>

</body>
</html>