-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2023 at 07:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE `clinic` (
  `ID` int(11) NOT NULL,
  `Hospital_Receiving` varchar(40) DEFAULT NULL,
  `Transportation` varchar(20) DEFAULT NULL,
  `Blood_num` int(11) DEFAULT NULL,
  `Location` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clinic`
--

INSERT INTO `clinic` (`ID`, `Hospital_Receiving`, `Transportation`, `Blood_num`, `Location`) VALUES
(0, 'St. Joseph Mercy', NULL, 0, '1000 Clinic Dr, Ypsilanti, MI 48197'),
(100000000, 'University of Michigan Hostpital', NULL, 1000, '1500 E Medical Center Dr, Ann Arbor, MI 48109');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `ID` int(11) NOT NULL,
  `Blood_type` varchar(3) DEFAULT NULL,
  `History` varchar(100) DEFAULT NULL,
  `Date_Donated` date DEFAULT NULL,
  `First_Name` varchar(25) DEFAULT NULL,
  `Last_Name` varchar(25) DEFAULT NULL,
  `Donated_Clinic` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`ID`, `Blood_type`, `History`, `Date_Donated`, `First_Name`, `Last_Name`, `Donated_Clinic`) VALUES
(4893478, 'A', 'No History', '2023-11-09', 'Mr.', 'Darcy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `SSN` int(11) NOT NULL,
  `Location_ID` int(11) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `Title` varchar(20) DEFAULT NULL,
  `First_Name` varchar(25) DEFAULT NULL,
  `Last_Name` varchar(25) DEFAULT NULL,
  `Username` varchar(30) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`SSN`, `Location_ID`, `Email`, `Title`, `First_Name`, `Last_Name`, `Username`, `Password`) VALUES
(5000000, NULL, NULL, NULL, 'First', 'Last', 'user', '$2y$10$atOBMRC2VZVPcMef4zoFEuS17AMpT2gteqF.RHLTod3GW1NOdiX26'),
(100000000, NULL, 'mary@gmail.com', NULL, 'Mary', 'Jane', 'user7', '$2y$10$BCYnSxYe9XT2r46UNZ4q.edfFrQ348fz/kEMm3OwI8JiA0m8awkZC');

-- --------------------------------------------------------

--
-- Table structure for table `receiver`
--

CREATE TABLE `receiver` (
  `ID` int(11) NOT NULL,
  `Blood_type` varchar(3) DEFAULT NULL,
  `History` varchar(100) DEFAULT NULL,
  `Date_Received` date DEFAULT NULL,
  `First_Name` varchar(25) DEFAULT NULL,
  `Last_Name` varchar(25) DEFAULT NULL,
  `Received_from` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clinic`
--
ALTER TABLE `clinic`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Donated_Clinic` (`Donated_Clinic`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`SSN`),
  ADD KEY `Location_ID` (`Location_ID`);

--
-- Indexes for table `receiver`
--
ALTER TABLE `receiver`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Received_from` (`Received_from`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor_ibfk_1` FOREIGN KEY (`Donated_Clinic`) REFERENCES `clinic` (`ID`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`Location_ID`) REFERENCES `clinic` (`ID`);

--
-- Constraints for table `receiver`
--
ALTER TABLE `receiver`
  ADD CONSTRAINT `receiver_ibfk_1` FOREIGN KEY (`Received_from`) REFERENCES `donor` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
