-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 10:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frjsweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `bg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `bg`) VALUES
(1, 'Basket', 'wETDin0OkmmOVG5kqtwG.jpg'),
(2, 'Sepak Bola', 'QuIAryggKHWX8ubLCXV7.jpg'),
(3, 'Tennis', 'lVjTTFQInoEqm9YOKIZl.jpg'),
(4, 'Voli', 'NLevXJwfbwUh68trPRgM.jpg'),
(6, 'Roblox', 'wL8E0D0gL4oWFbMShtSB.jpg'),
(8, 'Badminton', 'L9CMuYEza4fECr6ClYzG.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `ukuran_id` int(11) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto1` varchar(255) DEFAULT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL,
  `foto4` varchar(255) DEFAULT NULL,
  `foto5` varchar(255) DEFAULT NULL,
  `foto6` varchar(255) DEFAULT NULL,
  `foto7` varchar(255) DEFAULT NULL,
  `foto8` varchar(255) DEFAULT NULL,
  `foto9` varchar(255) DEFAULT NULL,
  `foto10` varchar(255) DEFAULT NULL,
  `foto11` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `ketersediaan_stok` enum('pre-order','ready stock') DEFAULT 'pre-order'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `kategori_id`, `ukuran_id`, `nama`, `harga`, `foto`, `foto1`, `foto2`, `foto3`, `foto4`, `foto5`, `foto6`, `foto7`, `foto8`, `foto9`, `foto10`, `foto11`, `detail`, `ketersediaan_stok`) VALUES
(23, 4, 2, 'SB1AB', 324234, 'lExrWZ9ZhqiWB8uVq9Vp.jpg', 'Rkfd2UDDCskNYJ8EhToX.jpg', '4VGByxXDZA2yDuJqDSwW.jpg', 'jK4g7xz8jgyg2HwQSnag.png', 'yiYUm4m8fiWLlF18g4H9.jpg', 'TacgXBK28kJbWGIPKdYM.jpg', 'x07uN2HdMK2dC2izxKdf.jpg', '0CWfSZwqcXsGwWPnElaP.png', 'IdOe3PvsGFMFkk3k78av.png', 'vVTr9zwFwpEvlFSNZRZ8.png', 'MaZPkuEVVYykWBAwJqEA.png', 'kBcRhOYMxntUFNu6ThmS.png', 'might be temporarily down or it may have moved permanently to a new web address', 'ready stock'),
(24, 2, 1, 'SB1B', 23131, 'Gy8KWG2QSZ.jpg', NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Test', 'pre-order'),
(25, 3, 1, 'SB2A', 34342, 'rZNd4b9lss.jpg', 'fkCRQtaHbw.jpg', 'rXsClShlha.jpg', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Long text adalah istilah dalam bahasa gaul berupa pesan panjang yang dikirimkan untuk mengekspresikan perasaan atau pikiran kepada seseorang. Pesan ini biasanya dikirim kepada teman, sahabat.', 'pre-order'),
(26, 1, 2, 'SB3A', 55435353, 'aSAQ36JjBh.jpg', NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Long text adalah istilah dalam bahasa gaul berupa pesan panjang yang dikirimkan untuk mengekspresikan perasaan atau pikiran kepada seseorang. Pesan ini biasanya dikirim kepada teman, sahabat', 'pre-order'),
(27, 1, 2, 'SB44', 123123, '2AJbmr2heZ.jpg', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.', 'pre-order'),
(28, 1, 2, 'SB3C', 2424224, 'pFnWBaNUil.jpg', '8p7LGPVsln.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one ', 'pre-order'),
(29, 1, 3, 'SB99', 324224234, '7boO2JYpGH.jpg', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'User friendly web app to convert photos and other images to PDF quickly and easily', 'ready stock'),
(30, 1, 5, 'SB22', 43242342, '2Dah9E5uO56prAj2OimC.jpg', 'VcyFglJ4awTDwsnMPqMh.jpg', 'BGsY5R1KxgXItCODhqaJ.jpg', 'vDiI0yCWhC.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'deskripsi belum ada', 'pre-order');

-- --------------------------------------------------------

--
-- Table structure for table `ukuran`
--

CREATE TABLE `ukuran` (
  `id` int(10) NOT NULL,
  `panjang` double NOT NULL,
  `lebar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ukuran`
--

INSERT INTO `ukuran` (`id`, `panjang`, `lebar`) VALUES
(1, 160, 200),
(2, 100, 50),
(3, 150, 70),
(4, 100, 500),
(5, 123, 456),
(6, 100, 400),
(7, 234, 456);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama` (`nama`),
  ADD KEY `kategori_produk` (`kategori_id`),
  ADD KEY `fk_produk_ukuran` (`ukuran_id`);

--
-- Indexes for table `ukuran`
--
ALTER TABLE `ukuran`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `ukuran`
--
ALTER TABLE `ukuran`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_produk_ukuran` FOREIGN KEY (`ukuran_id`) REFERENCES `ukuran` (`id`),
  ADD CONSTRAINT `kategori_produk` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
