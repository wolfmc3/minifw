-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: Apr 30, 2013 alle 12:21
-- Versione del server: 5.5.30-log
-- Versione PHP: 5.4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `minifwsite`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `name` varchar(50) NOT NULL,
  `title` varchar(120) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `contents`
--

INSERT INTO `contents` (`name`, `title`, `content`) VALUES
('image1', 'Prova con immagine', '<p><img src="/mini_fw/img/user/animal.jpg/sepia/height/250/box/250/190" alt="" /></p>'),
('test1', 'Titolo di prova', '<p>Questo &egrave; il corpo del messaggio, quello che state leggendo &egrave; un testo HTML di prova.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n<p>Lista numerata:</p>\r\n<ol>\r\n<li>primo</li>\r\n<li>secondo</li>\r\n<li>terzo</li>\r\n<li>quarto</li>\r\n<li>quinto&nbsp;</li>\r\n</ol>');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
