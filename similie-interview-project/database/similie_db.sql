-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2020 at 09:40 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `similie_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `an_name` varchar(100) NOT NULL,
  `an_type` varchar(100) NOT NULL,
  `lat` float NOT NULL,
  `lng` float(10,6) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(200) NOT NULL,
  `dateEdit` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `an_name`, `an_type`, `lat`, `lng`, `image`, `description`, `dateEdit`, `username`) VALUES
(12, 'Eagle 505', 'Birds', 9.06497, 61.139297, 'images/764_Rabbit.png', 'Good', '2020-01-31 20:03:21', 'ss'),
(14, 'Eagle one', 'Rabbits', 67.0649, -68.139297, 'images/511_Rabbit.png', 'the nice Rabbit', '2020-01-31 20:06:06', 'ss'),
(15, 'Eagle one', 'Birds', 3.0649, -8.139297, 'images/126_birds.png', 'the flying eagle', '2020-01-31 20:05:06', 'ss'),
(17, 'Bears', 'Bears', 9.06567, 45.139297, 'images/361_bears3s.png', 'good', '2020-01-31 20:02:31', 'ss');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  `Fullname` varchar(160) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Passwords` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `Fullname`, `Username`, `Passwords`) VALUES
(2, 'Eric k. Gloto', 'abc', '$2y$10$fny5vHYEcopCI1F1ea4lZOn9lw5vZoHv1OOhD0DoZFOb9xtbqVz.y'),
(6, 'Moses Davies', 'ss', '$2y$10$092mv2qX/BgrOuAnm3y6SeBDnsIqvk3X.zwsviRLykQNADkcF92rq'),
(7, 'MohEric', 'aa', '$2y$10$R4CAkm1cpent73jGvPqH4OWHpMMNUxr/c2ATmF56GRDw6NCXX3gPy'),
(8, 'Eric k. Gloto', 'admin', '$2y$10$VHcBWfrlt8u665vNNlL8t.MM848two.THTwp71u/s9/jOhP6Ageka');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
