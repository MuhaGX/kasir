-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2025 at 07:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Charset settings
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minimarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `barcode`, `nama_produk`, `harga`) VALUES
(5, '23232', 'Nasi Goreng2', 3232.00),
(6, '32', '32', 32.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `total`) VALUES
(1, '2025-02-18 15:25:31', 55000.00),
(2, '2025-02-18 15:28:11', 30000.00),
(3, '2025-02-18 15:33:38', 25000.00),
(4, '2025-02-18 15:53:41', 5000.00),
(5, '2025-02-18 15:54:07', 5000.00),
(6, '2025-02-18 15:57:01', 3944.00);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga` int NOT NULL,
  `jumlah` int NOT NULL DEFAULT 1,
  `subtotal` int NOT NULL DEFAULT 0,
  FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `transaksi_id`, `produk_id`, `nama_produk`, `harga`, `jumlah`, `subtotal`) VALUES
(1, 2, 1, 'Minuman Soda', 5000, 1, 5000),
(2, 2, 1, 'Minuman Soda', 5000, 1, 5000),
(3, 2, 1, 'Minuman Soda', 5000, 1, 5000),
(4, 2, 1, 'Minuman Soda', 5000, 1, 5000),
(5, 2, 1, 'Minuman Soda', 5000, 1, 5000),
(6, 2, 1, 'Minuman Soda', 5000, 1, 5000),
(7, 3, 1, 'Minuman Soda', 5000, 1, 5000),
(8, 3, 1, 'Minuman Soda', 5000, 1, 5000),
(9, 3, 1, 'Minuman Soda', 5000, 1, 5000),
(10, 3, 1, 'Minuman Soda', 5000, 1, 5000),
(11, 3, 1, 'Minuman Soda', 5000, 1, 5000),
(12, 4, 1, 'Minuman Soda', 5000, 1, 5000),
(13, 5, 1, 'Minuman Soda', 5000, 1, 5000),
(14, 6, 4, 'Ujang', 232, 1, 232),
(15, 6, 4, 'Ujang', 232, 1, 232),
(16, 6, 4, 'Ujang', 232, 1, 232),
(17, 6, 4, 'Ujang', 232, 1, 232),
(18, 6, 4, 'Ujang', 232, 1, 232),
(19, 6, 4, 'Ujang', 232, 1, 232),
(20, 6, 4, 'Ujang', 232, 1, 232),
(21, 6, 4, 'Ujang', 232, 1, 232),
(22, 6, 4, 'Ujang', 232, 1, 232),
(23, 6, 4, 'Ujang', 232, 1, 232),
(24, 6, 4, 'Ujang', 232, 1, 232),
(25, 6, 4, 'Ujang', 232, 1, 232),
(26, 6, 4, 'Ujang', 232, 1, 232),
(27, 6, 4, 'Ujang', 232, 1, 232),
(28, 6, 4, 'Ujang', 232, 1, 232),
(29, 6, 4, 'Ujang', 232, 1, 232),
(30, 6, 4, 'Ujang', 232, 1, 232);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` enum('admin','karyawan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`) VALUES
(1, 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for all tables
--

ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `transaksi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
