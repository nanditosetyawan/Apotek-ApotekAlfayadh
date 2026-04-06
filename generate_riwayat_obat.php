<?php
session_start();
include "koneksi.php";

/* ===== BULAN & TAHUN SEKARANG ===== */
$bulan = date("m");
$tahun = date("Y");

/* ===== AMBIL DATA LOG ===== */
$query = mysqli_query($conn,"
SELECT * FROM log_stok
WHERE MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
");

/* ===== HITUNG TOTAL ===== */
$total = 0;
$jumlah = 0;
$data_all = [];

while($d = mysqli_fetch_assoc($query)){
    $total += $d['jumlah'];
    $jumlah++;
    $data_all[] = $d;
}

/* ===== FORMAT NAMA BULAN ===== */
$bulan_nama = [
"01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April",
"05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus",
"09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember"
];

$nama_bulan = $bulan_nama[$bulan];

/* ===== CEK VERSI LAPORAN ===== */
$cek = mysqli_query($conn,"
SELECT COUNT(*) as total FROM laporan_obat_masuk
WHERE bulan='$bulan' AND tahun='$tahun'
");

$row = mysqli_fetch_assoc($cek);
$versi = $row['total'] + 1;

/* ===== BUAT ISI FILE ===== */
$isi = "LAPORAN OBAT MASUK\n";
$isi .= "Bulan: $nama_bulan $tahun\n";

if($versi > 1){
    $isi .= "Versi: v$versi\n";
}

$isi .= "--------------------------\n";
$isi .= "Total transaksi: $jumlah\n";
$isi .= "Total masuk: $total\n\n";

$isi .= "DETAIL:\n";
$isi .= "id_obat | jumlah | sebelum | sesudah\n";

foreach($data_all as $d){
    $isi .= "{$d['id_obat']} | {$d['jumlah']} | {$d['stok_sebelum']} | {$d['stok_sesudah']}\n";
}

/* ===== BUAT FOLDER JIKA BELUM ADA ===== */
if(!is_dir("laporan")){
    mkdir("laporan");
}

/* ===== NAMA FILE ===== */
$nama_file = "laporan/riwayat_obat_".$tahun."_".$bulan."_v".$versi."_".time().".txt";

/* ===== SIMPAN FILE ===== */
file_put_contents($nama_file,$isi);

/* ===== SIMPAN KE DATABASE ===== */
mysqli_query($conn,"
INSERT INTO laporan_obat_masuk (bulan,tahun,total_item,total_masuk,file_path,versi)
VALUES ('$bulan','$tahun','$jumlah','$total','$nama_file','$versi')
");

/* ===== REDIRECT ===== */
header("Location: riwayat_obat.php");
exit;
?>