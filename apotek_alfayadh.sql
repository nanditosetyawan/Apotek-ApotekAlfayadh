-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2026 at 11:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek_alfayadh`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(255) NOT NULL,
  `nama` text NOT NULL,
  `produsen` text NOT NULL,
  `stok` int(255) NOT NULL,
  `harga` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_obat` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `id_obat`, `jumlah`, `harga`, `subtotal`) VALUES
(1, 1, 34, 12, 13000.00, 156000.00),
(2, 1, 30, 5, 12000.00, 60000.00),
(3, 2, 25, 2, 9000.00, 18000.00),
(4, 3, 2, 1, 15000.00, 15000.00),
(5, 3, 16, 2, 9500.00, 19000.00),
(6, 4, 16, 1, 9500.00, 9500.00),
(7, 5, 44, 16, 14000.00, 224000.00),
(8, 6, 44, 12, 14000.00, 168000.00),
(9, 7, 44, 4, 14000.00, 56000.00),
(10, 8, 18, 10, 13000.00, 130000.00),
(11, 8, 25, 1, 9000.00, 9000.00);

-- --------------------------------------------------------

--
-- Table structure for table `laporan_obat_masuk`
--

CREATE TABLE `laporan_obat_masuk` (
  `id_laporan` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `total_item` int(11) DEFAULT NULL,
  `total_masuk` int(11) DEFAULT NULL,
  `file_path` text DEFAULT NULL,
  `dibuat_pada` datetime DEFAULT current_timestamp(),
  `versi` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_obat_masuk`
--

INSERT INTO `laporan_obat_masuk` (`id_laporan`, `bulan`, `tahun`, `total_item`, `total_masuk`, `file_path`, `dibuat_pada`, `versi`) VALUES
(15, 4, 2026, 2, 19, 'laporan/riwayat_obat_2026_04_v1_1776283411.txt', '2026-04-16 03:03:31', 1),
(16, 4, 2026, 3, 919, 'laporan/riwayat_obat_2026_04_v2_1776283445.txt', '2026-04-16 03:04:05', 2);

-- --------------------------------------------------------

--
-- Table structure for table `log_stok`
--

CREATE TABLE `log_stok` (
  `id_log` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `jenis` enum('tambah','kurang') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `stok_sebelum` int(11) NOT NULL,
  `stok_sesudah` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_stok`
--

INSERT INTO `log_stok` (`id_log`, `id_obat`, `jenis`, `jumlah`, `stok_sebelum`, `stok_sesudah`, `tanggal`) VALUES
(18, 25, 'tambah', 14, 6, 20, '2026-04-16 02:36:13'),
(20, 53, 'tambah', 5, 0, 5, '2026-04-16 02:37:17'),
(21, 18, 'tambah', 900, 100, 1000, '2026-04-16 03:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(20) NOT NULL,
  `nama` text NOT NULL,
  `produsen` text NOT NULL,
  `stok` int(50) NOT NULL,
  `harga` int(255) NOT NULL,
  `gambar` varchar(255) DEFAULT 'img/default.png',
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama`, `produsen`, `stok`, `harga`, `gambar`, `deskripsi`) VALUES
(1, 'Paracetamol 500mg', 'Kimia Farma', 120, 8000, 'img/obat/default.png', 'Pereda nyeri dan penurun demam.'),
(2, 'Amoxicillin 500mg', 'Kalbe Farma', 74, 15000, 'img/obat/amoxicillin.png', 'Antibiotik untuk infeksi bakteri.'),
(3, 'Ibuprofen 400mg', 'Dexa Medica', 90, 12000, 'img/obat/default.png', 'Anti nyeri dan anti inflamasi.'),
(4, 'CTM 4mg', 'Indofarma', 60, 5000, 'img/obat/default.png', 'Antihistamin untuk alergi dan gatal.'),
(5, 'Antasida DOEN', 'Kimia Farma', 1, 75000, 'img/obat/default.png', 'Menetralkan asam lambung biar sehat.'),
(6, 'Vitamin C 500mg', 'Sido Muncul', 200, 10000, 'img/obat/default.png', 'Meningkatkan daya tahan tubuh.'),
(7, 'Asam Mefenamat 500mg', 'Kalbe Farma', 85, 14000, 'img/obat/default.png', 'Pereda nyeri sedang hingga berat.'),
(8, 'OBH Combi', 'Combiphar', 40, 18000, 'img/obat/default.png', 'Obat batuk dan flu.'),
(9, 'Betadine 30ml', 'Mahakam Beta Farma', 55, 22000, 'img/obat/default.png', 'Antiseptik untuk luka.'),
(10, 'Salep Bioplacenton 15gr', 'Kalbe Farma', 35, 28000, 'img/obat/default.png', 'Salep luka dan infeksi kulit.'),
(11, 'Ciprofloxacin 500mg', 'Hexpharm Jaya', 70, 17000, 'img/obat/default.png', 'Antibiotik spektrum luas.'),
(12, 'Loperamide 2mg', 'Bernofarm', 110, 6000, 'img/obat/default.png', 'Mengatasi diare.'),
(13, 'Ranitidine 150mg', 'Novell Pharmaceutical', 95, 9000, 'img/obat/default.png', 'Menurunkan produksi asam lambung.'),
(15, 'Dexamethasone 0.5mg', 'Ifars Pharmaceutical', 65, 7000, 'img/obat/default.png', 'Anti inflamasi dan alergi.'),
(16, 'Ambroxol 30mg', 'Sanbe Farma', 137, 9500, 'img/obat/ambroxol.png', 'Mengencerkan dahak.'),
(17, 'Metformin 500mg', 'Kimia Farma', 180, 12000, 'img/obat/default.png', 'Mengontrol gula darah diabetes.'),
(18, 'Amlodipine 10mg', 'Kalbe Farma', 990, 13000, 'img/obat/amlodipine.png', 'Menurunkan tekanan darah.'),
(19, 'Domperidone 10mg', 'Dexa Medica', 85, 11000, 'img/obat/default.png', 'Mengatasi mual dan muntah.'),
(20, 'Salbutamol 2mg', 'Indofarma', 75, 10000, 'img/obat/default.png', 'Melegakan saluran pernapasan.'),
(21, 'Clindamycin 300mg', 'Sanbe Farma', 80, 21000, 'img/obat/default.png', 'Antibiotik untuk infeksi serius.'),
(22, 'Erythromycin 500mg', 'Kimia Farma', 95, 18000, 'img/obat/default.png', 'Antibiotik infeksi bakteri.'),
(23, 'Ketoconazole 200mg', 'Hexpharm Jaya', 60, 16000, 'img/obat/default.png', 'Antijamur untuk infeksi kulit.'),
(25, 'Allopurinol 100mg', 'Indofarma', 19, 9000, 'img/obat/allopurinol.png', 'Menurunkan kadar asam urat dan sakit kaki.'),
(26, 'Simvastatin 20mg', 'Kalbe Farma', 150, 14000, 'img/obat/default.png', NULL),
(27, 'Atorvastatin 20mg', 'Dexa Medica', 110, 22000, 'img/obat/default.png', NULL),
(28, 'Captopril 25mg', 'Kimia Farma', 200, 7000, 'img/obat/default.png', NULL),
(29, 'Furosemide 40mg', 'Bernofarm', 90, 8500, 'img/obat/default.png', NULL),
(30, 'Spironolactone 25mg', 'Interbat', 70, 12000, 'img/obat/default.png', NULL),
(31, 'Glibenclamide 5mg', 'Ifars Pharmaceutical', 130, 6000, 'img/obat/default.png', NULL),
(32, 'Glimepiride 2mg', 'Sanbe Farma', 85, 15000, 'img/obat/default.png', NULL),
(33, 'Lansoprazole 30mg', 'Kalbe Farma', 100, 20000, 'img/obat/default.png', NULL),
(34, 'Omeprazole 20mg', 'Dexa Medica', 148, 13000, 'img/obat/default.png', NULL),
(35, 'Pantoprazole 40mg', 'Hexpharm Jaya', 95, 23000, 'img/obat/default.png', NULL),
(36, 'Methylprednisolone 4mg', 'Kimia Farma', 140, 11000, 'img/obat/default.png', NULL),
(37, 'Prednisone 5mg', 'Indofarma', 120, 10000, 'img/obat/default.png', NULL),
(38, 'Azithromycin 500mg', 'Novell Pharmaceutical', 75, 27000, 'img/obat/default.png', NULL),
(40, 'Cefixime 200mg', 'Sanbe Farma', 65, 30000, 'img/obat/default.png', NULL),
(41, 'Codeine 10mg', 'Bernofarm', 40, 15000, 'img/obat/default.png', NULL),
(42, 'Tramadol 50mg', 'Dexa Medica', 55, 18000, 'img/obat/default.png', NULL),
(43, 'Diazepam 5mg', 'Interbat', 45, 12000, 'img/obat/default.png', NULL),
(44, 'Alprazolam 0.5mg', 'Ifars Pharmaceutical', 3, 14000, 'img/obat/alprazolam.png', NULL),
(46, 'Nifedipine 10mg', 'Indofarma', 115, 9500, 'img/obat/default.png', NULL),
(47, 'Bisoprolol 5mg', 'Kalbe Farma', 100, 16000, 'img/obat/default.png', NULL),
(48, 'Hydrochlorothiazide 25mg', 'Sanbe Farma', 125, 8000, 'img/obat/default.png', NULL),
(49, 'Carbamazepine 200mg', 'Novell Pharmaceutical', 60, 17000, 'img/obat/default.png', NULL),
(50, 'Levofloxacin 500mg', 'Dexa Medica', 70, 28000, 'img/obat/default.png', NULL),
(51, 'Baygon 200ml', '', 6, 20000, 'img/obat/1775500631_Screenshot_2026-04-07-01-36-17-834_com.android.chrome-edit.jpg', 'Obat Nyamuk Super'),
(52, 'Nasi Padang', '', 100, 25000, 'img/obat/1775502139_Screenshot_2026-04-07-01-59-19-506_com.android.chrome.png', 'Sarapan Instan'),
(53, 'Bodrex', '', 5, 5000, 'img/obat/default.png', 'obat joss');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_transaksi_kasir`
--

CREATE TABLE `riwayat_transaksi_kasir` (
  `id` int(100) NOT NULL,
  `nama_dokumen` varchar(300) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file_path` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_transaksi_kasir`
--

INSERT INTO `riwayat_transaksi_kasir` (`id`, `nama_dokumen`, `tanggal`, `jam`, `file_path`) VALUES
(20, 'Laporan Bulan MARET', '2026-03-25', '2026-03-25 10:53:24', 'laporan/laporan_2026_maret_1774436004.txt'),
(22, 'Laporan Bulan APRIL', '2026-04-16', '2026-04-15 20:25:15', 'laporan/laporan_2026_april_1776284715.txt');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tanggal`, `id_user`, `total`) VALUES
(1, '2026-02-17 04:43:14', 1, 216000.00),
(2, '2026-03-10 05:26:41', 1, 18000.00),
(3, '2026-03-25 17:24:35', 1, 34000.00),
(4, '2026-03-25 17:28:07', 1, 9500.00),
(5, '2026-03-25 17:34:20', 1, 224000.00),
(6, '2026-03-25 17:36:16', 1, 168000.00),
(7, '2026-03-25 17:43:43', 1, 56000.00),
(8, '2026-04-16 03:10:02', 1, 139000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `jabatan` enum('managergudang','managertoko','kasir') NOT NULL,
  `kode_reset` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `jabatan`, `kode_reset`) VALUES
(1, 'Angga', 'Kerja', 'kasir', 'Uangjaya'),
(2, 'Joko', 'SosisManis', 'managergudang', 'Laris'),
(3, 'Bowo', 'AyamGoreng', 'managertoko', 'makanHemat');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `laporan_obat_masuk`
--
ALTER TABLE `laporan_obat_masuk`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `log_stok`
--
ALTER TABLE `log_stok`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_log_obat` (`id_obat`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `riwayat_transaksi_kasir`
--
ALTER TABLE `riwayat_transaksi_kasir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `laporan_obat_masuk`
--
ALTER TABLE `laporan_obat_masuk`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `log_stok`
--
ALTER TABLE `log_stok`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `riwayat_transaksi_kasir`
--
ALTER TABLE `riwayat_transaksi_kasir`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_stok`
--
ALTER TABLE `log_stok`
  ADD CONSTRAINT `fk_log_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
