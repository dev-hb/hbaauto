-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2020 at 07:07 PM
-- Server version: 10.3.23-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devcrawl_hbaauto`
--

-- --------------------------------------------------------

--
-- Table structure for table `detfacture`
--

CREATE TABLE `detfacture` (
  `id_det` int(11) NOT NULL,
  `ref_det` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation_det` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `qtt_det` float NOT NULL,
  `prix_det` float NOT NULL,
  `tva_det` float NOT NULL,
  `rem_det` float NOT NULL,
  `id_fact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detfacture`
--

INSERT INTO `detfacture` (`id_det`, `ref_det`, `designation_det`, `qtt_det`, `prix_det`, `tva_det`, `rem_det`, `id_fact`) VALUES
(14, '01', 'chamgement kit distribution', 1, 175, 20, 0, 9),
(15, '02', 'changement cache culbuteur', 1, 200, 20, 0, 9),
(16, '03', 'recharge additif', 1, 30, 20, 0, 9),
(17, '03', 'vidange et changement des filtres', 1, 55, 20, 0, 9),
(18, '01', 'remplacement kit distribution et pompe a eau', 1, 350, 20, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `facture`
--

CREATE TABLE `facture` (
  `id_fact` int(11) NOT NULL,
  `ref_fact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_fact` date NOT NULL,
  `devise_fact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mode_fact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_fact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_fact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_fact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_fact` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `km_fact` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facture`
--

INSERT INTO `facture` (`id_fact`, `ref_fact`, `date_fact`, `devise_fact`, `mode_fact`, `nom_fact`, `company_fact`, `address_fact`, `car_fact`, `km_fact`) VALUES
(9, '1', '2020-02-10', 'Euro', 'especes', 'berjane  fatima', '', 'rue albert camus   46000 cahors', 'peugeot307', 267122),
(10, '01', '2020-02-03', 'Euro', 'especes', 'assali jaouad', 'assali jaouad', 'le clos dablanc 24 B 14 rue des tulipiers  46090 pradines', 'audi a4', 209483);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detfacture`
--
ALTER TABLE `detfacture`
  ADD PRIMARY KEY (`id_det`),
  ADD KEY `id_fact` (`id_fact`);

--
-- Indexes for table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id_fact`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detfacture`
--
ALTER TABLE `detfacture`
  MODIFY `id_det` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `facture`
--
ALTER TABLE `facture`
  MODIFY `id_fact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detfacture`
--
ALTER TABLE `detfacture`
  ADD CONSTRAINT `detfacture_ibfk_1` FOREIGN KEY (`id_fact`) REFERENCES `facture` (`id_fact`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
