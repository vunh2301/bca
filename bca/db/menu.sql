-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 09, 2016 at 09:38 AM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `database`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(110) CHARACTER SET latin1 DEFAULT NULL,
  `alias` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `controller` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `action` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `params` text CHARACTER SET latin1,
  `root` int(10) DEFAULT NULL,
  `level` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rgt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `alias`, `controller`, `action`, `params`, `root`, `level`, `lft`, `rgt`) VALUES
(5, 'Home', 'home', 'index', 'index', NULL, 0, 1, 1, 8),
(6, 'admin', 'admin', 'index', 'admin', NULL, NULL, 2, 2, 7),
(7, 'Main', 'main', 'index', 'main', NULL, NULL, 3, 3, 6),
(8, 'cms', 'cms', 'index', 'cms', NULL, NULL, 4, 4, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
