-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Des 2025 pada 13.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_klinik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_detail_tindakan`
--

CREATE TABLE `tbl_detail_tindakan` (
  `id_detail` int(11) NOT NULL,
  `id_rm` int(11) DEFAULT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `id_tindakan` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_dokter`
--

CREATE TABLE `tbl_dokter` (
  `id_dokter` int(11) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `spesialisasi` varchar(50) DEFAULT NULL,
  `no_izin` varchar(50) DEFAULT NULL,
  `tarif` decimal(10,2) DEFAULT 0.00,
  `id_poli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_dokter`
--

INSERT INTO `tbl_dokter` (`id_dokter`, `nama_dokter`, `spesialisasi`, `no_izin`, `tarif`, `id_poli`) VALUES
(5, 'Dr. Fadhil', 'gigi', '08980', 79000.00, 5),
(6, 'Dr. Farhan', 'umum', '10201', 60000.00, 4),
(8, 'Dr. Rusdi', NULL, '11231', 0.00, 0),
(9, 'Dr. Rey', NULL, '00089', 0.00, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kunjungan`
--

CREATE TABLE `tbl_kunjungan` (
  `id_kunjungan` int(11) NOT NULL,
  `tanggal_kunjungan` datetime DEFAULT current_timestamp(),
  `id_pasien` int(11) NOT NULL,
  `id_dokter` int(11) DEFAULT NULL,
  `status_kunjungan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_kunjungan`
--

INSERT INTO `tbl_kunjungan` (`id_kunjungan`, `tanggal_kunjungan`, `id_pasien`, `id_dokter`, `status_kunjungan`) VALUES
(7, '2025-12-06 12:48:01', 3, 6, ''),
(8, '2025-12-06 12:51:04', 3, 6, ''),
(9, '2025-12-06 12:54:17', 3, 5, 'Diperiksa'),
(12, '2025-12-07 07:01:58', 3, 6, 'Selesai'),
(13, '2025-12-07 07:07:40', 5, 6, 'Menunggu'),
(14, '2025-12-07 13:15:52', 3, 5, 'Selesai'),
(16, '2025-12-08 17:18:53', 3, 6, 'Selesai'),
(17, '2025-12-08 21:12:19', 7, 5, 'Selesai'),
(18, '2025-12-10 13:19:58', 7, 5, 'Selesai'),
(19, '2025-12-10 13:31:43', 3, 6, 'Selesai'),
(20, '2025-12-10 13:34:09', 5, 6, 'Selesai'),
(21, '2025-12-10 13:43:14', 3, 5, 'Selesai'),
(22, '2025-12-11 12:43:18', 3, 5, 'Selesai'),
(23, '2025-12-11 13:04:19', 5, 6, 'Selesai'),
(24, '2025-12-11 13:15:46', 7, 5, 'Selesai'),
(25, '2025-12-11 13:22:42', 5, 6, 'Selesai'),
(26, '2025-12-11 13:26:53', 3, 5, 'Selesai'),
(27, '2025-12-11 13:34:57', 3, 5, 'Selesai'),
(28, '2025-12-11 13:38:22', 3, 5, 'Selesai'),
(29, '2025-12-11 13:51:24', 5, 6, 'Selesai'),
(30, '2025-12-11 13:58:46', 7, 5, 'Selesai'),
(31, '2025-12-11 14:09:29', 3, 5, 'Selesai'),
(32, '2025-12-11 14:19:52', 3, 6, 'Selesai'),
(33, '2025-12-11 14:20:54', 5, 5, 'Menunggu Pembayaran'),
(34, '2025-12-11 14:21:26', 3, 5, 'Selesai'),
(35, '2025-12-16 12:27:50', 5, 5, 'Selesai'),
(36, '2025-12-22 20:24:49', 8, 9, 'Selesai'),
(37, '2025-12-23 11:41:08', 8, 6, 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_obat`
--

CREATE TABLE `tbl_obat` (
  `id_obat` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `foto_obat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_obat`
--

INSERT INTO `tbl_obat` (`id_obat`, `nama_obat`, `satuan`, `harga_jual`, `stok`, `foto_obat`) VALUES
(1, 'Sanmol', '100mg', 30000.00, 90, 'sanmol_1765438565.png'),
(3, 'Paracetamol', '500mg', 30000.00, 49, 'paracetamol_1765958809.jpg'),
(4, 'vitamin c', 'botol infusan', 1900000.00, 2, NULL),
(5, 'komix', 'botol', 80000.00, 1, 'komix_1766409847.png'),
(6, 'Tolak Angin', 'Bungkus', 2000.00, 6, 'tolak-angin_1766464740.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pasien`
--

CREATE TABLE `tbl_pasien` (
  `id_pasien` int(11) NOT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `tgl_dibuat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pasien`
--

INSERT INTO `tbl_pasien` (`id_pasien`, `nama_pasien`, `tgl_lahir`, `alamat`, `no_telp`, `tgl_dibuat`) VALUES
(3, 'RAFA', '2006-06-12', 'Sangiang jaya', '08979708897900', '2025-12-04 14:39:43'),
(5, 'Aqil', '2012-08-22', 'Bugel mas indah', '0869583938', '2025-12-07 07:06:55'),
(7, 'Dhani', '2006-05-10', 'Perumahan Mekar Sari, Rajeg', '08674939302', '2025-12-08 14:42:27'),
(8, 'Yudi', '2009-06-16', 'Kedaung wetan', '08808087908', '2025-12-22 14:22:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_kunjungan` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `tgl_bayar` datetime DEFAULT current_timestamp(),
  `total_akhir` decimal(10,2) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `metode_pembayaran` enum('cash','transfer') NOT NULL DEFAULT 'cash',
  `status_bayar` enum('Lunas','Belum Bayar') DEFAULT 'Lunas',
  `bukti_bayar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id_pembayaran`, `id_kunjungan`, `id_pengguna`, `tgl_bayar`, `total_akhir`, `jumlah_bayar`, `kembalian`, `metode_pembayaran`, `status_bayar`, `bukti_bayar`) VALUES
(1, 12, 1, '2025-12-08 18:14:56', 1900000.00, 0, 0, 'cash', 'Lunas', NULL),
(2, 14, 1, '2025-12-08 18:16:24', 1200000.00, 0, 0, 'cash', 'Lunas', NULL),
(3, 16, 1, '2025-12-08 18:20:13', 1200000.00, 0, 0, 'cash', 'Lunas', NULL),
(4, 17, 1, '2025-12-08 22:14:32', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(5, 18, 1, '2025-12-10 13:31:25', 4360000.00, 0, 0, 'cash', 'Lunas', NULL),
(6, 20, 1, '2025-12-10 13:41:39', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(7, 19, 1, '2025-12-10 14:04:50', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(8, 21, 1, '2025-12-10 15:52:38', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(9, 34, 1, '2025-12-11 14:22:25', 3800000.00, 0, 0, 'cash', 'Lunas', NULL),
(10, 22, 1, '2025-12-15 19:46:09', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(11, 35, 1, '2025-12-16 14:20:45', 1900000.00, 0, 0, 'cash', 'Lunas', NULL),
(12, 23, 1, '2025-12-16 14:41:22', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(13, 30, 1, '2025-12-16 14:43:58', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(14, 31, 1, '2025-12-17 13:44:49', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(15, 24, 1, '2025-12-17 14:46:26', 30000.00, 0, 0, 'transfer', 'Lunas', '27f400e19160f3c0e8fed45985e0bb0a.png'),
(16, 36, 1, '2025-12-22 20:27:12', 160000.00, 0, 0, 'cash', 'Lunas', NULL),
(17, 27, 1, '2025-12-22 20:30:40', 30000.00, 0, 0, 'transfer', 'Lunas', '6924da5dbd6eee902a378de9e0b59cd0.png'),
(18, 25, 1, '2025-12-22 20:32:16', 30000.00, 0, 0, 'cash', 'Lunas', NULL),
(19, 26, 1, '2025-12-22 20:43:29', 30000.00, 50000, 20000, 'cash', 'Lunas', NULL),
(21, 28, 1, '2025-12-22 20:45:32', 30000.00, 60000, 30000, 'cash', 'Lunas', NULL),
(22, 32, 1, '2025-12-22 20:46:22', 330000.00, 400000, 70000, 'cash', 'Lunas', NULL),
(23, 29, 1, '2025-12-22 20:46:58', 30000.00, 40000, 10000, 'cash', 'Lunas', NULL),
(24, 37, 5, '2025-12-23 11:44:22', 306000.00, 390000, 84000, 'cash', 'Lunas', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id_pengguna`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'fadhil'),
(3, 'rafa', '38eefa41cf3d6a1e2032afef8e52b955be78661f', 'rafa'),
(4, 'aldi', 'daf036f7f77e11a342e9520ff8fc256d', 'aldi'),
(5, 'Dapi', '579dbcc44c8b4baeaddd1071c20537d2', 'Maulana Khadafi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_rekam_medis`
--

CREATE TABLE `tbl_rekam_medis` (
  `id_rm` int(11) NOT NULL,
  `id_kunjungan` int(11) NOT NULL,
  `keluhan` text DEFAULT NULL,
  `diagnosa` text DEFAULT NULL,
  `catatan_medis` text DEFAULT NULL,
  `id_dokter` int(11) NOT NULL,
  `tgl_pemeriksaan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_rekam_medis`
--

INSERT INTO `tbl_rekam_medis` (`id_rm`, `id_kunjungan`, `keluhan`, `diagnosa`, `catatan_medis`, `id_dokter`, `tgl_pemeriksaan`) VALUES
(1, 12, 'sakit di bagian dada, dan sakit di bagian kepala serta tenggorokan sakit', 'kekurangan vitamin c', 'Tensi: 120/80mmHg mmHg | Suhu: 36.5 °C | BB: 60 kg', 6, '2025-12-08 17:52:43'),
(2, 14, 'sakit di bagian belakang kepala', 'Kurang vitamin c', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 56 kg', 5, '2025-12-08 17:50:33'),
(3, 16, 'sakit di bagian kepala', 'migrain ', 'Tensi: 160 mmHg | Suhu: 40 °C | BB: 89 kg', 6, '2025-12-08 18:19:42'),
(4, 17, 'sakit kepala ', 'migrain', 'Tensi: 100/80mmMHG mmHg | Suhu: 28 °C | BB: 70 kg', 5, '2025-12-08 22:09:51'),
(5, 18, 'sakit pinggang ', 'saraf kejepit', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 59 kg', 5, '2025-12-10 13:21:07'),
(6, 19, 'Sakit gigi', 'gigi berlubang', 'Tensi: 120/80 mmHg | Suhu: 45 °C | BB: 34 kg', 6, '2025-12-10 13:32:48'),
(7, 20, 'adad', 'adaada', 'Tensi: 120/80 mmHg | Suhu: 45 °C | BB: 43 kg', 6, '2025-12-10 13:41:26'),
(8, 21, 'ada', 'adad', 'Tensi: 160 mmHg | Suhu: 45 °C | BB: 34 kg', 5, '2025-12-10 15:52:26'),
(9, 22, 'sakiy', 'asa', 'Tensi: 120/80 mmHg | Suhu: 45 °C | BB: 34 kg', 5, '2025-12-11 13:03:29'),
(10, 23, 'aswsa', 'asad', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 35 kg', 6, '2025-12-11 13:04:58'),
(11, 24, 'kepala', 'asa', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 56 kg', 5, '2025-12-11 13:18:32'),
(12, 25, 'asera', 'asa', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 343 kg', 6, '2025-12-11 13:23:49'),
(13, 26, 'wqw', 'awsw', 'Tensi: 120/80 mmHg | Suhu: 30 °C | BB: 45 kg', 5, '2025-12-11 13:27:46'),
(14, 27, 'aswsa', 'awsaw', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 65 kg', 5, '2025-12-11 13:35:36'),
(15, 28, 'kepala', 'retu', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 60 kg', 5, '2025-12-11 13:49:01'),
(16, 29, 'awada', 'kepala', 'Tensi: 120/80 mmHg | Suhu: 45 °C | BB: 56 kg', 6, '2025-12-11 13:56:35'),
(17, 30, 'telinga', 'kotoran', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 45 kg', 5, '2025-12-11 13:59:31'),
(18, 31, 'adawa', 'rerer', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 54 kg', 5, '2025-12-11 14:10:05'),
(19, 32, 'asaws', 'aada', 'Tensi: 120/80 mmHg | Suhu: 45 °C | BB: 79 kg', 6, '2025-12-11 14:20:25'),
(20, 33, 'pinggang encok', 'adasd', 'Tensi: 120/80 mmHg | Suhu: 45 °C | BB: 65 kg', 5, '2025-12-11 14:21:13'),
(21, 34, 'rede', 'rede', 'Tensi: 120/80 mmHg | Suhu: 45 °C | BB: 45 kg', 5, '2025-12-11 14:22:03'),
(22, 35, 'aes', 'ae', 'Tensi: 120/80mmHg mmHg | Suhu: 45 °C | BB: 45 kg', 5, '2025-12-16 14:19:48'),
(23, 36, 'Sakit di kepala', 'Migrain', 'Tensi: 120/80 mmHg | Suhu: 45 °C | BB: 76 kg', 9, '2025-12-22 20:26:31'),
(24, 37, 'Sakit kepala', 'Migrain', 'Tensi: 150 mmHg | Suhu: 39 °C | BB: 64 kg', 6, '2025-12-23 11:43:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_resep_obat`
--

CREATE TABLE `tbl_resep_obat` (
  `id_resep_obat` int(11) NOT NULL,
  `id_rm` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `aturan_pakai` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_resep_obat`
--

INSERT INTO `tbl_resep_obat` (`id_resep_obat`, `id_rm`, `id_obat`, `jumlah`, `aturan_pakai`) VALUES
(1, 2, 1, 40, '3x sehari 1 tablet setelah makan'),
(2, 1, 4, 1, '1 kali'),
(3, 3, 1, 40, '3x sehari 1 tablet setelah makan'),
(4, 4, 1, 1, '3x sehari 1 tablet sesudah makan'),
(5, 5, 3, 1, '3x sehari 1 tablet sesudah makan'),
(6, 6, 1, 1, '3x sehari 1 tablet sesudah makan'),
(7, 7, 1, 1, '1 sehari'),
(8, 8, 1, 1, 'adawsas'),
(9, 9, 1, 1, '3x sehari 1 tablet sesudah makan'),
(10, 10, 3, 1, '3x sehari 1 tablet sesudah makan'),
(11, 11, 1, 1, '3x'),
(12, 12, 1, 1, '4x sehari'),
(13, 13, 1, 1, '3x sehari 1 tablet sesudah makan'),
(14, 14, 1, 1, '3x sehari 1 tablet sesudah makan'),
(15, 15, 1, 1, '3x sehari '),
(16, 16, 1, 1, '3x sehari'),
(17, 17, 1, 1, '3x sehari'),
(18, 18, 1, 1, '3x sehari'),
(19, 19, 1, 11, '3x sehari 1 tablet sesudah makan'),
(20, 21, 4, 2, '3x sehari 1 tablet sesudah makan'),
(21, 22, 4, 1, '1x sehari'),
(22, 23, 5, 2, '1 kali sehari 1 botol sesudah makan'),
(23, 24, 6, 3, '3x sehari sesudah makan'),
(24, 24, 1, 10, '3x sehari setelah makan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_tindakan`
--

CREATE TABLE `tbl_tindakan` (
  `id_tindakan` int(11) NOT NULL,
  `nama_tindakan` varchar(100) NOT NULL,
  `biaya_tindakan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_tindakan`
--

INSERT INTO `tbl_tindakan` (`id_tindakan`, `nama_tindakan`, `biaya_tindakan`) VALUES
(1, 'Konsultasi Dokter Umum', 60000.00),
(2, 'Pemeriksaan Fisik Lanjutan', 25000.00),
(3, 'Suntik Vitamin C', 45000.00),
(4, 'Perawatan Luka Ringan', 75000.00),
(5, 'Pencabutan Gigi Anak', 150000.00),
(6, 'Penambalan Gigi Sederhana', 200000.00),
(7, 'Konsultasi Dokter Anak', 75000.00),
(8, 'Imunisasi Rutin', 80000.00);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_detail_tindakan`
--
ALTER TABLE `tbl_detail_tindakan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pembayaran` (`id_pembayaran`),
  ADD KEY `id_tindakan` (`id_tindakan`);

--
-- Indeks untuk tabel `tbl_dokter`
--
ALTER TABLE `tbl_dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indeks untuk tabel `tbl_kunjungan`
--
ALTER TABLE `tbl_kunjungan`
  ADD PRIMARY KEY (`id_kunjungan`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indeks untuk tabel `tbl_obat`
--
ALTER TABLE `tbl_obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indeks untuk tabel `tbl_pasien`
--
ALTER TABLE `tbl_pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indeks untuk tabel `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `id_kunjungan` (`id_kunjungan`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indeks untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  ADD PRIMARY KEY (`id_rm`),
  ADD UNIQUE KEY `id_kunjungan` (`id_kunjungan`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indeks untuk tabel `tbl_resep_obat`
--
ALTER TABLE `tbl_resep_obat`
  ADD PRIMARY KEY (`id_resep_obat`),
  ADD KEY `id_rm` (`id_rm`),
  ADD KEY `id_obat` (`id_obat`);

--
-- Indeks untuk tabel `tbl_tindakan`
--
ALTER TABLE `tbl_tindakan`
  ADD PRIMARY KEY (`id_tindakan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_detail_tindakan`
--
ALTER TABLE `tbl_detail_tindakan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_dokter`
--
ALTER TABLE `tbl_dokter`
  MODIFY `id_dokter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbl_kunjungan`
--
ALTER TABLE `tbl_kunjungan`
  MODIFY `id_kunjungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `tbl_obat`
--
ALTER TABLE `tbl_obat`
  MODIFY `id_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_pasien`
--
ALTER TABLE `tbl_pasien`
  MODIFY `id_pasien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  MODIFY `id_rm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `tbl_resep_obat`
--
ALTER TABLE `tbl_resep_obat`
  MODIFY `id_resep_obat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `tbl_tindakan`
--
ALTER TABLE `tbl_tindakan`
  MODIFY `id_tindakan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_detail_tindakan`
--
ALTER TABLE `tbl_detail_tindakan`
  ADD CONSTRAINT `tbl_detail_tindakan_ibfk_1` FOREIGN KEY (`id_pembayaran`) REFERENCES `tbl_pembayaran` (`id_pembayaran`),
  ADD CONSTRAINT `tbl_detail_tindakan_ibfk_2` FOREIGN KEY (`id_tindakan`) REFERENCES `tbl_tindakan` (`id_tindakan`);

--
-- Ketidakleluasaan untuk tabel `tbl_kunjungan`
--
ALTER TABLE `tbl_kunjungan`
  ADD CONSTRAINT `tbl_kunjungan_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tbl_pasien` (`id_pasien`),
  ADD CONSTRAINT `tbl_kunjungan_ibfk_3` FOREIGN KEY (`id_dokter`) REFERENCES `tbl_dokter` (`id_dokter`);

--
-- Ketidakleluasaan untuk tabel `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD CONSTRAINT `tbl_pembayaran_ibfk_1` FOREIGN KEY (`id_kunjungan`) REFERENCES `tbl_kunjungan` (`id_kunjungan`),
  ADD CONSTRAINT `tbl_pembayaran_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id_pengguna`);

--
-- Ketidakleluasaan untuk tabel `tbl_rekam_medis`
--
ALTER TABLE `tbl_rekam_medis`
  ADD CONSTRAINT `tbl_rekam_medis_ibfk_1` FOREIGN KEY (`id_kunjungan`) REFERENCES `tbl_kunjungan` (`id_kunjungan`),
  ADD CONSTRAINT `tbl_rekam_medis_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tbl_dokter` (`id_dokter`);

--
-- Ketidakleluasaan untuk tabel `tbl_resep_obat`
--
ALTER TABLE `tbl_resep_obat`
  ADD CONSTRAINT `tbl_resep_obat_ibfk_1` FOREIGN KEY (`id_rm`) REFERENCES `tbl_rekam_medis` (`id_rm`),
  ADD CONSTRAINT `tbl_resep_obat_ibfk_2` FOREIGN KEY (`id_obat`) REFERENCES `tbl_obat` (`id_obat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
