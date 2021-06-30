-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2021 at 04:25 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dnevnik`
--

-- --------------------------------------------------------

--
-- Table structure for table `dnevnik`
--

CREATE TABLE `dnevnik` (
  `id` int(11) NOT NULL,
  `imeDnevnika` varchar(45) DEFAULT NULL,
  `idUporabnika` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dnevnik`
--

INSERT INTO `dnevnik` (`id`, `imeDnevnika`, `idUporabnika`) VALUES
(2, 'asd', 9),
(8, 'uporabnik', 13);

-- --------------------------------------------------------

--
-- Table structure for table `ocena`
--

CREATE TABLE `ocena` (
  `id` int(11) NOT NULL,
  `idUporabnika` int(11) NOT NULL,
  `idZapisa` int(11) NOT NULL,
  `ocena` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ocena`
--

INSERT INTO `ocena` (`id`, `idUporabnika`, `idZapisa`, `ocena`) VALUES
(12, 9, 12, 1),
(13, 9, 11, 1),
(14, 9, 19, 1),
(15, 9, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `priljubljen`
--

CREATE TABLE `priljubljen` (
  `id` int(11) NOT NULL,
  `idZapisa` int(11) NOT NULL,
  `idUporabnika` int(11) NOT NULL,
  `stanje` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `priljubljen`
--

INSERT INTO `priljubljen` (`id`, `idZapisa`, `idUporabnika`, `stanje`) VALUES
(10, 12, 13, 0),
(11, 19, 9, 0),
(12, 19, 13, 0),
(13, 13, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `uporabniki`
--

CREATE TABLE `uporabniki` (
  `id` int(11) NOT NULL,
  `up_ime` varchar(45) NOT NULL,
  `ime` varchar(45) DEFAULT NULL,
  `priimek` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `geslo` varchar(255) NOT NULL,
  `dostop` tinyint(1) DEFAULT NULL,
  `vkey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uporabniki`
--

INSERT INTO `uporabniki` (`id`, `up_ime`, `ime`, `priimek`, `email`, `geslo`, `dostop`, `vkey`) VALUES
(9, 'rokrak', 'rok3', 'rak', 'rok.rak1@gmail.com', '$2y$10$9JLv/mEMgTyvr0J6FFoj1OjcjR7vqxRt8gsQV3uNdm/XrITDgUy1W', 1, 'c6e853087721af36927c28538c635597'),
(13, 'uporabnik2', 'rok', 'rak', 'rok@test.com', '$2y$10$x/pN3FqlgprL8qSDYD41f.ADGAorcwttHlcp56ALbs5gfg6GLknqu', 1, '6ffecb4bbfd39af3e41609e97b617dd4');

-- --------------------------------------------------------

--
-- Table structure for table `zapis`
--

CREATE TABLE `zapis` (
  `id` int(11) NOT NULL,
  `imeZapisa` varchar(45) DEFAULT NULL,
  `datum` datetime DEFAULT NULL,
  `besedilo` text DEFAULT NULL,
  `idDnevnika` int(11) NOT NULL,
  `vidno` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zapis`
--

INSERT INTO `zapis` (`id`, `imeZapisa`, `datum`, `besedilo`, `idDnevnika`, `vidno`) VALUES
(11, 'Moj prvi zapis', '2021-05-04 00:00:00', 'Neka čudna zgodba', 8, 1),
(12, 'asd', '2021-05-04 00:00:00', 'asd', 8, 1),
(13, 'asdasd', '2021-05-04 00:00:00', 'asdasds', 8, 1),
(14, 'sdasdasdas', '2021-05-04 00:00:00', 'dasdasdasdasdasd', 8, 0),
(19, 'asdasd', '2021-05-05 00:00:00', 'asdasd', 2, 1),
(20, 'zapis1', '2021-05-05 00:00:00', 'zapis', 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dnevnik`
--
ALTER TABLE `dnevnik`
  ADD PRIMARY KEY (`id`,`idUporabnika`),
  ADD KEY `fk_dnevnik_uporabniki1` (`idUporabnika`);

--
-- Indexes for table `ocena`
--
ALTER TABLE `ocena`
  ADD PRIMARY KEY (`id`,`idUporabnika`,`idZapisa`),
  ADD KEY `fk_ocena_uporabniki1` (`idUporabnika`),
  ADD KEY `fk_ocena_zapis1` (`idZapisa`);

--
-- Indexes for table `priljubljen`
--
ALTER TABLE `priljubljen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `priljubljen_ibfk_1` (`idZapisa`),
  ADD KEY `priljubljen_ibfk_2` (`idUporabnika`);

--
-- Indexes for table `uporabniki`
--
ALTER TABLE `uporabniki`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zapis`
--
ALTER TABLE `zapis`
  ADD PRIMARY KEY (`id`,`idDnevnika`),
  ADD KEY `fk_zapis_dnevnik1` (`idDnevnika`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dnevnik`
--
ALTER TABLE `dnevnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ocena`
--
ALTER TABLE `ocena`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `priljubljen`
--
ALTER TABLE `priljubljen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `uporabniki`
--
ALTER TABLE `uporabniki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `zapis`
--
ALTER TABLE `zapis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dnevnik`
--
ALTER TABLE `dnevnik`
  ADD CONSTRAINT `fk_dnevnik_uporabniki1` FOREIGN KEY (`idUporabnika`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `ocena`
--
ALTER TABLE `ocena`
  ADD CONSTRAINT `fk_ocena_uporabniki1` FOREIGN KEY (`idUporabnika`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ocena_zapis1` FOREIGN KEY (`idZapisa`) REFERENCES `zapis` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `priljubljen`
--
ALTER TABLE `priljubljen`
  ADD CONSTRAINT `priljubljen_ibfk_1` FOREIGN KEY (`idZapisa`) REFERENCES `zapis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `priljubljen_ibfk_2` FOREIGN KEY (`idUporabnika`) REFERENCES `uporabniki` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `zapis`
--
ALTER TABLE `zapis`
  ADD CONSTRAINT `fk_zapis_dnevnik1` FOREIGN KEY (`idDnevnika`) REFERENCES `dnevnik` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
