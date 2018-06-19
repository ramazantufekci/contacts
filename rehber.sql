-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Haz 2018, 09:48:50
-- Sunucu sürümü: 5.6.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `rehber`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `crehber`
--

CREATE TABLE IF NOT EXISTS `crehber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `soyad` varchar(70) COLLATE utf8_turkish_ci NOT NULL,
  `tel_no` varchar(12) COLLATE utf8_turkish_ci NOT NULL,
  `tel_kisa` varchar(12) COLLATE utf8_turkish_ci NOT NULL,
  `da_kisa` varchar(12) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=50 ;


--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE IF NOT EXISTS `kullanici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adSoyad` varchar(70) COLLATE utf8_turkish_ci NOT NULL,
  `kAd` varchar(70) COLLATE utf8_turkish_ci NOT NULL,
  `kSifre` varchar(38) COLLATE utf8_turkish_ci NOT NULL,
  `kMail` varchar(128) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

INSERT INTO `kullanici` (`id`, `adSoyad`, `kAd`, `kSifre`, `kMail`) VALUES
(1, 'Root', 'root', 'e10adc3949ba59abbe56e057f20f883e', 'root@example.com');
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
