-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 23, 2025 at 11:55 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sig`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `nama` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`) VALUES
(1, 'admin', 'admin', 'admin'),
(2, 'Azlan', 'azlan', '$2y$10$i/pLkvAMgKZdchA5JreZMuKWK319HxzEfUyf9BIvZLPzdORGjFGK2'),
(3, 'ica', 'ica', '$2y$10$U6Vr9Rb2JBLFaXzpD8OiFe4jKgAoeLa3TTh0OywuYYLdBPwPpEqUq');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `isi_berita` text NOT NULL,
  `tanggal_posting` datetime NOT NULL,
  `foto_berita` varchar(255) NOT NULL,
  `id_admin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `isi_berita`, `tanggal_posting`, `foto_berita`, `id_admin`) VALUES
(1, 'berita baru1 edit', '<p>lorem ipsum dolor sit amet edit</p>\r\n', '2025-01-31 17:59:19', '679d0f77af509.jpg', 1),
(3, 'coba 22', '<p>coba trip kke 2</p>\r\n', '2025-01-31 18:03:07', '679d105b1dcd1.jpg', 1),
(4, 'cobaaaaaaaaa1', '<p>cobaaaaaaaaa1</p>\r\n', '2025-02-02 16:23:37', '679f9c09b7fd6.jpg', 1),
(5, 'cobaaaaaaaaa2', '<p>cobaaaaaaaaa2</p>\r\n', '2025-02-02 16:23:49', '679f9c155db9e.jpg', 1),
(6, 'cobaaaaaaaaa3', '<p>cobaaaaaaaaa3</p>\r\n', '2025-02-02 16:24:02', '679f9c22b2d53.jpg', 1),
(7, 'cobaaaaaaaaa4', '<p>cobaaaaaaaaa4</p>\r\n', '2025-02-02 16:24:14', '679f9c2e68ce1.png', 1),
(8, 'cobaaaaaaaaa5', '<p>cobaaaaaaaaa4</p>\r\n', '2025-02-02 16:25:07', '679f9c63eccba.jpg', 1),
(9, 'cobaaaaaaaaa6', '<p>cobaaaaaaaaa4</p>\r\n', '2025-02-02 16:25:17', '679f9c6d922a0.jpg', 1),
(10, 'cobaaaaaaaaa7', '<p>cobaaaaaaaaa4</p>\r\n', '2025-02-02 16:25:30', '679f9c7a1b842.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id_event` int NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `alamat` text NOT NULL,
  `deskripsi` text NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto_event` varchar(255) NOT NULL,
  `status` enum('aktif','selesai') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id_event`, `nama_event`, `tanggal_mulai`, `tanggal_selesai`, `alamat`, `deskripsi`, `latitude`, `longitude`, `foto_event`, `status`) VALUES
(2, 'azlan edit', '2025-01-31', '2025-02-08', 'azlan', 'azlan', '-0.8689192629516812', '100.66248893737793', '679cc1528d9ce.png', 'aktif'),
(3, 'coba 23', '2025-02-01', '2025-02-12', 'coba 23', 'coba 23', '-0.920623263330019', '100.4747772216797', '679d0c57c2a2c.jpg', 'aktif'),
(4, 'azlannn', '2025-02-03', '2025-02-14', 'azlannn', 'azlannn', '-0.8327429352594208', '100.5352020263672', '679fa1508503c.jpg', 'aktif'),
(5, 'azlannn222', '2025-02-02', '2025-02-03', 'azlannn222', 'azlannn222', '-0.8766833571195343', '100.6011199951172', '679fa16cc9782.jpg', 'aktif'),
(6, 'azlannn3333', '2025-02-13', '2025-02-21', 'azlannn3333', 'azlannn3333', '-0.8629520294660487', '100.6340789794922', '679fa1914d2c1.jpg', 'aktif'),
(10, 'Tes Event', '2025-02-04', '2025-02-08', 'Tes', 'Tes', '-0.803649298884359', '100.66034573227611', '67a1543df35e0.jpg', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id_fasilitas` int NOT NULL,
  `nama_fasilitas` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `detail` text NOT NULL,
  `banyak_pengunjung` varchar(255) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto_fasilitas1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `foto_fasilitas2` varchar(255) NOT NULL,
  `foto_fasilitas3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id_fasilitas`, `nama_fasilitas`, `harga`, `alamat`, `detail`, `banyak_pengunjung`, `latitude`, `longitude`, `foto_fasilitas1`, `foto_fasilitas2`, `foto_fasilitas3`) VALUES
(11, 'Coba', '123', 'asd', 'asd', '123', '-0.9725437415987982', '100.62327942437874', 'fasilitas_20250222112055_67b9b317d52b7_1.png', 'fasilitas_20250222112055_67b9b317d5c10_2.png', 'fasilitas_20250222112055_67b9b317d5f54_3.png');

-- --------------------------------------------------------

--
-- Table structure for table `wisata`
--

CREATE TABLE `wisata` (
  `id_wisata` int NOT NULL,
  `nama_wisata` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `deskripsi` text NOT NULL,
  `harga_tiket` varchar(255) NOT NULL,
  `banyak_pengunjung` varchar(255) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto_wisata` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wisata`
--

INSERT INTO `wisata` (`id_wisata`, `nama_wisata`, `alamat`, `deskripsi`, `harga_tiket`, `banyak_pengunjung`, `latitude`, `longitude`, `foto_wisata`) VALUES
(63, 'kebun teh', 'antah berantah', 'tes', '123', '123', '-1.04008207', '100.66861800', '20250218151055_67b4a2ffe92b0.png'),
(64, 'danau kembar edit', 'tes', 'tes', '123', '123', '-1.0136424195824', '100.70369150791', '20250218_151917_67b4a4f577c36.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`),
  ADD KEY `fk_berita_admin` (`id_admin`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id_fasilitas`);

--
-- Indexes for table `wisata`
--
ALTER TABLE `wisata`
  ADD PRIMARY KEY (`id_wisata`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id_fasilitas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `wisata`
--
ALTER TABLE `wisata`
  MODIFY `id_wisata` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `fk_berita_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
