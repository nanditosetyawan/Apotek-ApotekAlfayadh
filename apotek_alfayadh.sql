-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 06:40 PM
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
(9, 7, 44, 4, 14000.00, 56000.00);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(20) NOT NULL,
  `nama` text NOT NULL,
  `produsen` text NOT NULL,
  `stok` int(50) NOT NULL,
  `harga` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama`, `produsen`, `stok`, `harga`) VALUES
(1, 'Paracetamol 500mg', 'Kimia Farma', 120, 8000),
(2, 'Amoxicillin 500mg', 'Kalbe Farma', 74, 15000),
(3, 'Ibuprofen 400mg', 'Dexa Medica', 90, 12000),
(4, 'CTM 4mg', 'Indofarma', 60, 5000),
(5, 'Antasida DOEN', 'Kimia Farma', 150, 7500),
(6, 'Vitamin C 500mg', 'Sido Muncul', 200, 10000),
(7, 'Asam Mefenamat 500mg', 'Kalbe Farma', 85, 14000),
(8, 'OBH Combi', 'Combiphar', 40, 18000),
(9, 'Betadine 30ml', 'Mahakam Beta Farma', 55, 22000),
(10, 'Salep Bioplacenton 15gr', 'Kalbe Farma', 35, 28000),
(11, 'Ciprofloxacin 500mg', 'Hexpharm Jaya', 70, 17000),
(12, 'Loperamide 2mg', 'Bernofarm', 110, 6000),
(13, 'Ranitidine 150mg', 'Novell Pharmaceutical', 95, 9000),
(14, 'Cetirizine 10mg', 'Interbat', 130, 8000),
(15, 'Dexamethasone 0.5mg', 'Ifars Pharmaceutical', 65, 7000),
(16, 'Ambroxol 30mg', 'Sanbe Farma', 137, 9500),
(17, 'Metformin 500mg', 'Kimia Farma', 180, 12000),
(18, 'Amlodipine 10mg', 'Kalbe Farma', 100, 13000),
(19, 'Domperidone 10mg', 'Dexa Medica', 85, 11000),
(20, 'Salbutamol 2mg', 'Indofarma', 75, 10000),
(21, 'Clindamycin 300mg', 'Sanbe Farma', 80, 21000),
(22, 'Erythromycin 500mg', 'Kimia Farma', 95, 18000),
(23, 'Ketoconazole 200mg', 'Hexpharm Jaya', 60, 16000),
(24, 'Fluconazole 150mg', 'Novell Pharmaceutical', 70, 25000),
(25, 'Allopurinol 100mg', 'Indofarma', 118, 9000),
(26, 'Simvastatin 20mg', 'Kalbe Farma', 150, 14000),
(27, 'Atorvastatin 20mg', 'Dexa Medica', 110, 22000),
(28, 'Captopril 25mg', 'Kimia Farma', 200, 7000),
(29, 'Furosemide 40mg', 'Bernofarm', 90, 8500),
(30, 'Spironolactone 25mg', 'Interbat', 70, 12000),
(31, 'Glibenclamide 5mg', 'Ifars Pharmaceutical', 130, 6000),
(32, 'Glimepiride 2mg', 'Sanbe Farma', 85, 15000),
(33, 'Lansoprazole 30mg', 'Kalbe Farma', 100, 20000),
(34, 'Omeprazole 20mg', 'Dexa Medica', 148, 13000),
(35, 'Pantoprazole 40mg', 'Hexpharm Jaya', 95, 23000),
(36, 'Methylprednisolone 4mg', 'Kimia Farma', 140, 11000),
(37, 'Prednisone 5mg', 'Indofarma', 120, 10000),
(38, 'Azithromycin 500mg', 'Novell Pharmaceutical', 75, 27000),
(39, 'Cefadroxil 500mg', 'Kalbe Farma', 105, 19000),
(40, 'Cefixime 200mg', 'Sanbe Farma', 65, 30000),
(41, 'Codeine 10mg', 'Bernofarm', 40, 15000),
(42, 'Tramadol 50mg', 'Dexa Medica', 55, 18000),
(43, 'Diazepam 5mg', 'Interbat', 45, 12000),
(44, 'Alprazolam 0.5mg', 'Ifars Pharmaceutical', 3, 14000),
(45, 'Chloramphenicol 250mg', 'Kimia Farma', 90, 10000),
(46, 'Nifedipine 10mg', 'Indofarma', 115, 9500),
(47, 'Bisoprolol 5mg', 'Kalbe Farma', 100, 16000),
(48, 'Hydrochlorothiazide 25mg', 'Sanbe Farma', 125, 8000),
(49, 'Carbamazepine 200mg', 'Novell Pharmaceutical', 60, 17000),
(50, 'Levofloxacin 500mg', 'Dexa Medica', 70, 28000);

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
(2, 'Transaksi Bulan November', '2025-11-06', '2025-11-06 01:07:02', NULL),
(3, 'Transaksi Bulan Oktober', '2025-10-10', '2025-10-09 18:07:53', NULL),
(20, 'Laporan Bulan MARET', '2026-03-25', '2026-03-25 10:53:24', 'laporan/laporan_2026_maret_1774436004.txt');

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
(7, '2026-03-25 17:43:43', 1, 56000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `jabatan` enum('managergudang','managertoko','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `jabatan`) VALUES
(1, 'Angga', ' ', 'kasir'),
(2, 'Joko', ' ', 'managergudang'),
(3, 'Bowo', ' ', 'managertoko');

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
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `riwayat_transaksi_kasir`
--
ALTER TABLE `riwayat_transaksi_kasir`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
