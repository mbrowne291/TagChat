-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 09, 2011 at 09:54 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tagchat_db`
--
CREATE DATABASE `tagchat_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tagchat_db`;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roomID` int(10) unsigned NOT NULL,
  `content` varchar(256) NOT NULL,
  `timeCreated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roomID` (`roomID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topicTagID` int(10) unsigned NOT NULL,
  `urlKey` varchar(8) NOT NULL,
  `lastTopicTime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roomID` int(10) unsigned NOT NULL,
  `content` varchar(48) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roomID` (`roomID`,`content`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `taguserlinks`
--

CREATE TABLE IF NOT EXISTS `taguserlinks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagID` int(10) unsigned NOT NULL,
  `userID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagID` (`tagID`,`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roomID` int(10) unsigned NOT NULL,
  `identifier` int(11) DEFAULT NULL,
  `lastActivityTime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roomID` (`roomID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
