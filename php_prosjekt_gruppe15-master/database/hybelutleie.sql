-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11. Nov, 2022 16:57 PM
-- Tjener-versjon: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hybelutleie`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `annonse`
--

CREATE TABLE `annonse` (
  `annonse_id` int(255) NOT NULL,
  `bolig_id` int(255) NOT NULL,
  `månedsleie` int(255) NOT NULL,
  `depositum` int(255) DEFAULT NULL,
  `leieperiode` varchar(100) DEFAULT NULL,
  `ledig_fra` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `bolig`
--

CREATE TABLE `bolig` (
  `bolig_id` int(255) NOT NULL,
  `boligtype_id` int(255) NOT NULL,
  `bolig_eier` int(255) NOT NULL,
  `boligbilde_id` int(255) DEFAULT NULL,
  `funksjon_id` int(255) NOT NULL,
  `areal` int(255) NOT NULL,
  `antall_rom` int(255) NOT NULL,
  `ledige_rom` int(255) DEFAULT NULL,
  `bolig_beskrivelse` text NOT NULL,
  `antall_bad` int(255) NOT NULL,
  `antall_balkonger` int(255) DEFAULT NULL,
  `antall_soverom` int(255) NOT NULL,
  `er_møblert` tinyint(1) NOT NULL,
  `har_hvitevarer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `boligtype`
--

CREATE TABLE `boligtype` (
  `boligtype_id` int(255) NOT NULL,
  `boligtype` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `boligtype`
--

INSERT INTO `boligtype` (`boligtype_id`, `boligtype`) VALUES
(1, 'Hybel'),
(2, 'Jentekollektiv'),
(3, 'Guttekollektiv'),
(4, 'Kollektiv'),
(5, 'Leilighet');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `bolig_bilder`
--

CREATE TABLE `bolig_bilder` (
  `boligbilde_id` int(255) NOT NULL,
  `bolig_id` int(255) NOT NULL,
  `bilde` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `bolig_funksjoner`
--

CREATE TABLE `bolig_funksjoner` (
  `funksjon_id` int(255) NOT NULL,
  `dyr_tillat` tinyint(1) NOT NULL,
  `røyk_tillat` tinyint(1) NOT NULL,
  `har_vaskemaskin` tinyint(1) NOT NULL,
  `har_hage` tinyint(1) NOT NULL,
  `har_varmekabler` tinyint(1) NOT NULL,
  `antall_parkeringsplasser` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `bruker`
--

CREATE TABLE `bruker` (
  `bruker_id` int(255) NOT NULL,
  `fornavn` varchar(255) NOT NULL,
  `etternavn` varchar(255) NOT NULL,
  `epost` varchar(255) NOT NULL,
  `telefon` varchar(8) DEFAULT NULL,
  `passord` varchar(255) NOT NULL,
  `utleier` tinyint(1) NOT NULL,
  `kjonn` tinyint(1) NOT NULL,
  `profilbilde` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dataark for tabell `bruker`
--

INSERT INTO `bruker` (`bruker_id`, `fornavn`, `etternavn`, `epost`, `telefon`, `passord`, `utleier`, `kjonn`, `profilbilde`) VALUES
(29, 'Henning', 'Sletner', 'Henning@uia.no', '46897309', '$2y$10$79HpDuVlCOK82SlsrDb4W.V8nRFbqv07CW6wiQxyF4AQhFwl.PCzi', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `leie_avtale`
--

CREATE TABLE `leie_avtale` (
  `leie_id` int(255) NOT NULL,
  `annonse_id` int(255) NOT NULL,
  `leietaker` int(255) NOT NULL,
  `leiedato_fra` datetime NOT NULL,
  `leiedato_til` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annonse`
--
ALTER TABLE `annonse`
  ADD PRIMARY KEY (`annonse_id`),
  ADD KEY `FK_bolig_id2` (`bolig_id`);

--
-- Indexes for table `bolig`
--
ALTER TABLE `bolig`
  ADD PRIMARY KEY (`bolig_id`),
  ADD KEY `FK_boligtype_id` (`boligtype_id`),
  ADD KEY `FK_bolig_eier` (`bolig_eier`),
  ADD KEY `FK_boligbilde_id` (`boligbilde_id`),
  ADD KEY `FK_funksjon_id` (`funksjon_id`);

--
-- Indexes for table `boligtype`
--
ALTER TABLE `boligtype`
  ADD PRIMARY KEY (`boligtype_id`);

--
-- Indexes for table `bolig_bilder`
--
ALTER TABLE `bolig_bilder`
  ADD PRIMARY KEY (`boligbilde_id`),
  ADD KEY `FK_bolig_id` (`bolig_id`);

--
-- Indexes for table `bolig_funksjoner`
--
ALTER TABLE `bolig_funksjoner`
  ADD PRIMARY KEY (`funksjon_id`);

--
-- Indexes for table `bruker`
--
ALTER TABLE `bruker`
  ADD PRIMARY KEY (`bruker_id`);

--
-- Indexes for table `leie_avtale`
--
ALTER TABLE `leie_avtale`
  ADD PRIMARY KEY (`leie_id`),
  ADD KEY `FK_annonse_id` (`annonse_id`),
  ADD KEY `FK_leietaker` (`leietaker`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annonse`
--
ALTER TABLE `annonse`
  MODIFY `annonse_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bolig`
--
ALTER TABLE `bolig`
  MODIFY `bolig_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `boligtype`
--
ALTER TABLE `boligtype`
  MODIFY `boligtype_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bolig_bilder`
--
ALTER TABLE `bolig_bilder`
  MODIFY `boligbilde_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bolig_funksjoner`
--
ALTER TABLE `bolig_funksjoner`
  MODIFY `funksjon_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bruker`
--
ALTER TABLE `bruker`
  MODIFY `bruker_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `leie_avtale`
--
ALTER TABLE `leie_avtale`
  MODIFY `leie_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- Begrensninger for dumpede tabeller
--

--
-- Begrensninger for tabell `annonse`
--
ALTER TABLE `annonse`
  ADD CONSTRAINT `FK_bolig_id2` FOREIGN KEY (`bolig_id`) REFERENCES `bolig` (`bolig_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `bolig`
--
ALTER TABLE `bolig`
  ADD CONSTRAINT `FK_bolig_eier` FOREIGN KEY (`bolig_eier`) REFERENCES `bruker` (`bruker_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_boligbilde_id` FOREIGN KEY (`boligbilde_id`) REFERENCES `bolig_bilder` (`boligbilde_id`),
  ADD CONSTRAINT `FK_boligtype_id` FOREIGN KEY (`boligtype_id`) REFERENCES `boligtype` (`boligtype_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_funksjon_id` FOREIGN KEY (`funksjon_id`) REFERENCES `bolig_funksjoner` (`funksjon_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `bolig_bilder`
--
ALTER TABLE `bolig_bilder`
  ADD CONSTRAINT `FK_bolig_id` FOREIGN KEY (`bolig_id`) REFERENCES `bolig` (`bolig_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrensninger for tabell `leie_avtale`
--
ALTER TABLE `leie_avtale`
  ADD CONSTRAINT `FK_annonse_id` FOREIGN KEY (`annonse_id`) REFERENCES `annonse` (`annonse_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_leietaker` FOREIGN KEY (`leietaker`) REFERENCES `bruker` (`bruker_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
