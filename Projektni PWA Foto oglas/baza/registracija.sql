-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2024 at 03:44 PM
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
-- Database: `registracija`
--

-- --------------------------------------------------------

--
-- Table structure for table `home_ads`
--

CREATE TABLE `home_ads` (
  `id` int(11) NOT NULL,
  `naziv` varchar(255) NOT NULL,
  `opis` text NOT NULL,
  `cijena` int(32) NOT NULL,
  `slika` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_ads`
--

INSERT INTO `home_ads` (`id`, `naziv`, `opis`, `cijena`, `slika`) VALUES
(12, 'Velesajam', 'Fotografija djela zgrade sa velesajma', 123, 'slike/IMG_7246.JPG'),
(13, 'Zgrada', 'Zgrada u ulici Ede Murtica na bundeku. Ekstremni gornji.', 213, 'slike/IMG_7257.JPG'),
(14, 'Msu', 'Msu, pozicija rasvjete.', 321, 'slike/IMG_7259.JPG'),
(15, 'Jez', 'Ilustracija jeza na vanjskom djelu msu.', 122, 'slike/IMG_7266.JPG'),
(19, 'Nesto nesto', 'Nesto na platou msu.', 111, 'slike/IMG_7282.JPG'),
(20, 'Macka', 'Macka s kvarta.', 12, 'slike/IMG_7608.JPG'),
(21, 'Oko', 'Ilustracija oka na vanjskom zidu msu.', 221, 'slike/IMG_7268.JPG'),
(22, 'Precko', 'Precko,zgrada,novogradnja', 121, 'slike/IMG_7597.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(255) NOT NULL,
  `korisnik` varchar(32) NOT NULL,
  `lozinka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `korisnik`, `lozinka`) VALUES
(7, 'rok', '$2y$10$/8eM0CXWUYwq16w4GFyJ5uQElOP0Db8NSIblk5amHEF7ZOWuNvGDu'),
(8, 'rok', '$2y$10$HiMz9yQ7LNetXcZaRljlhOw4DA77Zf/u.DJPfV5DdaSFAyte1ai.i'),
(9, 'zdenko', '$2y$10$YieAEVC36m/cOFjqjw6IK.3FiWYDh7iX/OVMzT6xmNFkkAfMM0Huy'),
(10, 'zdenko', '$2y$10$wvOSUvacqoM05O7pvatI8eWPGHaC1bgbYabyB044c4a/vMqKQ59u6'),
(11, 'vladimir', '$2y$10$IoDdHe9azMset7jd.JuATeLk6NBa/.VdSuUKa69I4UxJAIQWYxxci'),
(12, 'rok123', '$2y$10$vf5U8diEKO6HXRv9TlvPBuxpPx.7Rk.HWbbI38JWRTrKJLvvd7NE6');

-- --------------------------------------------------------

--
-- Table structure for table `oglasi`
--

CREATE TABLE `oglasi` (
  `id` int(255) NOT NULL,
  `slika` varchar(255) NOT NULL,
  `naziv` varchar(32) NOT NULL,
  `opis` varchar(255) NOT NULL,
  `cijena` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oglasi`
--

INSERT INTO `oglasi` (`id`, `slika`, `naziv`, `opis`, `cijena`) VALUES
(12, 'slike/IMG_7246.JPG', 'Velesajam', 'Fotografija djela zgrade sa velesajma', 123),
(13, 'slike/IMG_7257.JPG', 'Zgrada', 'Zgrada u ulici Ede Murtica na bundeku. Ekstremni gornji.', 213),
(14, 'slike/IMG_7259.JPG', 'Msu', 'Msu, pozicija rasvjete.', 321),
(15, 'slike/IMG_7266.JPG', 'Jez', 'Ilustracija jeza na vanjskom djelu msu.', 122),
(17, 'slike/IMG_7269.JPG', 'Vjeverica', 'Ilustracija vjeverice na vanjskom dijelu msu.', 332),
(18, 'slike/IMG_7265.JPG', 'Ulaz', 'Slika ulaza u garazu/parking msu.', 222),
(19, 'slike/IMG_7282.JPG', 'Nesto nesto', 'Nesto na platou msu.', 111),
(20, 'slike/IMG_7608.JPG', 'Macka', 'Macka s kvarta.', 12),
(21, 'slike/IMG_7268.JPG', 'Oko', 'Ilustracija oka na vanjskom zidu msu.', 221),
(22, 'slike/IMG_7597.JPG', 'Precko', 'Precko,zgrada,novogradnja', 121);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `home_ads`
--
ALTER TABLE `home_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oglasi`
--
ALTER TABLE `oglasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `home_ads`
--
ALTER TABLE `home_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `oglasi`
--
ALTER TABLE `oglasi`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
