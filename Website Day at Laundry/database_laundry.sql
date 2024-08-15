-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2023 at 05:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  `nama_pelanggan` varchar(75) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`username`, `password`, `nama_pelanggan`, `no_telp`, `email`) VALUES
('Hadi', '123', 'Muhammad Rahman Hadi', '081234567890', 'hadi@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pelayanan`
--

CREATE TABLE `pelayanan` (
  `id_pelayanan` char(10) NOT NULL,
  `nama` char(30) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelayanan`
--

INSERT INTO `pelayanan` (`id_pelayanan`, `nama`, `deskripsi`, `harga`) VALUES
('PEL0000001', 'Laundry Kiloan', 'Melakukan laundry per kilo', 8000.00),
('PEL0000002', 'Dry Cleaning', 'Melakukan dry cleaning per barang ', 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` char(10) NOT NULL,
  `id_pemesanan` char(10) DEFAULT NULL,
  `instusi_keuangan` enum('Mandiri','BCA','BNI','HSBC') DEFAULT NULL,
  `metode_pembayaran` enum('transfer','kredit') DEFAULT NULL,
  `total_harga` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `instusi_keuangan`, `metode_pembayaran`, `total_harga`) VALUES
('PBY0000001', 'PEM0000001', 'Mandiri', 'kredit', 96000);

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` char(10) NOT NULL,
  `username` char(30) DEFAULT NULL,
  `id_pelayanan` char(10) DEFAULT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `status` enum('Dicuci','Dikeringkan','Digosok','Siap Diambil') DEFAULT NULL,
  `tanggal_pemesanan` datetime DEFAULT NULL,
  `kuantitas` decimal(5,2) DEFAULT NULL,
  `no_rekening_atau_kredit` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `username`, `id_pelayanan`, `alamat`, `status`, `tanggal_pemesanan`, `kuantitas`, `no_rekening_atau_kredit`) VALUES
('PEM0000001', 'Hadi', 'PEL0000001', 'Jakarta Selatan', 'Dicuci', '2023-06-09 13:44:26', 12.00, '1234567890123499');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `id_promo` char(10) NOT NULL,
  `kode` char(6) DEFAULT NULL,
  `persentase_diskon` decimal(5,2) DEFAULT NULL,
  `tanggal_hangus` date DEFAULT NULL,
  `masih_berlaku` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`id_promo`, `kode`, `persentase_diskon`, `tanggal_hangus`, `masih_berlaku`) VALUES
('PRO0000001', 'ABC123', 0.50, '2023-12-31', 1),
('PRO0000002', 'DEF456', 0.10, '2023-12-31', 1),
('PRO0000003', 'GHI789', 0.30, '2023-12-31', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pelayanan`
--
ALTER TABLE `pelayanan`
  ADD PRIMARY KEY (`id_pelayanan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_pelayanan` (`id_pelayanan`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id_promo`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`);

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_pelayanan`) REFERENCES `pelayanan` (`id_pelayanan`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`username`) REFERENCES `pelanggan` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
