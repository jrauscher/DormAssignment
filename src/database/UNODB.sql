-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2014 at 09:00 PM
-- Server version: 5.5.40
-- PHP Version: 5.3.10-1ubuntu3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `UNODB`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pwd_reset` int(1) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `bench`
--

CREATE TABLE IF NOT EXISTS `bench` (
  `bench_id` int(10) unsigned NOT NULL,
  `student_id` int(100) unsigned NOT NULL,
  `query1` varchar(100) NOT NULL,
  `query2` varchar(100) NOT NULL,
  PRIMARY KEY (`bench_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE IF NOT EXISTS `building` (
  `build_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `building_name` varchar(50) NOT NULL,
  `building_letter` varchar(3) NOT NULL,
  `campus` varchar(10) NOT NULL,
  `num_rooms` int(10) NOT NULL,
  `floor` int(10) NOT NULL,
  `lease` int(10) NOT NULL,
  `RA_rooms` int(10) NOT NULL,
  `handicapped_rooms` int(10) NOT NULL,
  `complex` int(10) NOT NULL,
  PRIMARY KEY (`build_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `form_settings`
--

CREATE TABLE IF NOT EXISTS `form_settings` (
  `form_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_name` varchar(50) NOT NULL,
  `deadline_date` date NOT NULL,
  `warning_date` date NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(10) unsigned NOT NULL,
  `build_id` int(10) unsigned NOT NULL,
  `room_num` int(10) unsigned NOT NULL,
  `student_id_1` int(100) unsigned NOT NULL,
  `student_id_2` int(100) unsigned NOT NULL,
  `student_id_3` int(100) unsigned NOT NULL,
  `student_id_4` int(100) unsigned NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `room_num` int(10) unsigned NOT NULL,
  `build_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `num_students` int(10) NOT NULL,
  `floor` int(10) NOT NULL,
  `gender` int(1) NOT NULL,
  `smoking` int(1) NOT NULL,
  `RA_Room` int(10) NOT NULL,
  `HC_Room` int(10) NOT NULL,
  PRIMARY KEY (`room_num`,`build_id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room_available_que`
--

CREATE TABLE IF NOT EXISTS `room_available_que` (
  `student_id` int(100) unsigned NOT NULL,
  `date` date NOT NULL,
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `room_letter`
--

CREATE TABLE IF NOT EXISTS `room_letter` (
  `room_num` int(10) unsigned NOT NULL,
  `build_id` int(10) unsigned NOT NULL,
  `student_id` int(100) unsigned NOT NULL,
  `letter` varchar(10) NOT NULL,
  PRIMARY KEY (`room_num`,`build_id`,`letter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int(100) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `room_num` int(10) unsigned NOT NULL,
  `build_id` int(10) unsigned NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL,
  `birthdate` date NOT NULL,
  `cell_phone` int(10) NOT NULL,
  `home_phone` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `age` int(10) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` int(10) NOT NULL,
  `lease` int(10) NOT NULL,
  `renewal` int(1) NOT NULL,
  `sub_date` date NOT NULL,
  `scott_scholar` int(1) NOT NULL,
  `desired_roommate1` varchar(80) NOT NULL,
  `desired_roommate2` varchar(80) NOT NULL,
  `desired_roommate3` varchar(80) NOT NULL,
  `desired_roommate1_ph` int(10) NOT NULL,
  `desired_roommate2_ph` int(10) NOT NULL,
  `desired_roommate3_ph` int(10) NOT NULL,
  `grade_lvl` int(10) NOT NULL,
  `enrolled_college` varchar(50) NOT NULL,
  `enrolled_department` varchar(50) NOT NULL,
  `cleanliness` int(10) NOT NULL,
  `noise` int(10) NOT NULL,
  `guest_sleeping` int(10) NOT NULL,
  `share_belongings` int(10) NOT NULL,
  `bed_time` time NOT NULL,
  `wakeup_time` time NOT NULL,
  `gathering` int(10) NOT NULL,
  `drink_alchohol` int(10) NOT NULL,
  `others_drink` int(10) NOT NULL,
  `smoking` int(10) NOT NULL,
  `others_smoking` int(10) NOT NULL,
  `noise_rating` int(10) NOT NULL,
  `cleanliness_rating` int(10) NOT NULL,
  `lifestyle_rating` int(10) NOT NULL,
  `age_rating` int(10) NOT NULL,
  `major_rating` int(10) NOT NULL,
  `guest_rating` int(10) NOT NULL,
  `comments` varchar(500) NOT NULL,
  `comments_resolved` int(1) NOT NULL,
  `req_room_num` int(10) NOT NULL,
  `req_bedroom_letter` int(11) NOT NULL,
  `req_build_id` int(100) NOT NULL,
  PRIMARY KEY (`student_id`),
  KEY `group_id` (`group_id`),
  KEY `room_num` (`room_num`),
  KEY `build_id` (`build_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `student_id` int(100) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pwd_reset` int(1) NOT NULL,
  `needs_email` int(1) NOT NULL,
  `form_completion` int(1) NOT NULL,
  `building_name` varchar(50) NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `room_available_que`
--
ALTER TABLE `room_available_que`
  ADD CONSTRAINT `room_available_que_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
