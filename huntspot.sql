-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 05:24 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `huntspot`

-- Table structure for table `employer`
CREATE TABLE IF NOT EXISTS `employer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table structure for table `jobsapplied`
CREATE TABLE IF NOT EXISTS `jobsapplied` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `pid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `status` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobapplied_seekerFK` (`sid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Table structure for table `logpost`
CREATE TABLE IF NOT EXISTS `logpost` (
  `lpid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `eid` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `category` varchar(500) NOT NULL,
  `industry` varchar(500) NOT NULL,
  `role` varchar(100) NOT NULL,
  `employmentType` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `action` varchar(500) NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`lpid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `post`
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `eid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category` varchar(500) NOT NULL,
  `minexp` varchar(100) NOT NULL,
  `desc` varchar(5000) NOT NULL,
  `salary` varchar(200) NOT NULL,
  `industry` varchar(500) NOT NULL,
  `role` varchar(500) NOT NULL,
  `employmentType` varchar(500) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employer_postFK` (`eid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Triggers for `post`
DELIMITER $$
CREATE TRIGGER `Existing_Row_Deleted` AFTER DELETE ON `post` FOR EACH ROW 
INSERT INTO logpost VALUES(NULL, OLD.id, OLD.eid, OLD.name, OLD.category, OLD.industry, OLD.role, OLD.employmentType, OLD.status, 'DELETED', NOW());
$$
DELIMITER $$
CREATE TRIGGER `Existing_Row_Updated` AFTER UPDATE ON `post` FOR EACH ROW 
INSERT INTO logpost VALUES(NULL, NEW.id, NEW.eid, NEW.name, NEW.category, NEW.industry, NEW.role, NEW.employmentType, NEW.status, 'UPDATED', NOW());
$$
DELIMITER $$
CREATE TRIGGER `New_Row_Inserted` AFTER INSERT ON `post` FOR EACH ROW 
INSERT INTO logpost VALUES(NULL, NEW.id, NEW.eid, NEW.name, NEW.category, NEW.industry, NEW.role, NEW.employmentType, NEW.status, 'INSERTED', NOW());
$$
DELIMITER ;

-- Table structure for table `seeker`
CREATE TABLE IF NOT EXISTS `seeker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `qualification` varchar(500) NOT NULL,
  `dob` date NOT NULL,
  `skills` varchar(2000) NOT NULL,
  `resume` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- AUTO_INCREMENT for dumped tables
ALTER TABLE `employer` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
ALTER TABLE `jobsapplied` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
ALTER TABLE `logpost` MODIFY `lpid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
ALTER TABLE `post` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
ALTER TABLE `seeker` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;