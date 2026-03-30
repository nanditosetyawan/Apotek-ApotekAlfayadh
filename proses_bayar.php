<?php
session_start();
include "koneksi.php";

$data = json_decode(file_get_contents("php://input"), true);

$id_user = $_SESSION['id_user'] ?? 1;

$total = 0;
foreach($data as $d){
    $total += $d['harga'] * $d['jumlah'];
}

mysqli_query($conn,"INSERT INTO transaksi (id_user,total) VALUES ('$id_user','$total')");
$id_transaksi = mysqli_insert_id($conn);

foreach($data as $id=>$d){
    mysqli_query($conn,"INSERT INTO detail_transaksi 
        (id_transaksi,id_obat,jumlah,harga,subtotal)
        VALUES
        ('$id_transaksi','$id','".$d['jumlah']."','".$d['harga']."','".($d['harga']*$d['jumlah'])."')
    ");

    mysqli_query($conn,"UPDATE obat SET stok = stok - ".$d['jumlah']." WHERE id_obat='$id'");
}

echo "ok";