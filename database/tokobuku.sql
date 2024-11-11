-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2024 at 03:05 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tokobuku`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buku`
--

CREATE TABLE `tbl_buku` (
  `kd_buku` varchar(250) NOT NULL,
  `judul_buku` varchar(250) NOT NULL,
  `id_kategori` int NOT NULL,
  `isbn` varchar(100) NOT NULL,
  `tahun` int NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `jml_hal` int NOT NULL,
  `cetakan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_buku`
--

INSERT INTO `tbl_buku` (`kd_buku`, `judul_buku`, `id_kategori`, `isbn`, `tahun`, `penerbit`, `jml_hal`, `cetakan`) VALUES
('A001', 'BAHASA PEMROGRAMAN ', 2, '978-602-1234-12-3', 2024, 'Erlangga', 100, 1),
('A002', 'ANDROID STUDIO', 2, '978-979-1234-45-6', 2024, 'Erlangga', 100, 1),
('A003', 'BELAJAR PHP', 2, '978-602-9876-11-9', 2024, 'Erlangga', 100, 2),
('A004', 'JARINGAN KOMPUTER', 2, '978-979-6543-22-8', 2024, 'Erlangga', 100, 2),
('A005', 'INTERAKSI MANUSIA DAN KOM', 2, '978-602-4321-89-2', 2024, 'Erlangga', 200, 2),
('A006', 'SISTEM INFORMASI MNJ', 2, '978-602-1234-77-0', 2024, 'Gramedia', 200, 2),
('A007', 'AKUNTANSI', 7, '978-602-4321-11-9', 2024, 'Gramedia', 200, 2),
('A008', 'MANAJEMEN RANTAI PASOK', 2, '978-602-8976-12-7', 2024, 'Gramedia', 200, 4),
('A009', 'PANDUAN GIZI SEIMBANG', 6, '978-602-5432-88-5', 2024, 'Gramedia', 200, 5),
('A010', 'Kesehatan Lingkungan untuk Masyarakat', 6, '978-602-4321-78-3', 2024, 'Penerbit Bumi Aksara', 200, 2),
('A011', 'Anatomi dan Fisiologi Manusia', 6, '978-979-6543-11-2', 2024, 'Penerbit Salemba Empat', 300, 2),
('A012', 'Dasar-dasar Ilmu Kesehatan Masyarakat', 6, '978-602-5432-55-8', 2024, 'Gramedia', 200, 2),
('A013', 'Prinsip Dasar Farmakologi', 6, '978-602-1234-44-7', 2024, 'Gramedia', 100, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int NOT NULL,
  `kategori` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `kategori`) VALUES
(2, 'Teknologi'),
(6, 'Kesehatan'),
(7, 'Pendidikan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `status` int NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `kontak` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `username`, `password`, `nama_user`, `status`, `alamat`, `kontak`) VALUES
('002', 'gataulah', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 'mbuhhhhh', 1, 'Jepang sebelah kanan', '0738383388222'),
('122', 'cipaa', '1612', 'nay', 1, 'jepang', '082343333211'),
('123', 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'Administrator', 0, 'Bantarkawung', '083861228265'),
('25e0852b-7f3e-4414-8ff4-5956164c65d6', 'Syifaja', 'e7cb1be70ddcba3dea9144f35988f0b1af5aba1b', 'Naylu Syifa', 1, 'Tanjung, Pwt', '083861228265'),
('456', 'kasir', '8cfab3d2724448440ea03b9cfa0194cb962a7723', 'Matien jelek', 1, 'Pagojengan', '087829302902'),
('4cb6e2a6-4e79-4d2d-b52e-a4ad89616ea0', 'cipa', '54566879bfd232e1ef8ad3619185f1e7e55e46e4', 'Naylu Syifa', 0, 'Bantarkawung, Kab.Brebes', '083526272728');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_po`
--

CREATE TABLE `tbl_po` (
  `id_po` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_sup` varchar(20) NOT NULL,
  `status` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_po`
--

INSERT INTO `tbl_po` (`id_po`, `tanggal`, `kode_sup`, `status`) VALUES
('11112024-PO-1', '2024-11-11', 'S002', 3),
('11112024-PO-2', '2024-11-11', 'S003', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_po_detail`
--

CREATE TABLE `tbl_po_detail` (
  `id` int NOT NULL,
  `id_po` varchar(255) NOT NULL,
  `kd_buku` varchar(250) NOT NULL,
  `jumlah` int NOT NULL,
  `harga` varchar(50) NOT NULL,
  `qty_dtg` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `harga_dtg` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `stat` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_po_detail`
--

INSERT INTO `tbl_po_detail` (`id`, `id_po`, `kd_buku`, `jumlah`, `harga`, `qty_dtg`, `harga_dtg`, `stat`) VALUES
(1, '11112024-PO-1', 'A001', 2, '10000', '2', '20000', '1'),
(2, '11112024-PO-1', 'A002', 3, '11111', NULL, NULL, '1'),
(3, '11112024-PO-1', 'A008', 10, '50000', NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `kode_sup` varchar(20) NOT NULL,
  `nama_suplier` varchar(250) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `kontak_sup` varchar(20) NOT NULL,
  `nama_sales` varchar(250) NOT NULL,
  `kontak_sales` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`kode_sup`, `nama_suplier`, `alamat`, `kontak_sup`, `nama_sales`, `kontak_sales`) VALUES
('S001', 'PT SUMBER JAYA AQUA', 'Yogyakarta', '083492001939', 'Naylu Syifa', '0823192039393'),
('S002', 'PT TANJUNG MULIA INFORMATIKA', 'Purwokerto Barat', '089392000192', 'Matien Hakim FB', '08392838922'),
('S003', 'PT MENCARI CINTA SEJATI', 'ALAAY', '087636277721', 'ADM-UHUY', '083930200300');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD PRIMARY KEY (`kd_buku`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_po`
--
ALTER TABLE `tbl_po`
  ADD PRIMARY KEY (`id_po`);

--
-- Indexes for table `tbl_po_detail`
--
ALTER TABLE `tbl_po_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`kode_sup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_po_detail`
--
ALTER TABLE `tbl_po_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
