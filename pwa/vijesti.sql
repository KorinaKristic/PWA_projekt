-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Računalo: localhost
-- Vrijeme generiranja: Lip 13, 2024 u 11:18 PM
-- Verzija poslužitelja: 5.1.41
-- PHP verzija: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza podataka: `vijesti`
--

-- --------------------------------------------------------

--
-- Tablična struktura za tablicu `vijesti`
--

CREATE TABLE IF NOT EXISTS `vijesti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naslov` varchar(255) NOT NULL,
  `kratki_sadrzaj` varchar(255) DEFAULT NULL,
  `sadrzaj` text,
  `kategorija` varchar(50) DEFAULT NULL,
  `slika` varchar(255) DEFAULT NULL,
  `arhivirano` tinyint(1) DEFAULT '0',
  `autor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Izbacivanje podataka za tablicu `vijesti`
--

INSERT INTO `vijesti` (`id`, `naslov`, `kratki_sadrzaj`, `sadrzaj`, `kategorija`, `slika`, `arhivirano`, `autor_id`) VALUES
(12, 'Strojno ucenje', 'Clanak o strojnom ucenju', 'Strojno ucenje grana je umjetne inteligencije koja se bave oblikovanjem algoritama koji svoju ucinkovitost poboljsavaju na temelju empirijskih podataka. Strojno ucenje jedno je od danas najaktivnijih i najuzbudljivijih podrucja racunarske znanosti, ponajvise zbog brojnih mogucnosti primjene koje se protezu od raspoznavanja uzoraka i dubinske analize podataka do robotike, racunalnog vida, bioinformatike i racunalne lingvistike. Ovaj se kolegij bavi teorijom i nacelima strojnog ucenja te daje pregled njegovih primjena. Kolegij obuhvaca dva osnovna pristupa strojnom ucenju: nadzirano ucenje (klasifikacija i regresija) i nenadzirano ucenje (grupiranje i smanjenje dimenzionalnosti).', 'Tehnologija', 'uploads/strojno-ucenje.jpg', 0, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
