-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 17, 2023 at 01:04 AM
-- Server version: 5.7.39-42-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db3dpzjdij5qds`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbdates`
--

CREATE TABLE `dbdates` (
  `id` char(20) NOT NULL,
  `shifts` text,
  `mgr_notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbdates`
--

INSERT INTO `dbdates` (`id`, `shifts`, `mgr_notes`) VALUES
('22-10-24:bangor', '22-10-24:9-12:bangor*22-10-24:12-3:bangor*22-10-24:3-6:bangor*22-10-24:6-9:bangor', ''),
('22-10-25:bangor', '22-10-25:9-12:bangor*22-10-25:12-3:bangor*22-10-25:3-6:bangor*22-10-25:6-9:bangor', ''),
('22-10-26:bangor', '22-10-26:9-12:bangor*22-10-26:12-3:bangor*22-10-26:3-6:bangor*22-10-26:6-9:bangor', ''),
('22-10-27:bangor', '22-10-27:9-12:bangor*22-10-27:12-3:bangor*22-10-27:3-6:bangor*22-10-27:6-9:bangor', ''),
('22-10-28:bangor', '22-10-28:9-12:bangor*22-10-28:12-3:bangor*22-10-28:3-6:bangor*22-10-28:night:bangor', ''),
('22-10-29:bangor', '22-10-29:night:bangor*22-10-29:9-5:bangor', ''),
('22-10-30:bangor', '22-10-30:9-5:bangor*22-10-30:5-9:bangor', ''),
('22-10-31:bangor', '22-10-31:9-12:bangor*22-10-31:12-3:bangor*22-10-31:3-6:bangor*22-10-31:6-9:bangor', ''),
('22-11-01:bangor', '22-11-01:9-12:bangor*22-11-01:12-3:bangor*22-11-01:3-6:bangor*22-11-01:6-9:bangor', ''),
('22-11-02:bangor', '22-11-02:9-12:bangor*22-11-02:12-3:bangor*22-11-02:3-6:bangor*22-11-02:6-9:bangor', ''),
('22-11-03:bangor', '22-11-03:9-12:bangor*22-11-03:3-6:bangor*22-11-03:12-3:bangor*22-11-03:6-9:bangor', ''),
('22-11-04:bangor', '22-11-04:9-12:bangor*22-11-04:12-3:bangor*22-11-04:3-6:bangor*22-11-04:night:bangor', ''),
('22-11-05:bangor', '22-11-05:night:bangor*22-11-05:9-5:bangor', ''),
('22-11-06:bangor', '22-11-06:5-9:bangor*22-11-06:9-5:bangor', ''),
('22-11-07:bangor', '22-11-07:9-12:bangor*22-11-07:12-3:bangor*22-11-07:3-6:bangor*22-11-07:6-9:bangor', ''),
('22-11-08:bangor', '22-11-08:9-12:bangor*22-11-08:12-3:bangor*22-11-08:3-6:bangor*22-11-08:6-9:bangor', ''),
('22-11-09:bangor', '22-11-09:9-12:bangor*22-11-09:12-3:bangor*22-11-09:3-6:bangor*22-11-09:6-9:bangor', ''),
('22-11-10:bangor', '22-11-10:9-12:bangor*22-11-10:12-3:bangor*22-11-10:3-6:bangor*22-11-10:6-9:bangor', ''),
('22-11-11:bangor', '22-11-11:9-12:bangor*22-11-11:12-3:bangor*22-11-11:3-6:bangor*22-11-11:night:bangor', ''),
('22-11-12:bangor', '22-11-12:night:bangor*22-11-12:9-5:bangor', ''),
('22-11-13:bangor', '22-11-13:9-5:bangor*22-11-13:5-9:bangor', ''),
('22-11-14:bangor', '22-11-14:9-12:bangor*22-11-14:12-3:bangor*22-11-14:3-6:bangor*22-11-14:6-9:bangor', ''),
('22-11-15:bangor', '22-11-15:9-12:bangor*22-11-15:12-3:bangor*22-11-15:3-6:bangor*22-11-15:6-9:bangor', ''),
('22-11-16:bangor', '22-11-16:9-12:bangor*22-11-16:12-3:bangor*22-11-16:3-6:bangor*22-11-16:6-9:bangor', ''),
('22-11-17:bangor', '22-11-17:9-12:bangor*22-11-17:3-6:bangor*22-11-17:12-3:bangor*22-11-17:6-9:bangor', ''),
('22-11-18:bangor', '22-11-18:9-12:bangor*22-11-18:12-3:bangor*22-11-18:3-6:bangor*22-11-18:night:bangor', ''),
('22-11-19:bangor', '22-11-19:night:bangor*22-11-19:9-5:bangor', ''),
('22-11-20:bangor', '22-11-20:9-5:bangor*22-11-20:5-9:bangor', ''),
('22-11-21:bangor', '22-11-21:9-12:bangor*22-11-21:12-3:bangor*22-11-21:3-6:bangor*22-11-21:6-9:bangor', ''),
('22-11-22:bangor', '22-11-22:9-12:bangor*22-11-22:12-3:bangor*22-11-22:3-6:bangor*22-11-22:6-9:bangor', ''),
('22-11-23:bangor', '22-11-23:9-12:bangor*22-11-23:12-3:bangor*22-11-23:3-6:bangor*22-11-23:6-9:bangor', ''),
('22-11-24:bangor', '22-11-24:9-12:bangor*22-11-24:12-3:bangor*22-11-24:3-6:bangor*22-11-24:6-9:bangor', ''),
('22-11-25:bangor', '22-11-25:9-12:bangor*22-11-25:12-3:bangor*22-11-25:3-6:bangor*22-11-25:night:bangor', ''),
('22-11-26:bangor', '22-11-26:night:bangor*22-11-26:9-5:bangor', ''),
('22-11-27:bangor', '22-11-27:9-5:bangor*22-11-27:5-9:bangor', ''),
('23-01-30:portland', '23-01-30:9-12:portland*23-01-30:3-6:portland*23-01-30:6-9:portland*23-01-30:12-3:portland', ''),
('23-01-31:portland', '23-01-31:9-12:portland*23-01-31:12-3:portland*23-01-31:3-6:portland*23-01-31:6-9:portland', ''),
('23-02-01:portland', '23-02-01:9-12:portland*23-02-01:12-3:portland*23-02-01:3-6:portland*23-02-01:6-9:portland', ''),
('23-02-02:portland', '23-02-02:9-12:portland*23-02-02:12-3:portland*23-02-02:3-6:portland*23-02-02:6-9:portland', ''),
('23-02-03:portland', '23-02-03:9-12:portland*23-02-03:3-6:portland*23-02-03:6-9:portland*23-02-03:night:portland*23-02-03:12-3:portland', ''),
('23-02-04:portland', '23-02-04:10-1:portland*23-02-04:1-4:portland*23-02-04:night:portland', ''),
('23-02-05:portland', '23-02-05:9-12:portland*23-02-05:2-5:portland*23-02-05:5-9:portland', ''),
('23-02-06:portland', '23-02-06:9-12:portland*23-02-06:3-6:portland*23-02-06:6-9:portland*23-02-06:12-3:portland', ''),
('23-02-07:portland', '23-02-07:9-12:portland*23-02-07:12-3:portland*23-02-07:3-6:portland*23-02-07:6-9:portland', ''),
('23-02-08:portland', '23-02-08:9-12:portland*23-02-08:12-3:portland*23-02-08:3-6:portland*23-02-08:6-9:portland', ''),
('23-02-09:portland', '23-02-09:9-12:portland*23-02-09:12-3:portland*23-02-09:3-6:portland*23-02-09:6-9:portland', ''),
('23-02-10:portland', '23-02-10:9-12:portland*23-02-10:12-3:portland*23-02-10:3-6:portland*23-02-10:6-9:portland*23-02-10:night:portland', ''),
('23-02-11:portland', '23-02-11:10-1:portland*23-02-11:1-4:portland*23-02-11:night:portland', ''),
('23-02-12:portland', '23-02-12:9-12:portland*23-02-12:2-5:portland*23-02-12:5-9:portland', ''),
('23-02-13:portland', '23-02-13:9-12:portland*23-02-13:3-6:portland*23-02-13:6-9:portland*23-02-13:12-3:portland', ''),
('23-02-14:portland', '23-02-14:9-12:portland*23-02-14:12-3:portland*23-02-14:3-6:portland*23-02-14:6-9:portland', ''),
('23-02-15:portland', '23-02-15:9-12:portland*23-02-15:12-3:portland*23-02-15:3-6:portland*23-02-15:6-9:portland', ''),
('23-02-16:portland', '23-02-16:9-12:portland*23-02-16:12-3:portland*23-02-16:3-6:portland*23-02-16:6-9:portland', ''),
('23-02-17:portland', '23-02-17:9-12:portland*23-02-17:3-6:portland*23-02-17:6-9:portland*23-02-17:night:portland*23-02-17:12-3:portland', ''),
('23-02-18:portland', '23-02-18:10-1:portland*23-02-18:1-4:portland*23-02-18:night:portland', ''),
('23-02-19:portland', '23-02-19:9-12:portland*23-02-19:2-5:portland*23-02-19:5-9:portland', ''),
('23-02-20:portland', '23-02-20:9-12:portland*23-02-20:3-6:portland*23-02-20:6-9:portland*23-02-20:12-3:portland', ''),
('23-02-21:portland', '23-02-21:9-12:portland*23-02-21:12-3:portland*23-02-21:3-6:portland*23-02-21:6-9:portland', ''),
('23-02-22:portland', '23-02-22:9-12:portland*23-02-22:12-3:portland*23-02-22:3-6:portland*23-02-22:6-9:portland', ''),
('23-02-23:portland', '23-02-23:9-12:portland*23-02-23:12-3:portland*23-02-23:3-6:portland*23-02-23:6-9:portland', ''),
('23-02-24:portland', '23-02-24:9-12:portland*23-02-24:12-3:portland*23-02-24:3-6:portland*23-02-24:6-9:portland*23-02-24:night:portland', ''),
('23-02-25:portland', '23-02-25:10-1:portland*23-02-25:night:portland*23-02-25:1-4:portland', ''),
('23-02-26:portland', '23-02-26:9-12:portland*23-02-26:2-5:portland*23-02-26:5-9:portland', ''),
('23-02-27:portland', '23-02-27:9-12:portland*23-02-27:3-6:portland*23-02-27:6-9:portland*23-02-27:12-3:portland', ''),
('23-02-28:portland', '23-02-28:9-12:portland*23-02-28:12-3:portland*23-02-28:3-6:portland*23-02-28:6-9:portland', ''),
('23-03-01:portland', '23-03-01:9-12:portland*23-03-01:12-3:portland*23-03-01:3-6:portland*23-03-01:6-9:portland', ''),
('23-03-02:portland', '23-03-02:9-12:portland*23-03-02:12-3:portland*23-03-02:3-6:portland*23-03-02:6-9:portland', ''),
('23-03-03:portland', '23-03-03:9-12:portland*23-03-03:3-6:portland*23-03-03:6-9:portland*23-03-03:night:portland*23-03-03:12-3:portland', ''),
('23-03-04:portland', '23-03-04:10-1:portland*23-03-04:1-4:portland*23-03-04:night:portland', ''),
('23-03-05:portland', '23-03-05:9-12:portland*23-03-05:2-5:portland*23-03-05:5-9:portland', ''),
('23-03-06:portland', '23-03-06:9-12:portland*23-03-06:3-6:portland*23-03-06:6-9:portland*23-03-06:12-3:portland', ''),
('23-03-07:portland', '23-03-07:9-12:portland*23-03-07:12-3:portland*23-03-07:3-6:portland*23-03-07:6-9:portland', ''),
('23-03-08:portland', '23-03-08:9-12:portland*23-03-08:12-3:portland*23-03-08:3-6:portland*23-03-08:6-9:portland', ''),
('23-03-09:portland', '23-03-09:9-12:portland*23-03-09:12-3:portland*23-03-09:3-6:portland*23-03-09:6-9:portland', ''),
('23-03-10:portland', '23-03-10:9-12:portland*23-03-10:12-3:portland*23-03-10:3-6:portland*23-03-10:6-9:portland*23-03-10:night:portland', ''),
('23-03-11:portland', '23-03-11:10-1:portland*23-03-11:1-4:portland*23-03-11:night:portland', ''),
('23-03-12:portland', '23-03-12:9-12:portland*23-03-12:2-5:portland*23-03-12:5-9:portland', ''),
('23-03-13:portland', '23-03-13:9-12:portland*23-03-13:3-6:portland*23-03-13:6-9:portland*23-03-13:12-3:portland', ''),
('23-03-14:portland', '23-03-14:9-12:portland*23-03-14:12-3:portland*23-03-14:3-6:portland*23-03-14:6-9:portland', ''),
('23-03-15:portland', '23-03-15:9-12:portland*23-03-15:12-3:portland*23-03-15:3-6:portland*23-03-15:6-9:portland', ''),
('23-03-16:portland', '23-03-16:9-12:portland*23-03-16:12-3:portland*23-03-16:3-6:portland*23-03-16:6-9:portland', ''),
('23-03-17:portland', '23-03-17:9-12:portland*23-03-17:3-6:portland*23-03-17:6-9:portland*23-03-17:night:portland*23-03-17:12-3:portland', ''),
('23-03-18:portland', '23-03-18:10-1:portland*23-03-18:1-4:portland*23-03-18:night:portland', ''),
('23-03-19:portland', '23-03-19:9-12:portland*23-03-19:2-5:portland*23-03-19:5-9:portland', ''),
('23-03-20:portland', '23-03-20:9-12:portland*23-03-20:3-6:portland*23-03-20:6-9:portland*23-03-20:12-3:portland', ''),
('23-03-21:portland', '23-03-21:9-12:portland*23-03-21:12-3:portland*23-03-21:3-6:portland*23-03-21:6-9:portland', ''),
('23-03-22:portland', '23-03-22:9-12:portland*23-03-22:12-3:portland*23-03-22:3-6:portland*23-03-22:6-9:portland', ''),
('23-03-23:portland', '23-03-23:9-12:portland*23-03-23:12-3:portland*23-03-23:3-6:portland*23-03-23:6-9:portland', ''),
('23-03-24:portland', '23-03-24:9-12:portland*23-03-24:12-3:portland*23-03-24:3-6:portland*23-03-24:6-9:portland*23-03-24:night:portland', ''),
('23-03-25:portland', '23-03-25:10-1:portland*23-03-25:night:portland*23-03-25:1-4:portland', ''),
('23-03-26:portland', '23-03-26:9-12:portland*23-03-26:2-5:portland*23-03-26:5-9:portland', ''),
('23-03-27:portland', '23-03-27:9-12:portland*23-03-27:3-6:portland*23-03-27:6-9:portland*23-03-27:12-3:portland', ''),
('23-03-28:portland', '23-03-28:9-12:portland*23-03-28:12-3:portland*23-03-28:3-6:portland*23-03-28:6-9:portland', ''),
('23-03-29:portland', '23-03-29:9-12:portland*23-03-29:12-3:portland*23-03-29:3-6:portland*23-03-29:6-9:portland', ''),
('23-03-30:portland', '23-03-30:9-12:portland*23-03-30:12-3:portland*23-03-30:3-6:portland*23-03-30:6-9:portland', ''),
('23-03-31:portland', '23-03-31:9-12:portland*23-03-31:3-6:portland*23-03-31:6-9:portland*23-03-31:night:portland*23-03-31:12-3:portland', ''),
('23-04-01:portland', '23-04-01:10-1:portland*23-04-01:1-4:portland*23-04-01:night:portland', ''),
('23-04-02:portland', '23-04-02:9-12:portland*23-04-02:2-5:portland*23-04-02:5-9:portland', '');

-- --------------------------------------------------------

--
-- Table structure for table `dbEventMedia`
--

CREATE TABLE `dbEventMedia` (
  `id` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  `url` text NOT NULL,
  `type` text NOT NULL,
  `format` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dbEventMedia`
--

INSERT INTO `dbEventMedia` (`id`, `eventID`, `url`, `type`, `format`, `description`) VALUES
(19, 17, 'http://test.com', 'post', 'link', 'test'),
(20, 17, 'https://www.youtube.com/embed/ZyoSNt03o7g', 'training', 'video', 'Lofi Jam'),
(21, 18, 'https://i.imgur.com/QSfApBk.jpeg', 'training', 'picture', 'Lol'),
(22, 18, 'https://www.youtube.com/embed/geWYyNbNR24', 'post', 'video', 'Cozy Music'),
(23, 18, 'https://lk-umw-cpsc.github.io/', 'training', 'link', 'Eagle Dash by Lauren &amp; Matt'),
(24, 18, 'https://images.unsplash.com/photo-1615789591457-74a63395c990?ixlib=rb-4.0.3&amp;ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZG9tZXN0aWMlMjBjYXR8ZW58MHx8MHx8&amp;w=1000&amp;q=80', 'post', 'picture', 'This is a very cute cat :)'),
(25, 19, 'https://www.facebook.com/gwynethsgift/', 'training', 'link', 'test'),
(27, 19, 'https://www.youtube.com/embed/G9ijqOsYzF8', 'training', 'video', 'ok'),
(28, 19, 'https://i.natgeofe.com/n/548467d8-c5f1-4551-9f58-6817a8d2c45e/NationalGeographic_2572187_square.jpg', 'training', 'picture', 'test'),
(29, 19, 'https://www.facebook.com/gwynethsgift/', 'post', 'link', 'ok'),
(30, 20, 'https://www.youtube.com/embed/G9ijqOsYzF8', 'training', 'video', 'asdf'),
(31, 20, 'https://www.youtube.com/embed/G9ijqOsYzF8', 'post', 'video', 'did zack do a good?');

-- --------------------------------------------------------

--
-- Table structure for table `dbEvents`
--

CREATE TABLE `dbEvents` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `abbrevName` text NOT NULL,
  `date` char(10) NOT NULL,
  `startTime` char(5) NOT NULL,
  `endTime` char(5) NOT NULL,
  `description` text NOT NULL,
  `location` text NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dbEvents`
--

INSERT INTO `dbEvents` (`id`, `name`, `abbrevName`, `date`, `startTime`, `endTime`, `description`, `location`, `capacity`) VALUES
(17, 'Test Event', 'Testing', '2023-03-24', '12:00', '16:00', 'A test event', 'Some place fun', 3),
(18, 'Test Event', 'Test', '2023-04-06', '13:00', '17:00', 'An event description', '100 Event Location Ave, Locationville, VA 22401', 4),
(19, 'test me pls', 'test 123', '2023-04-21', '12:00', '13:00', 'test', 'testville', 3),
(20, 'Test Event 2', 'Test 2', '2023-04-19', '12:00', '13:00', 'Descript', 'Location', 5),
(21, 'Testing Hours Report', 'Testing Hou', '2023-04-24', '12:00', '13:00', 'Description', 'Location', 1),
(23, 'CPR Awareness', 'CPR', '2023-06-13', '13:00', '17:00', '', 'Location', 20),
(24, 'Building Event', 'Build', '2023-05-24', '09:00', '17:00', '', 'Location', 3),
(25, 'Black and White', 'B&W', '2023-12-10', '20:00', '21:00', '', 'Location', 1),
(26, 'Government Training', 'Gov\'t', '2023-04-24', '08:00', '09:00', 'how did you end up with no description?', 'Location', 20),
(27, 'schema test', 'schema', '2023-04-14', '10:00', '12:00', 'tomorrow', 'asdfasdfasdf', 1),
(28, 'asdf', 'asdf', '2023-04-21', '09:00', '17:00', 'tet', 'test', 1),
(29, 'space test', 'asdf', '2023-04-20', '12:00', '16:00', 'testttt', 'OKAY', 2);

-- --------------------------------------------------------

--
-- Table structure for table `dbEventVolunteers`
--

CREATE TABLE `dbEventVolunteers` (
  `eventID` int(11) NOT NULL,
  `userID` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dbEventVolunteers`
--

INSERT INTO `dbEventVolunteers` (`eventID`, `userID`) VALUES
(17, 'jdoe@umw.edu'),
(17, 'volunteer@example.com'),
(18, 'volunteer@example.com'),
(19, 'volunteer@example.com'),
(21, 'volunteer@example.com'),
(24, 'lknight2@mail.umw.edu');

-- --------------------------------------------------------

--
-- Table structure for table `dbLog`
--

CREATE TABLE `dbLog` (
  `id` int(3) NOT NULL,
  `time` text,
  `message` text,
  `venue` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbmasterschedule`
--

CREATE TABLE `dbmasterschedule` (
  `venue` text,
  `day` text NOT NULL,
  `week_no` text NOT NULL,
  `hours` text,
  `slots` int(11) DEFAULT NULL,
  `persons` text,
  `notes` text,
  `id` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbmasterschedule`
--

INSERT INTO `dbmasterschedule` (`venue`, `day`, `week_no`, `hours`, `slots`, `persons`, `notes`, `id`) VALUES
('portland', 'Mon', 'odd', '9-12', 3, ',Jane7038293469,Cathy7038295422,Cheryl7032821358', '', 'odd:Mon:9-12:portland'),
('portland', 'Mon', 'odd', '3-6', 2, ',Robin7037510984,Claire7033293465', '', 'odd:Mon:3-6:portland'),
('portland', 'Mon', 'odd', '6-9', 2, ',Nonie7037812392', '', 'odd:Mon:6-9:portland'),
('portland', 'Tue', 'odd', '9-12', 2, ',Jane7038859127,Stacey7032333522', '', 'odd:Tue:9-12:portland'),
('portland', 'Tue', 'odd', '12-3', 2, ',Cindy7035631089', '', 'odd:Tue:12-3:portland'),
('portland', 'Tue', 'odd', '3-6', 2, ',Becky7037725009,Betsy7038464935', '', 'odd:Tue:3-6:portland'),
('portland', 'Tue', 'odd', '6-9', 2, ',Kara7035953232,Daniel7032330196', '', 'odd:Tue:6-9:portland'),
('portland', 'Wed', 'odd', '9-12', 2, ',Aynne7032328782,Charlie7032728637', '', 'odd:Wed:9-12:portland'),
('portland', 'Wed', 'odd', '12-3', 2, ',John7032476256', '', 'odd:Wed:12-3:portland'),
('portland', 'Wed', 'odd', '3-6', 2, ',Amy7037519944,Ann7038470375', '', 'odd:Wed:3-6:portland'),
('portland', 'Wed', 'odd', '6-9', 2, ',Marilee7034159124,Claudia7033181908', '', 'odd:Wed:6-9:portland'),
('portland', 'Thu', 'odd', '9-12', 2, ',Cathy7038784455,Meg7039395058', '', 'odd:Thu:9-12:portland'),
('portland', 'Thu', 'odd', '12-3', 2, ',Marjorie7032328434', '', 'odd:Thu:12-3:portland'),
('portland', 'Thu', 'odd', '3-6', 2, ',Nancy7032210332,Suzanne7037018778', '', 'odd:Thu:3-6:portland'),
('portland', 'Thu', 'odd', '6-9', 2, ',Jody7033294089,Allyson7034410528', '', 'odd:Thu:6-9:portland'),
('portland', 'Fri', 'odd', '9-12', 2, ',Sally7037993827,Becky7038463827', '', 'odd:Fri:9-12:portland'),
('portland', 'Fri', 'odd', '12-3', 2, ',Ellen7034432810', '', 'odd:Fri:12-3:portland'),
('portland', 'Fri', 'odd', '3-6', 3, ',Phyllis7032325963,Elaine7037672928', '', 'odd:Fri:3-6:portland'),
('portland', 'Fri', 'odd', '6-9', 0, '', '', 'odd:Fri:6-9:portland'),
('portland', 'Mon', 'even', '9-12', 3, ',Jane7038293469,Cathy7038295422,Cheryl7032821358', '', 'even:Mon:9-12:portland'),
('portland', 'Mon', 'even', '3-6', 2, ',Maureen7032100761,Claire7033293465', '', 'even:Mon:3-6:portland'),
('portland', 'Mon', 'even', '6-9', 2, ',Vickie7033180302,Estelle7037720647', '', 'even:Mon:6-9:portland'),
('portland', 'Tue', 'even', '9-12', 2, ',Jane7038859127,Stacey7032333522', '', 'even:Tue:9-12:portland'),
('portland', 'Tue', 'even', '12-3', 2, ',Mary Ann7038833212,Gibbs7037474590', '', 'even:Tue:12-3:portland'),
('portland', 'Tue', 'even', '3-6', 2, ',Becky7037725009,Betsy7038464935', '', 'even:Tue:3-6:portland'),
('portland', 'Tue', 'even', '6-9', 2, ',Josh7037124705,April7038075431', '', 'even:Tue:6-9:portland'),
('portland', 'Wed', 'even', '9-12', 2, ',Jeannie7037970345,Kym7037970345', '', 'even:Wed:9-12:portland'),
('portland', 'Wed', 'even', '12-3', 2, ',Ellen7037994830', '', 'even:Wed:12-3:portland'),
('portland', 'Wed', 'even', '3-6', 2, ',Nancy7034158150', '', 'even:Wed:3-6:portland'),
('portland', 'Wed', 'even', '6-9', 2, ',Jody7033294089,Lilly2158349209', '', 'even:Wed:6-9:portland'),
('portland', 'Thu', 'even', '9-12', 2, '', '', 'even:Thu:9-12:portland'),
('portland', 'Thu', 'even', '12-3', 2, ',Thorne7034439654,Meg7037298111', '', 'even:Thu:12-3:portland'),
('portland', 'Thu', 'even', '3-6', 2, ',Linda7037568845,Sue7033171877', '', 'even:Thu:3-6:portland'),
('portland', 'Thu', 'even', '6-9', 2, ',Shay6175012425,Rebecca5185881836', '', 'even:Thu:6-9:portland'),
('portland', 'Fri', 'even', '9-12', 3, ',Bobbi7033447417,Meg7039395058', '', 'even:Fri:9-12:portland'),
('portland', 'Fri', 'even', '3-6', 3, ',Phyllis7032325963,Margi7034152255', '', 'even:Fri:3-6:portland'),
('portland', 'Fri', 'even', '6-9', 0, '', '', 'even:Fri:6-9:portland'),
('portland', 'Sat', '1st', '10-1', 3, ',Nancy7036769033,Beth7033399448,Rita7037998431', '', '1st:Sat:10-1:portland'),
('portland', 'Sat', '1st', '1-4', 1, ',Beverly7038542682', '', '1st:Sat:1-4:portland'),
('portland', 'Sat', '2nd', '10-1', 1, '', '', '2nd:Sat:10-1:portland'),
('portland', 'Sat', '2nd', '1-4', 1, ',Susan7037817946', '', '2nd:Sat:1-4:portland'),
('portland', 'Sat', '3rd', '10-1', 1, '', '', '3rd:Sat:10-1:portland'),
('portland', 'Sat', '3rd', '1-4', 1, '', '', '3rd:Sat:1-4:portland'),
('portland', 'Sat', '4th', '10-1', 1, '', '', '4th:Sat:10-1:portland'),
('portland', 'Sat', '5th', '10-1', 1, '', '', '5th:Sat:10-1:portland'),
('portland', 'Sat', '5th', '1-4', 1, '', '', '5th:Sat:1-4:portland'),
('portland', 'Sun', '1st', '9-12', 1, '', '', '1st:Sun:9-12:portland'),
('portland', 'Sun', '1st', '2-5', 1, ',Mary7038293321', '', '1st:Sun:2-5:portland'),
('portland', 'Sun', '1st', '5-9', 1, ',Paul7032323414', '', '1st:Sun:5-9:portland'),
('portland', 'Sun', '2nd', '9-12', 1, '', '', '2nd:Sun:9-12:portland'),
('portland', 'Sun', '3rd', '9-12', 1, '', '', '3rd:Sun:9-12:portland'),
('portland', 'Sun', '3rd', '2-5', 2, ',Lance7032528780,Melissa7036501479', '', '3rd:Sun:2-5:portland'),
('portland', 'Sun', '4th', '9-12', 1, ',Gaye7032476985', '', '4th:Sun:9-12:portland'),
('portland', 'Sun', '4th', '2-5', 1, '', '', '4th:Sun:2-5:portland'),
('portland', 'Sun', '4th', '5-9', 1, '', '', '4th:Sun:5-9:portland'),
('portland', 'Sun', '5th', '9-12', 1, '', '', '5th:Sun:9-12:portland'),
('portland', 'Sun', '5th', '2-5', 1, '', '', '5th:Sun:2-5:portland'),
('portland', 'Sun', '5th', '5-9', 1, ',Chris7038788512', '', '5th:Sun:5-9:portland'),
('portland', 'Fri', 'odd', 'night', 1, '', '', 'odd:Fri:night:portland'),
('portland', 'Fri', 'even', 'night', 1, '', '', 'even:Fri:night:portland'),
('portland', 'Sat', '1st', 'night', 1, '', '', '1st:Sat:night:portland'),
('portland', 'Sat', '2nd', 'night', 1, '', '', '2nd:Sat:night:portland'),
('portland', 'Sat', '3rd', 'night', 1, '', '', '3rd:Sat:night:portland'),
('portland', 'Sat', '4th', 'night', 1, '', '', '4th:Sat:night:portland'),
('portland', 'Sat', '5th', 'night', 1, '', '', '5th:Sat:night:portland'),
('portland', 'Sat', '4th', '1-4', 1, '', '', '4th:Sat:1-4:portland'),
('portland', 'Mon', 'even', '12-3', 2, ',Peter7037991786,Cheryl7038089589', '', 'even:Mon:12-3:portland'),
('portland', 'Sun', '3rd', '5-9', 1, '', '', '3rd:Sun:5-9:portland'),
('portland', 'Fri', 'even', '12-3', 2, ',Suzanne7037018778', '', 'even:Fri:12-3:portland'),
('portland', 'Sun', '2nd', '2-5', 1, ',Chris7038788512', '', '2nd:Sun:2-5:portland'),
('portland', 'Sun', '2nd', '5-9', 1, '', '', '2nd:Sun:5-9:portland'),
('portland', 'Mon', 'odd', '12-3', 2, ',Cheryl7038089589', '', 'odd:Mon:12-3:portland'),
('bangor', 'Sat', '5th', 'night', 0, '', '', '5th:Sat:night:bangor'),
('bangor', 'Mon', 'odd', '9-12', 1, '', '', 'odd:Mon:9-12:bangor'),
('bangor', 'Tue', 'odd', '9-12', 1, ',Julie7039424211', '', 'odd:Tue:9-12:bangor'),
('bangor', 'Wed', 'odd', '9-12', 1, ',Linda7037358701', '', 'odd:Wed:9-12:bangor'),
('bangor', 'Thu', 'odd', '9-12', 1, ',Lura7039471915', '', 'odd:Thu:9-12:bangor'),
('bangor', 'Fri', 'odd', '9-12', 1, ',Sara7036594431', '', 'odd:Fri:9-12:bangor'),
('bangor', 'Mon', 'even', '9-12', 1, '', '', 'even:Mon:9-12:bangor'),
('bangor', 'Tue', 'even', '9-12', 1, ',Julie7039424211', '', 'even:Tue:9-12:bangor'),
('bangor', 'Wed', 'even', '9-12', 1, ',Linda7037358701', '', 'even:Wed:9-12:bangor'),
('bangor', 'Thu', 'even', '9-12', 1, ',Lura7039471915', '', 'even:Thu:9-12:bangor'),
('bangor', 'Fri', 'even', '9-12', 1, ',Sara7036594431', '', 'even:Fri:9-12:bangor'),
('bangor', 'Thu', 'odd', '3-6', 2, ',Cassandra7039445038,Nicole9176052094', '', 'odd:Thu:3-6:bangor'),
('bangor', 'Mon', 'odd', '12-3', 1, ',Barbara7033227096', '', 'odd:Mon:12-3:bangor'),
('bangor', 'Tue', 'odd', '12-3', 1, ',Sara7036594431', '', 'odd:Tue:12-3:bangor'),
('bangor', 'Wed', 'odd', '12-3', 1, ',Bonnie7039421321', '', 'odd:Wed:12-3:bangor'),
('bangor', 'Thu', 'odd', '12-3', 2, ',Shannon7039912298,Hannah7036109735', '', 'odd:Thu:12-3:bangor'),
('bangor', 'Fri', 'odd', '12-3', 1, ',Jane7038273452', '', 'odd:Fri:12-3:bangor'),
('bangor', 'Mon', 'odd', '3-6', 1, '', '', 'odd:Mon:3-6:bangor'),
('bangor', 'Tue', 'odd', '3-6', 1, ',Jennifer7038527724', '', 'odd:Tue:3-6:bangor'),
('bangor', 'Wed', 'odd', '3-6', 1, '', '', 'odd:Wed:3-6:bangor'),
('bangor', 'Fri', 'odd', '3-6', 1, ',Amanda7032051750', '', 'odd:Fri:3-6:bangor'),
('bangor', 'Mon', 'odd', '6-9', 1, '', '', 'odd:Mon:6-9:bangor'),
('bangor', 'Tue', 'odd', '6-9', 1, ',Natasha7034040029', '', 'odd:Tue:6-9:bangor'),
('bangor', 'Wed', 'odd', '6-9', 1, ',Natasha7034040029', '', 'odd:Wed:6-9:bangor'),
('bangor', 'Thu', 'odd', '6-9', 1, '', '', 'odd:Thu:6-9:bangor'),
('bangor', 'Mon', 'even', '12-3', 1, ',Barbara7033227096', '', 'even:Mon:12-3:bangor'),
('bangor', 'Tue', 'even', '12-3', 1, ',Kimberley9048746622', '', 'even:Tue:12-3:bangor'),
('bangor', 'Wed', 'even', '12-3', 1, ',Bonnie7039421321', '', 'even:Wed:12-3:bangor'),
('bangor', 'Thu', 'even', '12-3', 2, ',Shannon7039912298,Hannah7036109735', '', 'even:Thu:12-3:bangor'),
('bangor', 'Fri', 'even', '12-3', 1, ',Jane7038273452', '', 'even:Fri:12-3:bangor'),
('bangor', 'Mon', 'even', '3-6', 1, '', '', 'even:Mon:3-6:bangor'),
('bangor', 'Tue', 'even', '3-6', 1, ',Jennifer7038527724', '', 'even:Tue:3-6:bangor'),
('bangor', 'Wed', 'even', '3-6', 1, '', '', 'even:Wed:3-6:bangor'),
('bangor', 'Thu', 'even', '3-6', 2, ',Cassandra7039445038,Nicole9176052094', '', 'even:Thu:3-6:bangor'),
('bangor', 'Fri', 'even', '3-6', 1, ',Amanda7032051750', '', 'even:Fri:3-6:bangor'),
('bangor', 'Mon', 'even', '6-9', 1, '', '', 'even:Mon:6-9:bangor'),
('bangor', 'Tue', 'even', '6-9', 1, ',Natasha7034040029', '', 'even:Tue:6-9:bangor'),
('bangor', 'Wed', 'even', '6-9', 1, ',Natasha7034040029', '', 'even:Wed:6-9:bangor'),
('bangor', 'Thu', 'even', '6-9', 1, '', '', 'even:Thu:6-9:bangor'),
('bangor', 'Fri', 'odd', 'night', 0, '', '', 'odd:Fri:night:bangor'),
('bangor', 'Fri', 'even', 'night', 0, '', '', 'even:Fri:night:bangor'),
('bangor', 'Sun', '1st', '5-9', 0, '', '', '1st:Sun:5-9:bangor'),
('bangor', 'Sat', '4th', 'night', 0, '', '', '4th:Sat:night:bangor'),
('bangor', 'Sat', '1st', 'night', 0, '', '', '1st:Sat:night:bangor'),
('bangor', 'Sun', '1st', '9-5', 0, '', '', '1st:Sun:9-5:bangor'),
('bangor', 'Sat', '2nd', 'night', 0, '', '', '2nd:Sat:night:bangor'),
('bangor', 'Sun', '2nd', '9-5', 0, '', '', '2nd:Sun:9-5:bangor'),
('bangor', 'Sun', '2nd', '5-9', 0, '', '', '2nd:Sun:5-9:bangor'),
('bangor', 'Sun', '3rd', '9-5', 0, '', '', '3rd:Sun:9-5:bangor'),
('bangor', 'Sun', '4th', '9-5', 0, '', '', '4th:Sun:9-5:bangor'),
('bangor', 'Sun', '3rd', '5-9', 0, '', '', '3rd:Sun:5-9:bangor'),
('bangor', 'Sat', '3rd', 'night', 0, '', '', '3rd:Sat:night:bangor'),
('bangor', 'Sun', '4th', '5-9', 0, '', '', '4th:Sun:5-9:bangor'),
('bangor', 'Sun', '5th', '9-5', 0, '', '', '5th:Sun:9-5:bangor'),
('bangor', 'Sun', '5th', '5-9', 0, '', '', '5th:Sun:5-9:bangor'),
('bangor', 'Sat', '1st', '9-5', 0, '', '', '1st:Sat:9-5:bangor'),
('bangor', 'Sat', '2nd', '9-5', 0, '', '', '2nd:Sat:9-5:bangor'),
('bangor', 'Sat', '3rd', '9-5', 0, '', '', '3rd:Sat:9-5:bangor'),
('bangor', 'Sat', '4th', '9-5', 0, '', '', '4th:Sat:9-5:bangor'),
('bangor', 'Sat', '5th', '9-5', 0, '', '', '5th:Sat:9-5:bangor');

-- --------------------------------------------------------

--
-- Table structure for table `dbPersons`
--

CREATE TABLE `dbPersons` (
  `id` varchar(256) CHARACTER SET utf8mb4 NOT NULL,
  `start_date` text,
  `venue` text,
  `first_name` text NOT NULL,
  `last_name` text,
  `address` text,
  `city` text,
  `state` varchar(2) DEFAULT NULL,
  `zip` text,
  `phone1` varchar(12) NOT NULL,
  `phone1type` text,
  `phone2` varchar(12) DEFAULT NULL,
  `phone2type` text,
  `birthday` text,
  `email` text,
  `shirt_size` varchar(3) DEFAULT NULL,
  `computer` varchar(3) DEFAULT NULL,
  `camera` varchar(3) NOT NULL,
  `transportation` varchar(3) NOT NULL,
  `contact_name` text NOT NULL,
  `contact_num` varchar(12) NOT NULL,
  `relation` text NOT NULL,
  `contact_time` text NOT NULL,
  `cMethod` text,
  `position` text,
  `credithours` text,
  `howdidyouhear` text,
  `commitment` text,
  `motivation` text,
  `specialties` text,
  `convictions` text,
  `type` text,
  `status` text,
  `availability` text,
  `schedule` text,
  `hours` text,
  `notes` text,
  `password` text,
  `sundays_start` char(5) DEFAULT NULL,
  `sundays_end` char(5) DEFAULT NULL,
  `mondays_start` char(5) DEFAULT NULL,
  `mondays_end` char(5) DEFAULT NULL,
  `tuesdays_start` char(5) DEFAULT NULL,
  `tuesdays_end` char(5) DEFAULT NULL,
  `wednesdays_start` char(5) DEFAULT NULL,
  `wednesdays_end` char(5) DEFAULT NULL,
  `thursdays_start` char(5) DEFAULT NULL,
  `thursdays_end` char(5) DEFAULT NULL,
  `fridays_start` char(5) DEFAULT NULL,
  `fridays_end` char(5) DEFAULT NULL,
  `saturdays_start` char(5) DEFAULT NULL,
  `saturdays_end` char(5) DEFAULT NULL,
  `profile_pic` text NOT NULL,
  `force_password_change` tinyint(1) NOT NULL,
  `gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbPersons`
--

INSERT INTO `dbPersons` (`id`, `start_date`, `venue`, `first_name`, `last_name`, `address`, `city`, `state`, `zip`, `phone1`, `phone1type`, `phone2`, `phone2type`, `birthday`, `email`, `shirt_size`, `computer`, `camera`, `transportation`, `contact_name`, `contact_num`, `relation`, `contact_time`, `cMethod`, `position`, `credithours`, `howdidyouhear`, `commitment`, `motivation`, `specialties`, `convictions`, `type`, `status`, `availability`, `schedule`, `hours`, `notes`, `password`, `sundays_start`, `sundays_end`, `mondays_start`, `mondays_end`, `tuesdays_start`, `tuesdays_end`, `wednesdays_start`, `wednesdays_end`, `thursdays_start`, `thursdays_end`, `fridays_start`, `fridays_end`, `saturdays_start`, `saturdays_end`, `profile_pic`, `force_password_change`, `gender`) VALUES
('bob.testa@test.com', '2023-04-15', 'portland', 'bob', 'testa', 'asdf', 'asdf', 'VA', '10000', '1000000000', 'cellphone', '', '', '1991-01-01', 'bob.testa@test.com', 'S', '', '', '', 'asdf', '9999999999', 'asdf', 'asf', 'phone', '', '', '', '', '', '', '', 'volunteer', 'Active', '', '', '', '', '$2y$10$xRxucb0Lv24F7um9NMt8ZO5JQpZM9tZvizQWj.c.3fNCTkB78u8aG', '00:00', '23:59', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, ''),
('bob@test.com', '1995-10-30', 'portland', 'Bob', 'Testington', '1696 Carl D. Silver Pkway', 'TEST CITY', 'VA', '10000', '1000000000', 'cellphone', '', '', '1991-01-01', 'bob@test.com', 'S', '', '', '', 'akdjf', '1234567890', 'as;dlfj', 'asdflkjashdf', 'phone', '', '', '', '', '', '', '', 'volunteer', 'Active', '', '', '', '', '$2y$10$8dfJhC/hIJYChCyfVGnyCOAIZ1z1NZlR/7eJ7PkgLtI61ppeTA9gi', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '', 0, ''),
('clarence@test.com', '2012-01-01', 'portland', 'Clarence', 'Testington', 'asldkfhaslkdjfh', 'asdlkfjahsdlfkj', 'VA', '12345', '1234567890', 'cellphone', '', '', '1991-01-01', 'clarence@test.com', 'S', '', '', '', 'asjdfh', '1234567890', 'askldjfh', 'asdf', 'phone', '', '', '', '', '', '', '', 'volunteer', 'Active', '', '', '', '', '$2y$10$/r/3t57lNeDTib0h5ow2.OY7AIAtku9/GxKm7SILWFs6w/MtCBqA2', '', '', '13:00', '17:00', '13:00', '17:00', '13:00', '17:00', '', '', '', '', '', '', '', 0, ''),
('jdoe@umw.edu', '2023-03-03', 'portland', 'John', 'Doe', '123456 College Ave', 'Fredericksburg', 'VA', '22401', '5551234567', 'cellphone', '', '', '2000-01-01', 'jdoe@umw.edu', 'XL', '', '', '', 'Mom Doe', '1234567890', 'Mom, duh', 'Whenever you feel like it, really', 'phone', '', '', '', '', '', '&lt;script&gt;alert(\'if this works, we are vulnerable to XSS!\');&lt;/script&gt;', '', 'volunteer', 'Active', '', '', '', '', '$2y$10$SD9rYWp9tWGM88LnCh5ge.486qOjkRLM5mQ9hqrE3T9oKlmWlf13a', '08:00', '18:00', '', '', '', '', '00:00', '23:59', '', '', '09:00', '23:59', '', '', 'https://www.washingtonian.com/wp-content/uploads/2020/03/sandie-clarke-C8uGiOanMY4-unsplash-2048x1365.jpg', 0, ''),
('jessie@test.com', '2016-06-19', 'portland', 'Jessie', 'Testington', 'asdlfkjh', 'asdflkj', 'VA', '10000', '5555555555', 'cellphone', '', '', '1991-01-01', 'jessie@test.com', 'S', '', '', '', 'asdf', '5555555555', 'Mother', '123', 'phone', '', '', '', '', '', '', '', 'volunteer', 'Active', '', '', '', '', '$2y$10$XwmYCzXNfD8EFE/R0zLjsOoFv9jwAjPJIBEBYUmZWkdKWHsBZVj0e', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '09:00', '17:00', '', 0, ''),
('justin@test.com', '2001-12-03', 'portland', 'Justin', 'Testington', 'lhdfoiuhdf', 'alskdjfh', 'VA', '60000', '5555555555', 'cellphone', '', '', '1991-01-01', 'justin@test.com', 'S', '', '', '', 'alkjshdf', '5555555555', 'Mother', 'Days', 'phone', '', '', '', '', '', '', '', 'volunteer', 'Active', '', '', '', '', '$2y$10$yd7NUrB3DTvOLu8pkvGsmeyA2y7XoJeWOZQpAVylFTOMb0uuzuto6', '00:00', '23:59', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, ''),
('lknight2@mail.umw.edu', '2023-03-21', 'portland', 'Lauren', 'Knight', '1234 Street St', 'Fredericksburg', 'VA', '22401', '5405555555', 'home', '', '', '1990-01-01', 'lknight2@mail.umw.edu', 'S', '1', '1', '1', 'Halulolo', '5555555555', 'That person', 'Days', 'phone', '', '', '', '', '', '', '', 'admin', 'Inactive', '', '', '', 'Administrative', '$2y$10$28EB5VqpTe2.1ZfVN3B/8eoDfCjh8rX/XXIyW7gutbyCvRBJ7k0xS', '', '', '00:00', '23:59', '', '', '', '', '', '', '', '', '', '', '', 0, ''),
('moe@test.com', '2025-04-24', 'portland', 'Moe', 'Testington', 'asdfklj', 'asdlfkjahsdf', 'VA', '22401', '5555555555', 'cellphone', '', '', '1991-01-01', 'moe@test.com', 'S', '', '', '', 'Olive', '5555555555', 'FRIEND', 'Days', 'phone', '', '', '', '', '', '', '', 'volunteer', 'Active', '', '', '', '', '$2y$10$0nB9ctK9wkExsuU1NG0Tnu3EZkmY4BVFhQyyUn5uMMQ01EPuun9nC', '', '', '', '', '', '', '', '', '00:00', '23:59', '00:00', '23:59', '00:00', '23:59', '', 0, ''),
('suzie@test.com', '2001-12-03', 'portland', 'Suzie', 'Inactington', 'asdf', 'asdf', 'VA', '10000', '5555555555', 'cellphone', '', '', '1991-01-01', 'suzie@test.com', 'S', '', '', '', 'asfdlk', '1001001000', 'asdf', 'asdf', 'phone', '', '', '', '', '', '', '', 'volunteer', 'Inactive', '', '', '', '', '$2y$10$lusHTnyt/PjxDCVLw0ITA.4M5YSxGfyeMI9MFj1r7TAMRAbfahCKC', '00:00', '23:59', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, ''),
('tao@test.com', '2016-06-19', 'portland', 'Tao', 'Inactington', '1696 Carl D. Silver Pkwy', 'Fredericksburg', 'VA', '22401', '5555555555', 'cellphone', '', '', '1991-01-01', 'tao@test.com', 'S', '', '', '', 'asdff', '1001001000', 'Mother', 'Days', 'text', '', '', '', '', '', '', '', 'volunteer', 'Inactive', '', '', '', '', '$2y$10$72vscf.mstNlu5x89kv.LudvKFV0py2R7JWjT48chWUowLuMm0.dS', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '05:00', '21:00', '', 0, ''),
('testuser@gmail.com', '2023-04-03', 'portland', 'Test', 'User 1', 'kjsaldgjawes', 'sabbs', 'VA', '00000', '0000000000', 'cellphone', '', '', '2023-04-03', 'testuser@gmail.com', 'S', '', '', '', 'Bob', '1235544444', 'Father', 'Evenings', 'text', '', '', '', '', '', '', '', 'admin', 'Active', '', '', '', 'Administrative', '$2y$10$pAQJHJ018sTQXgXRe2JIDex6AByMNhPyrt3QmgSiQfGeQUBIn0z1m', '08:00', '16:00', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, ''),
('vmsroot', 'N/A', 'portland', 'vmsroot', '', 'N/A', 'N/A', 'VA', 'N/A', '', 'N/A', 'N/A', 'N/A', 'N/A', 'vmsroot', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '', 'N/A', 'N/A', 'N/A', 'N/A', 'N/A', '$2y$10$DS9SB18EjwP03YDuEOfTuOIa2HtNKXu3gEt4b6Z/.0.M4K/d5OJFu', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, ''),
('volunteer@example.com', '2023-04-01', 'portland', 'Harry', 'Potter', '1000 College Ave', 'Fredericksburg', 'VA', '22401', '5408675309', 'work', '', '', '1990-10-10', 'volunteer@example.com', 'S', '', '', '', 'Volunteer\'s Dad', '5408008000', 'Father', 'Evenings', 'email', '', '', '', '', '', '', '', 'volunteer', 'Active', '', '', '', '', '$2y$10$6r3Tu9GwZwjUk6hUp3DWq.ZtuRkPTMv4wYHF1CshWP5dCyXyABqVq', '00:00', '23:59', '00:00', '23:59', '00:00', '23:59', '00:00', '23:59', '00:00', '23:59', '00:00', '23:59', '00:00', '23:59', 'data:image/jpeg;base64,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', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `dbscl`
--

CREATE TABLE `dbscl` (
  `id` char(25) NOT NULL,
  `persons` text,
  `status` text,
  `vacancies` text,
  `time` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbscl`
--

INSERT INTO `dbscl` (`id`, `persons`, `status`, `vacancies`, `time`) VALUES
('22-10-24:12-3:portland', 'Annie7032831610+Annie+Jones+7032831610 + +++?,Charlie7032728637+Charlie+Jones+7032728637 + +++?,Jeanette7037615825+Jeanette+Jones+7037615825 + +++?,Jill7037739540+Jill+Jones+7037739540 + +++?,Lucy7037495489+Lucy+Jones+7037495489 + +++?,Marjorie7032328434+Marjorie+Jones+7032328434 cell+ +++?,Mary7036423647+Mary+Jones+7036423647 + +++?,Meg7039395058+Meg+Jones+7039395058 + +++?,Nancy7032210332+Nancy+Jones+7032210332 + +++?,Robin7037510984+Robin+Jones+7037510984 + +++?,Star7036536759+Star+Jones+7036536759 + +++?,Suzanne7037018778+Suzanne+Jones+7037018778 + +++?', 'open', '1', '202422101'),
('22-11-01:9-12:bangor', 'Amanda7032051750+Amanda+Jones+7032051750 cell+ +++?,Sara7036594431+Sara+Jones+7036594431 cell+ +++?', 'open', '1', '200122119');

-- --------------------------------------------------------

--
-- Table structure for table `dbshifts`
--

CREATE TABLE `dbshifts` (
  `id` char(25) NOT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `venue` text,
  `vacancies` int(11) DEFAULT NULL,
  `persons` text,
  `removed_persons` text,
  `sub_call_list` text,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbshifts`
--

INSERT INTO `dbshifts` (`id`, `start_time`, `end_time`, `venue`, `vacancies`, `persons`, `removed_persons`, `sub_call_list`, `notes`) VALUES
('22-10-24:12-3:bangor', 12, 15, 'bangor', 0, 'Barbara7033227096+Barbara+Jones', '', '', ''),
('22-10-24:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-10-24:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-10-24:9-12:bangor', 9, 12, 'bangor', 1, '', '', '', ''),
('22-10-25:12-3:bangor', 12, 15, 'bangor', 0, 'Kimberley9048746622', '', '', ''),
('22-10-25:3-6:bangor', 15, 18, 'bangor', 0, 'Jennifer7038527724+Jennifer+Jones', '', '', ''),
('22-10-25:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-10-25:9-12:bangor', 9, 12, 'bangor', 0, 'Julie7039424211+Julie+Jones', '', '', ''),
('22-10-26:12-3:bangor', 12, 15, 'bangor', 0, 'Bonnie7039421321+Bonnie+Jones', '', '', ''),
('22-10-26:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-10-26:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-10-26:9-12:bangor', 9, 12, 'bangor', 0, 'Linda7037358701+Linda+Jones', '', '', ''),
('22-10-27:12-3:bangor', 12, 15, 'bangor', 0, 'Shannon7039912298+Shannon+Jones*Hannah7036109735+Hannah+Jones', '', '', ''),
('22-10-27:3-6:bangor', 15, 18, 'bangor', 0, 'Cassandra7039445038+Cassandra+Jones*Nicole9176052094', '', '', ''),
('22-10-27:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-10-27:9-12:bangor', 9, 12, 'bangor', 0, 'Lura7039471915+Lura+Jones', '', '', ''),
('22-10-28:12-3:bangor', 12, 15, 'bangor', 0, 'Jane7038273452+Jane+Jones', '', '', ''),
('22-10-28:3-6:bangor', 15, 18, 'bangor', 0, 'Amanda7032051750+Amanda+Jones', '', '', ''),
('22-10-28:9-12:bangor', 9, 12, 'bangor', 0, 'Sara7036594431+Sara+Jones', '', '', ''),
('22-10-28:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-10-29:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('22-10-29:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-10-30:5-9:bangor', 17, 21, 'bangor', 0, '', '', '', ''),
('22-10-30:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('22-10-31:12-3:bangor', 12, 15, 'bangor', 0, 'Barbara7033227096+Barbara+Jones', '', '', ''),
('22-10-31:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-10-31:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-10-31:9-12:bangor', 9, 12, 'bangor', 1, '', '', '', ''),
('22-11-01:12-3:bangor', 12, 15, 'bangor', 0, 'Sara7036594431+Sara+Jones', '', '', ''),
('22-11-01:3-6:bangor', 15, 18, 'bangor', 0, 'Jennifer7038527724+Jennifer+Jones', '', '', ''),
('22-11-01:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-11-01:9-12:bangor', 9, 12, 'bangor', 1, 'AAd4544544545+AAd+AAAAd', 'Julie7039424211+Julie+Jones*AAd4544544545+AAd+AAAAd', '', ''),
('22-11-02:12-3:bangor', 12, 15, 'bangor', 0, 'Bonnie7039421321+Bonnie+Jones', '', '', ''),
('22-11-02:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-11-02:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-11-02:9-12:bangor', 9, 12, 'bangor', 0, 'Linda7037358701+Linda+Jones', '', '', ''),
('22-11-03:12-3:bangor', 12, 15, 'bangor', 0, 'Shannon7039912298+Shannon+Jones*Hannah7036109735+Hannah+Jones', '', '', ''),
('22-11-03:3-6:bangor', 15, 18, 'bangor', 0, 'Cassandra7039445038+Cassandra+Jones*Nicole9176052094', '', '', ''),
('22-11-03:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-11-03:9-12:bangor', 9, 12, 'bangor', 0, 'Lura7039471915+Lura+Jones', '', '', ''),
('22-11-04:12-3:bangor', 12, 15, 'bangor', 0, 'Jane7038273452+Jane+Jones', '', '', ''),
('22-11-04:3-6:bangor', 15, 18, 'bangor', 0, 'Amanda7032051750+Amanda+Jones', '', '', ''),
('22-11-04:9-12:bangor', 9, 12, 'bangor', 0, 'Sara7036594431+Sara+Jones', '', '', ''),
('22-11-04:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-11-05:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('22-11-05:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-11-06:5-9:bangor', 17, 21, 'bangor', 0, '', '', '', ''),
('22-11-06:9-5:bangor', 9, 17, 'bangor', 1, '', '', '', ''),
('22-11-07:12-3:bangor', 12, 15, 'bangor', 0, 'Barbara7033227096+Barbara+Jones', '', '', ''),
('22-11-07:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-11-07:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-11-07:9-12:bangor', 9, 12, 'bangor', 1, '', '', '', ''),
('22-11-08:12-3:bangor', 12, 15, 'bangor', 0, 'Kimberley9048746622', '', '', ''),
('22-11-08:3-6:bangor', 15, 18, 'bangor', 0, 'Jennifer7038527724+Jennifer+Jones', '', '', ''),
('22-11-08:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-11-08:9-12:bangor', 9, 12, 'bangor', 0, 'Julie7039424211+Julie+Jones', '', '', ''),
('22-11-09:12-3:bangor', 12, 15, 'bangor', 0, 'Bonnie7039421321+Bonnie+Jones', '', '', ''),
('22-11-09:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-11-09:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-11-09:9-12:bangor', 9, 12, 'bangor', 0, 'Linda7037358701+Linda+Jones', '', '', ''),
('22-11-10:12-3:bangor', 12, 15, 'bangor', 0, 'Shannon7039912298+Shannon+Jones*Hannah7036109735+Hannah+Jones', '', '', ''),
('22-11-10:3-6:bangor', 15, 18, 'bangor', 0, 'Cassandra7039445038+Cassandra+Jones*Nicole9176052094', '', '', ''),
('22-11-10:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-11-10:9-12:bangor', 9, 12, 'bangor', 0, 'Lura7039471915+Lura+Jones', '', '', ''),
('22-11-11:12-3:bangor', 12, 15, 'bangor', 0, 'Jane7038273452+Jane+Jones', '', '', ''),
('22-11-11:3-6:bangor', 15, 18, 'bangor', 0, 'Amanda7032051750+Amanda+Jones', '', '', ''),
('22-11-11:9-12:bangor', 9, 12, 'bangor', 0, 'Sara7036594431+Sara+Jones', '', '', ''),
('22-11-11:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-11-12:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('22-11-12:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-11-13:5-9:bangor', 17, 21, 'bangor', 0, '', '', '', ''),
('22-11-13:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('22-11-14:12-3:bangor', 12, 15, 'bangor', 0, 'Barbara7033227096+Barbara+Jones', '', '', ''),
('22-11-14:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-11-14:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-11-14:9-12:bangor', 9, 12, 'bangor', 1, '', '', '', ''),
('22-11-15:12-3:bangor', 12, 15, 'bangor', 0, 'Sara7036594431+Sara+Jones', '', '', ''),
('22-11-15:3-6:bangor', 15, 18, 'bangor', 0, 'Jennifer7038527724+Jennifer+Jones', '', '', ''),
('22-11-15:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-11-15:9-12:bangor', 9, 12, 'bangor', 0, 'Julie7039424211+Julie+Jones', '', '', ''),
('22-11-16:12-3:bangor', 12, 15, 'bangor', 0, 'Bonnie7039421321+Bonnie+Jones', '', '', ''),
('22-11-16:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-11-16:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-11-16:9-12:bangor', 9, 12, 'bangor', 0, 'Linda7037358701+Linda+Jones', '', '', ''),
('22-11-17:12-3:bangor', 12, 15, 'bangor', 0, 'Shannon7039912298+Shannon+Jones*Hannah7036109735+Hannah+Jones', '', '', ''),
('22-11-17:3-6:bangor', 15, 18, 'bangor', 0, 'Cassandra7039445038+Cassandra+Jones*Nicole9176052094', '', '', ''),
('22-11-17:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-11-17:9-12:bangor', 9, 12, 'bangor', 0, 'Lura7039471915+Lura+Jones', '', '', ''),
('22-11-18:12-3:bangor', 12, 15, 'bangor', 0, 'Jane7038273452+Jane+Jones', '', '', ''),
('22-11-18:3-6:bangor', 15, 18, 'bangor', 0, 'Amanda7032051750+Amanda+Jones', '', '', ''),
('22-11-18:9-12:bangor', 9, 12, 'bangor', 0, 'Sara7036594431+Sara+Jones', '', '', ''),
('22-11-18:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-11-19:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('22-11-19:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-11-20:5-9:bangor', 17, 21, 'bangor', 0, '', '', '', ''),
('22-11-20:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('22-11-21:12-3:bangor', 12, 15, 'bangor', 0, 'Barbara7033227096+Barbara+Jones', '', '', ''),
('22-11-21:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-11-21:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-11-21:9-12:bangor', 9, 12, 'bangor', 1, '', '', '', ''),
('22-11-22:12-3:bangor', 12, 15, 'bangor', 0, 'Kimberley9048746622', '', '', ''),
('22-11-22:3-6:bangor', 15, 18, 'bangor', 0, 'Jennifer7038527724+Jennifer+Jones', '', '', ''),
('22-11-22:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-11-22:9-12:bangor', 9, 12, 'bangor', 0, 'Julie7039424211+Julie+Jones', '', '', ''),
('22-11-23:12-3:bangor', 12, 15, 'bangor', 0, 'Bonnie7039421321+Bonnie+Jones', '', '', ''),
('22-11-23:3-6:bangor', 15, 18, 'bangor', 1, '', '', '', ''),
('22-11-23:6-9:bangor', 18, 21, 'bangor', 0, 'Natasha7034040029+Natasha+Jones', '', '', ''),
('22-11-23:9-12:bangor', 9, 12, 'bangor', 0, 'Linda7037358701+Linda+Jones', '', '', ''),
('22-11-24:12-3:bangor', 12, 15, 'bangor', 0, 'Shannon7039912298+Shannon+Jones*Hannah7036109735+Hannah+Jones', '', '', ''),
('22-11-24:3-6:bangor', 15, 18, 'bangor', 0, 'Cassandra7039445038+Cassandra+Jones*Nicole9176052094', '', '', ''),
('22-11-24:6-9:bangor', 18, 21, 'bangor', 1, '', '', '', ''),
('22-11-24:9-12:bangor', 9, 12, 'bangor', 0, 'Lura7039471915+Lura+Jones', '', '', ''),
('22-11-25:12-3:bangor', 12, 15, 'bangor', 0, 'Jane7038273452+Jane+Jones', '', '', ''),
('22-11-25:3-6:bangor', 15, 18, 'bangor', 0, 'Amanda7032051750+Amanda+Jones', '', '', ''),
('22-11-25:9-12:bangor', 9, 12, 'bangor', 0, 'Sara7036594431+Sara+Jones', '', '', ''),
('22-11-25:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-11-26:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('22-11-26:night:bangor', 0, 1, 'bangor', 0, '', '', '', ''),
('22-11-27:5-9:bangor', 17, 21, 'bangor', 0, '', '', '', ''),
('22-11-27:9-5:bangor', 9, 17, 'bangor', 0, '', '', '', ''),
('23-01-30:12-3:portland', 12, 15, 'portland', 0, 'Peter7037991786+Peter+Jones*Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-01-30:3-6:portland', 15, 18, 'portland', 0, 'Maureen7032100761+Maureen+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-01-30:6-9:portland', 18, 21, 'portland', 0, 'Vickie7033180302+Vickie+Jones*Estelle7037720647+Estelle+Jones', '', '', ''),
('23-01-30:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-01-31:12-3:portland', 12, 15, 'portland', 0, 'Mary Ann7038833212+Mary Ann+Jones*Gibbs7037474590+Gibbs+Jones', '', '', ''),
('23-01-31:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-01-31:6-9:portland', 18, 21, 'portland', 0, 'Josh7037124705+Josh+Jones*April7038075431+April+Jones', '', '', ''),
('23-01-31:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-02-01:12-3:portland', 12, 15, 'portland', 1, 'Ellen7037994830+Ellen+Jones', '', '', ''),
('23-02-01:3-6:portland', 15, 18, 'portland', 1, 'Nancy7034158150+Nancy+Jones', '', '', ''),
('23-02-01:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Lilly2158349209', '', '', ''),
('23-02-01:9-12:portland', 9, 12, 'portland', 0, 'Jeannie7037970345+Jeannie+Jones*Kym7037970345+Kym+Jones', '', '', ''),
('23-02-02:12-3:portland', 12, 15, 'portland', 0, 'Thorne7034439654+Thorne+Jones*Meg7037298111+Meg+Jones', '', '', ''),
('23-02-02:3-6:portland', 15, 18, 'portland', 0, 'Linda7037568845+Linda+Jones*Sue7033171877+Sue+Jones', '', '', ''),
('23-02-02:6-9:portland', 18, 21, 'portland', 0, 'Shay6175012425*Rebecca5185881836', '', '', ''),
('23-02-02:9-12:portland', 9, 12, 'portland', 2, '', '', '', ''),
('23-02-03:12-3:portland', 12, 15, 'portland', 1, 'Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-02-03:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Margi7034152255+Margi+Jones', '', '', ''),
('23-02-03:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-02-03:9-12:portland', 9, 12, 'portland', 1, 'Bobbi7033447417+Bobbi+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-02-03:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-02-04:1-4:portland', 13, 16, 'portland', 0, 'Beverly7038542682+Beverly+Jones', '', '', ''),
('23-02-04:10-1:portland', 10, 13, 'portland', 0, 'Nancy7036769033+Nancy+Jones*Beth7033399448+Beth+Jones*Rita7037998431+Rita+Jones', '', '', ''),
('23-02-04:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-02-05:2-5:portland', 14, 17, 'portland', 0, 'Mary7038293321+Mary+Jones', '', '', ''),
('23-02-05:5-9:portland', 17, 21, 'portland', 0, 'Paul7032323414+Paul+Jones', '', '', ''),
('23-02-05:9-12:portland', 9, 12, 'portland', 1, '', '', '', ''),
('23-02-06:12-3:portland', 12, 15, 'portland', 1, 'Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-02-06:3-6:portland', 15, 18, 'portland', 0, 'Robin7037510984+Robin+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-02-06:6-9:portland', 18, 21, 'portland', 1, 'Nonie7037812392+Nonie+Jones', '', '', ''),
('23-02-06:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-02-07:12-3:portland', 12, 15, 'portland', 1, 'Cindy7035631089+Cindy+Jones', '', '', ''),
('23-02-07:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-02-07:6-9:portland', 18, 21, 'portland', 0, 'Kara7035953232+Kara+Jones*Daniel7032330196+Daniel+Jones', '', '', ''),
('23-02-07:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-02-08:12-3:portland', 12, 15, 'portland', 1, 'John7032476256+John+Jones', '', '', ''),
('23-02-08:3-6:portland', 15, 18, 'portland', 0, 'Amy7037519944+Amy+Jones*Ann7038470375+Ann+Jones', '', '', ''),
('23-02-08:6-9:portland', 18, 21, 'portland', 0, 'Marilee7034159124+Marilee+Jones*Claudia7033181908+Claudia+Jones', '', '', ''),
('23-02-08:9-12:portland', 9, 12, 'portland', 0, 'Aynne7032328782+Aynne+Jones*Charlie7032728637+Charlie+Jones', '', '', ''),
('23-02-09:12-3:portland', 12, 15, 'portland', 1, 'Marjorie7032328434+Marjorie+Jones', '', '', ''),
('23-02-09:3-6:portland', 15, 18, 'portland', 0, 'Nancy7032210332+Nancy+Jones*Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-02-09:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Allyson7034410528+Allyson+Jones', '', '', ''),
('23-02-09:9-12:portland', 9, 12, 'portland', 0, 'Cathy7038784455+Cathy+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-02-10:12-3:portland', 12, 15, 'portland', 1, 'Ellen7034432810+Ellen+Jones', '', '', ''),
('23-02-10:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Elaine7037672928+Elaine+Jones', '', '', ''),
('23-02-10:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-02-10:9-12:portland', 9, 12, 'portland', 0, 'Sally7037993827+Sally+Jones*Becky7038463827+Becky+Jones', '', '', ''),
('23-02-10:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-02-11:1-4:portland', 13, 16, 'portland', 0, 'Susan7037817946+Susan+Jones', '', '', ''),
('23-02-11:10-1:portland', 10, 13, 'portland', 1, '', '', '', ''),
('23-02-11:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-02-12:2-5:portland', 14, 17, 'portland', 0, 'Chris7038788512+Chris+Jones', '', '', ''),
('23-02-12:5-9:portland', 17, 21, 'portland', 1, '', '', '', ''),
('23-02-12:9-12:portland', 9, 12, 'portland', 1, '', '', '', ''),
('23-02-13:12-3:portland', 12, 15, 'portland', 0, 'Peter7037991786+Peter+Jones*Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-02-13:3-6:portland', 15, 18, 'portland', 0, 'Maureen7032100761+Maureen+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-02-13:6-9:portland', 18, 21, 'portland', 0, 'Vickie7033180302+Vickie+Jones*Estelle7037720647+Estelle+Jones', '', '', ''),
('23-02-13:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-02-14:12-3:portland', 12, 15, 'portland', 0, 'Mary Ann7038833212+Mary Ann+Jones*Gibbs7037474590+Gibbs+Jones', '', '', ''),
('23-02-14:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-02-14:6-9:portland', 18, 21, 'portland', 0, 'Josh7037124705+Josh+Jones*April7038075431+April+Jones', '', '', ''),
('23-02-14:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-02-15:12-3:portland', 12, 15, 'portland', 1, 'Ellen7037994830+Ellen+Jones', '', '', ''),
('23-02-15:3-6:portland', 15, 18, 'portland', 1, 'Nancy7034158150+Nancy+Jones', '', '', ''),
('23-02-15:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Lilly2158349209', '', '', ''),
('23-02-15:9-12:portland', 9, 12, 'portland', 0, 'Jeannie7037970345+Jeannie+Jones*Kym7037970345+Kym+Jones', '', '', ''),
('23-02-16:12-3:portland', 12, 15, 'portland', 0, 'Thorne7034439654+Thorne+Jones*Meg7037298111+Meg+Jones', '', '', ''),
('23-02-16:3-6:portland', 15, 18, 'portland', 0, 'Linda7037568845+Linda+Jones*Sue7033171877+Sue+Jones', '', '', ''),
('23-02-16:6-9:portland', 18, 21, 'portland', 0, 'Shay6175012425*Rebecca5185881836', '', '', ''),
('23-02-16:9-12:portland', 9, 12, 'portland', 2, '', '', '', ''),
('23-02-17:12-3:portland', 12, 15, 'portland', 1, 'Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-02-17:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Margi7034152255+Margi+Jones', '', '', ''),
('23-02-17:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-02-17:9-12:portland', 9, 12, 'portland', 1, 'Bobbi7033447417+Bobbi+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-02-17:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-02-18:1-4:portland', 13, 16, 'portland', 1, '', '', '', ''),
('23-02-18:10-1:portland', 10, 13, 'portland', 1, '', '', '', ''),
('23-02-18:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-02-19:2-5:portland', 14, 17, 'portland', 0, 'Lance7032528780+Lance+Jones*Melissa7036501479+Melissa+Jones', '', '', ''),
('23-02-19:5-9:portland', 17, 21, 'portland', 1, '', '', '', ''),
('23-02-19:9-12:portland', 9, 12, 'portland', 1, '', '', '', ''),
('23-02-20:12-3:portland', 12, 15, 'portland', 1, 'Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-02-20:3-6:portland', 15, 18, 'portland', 0, 'Robin7037510984+Robin+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-02-20:6-9:portland', 18, 21, 'portland', 1, 'Nonie7037812392+Nonie+Jones', '', '', ''),
('23-02-20:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-02-21:12-3:portland', 12, 15, 'portland', 1, 'Cindy7035631089+Cindy+Jones', '', '', ''),
('23-02-21:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-02-21:6-9:portland', 18, 21, 'portland', 0, 'Kara7035953232+Kara+Jones*Daniel7032330196+Daniel+Jones', '', '', ''),
('23-02-21:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-02-22:12-3:portland', 12, 15, 'portland', 1, 'John7032476256+John+Jones', '', '', ''),
('23-02-22:3-6:portland', 15, 18, 'portland', 0, 'Amy7037519944+Amy+Jones*Ann7038470375+Ann+Jones', '', '', ''),
('23-02-22:6-9:portland', 18, 21, 'portland', 0, 'Marilee7034159124+Marilee+Jones*Claudia7033181908+Claudia+Jones', '', '', ''),
('23-02-22:9-12:portland', 9, 12, 'portland', 0, 'Aynne7032328782+Aynne+Jones*Charlie7032728637+Charlie+Jones', '', '', ''),
('23-02-23:12-3:portland', 12, 15, 'portland', 1, 'Marjorie7032328434+Marjorie+Jones', '', '', ''),
('23-02-23:3-6:portland', 15, 18, 'portland', 0, 'Nancy7032210332+Nancy+Jones*Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-02-23:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Allyson7034410528+Allyson+Jones', '', '', ''),
('23-02-23:9-12:portland', 9, 12, 'portland', 0, 'Cathy7038784455+Cathy+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-02-24:12-3:portland', 12, 15, 'portland', 1, 'Ellen7034432810+Ellen+Jones', '', '', ''),
('23-02-24:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Elaine7037672928+Elaine+Jones', '', '', ''),
('23-02-24:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-02-24:9-12:portland', 9, 12, 'portland', 0, 'Sally7037993827+Sally+Jones*Becky7038463827+Becky+Jones', '', '', ''),
('23-02-24:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-02-25:1-4:portland', 13, 16, 'portland', 1, '', '', '', ''),
('23-02-25:10-1:portland', 10, 13, 'portland', 1, '', '', '', ''),
('23-02-25:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-02-26:2-5:portland', 14, 17, 'portland', 1, '', '', '', ''),
('23-02-26:5-9:portland', 17, 21, 'portland', 1, '', '', '', ''),
('23-02-26:9-12:portland', 9, 12, 'portland', 0, 'Gaye7032476985+Gaye+Jones', '', '', ''),
('23-02-27:12-3:portland', 12, 15, 'portland', 0, 'Peter7037991786+Peter+Jones*Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-02-27:3-6:portland', 15, 18, 'portland', 0, 'Maureen7032100761+Maureen+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-02-27:6-9:portland', 18, 21, 'portland', 0, 'Vickie7033180302+Vickie+Jones*Estelle7037720647+Estelle+Jones', '', '', ''),
('23-02-27:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-02-28:12-3:portland', 12, 15, 'portland', 0, 'Mary Ann7038833212+Mary Ann+Jones*Gibbs7037474590+Gibbs+Jones', '', '', ''),
('23-02-28:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-02-28:6-9:portland', 18, 21, 'portland', 0, 'Josh7037124705+Josh+Jones*April7038075431+April+Jones', '', '', ''),
('23-02-28:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-03-01:12-3:portland', 12, 15, 'portland', 1, 'Ellen7037994830+Ellen+Jones', '', '', ''),
('23-03-01:3-6:portland', 15, 18, 'portland', 1, 'Nancy7034158150+Nancy+Jones', '', '', ''),
('23-03-01:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Lilly2158349209', '', '', ''),
('23-03-01:9-12:portland', 9, 12, 'portland', 0, 'Jeannie7037970345+Jeannie+Jones*Kym7037970345+Kym+Jones', '', '', ''),
('23-03-02:12-3:portland', 12, 15, 'portland', 0, 'Thorne7034439654+Thorne+Jones*Meg7037298111+Meg+Jones', '', '', ''),
('23-03-02:3-6:portland', 15, 18, 'portland', 0, 'Linda7037568845+Linda+Jones*Sue7033171877+Sue+Jones', '', '', ''),
('23-03-02:6-9:portland', 18, 21, 'portland', 0, 'Shay6175012425*Rebecca5185881836', '', '', ''),
('23-03-02:9-12:portland', 9, 12, 'portland', 2, '', '', '', ''),
('23-03-03:12-3:portland', 12, 15, 'portland', 1, 'Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-03-03:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Margi7034152255+Margi+Jones', '', '', ''),
('23-03-03:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-03-03:9-12:portland', 9, 12, 'portland', 1, 'Bobbi7033447417+Bobbi+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-03-03:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-03-04:1-4:portland', 13, 16, 'portland', 0, 'Beverly7038542682+Beverly+Jones', '', '', ''),
('23-03-04:10-1:portland', 10, 13, 'portland', 0, 'Nancy7036769033+Nancy+Jones*Beth7033399448+Beth+Jones*Rita7037998431+Rita+Jones', '', '', ''),
('23-03-04:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-03-05:2-5:portland', 14, 17, 'portland', 0, 'Mary7038293321+Mary+Jones', '', '', ''),
('23-03-05:5-9:portland', 17, 21, 'portland', 0, 'Paul7032323414+Paul+Jones', '', '', ''),
('23-03-05:9-12:portland', 9, 12, 'portland', 1, '', '', '', ''),
('23-03-06:12-3:portland', 12, 15, 'portland', 1, 'Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-03-06:3-6:portland', 15, 18, 'portland', 0, 'Robin7037510984+Robin+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-03-06:6-9:portland', 18, 21, 'portland', 1, 'Nonie7037812392+Nonie+Jones', '', '', ''),
('23-03-06:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-03-07:12-3:portland', 12, 15, 'portland', 1, 'Cindy7035631089+Cindy+Jones', '', '', ''),
('23-03-07:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-03-07:6-9:portland', 18, 21, 'portland', 0, 'Kara7035953232+Kara+Jones*Daniel7032330196+Daniel+Jones', '', '', ''),
('23-03-07:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-03-08:12-3:portland', 12, 15, 'portland', 1, 'John7032476256+John+Jones', '', '', ''),
('23-03-08:3-6:portland', 15, 18, 'portland', 0, 'Amy7037519944+Amy+Jones*Ann7038470375+Ann+Jones', '', '', ''),
('23-03-08:6-9:portland', 18, 21, 'portland', 0, 'Marilee7034159124+Marilee+Jones*Claudia7033181908+Claudia+Jones', '', '', ''),
('23-03-08:9-12:portland', 9, 12, 'portland', 0, 'Aynne7032328782+Aynne+Jones*Charlie7032728637+Charlie+Jones', '', '', ''),
('23-03-09:12-3:portland', 12, 15, 'portland', 1, 'Marjorie7032328434+Marjorie+Jones', '', '', ''),
('23-03-09:3-6:portland', 15, 18, 'portland', 0, 'Nancy7032210332+Nancy+Jones*Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-03-09:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Allyson7034410528+Allyson+Jones', '', '', ''),
('23-03-09:9-12:portland', 9, 12, 'portland', 0, 'Cathy7038784455+Cathy+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-03-10:12-3:portland', 12, 15, 'portland', 1, 'Ellen7034432810+Ellen+Jones', '', '', ''),
('23-03-10:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Elaine7037672928+Elaine+Jones', '', '', ''),
('23-03-10:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-03-10:9-12:portland', 9, 12, 'portland', 0, 'Sally7037993827+Sally+Jones*Becky7038463827+Becky+Jones', '', '', ''),
('23-03-10:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-03-11:1-4:portland', 13, 16, 'portland', 0, 'Susan7037817946+Susan+Jones', '', '', ''),
('23-03-11:10-1:portland', 10, 13, 'portland', 1, '', '', '', ''),
('23-03-11:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-03-12:2-5:portland', 14, 17, 'portland', 0, 'Chris7038788512+Chris+Jones', '', '', ''),
('23-03-12:5-9:portland', 17, 21, 'portland', 1, '', '', '', ''),
('23-03-12:9-12:portland', 9, 12, 'portland', 1, '', '', '', ''),
('23-03-13:12-3:portland', 12, 15, 'portland', 0, 'Peter7037991786+Peter+Jones*Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-03-13:3-6:portland', 15, 18, 'portland', 0, 'Maureen7032100761+Maureen+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-03-13:6-9:portland', 18, 21, 'portland', 0, 'Vickie7033180302+Vickie+Jones*Estelle7037720647+Estelle+Jones', '', '', ''),
('23-03-13:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-03-14:12-3:portland', 12, 15, 'portland', 0, 'Mary Ann7038833212+Mary Ann+Jones*Gibbs7037474590+Gibbs+Jones', '', '', ''),
('23-03-14:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-03-14:6-9:portland', 18, 21, 'portland', 0, 'Josh7037124705+Josh+Jones*April7038075431+April+Jones', '', '', ''),
('23-03-14:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-03-15:12-3:portland', 12, 15, 'portland', 1, 'Ellen7037994830+Ellen+Jones', '', '', ''),
('23-03-15:3-6:portland', 15, 18, 'portland', 1, 'Nancy7034158150+Nancy+Jones', '', '', ''),
('23-03-15:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Lilly2158349209', '', '', ''),
('23-03-15:9-12:portland', 9, 12, 'portland', 0, 'Jeannie7037970345+Jeannie+Jones*Kym7037970345+Kym+Jones', '', '', ''),
('23-03-16:12-3:portland', 12, 15, 'portland', 0, 'Thorne7034439654+Thorne+Jones*Meg7037298111+Meg+Jones', '', '', ''),
('23-03-16:3-6:portland', 15, 18, 'portland', 0, 'Linda7037568845+Linda+Jones*Sue7033171877+Sue+Jones', '', '', ''),
('23-03-16:6-9:portland', 18, 21, 'portland', 0, 'Shay6175012425*Rebecca5185881836', '', '', ''),
('23-03-16:9-12:portland', 9, 12, 'portland', 2, '', '', '', ''),
('23-03-17:12-3:portland', 12, 15, 'portland', 1, 'Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-03-17:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Margi7034152255+Margi+Jones', '', '', ''),
('23-03-17:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-03-17:9-12:portland', 9, 12, 'portland', 1, 'Bobbi7033447417+Bobbi+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-03-17:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-03-18:1-4:portland', 13, 16, 'portland', 1, '', '', '', ''),
('23-03-18:10-1:portland', 10, 13, 'portland', 1, '', '', '', ''),
('23-03-18:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-03-19:2-5:portland', 14, 17, 'portland', 0, 'Lance7032528780+Lance+Jones*Melissa7036501479+Melissa+Jones', '', '', ''),
('23-03-19:5-9:portland', 17, 21, 'portland', 1, '', '', '', ''),
('23-03-19:9-12:portland', 9, 12, 'portland', 1, '', '', '', ''),
('23-03-20:12-3:portland', 12, 15, 'portland', 1, 'Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-03-20:3-6:portland', 15, 18, 'portland', 0, 'Robin7037510984+Robin+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-03-20:6-9:portland', 18, 21, 'portland', 1, 'Nonie7037812392+Nonie+Jones', '', '', ''),
('23-03-20:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-03-21:12-3:portland', 12, 15, 'portland', 1, 'Cindy7035631089+Cindy+Jones', '', '', ''),
('23-03-21:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-03-21:6-9:portland', 18, 21, 'portland', 0, 'Kara7035953232+Kara+Jones*Daniel7032330196+Daniel+Jones', '', '', ''),
('23-03-21:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-03-22:12-3:portland', 12, 15, 'portland', 1, 'John7032476256+John+Jones', '', '', ''),
('23-03-22:3-6:portland', 15, 18, 'portland', 0, 'Amy7037519944+Amy+Jones*Ann7038470375+Ann+Jones', '', '', ''),
('23-03-22:6-9:portland', 18, 21, 'portland', 0, 'Marilee7034159124+Marilee+Jones*Claudia7033181908+Claudia+Jones', '', '', ''),
('23-03-22:9-12:portland', 9, 12, 'portland', 0, 'Aynne7032328782+Aynne+Jones*Charlie7032728637+Charlie+Jones', '', '', ''),
('23-03-23:12-3:portland', 12, 15, 'portland', 1, 'Marjorie7032328434+Marjorie+Jones', '', '', ''),
('23-03-23:3-6:portland', 15, 18, 'portland', 0, 'Nancy7032210332+Nancy+Jones*Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-03-23:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Allyson7034410528+Allyson+Jones', '', '', ''),
('23-03-23:9-12:portland', 9, 12, 'portland', 0, 'Cathy7038784455+Cathy+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-03-24:12-3:portland', 12, 15, 'portland', 1, 'Ellen7034432810+Ellen+Jones', '', '', ''),
('23-03-24:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Elaine7037672928+Elaine+Jones', '', '', ''),
('23-03-24:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-03-24:9-12:portland', 9, 12, 'portland', 0, 'Sally7037993827+Sally+Jones*Becky7038463827+Becky+Jones', '', '', ''),
('23-03-24:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-03-25:1-4:portland', 13, 16, 'portland', 1, '', '', '', ''),
('23-03-25:10-1:portland', 10, 13, 'portland', 1, '', '', '', ''),
('23-03-25:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-03-26:2-5:portland', 14, 17, 'portland', 1, '', '', '', ''),
('23-03-26:5-9:portland', 17, 21, 'portland', 1, '', '', '', ''),
('23-03-26:9-12:portland', 9, 12, 'portland', 0, 'Gaye7032476985+Gaye+Jones', '', '', ''),
('23-03-27:12-3:portland', 12, 15, 'portland', 0, 'Peter7037991786+Peter+Jones*Cheryl7038089589+Cheryl+Jones', '', '', ''),
('23-03-27:3-6:portland', 15, 18, 'portland', 0, 'Maureen7032100761+Maureen+Jones*Claire7033293465+Claire+Jones', '', '', ''),
('23-03-27:6-9:portland', 18, 21, 'portland', 0, 'Vickie7033180302+Vickie+Jones*Estelle7037720647+Estelle+Jones', '', '', ''),
('23-03-27:9-12:portland', 9, 12, 'portland', 0, 'Jane7038293469+Jane+Jones*Cathy7038295422+Cathy+Jones*Cheryl7032821358+Cheryl+Jones', '', '', ''),
('23-03-28:12-3:portland', 12, 15, 'portland', 0, 'Mary Ann7038833212+Mary Ann+Jones*Gibbs7037474590+Gibbs+Jones', '', '', ''),
('23-03-28:3-6:portland', 15, 18, 'portland', 0, 'Becky7037725009*Betsy7038464935+Betsy+Jones', '', '', ''),
('23-03-28:6-9:portland', 18, 21, 'portland', 0, 'Josh7037124705+Josh+Jones*April7038075431+April+Jones', '', '', ''),
('23-03-28:9-12:portland', 9, 12, 'portland', 0, 'Jane7038859127*Stacey7032333522+Stacey+Jones', '', '', ''),
('23-03-29:12-3:portland', 12, 15, 'portland', 1, 'Ellen7037994830+Ellen+Jones', '', '', ''),
('23-03-29:3-6:portland', 15, 18, 'portland', 1, 'Nancy7034158150+Nancy+Jones', '', '', ''),
('23-03-29:6-9:portland', 18, 21, 'portland', 0, 'Jody7033294089+Jody+Jones*Lilly2158349209', '', '', ''),
('23-03-29:9-12:portland', 9, 12, 'portland', 0, 'Jeannie7037970345+Jeannie+Jones*Kym7037970345+Kym+Jones', '', '', ''),
('23-03-30:12-3:portland', 12, 15, 'portland', 0, 'Thorne7034439654+Thorne+Jones*Meg7037298111+Meg+Jones', '', '', ''),
('23-03-30:3-6:portland', 15, 18, 'portland', 0, 'Linda7037568845+Linda+Jones*Sue7033171877+Sue+Jones', '', '', ''),
('23-03-30:6-9:portland', 18, 21, 'portland', 0, 'Shay6175012425*Rebecca5185881836', '', '', ''),
('23-03-30:9-12:portland', 9, 12, 'portland', 2, '', '', '', ''),
('23-03-31:12-3:portland', 12, 15, 'portland', 1, 'Suzanne7037018778+Suzanne+Jones', '', '', ''),
('23-03-31:3-6:portland', 15, 18, 'portland', 1, 'Phyllis7032325963*Margi7034152255+Margi+Jones', '', '', ''),
('23-03-31:6-9:portland', 18, 21, 'portland', 0, '', '', '', ''),
('23-03-31:9-12:portland', 9, 12, 'portland', 1, 'Bobbi7033447417+Bobbi+Jones*Meg7039395058+Meg+Jones', '', '', ''),
('23-03-31:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-04-01:1-4:portland', 13, 16, 'portland', 0, 'Beverly7038542682+Beverly+Jones', '', '', ''),
('23-04-01:10-1:portland', 10, 13, 'portland', 0, 'Nancy7036769033+Nancy+Jones*Beth7033399448+Beth+Jones*Rita7037998431+Rita+Jones', '', '', ''),
('23-04-01:night:portland', 0, 1, 'portland', 1, '', '', '', ''),
('23-04-02:2-5:portland', 14, 17, 'portland', 0, 'Mary7038293321+Mary+Jones', '', '', ''),
('23-04-02:5-9:portland', 17, 21, 'portland', 0, 'Paul7032323414+Paul+Jones', '', '', ''),
('23-04-02:9-12:portland', 9, 12, 'portland', 1, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `dbweeks`
--

CREATE TABLE `dbweeks` (
  `id` char(20) NOT NULL,
  `dates` text,
  `venue` text,
  `status` text,
  `name` text,
  `end` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbweeks`
--

INSERT INTO `dbweeks` (`id`, `dates`, `venue`, `status`, `name`, `end`) VALUES
('22-10-24:bangor', '22-10-24:bangor*22-10-25:bangor*22-10-26:bangor*22-10-27:bangor*22-10-28:bangor*22-10-29:bangor*22-10-30:bangor', 'bangor', 'published', 'October 24, 2022 to October 30, 2022', 1667174399),
('22-10-31:bangor', '22-10-31:bangor*22-11-01:bangor*22-11-02:bangor*22-11-03:bangor*22-11-04:bangor*22-11-05:bangor*22-11-06:bangor', 'bangor', 'published', 'October 31, 2022 to November 6, 2022', 1667779199),
('22-11-07:bangor', '22-11-07:bangor*22-11-08:bangor*22-11-09:bangor*22-11-10:bangor*22-11-11:bangor*22-11-12:bangor*22-11-13:bangor', 'bangor', 'published', 'November 7, 2022 to November 13, 2022', 1668383999),
('22-11-14:bangor', '22-11-14:bangor*22-11-15:bangor*22-11-16:bangor*22-11-17:bangor*22-11-18:bangor*22-11-19:bangor*22-11-20:bangor', 'bangor', 'published', 'November 14, 2022 to November 20, 2022', 1668988799),
('22-11-21:bangor', '22-11-21:bangor*22-11-22:bangor*22-11-23:bangor*22-11-24:bangor*22-11-25:bangor*22-11-26:bangor*22-11-27:bangor', 'bangor', 'published', 'November 21, 2022 to November 27, 2022', 1669593599),
('23-01-30:portland', '23-01-30:portland*23-01-31:portland*23-02-01:portland*23-02-02:portland*23-02-03:portland*23-02-04:portland*23-02-05:portland', 'portland', 'archived', 'January 30, 2023 to February 5, 2023', 1675637999),
('23-02-06:portland', '23-02-06:portland*23-02-07:portland*23-02-08:portland*23-02-09:portland*23-02-10:portland*23-02-11:portland*23-02-12:portland', 'portland', 'archived', 'February 6, 2023 to February 12, 2023', 1676242799),
('23-02-13:portland', '23-02-13:portland*23-02-14:portland*23-02-15:portland*23-02-16:portland*23-02-17:portland*23-02-18:portland*23-02-19:portland', 'portland', 'archived', 'February 13, 2023 to February 19, 2023', 1676847599),
('23-02-20:portland', '23-02-20:portland*23-02-21:portland*23-02-22:portland*23-02-23:portland*23-02-24:portland*23-02-25:portland*23-02-26:portland', 'portland', 'archived', 'February 20, 2023 to February 26, 2023', 1677452399),
('23-02-27:portland', '23-02-27:portland*23-02-28:portland*23-03-01:portland*23-03-02:portland*23-03-03:portland*23-03-04:portland*23-03-05:portland', 'portland', 'published', 'February 27, 2023 to March 5, 2023', 1678057199),
('23-03-06:portland', '23-03-06:portland*23-03-07:portland*23-03-08:portland*23-03-09:portland*23-03-10:portland*23-03-11:portland*23-03-12:portland', 'portland', 'published', 'March 6, 2023 to March 12, 2023', 1678661999),
('23-03-13:portland', '23-03-13:portland*23-03-14:portland*23-03-15:portland*23-03-16:portland*23-03-17:portland*23-03-18:portland*23-03-19:portland', 'portland', 'published', 'March 13, 2023 to March 19, 2023', 1679266799),
('23-03-20:portland', '23-03-20:portland*23-03-21:portland*23-03-22:portland*23-03-23:portland*23-03-24:portland*23-03-25:portland*23-03-26:portland', 'portland', 'published', 'March 20, 2023 to March 26, 2023', 1679867999),
('23-03-27:portland', '23-03-27:portland*23-03-28:portland*23-03-29:portland*23-03-30:portland*23-03-31:portland*23-04-01:portland*23-04-02:portland', 'portland', 'published', 'March 27, 2023 to April 2, 2023', 1680472799);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbdates`
--
ALTER TABLE `dbdates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbEventMedia`
--
ALTER TABLE `dbEventMedia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKeventID2` (`eventID`);

--
-- Indexes for table `dbEvents`
--
ALTER TABLE `dbEvents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbEventVolunteers`
--
ALTER TABLE `dbEventVolunteers`
  ADD KEY `FKeventID` (`eventID`),
  ADD KEY `FKpersonID` (`userID`);

--
-- Indexes for table `dbLog`
--
ALTER TABLE `dbLog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbPersons`
--
ALTER TABLE `dbPersons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbscl`
--
ALTER TABLE `dbscl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbshifts`
--
ALTER TABLE `dbshifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbweeks`
--
ALTER TABLE `dbweeks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbEventMedia`
--
ALTER TABLE `dbEventMedia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `dbEvents`
--
ALTER TABLE `dbEvents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `dbLog`
--
ALTER TABLE `dbLog`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dbEventMedia`
--
ALTER TABLE `dbEventMedia`
  ADD CONSTRAINT `FKeventID2` FOREIGN KEY (`eventID`) REFERENCES `dbEvents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dbEventVolunteers`
--
ALTER TABLE `dbEventVolunteers`
  ADD CONSTRAINT `FKeventID` FOREIGN KEY (`eventID`) REFERENCES `dbEvents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FKpersonID` FOREIGN KEY (`userID`) REFERENCES `dbPersons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
