<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['jabatan'] != 'managergudang') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'] ?? 0;

$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM obat WHERE id_obat='$id'"));

if(!$data){
    die("Data tidak ditemukan");
}

/* ===== SIMPAN ===== */
if(isset($_POST['simpan'])){
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];

    $gambar = $data['gambar'];

    if($_FILES['gambar']['name'] != ""){
        $nama_file = time()."_".$_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "img/obat/".$nama_file);
        $gambar = "img/obat/".$nama_file;
    }

    mysqli_query($conn,"UPDATE obat SET 
        nama='$nama',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi',
        gambar='$gambar'
        WHERE id_obat='$id'
    ");

    header("Location: edit_obat.php");
    exit;
}

/* ===== HAPUS ===== */
if(isset($_POST['hapus'])){
    mysqli_query($conn,"DELETE FROM obat WHERE id_obat='$id'");
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
<br>
<!-- HEADER -->
<div class="header-box">

    <!-- GAMBAR -->
    <div class="img-box" onclick="document.getElementById('file').click()">
        <img id="preview" src="<?= $data['gambar'] ?>" class="img">
    </div>

    <input type="file" name="gambar" id="file" hidden onchange="previewImage(event)">

    <!-- INPUT -->
    <div class="info">
        <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
        <input type="number" name="harga" value="<?= $data['harga'] ?>" required>
        <input type="number" name="stok" value="<?= $data['stok'] ?>" required>
    </div>

</div>

<!-- DESKRIPSI -->
<textarea name="deskripsi"><?= $data['deskripsi'] ?></textarea>
<br><br>
<!-- BUTTON -->
<div class="btn-group">
    <button type="button" class="btn-hapus" onclick="openHapus()">HAPUS</button>
    <button type="button" class="btn-simpan" onclick="openSimpan()">SIMPAN</button>
</div>

<!-- CONFIRM HAPUS -->
<div id="popupHapus" class="popup">
    <div class="popup-box"> <br>
        <img src="<?= $data['gambar'] ?>">
        <p>Yakin hapus?</p>
       <div class="popup-btn">
    <button name="hapus" class="popup-hapus">HAPUS</button>
    <button type="button" onclick="closePopup()" class="popup-batal">BATAL</button>
</div>
    </div>
</div>

<!-- CONFIRM SIMPAN -->
<div id="popupSimpan" class="popup">
    <div class="popup-box"> <br>
        <img src="<?= $data['gambar'] ?>">
        <p>Yakin simpan perubahan?</p>
     <div class="popup-btn">
    <button name="simpan" class="popup-simpan">SIMPAN</button>
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

/* PREVIEW GAMBAR */
function previewImage(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

/* POPUP */
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