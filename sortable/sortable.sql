-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2012 at 06:51 PM
-- Server version: 5.1.40
-- PHP Version: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sortable`
--

-- --------------------------------------------------------

--
-- Table structure for table `sortable`
--

CREATE TABLE IF NOT EXISTS `sortable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listorder` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `sortable`
--

INSERT INTO `sortable` (`id`, `listorder`) VALUES
(1, 'a:7:{i:0;s:12:"Лондон";i:1;s:10:"Париж";i:2;s:15:"Нью-Йорк";i:3;s:10:"Милан";i:4;s:10:"Токио";i:5;s:16:"Мельбурн";i:6;s:6:"Рим";}');
