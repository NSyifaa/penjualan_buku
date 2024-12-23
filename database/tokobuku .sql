-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Nov 2024 pada 09.53
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.0.19

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
-- Struktur dari tabel `tbl_buku`
--

CREATE TABLE `tbl_buku` (
  `kd_buku` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_buku` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `isbn` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` int(11) NOT NULL,
  `penerbit` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_hal` int(11) NOT NULL,
  `cetakan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_buku`
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
-- Struktur dari tabel `tbl_detail_penjualan`
--

CREATE TABLE `tbl_detail_penjualan` (
  `id` int(11) NOT NULL,
  `nomor` varchar(255) NOT NULL,
  `kd_buku` varchar(250) NOT NULL,
  `qty` varchar(250) NOT NULL,
  `harga` varchar(50) NOT NULL,
  `subtotal` varchar(250) NOT NULL,
  `diskon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_detail_penjualan`
--

INSERT INTO `tbl_detail_penjualan` (`id`, `nomor`, `kd_buku`, `qty`, `harga`, `subtotal`, `diskon`) VALUES
(1, '16112024-MYG-1', 'A001\r\n', '4', '100000', '400000', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `kategori`) VALUES
(2, 'Teknologi'),
(6, 'Kesehatan'),
(7, 'Pendidikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_margin`
--

CREATE TABLE `tbl_margin` (
  `id` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `margin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_margin`
--

INSERT INTO `tbl_margin` (`id`, `margin`) VALUES
('788opk', 70);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_user` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `alamat` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_pengguna`
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
-- Struktur dari tabel `tbl_penjualan`
--

CREATE TABLE `tbl_penjualan` (
  `id` varchar(255) NOT NULL,
  `tgl` datetime NOT NULL,
  `nomor` varchar(255) NOT NULL,
  `nama_pel` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `bukti` text NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_penjualan`
--

INSERT INTO `tbl_penjualan` (`id`, `tgl`, `nomor`, `nama_pel`, `total`, `bukti`, `status`) VALUES
('233c44b1-6827-417e-891c-9d7cfe45e467', '2024-11-16 11:16:05', '16112024-MYG-1', 'Naylu Syifa', 0, '0', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_po`
--

CREATE TABLE `tbl_po` (
  `id_po` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `kode_sup` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_po`
--

INSERT INTO `tbl_po` (`id_po`, `tanggal`, `kode_sup`, `status`) VALUES
('15112024-PO-1', '2024-11-15', 'S002', 3),
('15112024-PO-2', '2024-11-15', 'S003', 3),
('15112024-PO-3', '2024-11-15', 'S002', 2),
('16112024-PO-1', '2024-11-16', 'S001', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_po_detail`
--

CREATE TABLE `tbl_po_detail` (
  `id` int(11) NOT NULL,
  `id_po` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_buku` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty_dtg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_dtg` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stat` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_po_detail`
--

INSERT INTO `tbl_po_detail` (`id`, `id_po`, `kd_buku`, `jumlah`, `harga`, `qty_dtg`, `harga_dtg`, `stat`) VALUES
(1, '15112024-PO-1', 'A001', 60, '12000', '50', '600000', '1'),
(2, '15112024-PO-1', 'A004', 70, '80000', '40', '3200000', '1'),
(3, '15112024-PO-2', 'A009', 60, '12000', '50', '600000', '1'),
(4, '15112024-PO-2', 'A010', 90, '23000', '80', '1840000', '1'),
(5, '15112024-PO-2', 'A009', 80, '25000', '50', '600000', '1'),
(6, '15112024-PO-3', 'A001', 12, '10000', NULL, NULL, '0'),
(7, '16112024-PO-1', 'A002', 20, '10000', NULL, NULL, '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_stok`
--

CREATE TABLE `tbl_stok` (
  `no_po` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kd_buku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_stok`
--

INSERT INTO `tbl_stok` (`no_po`, `kd_buku`, `qty`, `harga_beli`, `harga_jual`) VALUES
('15112024-PO-1 ', 'A001', 50, 12000, 20400),
('15112024-PO-1 ', 'A004', 40, 80000, 136000),
('15112024-PO-2 ', 'A009', 50, 12000, 20400),
('15112024-PO-2 ', 'A010', 80, 23000, 39100),
('15112024-PO-2 ', 'A009', 50, 25000, 42500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `kode_sup` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_suplier` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak_sup` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sales` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak_sales` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`kode_sup`, `nama_suplier`, `alamat`, `kontak_sup`, `nama_sales`, `kontak_sales`) VALUES
('S001', 'PT SUMBER JAYA AQUA', 'Yogyakarta', '083492001939', 'Naylu Syifa', '0823192039393'),
('S002', 'PT TANJUNG MULIA INFORMATIKA', 'Purwokerto Barat', '089392000192', 'Matien Hakim FB', '08392838922'),
('S003', 'PT MENCARI CINTA SEJATI', 'ALAAY', '087636277721', 'ADM-UHUY', '083930200300');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD PRIMARY KEY (`kd_buku`);

--
-- Indeks untuk tabel `tbl_detail_penjualan`
--
ALTER TABLE `tbl_detail_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tbl_margin`
--
ALTER TABLE `tbl_margin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_penjualan`
--
ALTER TABLE `tbl_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_po`
--
ALTER TABLE `tbl_po`
  ADD PRIMARY KEY (`id_po`);

--
-- Indeks untuk tabel `tbl_po_detail`
--
ALTER TABLE `tbl_po_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`kode_sup`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_detail_penjualan`
--
ALTER TABLE `tbl_detail_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_po_detail`
--
ALTER TABLE `tbl_po_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
