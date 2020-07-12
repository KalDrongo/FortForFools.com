-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 11, 2020 at 05:30 PM
-- Server version: 10.2.32-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garrettf_FfF`
--

-- --------------------------------------------------------

--
-- Table structure for table `IMAGES`
--

CREATE TABLE `IMAGES` (
  `IMG_ID` int(11) NOT NULL,
  `IMG_LOCATION` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `POSTS`
--

CREATE TABLE `POSTS` (
  `POST_ID` int(11) NOT NULL,
  `POST_TITLE` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `POST_TIME_UPDATED` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SECTIONS`
--

CREATE TABLE `SECTIONS` (
  `SEC_ID` int(11) NOT NULL,
  `POST_ID` int(11) NOT NULL,
  `SEC_TEXT` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SECTIONS_WITH_IMAGES`
--

CREATE TABLE `SECTIONS_WITH_IMAGES` (
  `SEC_ID` int(11) NOT NULL,
  `IMG_ID` int(11) NOT NULL,
  `IMG_ORDER_NUM` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TAGGED_POSTS`
--

CREATE TABLE `TAGGED_POSTS` (
  `POST_ID` int(11) NOT NULL,
  `TAG_ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TAGS`
--

CREATE TABLE `TAGS` (
  `TAG_ID` int(11) NOT NULL,
  `TAG_NAME` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `IMAGES`
--
ALTER TABLE `IMAGES`
  ADD PRIMARY KEY (`IMG_ID`),
  ADD UNIQUE KEY `IMG_ID` (`IMG_ID`);

--
-- Indexes for table `POSTS`
--
ALTER TABLE `POSTS`
  ADD PRIMARY KEY (`POST_ID`),
  ADD UNIQUE KEY `POST_ID` (`POST_ID`);

--
-- Indexes for table `SECTIONS`
--
ALTER TABLE `SECTIONS`
  ADD PRIMARY KEY (`SEC_ID`),
  ADD UNIQUE KEY `SEC_ID` (`SEC_ID`),
  ADD KEY `POST_ID` (`POST_ID`);

--
-- Indexes for table `SECTIONS_WITH_IMAGES`
--
ALTER TABLE `SECTIONS_WITH_IMAGES`
  ADD PRIMARY KEY (`SEC_ID`,`IMG_ID`),
  ADD KEY `IMG_ID` (`IMG_ID`);

--
-- Indexes for table `TAGGED_POSTS`
--
ALTER TABLE `TAGGED_POSTS`
  ADD PRIMARY KEY (`POST_ID`,`TAG_ID`),
  ADD KEY `TAG_ID` (`TAG_ID`);

--
-- Indexes for table `TAGS`
--
ALTER TABLE `TAGS`
  ADD PRIMARY KEY (`TAG_ID`),
  ADD UNIQUE KEY `TAG_ID` (`TAG_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `IMAGES`
--
ALTER TABLE `IMAGES`
  MODIFY `IMG_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `POSTS`
--
ALTER TABLE `POSTS`
  MODIFY `POST_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SECTIONS`
--
ALTER TABLE `SECTIONS`
  MODIFY `SEC_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TAGS`
--
ALTER TABLE `TAGS`
  MODIFY `TAG_ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
