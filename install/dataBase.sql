-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2015 at 01:03 
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `BlueStats`
--

-- --------------------------------------------------------

--
-- Table structure for table `BlueStats_config`
--

CREATE TABLE IF NOT EXISTS `BlueStats_config` (
`row_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `option` varchar(64) NOT NULL,
  `plugin` varchar(64) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `BlueStats_players`
--

CREATE TABLE IF NOT EXISTS `BlueStats_players` (
`row_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `uuid` varchar(128) NOT NULL,
  `name` varchar(128) NOT NULL,
  `plugin` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `BlueStats_server`
--

CREATE TABLE IF NOT EXISTS `BlueStats_server` (
`row_id` int(11) NOT NULL,
  `server_id` int(11) NOT NULL,
  `option` varchar(64) NOT NULL,
  `value` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BlueStats_config`
--
ALTER TABLE `BlueStats_config`
 ADD PRIMARY KEY (`row_id`);

--
-- Indexes for table `BlueStats_players`
--
ALTER TABLE `BlueStats_players`
 ADD PRIMARY KEY (`row_id`);

--
-- Indexes for table `BlueStats_server`
--
ALTER TABLE `BlueStats_server`
 ADD PRIMARY KEY (`row_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `BlueStats_config`
--
ALTER TABLE `BlueStats_config`
MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `BlueStats_players`
--
ALTER TABLE `BlueStats_players`
MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `BlueStats_server`
--
ALTER TABLE `BlueStats_server`
MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
