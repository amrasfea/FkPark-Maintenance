-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 12:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fkpark`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookinfo`
--

CREATE TABLE `bookinfo` (
  `b_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL,
  `b_date` date NOT NULL,
  `b_time` time NOT NULL,
  `b_parkStart` time DEFAULT NULL,
  `b_duration` int(11) DEFAULT NULL,
  `b_status` varchar(10) DEFAULT NULL,
  `b_QRid` varchar(255) DEFAULT NULL,
  `v_id` int(11) DEFAULT NULL,
  `ps_id` varchar(10) DEFAULT NULL,
  `b_platenum` varchar(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parkspace`
--

CREATE TABLE `parkspace` (
  `ps_id` varchar(10) NOT NULL,
  `ps_area` varchar(10) NOT NULL,
  `ps_category` varchar(10) NOT NULL,
  `ps_date` date NOT NULL,
  `ps_time` time NOT NULL,
  `ps_typeEvent` varchar(50) DEFAULT NULL,
  `ps_descriptionEvent` varchar(50) DEFAULT NULL,
  `ps_QR` varchar(255) DEFAULT NULL,
  `ps_availableStat` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_course` enum('SOFTWARE ENGINEERING','NETWORKING','GRAPHIC DESIGN') DEFAULT NULL,
  `p_faculty` varchar(100) DEFAULT NULL,
  `p_icNumber` varchar(15) NOT NULL,
  `p_email` varchar(100) NOT NULL,
  `p_phoneNum` varchar(15) DEFAULT NULL,
  `p_address` varchar(100) DEFAULT NULL,
  `p_postCode` varchar(10) DEFAULT NULL,
  `p_country` varchar(50) DEFAULT NULL,
  `p_state` varchar(50) DEFAULT NULL,
  `p_department` varchar(100) DEFAULT NULL,
  `p_bodyNumber` varchar(10) DEFAULT NULL,
  `p_position` varchar(100) DEFAULT NULL,
  `p_matricNum` varchar(15) DEFAULT NULL,
  `u_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `summon`
--

CREATE TABLE `summon` (
  `sum_id` int(11) NOT NULL,
  `sum_date` date DEFAULT NULL,
  `sum_vModel` varchar(50) NOT NULL,
  `sum_vBrand` varchar(100) NOT NULL,
  `sum_vPlate` varchar(10) NOT NULL,
  `sum_location` varchar(10) NOT NULL,
  `sum_violationType` varchar(200) NOT NULL,
  `sum_demerit` int(11) NOT NULL,
  `sum_status` varchar(200) DEFAULT NULL,
  `vt_id` int(11) DEFAULT NULL,
  `v_id` int(11) NOT NULL,
  `sum_vType` enum ('Car','Motorcycle')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `u_id` int(11) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_type` enum('Unit Keselamatan Staff','Administrators','Student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `v_id` int(11) NOT NULL,
  `v_vehicleType` enum('MOTORCYCLE','CAR') NOT NULL,
  `v_brand` varchar(50) NOT NULL,
  `v_roadTaxValidDate` date NOT NULL,
  `v_licenceValidDate` date NOT NULL,
  `v_licenceClass` varchar(5) NOT NULL,
  `v_phoneNum` int(11) NOT NULL,
  `v_vehicleGrant` blob NOT NULL,
  `v_approvalStatus` enum('Pending','Reject','Approve') DEFAULT 'Pending',
  `v_remarks` text DEFAULT NULL,
  `v_qrCode` varchar(500) DEFAULT NULL,
  `v_plateNum` varchar(10) NOT NULL,
  `v_model` varchar(50) NOT NULL,
  `u_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `violationtype`
--

CREATE TABLE `violationtype` (
  `vt_id` int(11) NOT NULL,
  `vt_name` varchar(200) NOT NULL,
  `vt_demeritPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookinfo`
--
ALTER TABLE `bookinfo`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `v_id` (`v_id`),
  ADD KEY `ps_id` (`ps_id`);

--
-- Indexes for table `parkspace`
--
ALTER TABLE `parkspace`
  ADD PRIMARY KEY (`ps_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `summon`
--
ALTER TABLE `summon`
  ADD PRIMARY KEY (`sum_id`),
  ADD KEY `vt_id` (`vt_id`),
  ADD KEY `v_id` (`v_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_email` (`u_email`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`v_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `violationtype`
--
ALTER TABLE `violationtype`
  ADD PRIMARY KEY (`vt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookinfo`
--
ALTER TABLE `bookinfo`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `summon`
--
ALTER TABLE `summon`
  MODIFY `sum_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `v_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `violationtype`
--
ALTER TABLE `violationtype`
  MODIFY `vt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookinfo`
--
ALTER TABLE `bookinfo`
  ADD CONSTRAINT `bookinfo_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`),
  ADD CONSTRAINT `bookinfo_ibfk_2` FOREIGN KEY (`v_id`) REFERENCES `vehicle` (`v_id`),
  ADD CONSTRAINT `bookinfo_ibfk_3` FOREIGN KEY (`ps_id`) REFERENCES `parkspace` (`ps_id`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);

--
-- Constraints for table `summon`
--
ALTER TABLE `summon`
  ADD CONSTRAINT `summon_ibfk_1` FOREIGN KEY (`vt_id`) REFERENCES `violationtype` (`vt_id`),
  ADD CONSTRAINT `summon_ibfk_2` FOREIGN KEY (`v_id`) REFERENCES `vehicle` (`v_id`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
