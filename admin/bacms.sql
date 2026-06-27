-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2026 at 11:18 AM
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
-- Database: `bacms`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment_inventory`
--

CREATE TABLE `equipment_inventory` (
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(100) NOT NULL,
  `equipment_quantity` int(11) NOT NULL,
  `equipment_category` varchar(100) NOT NULL,
  `equipment_status` varchar(100) NOT NULL,
  `equipment_condition` varchar(100) NOT NULL,
  `date_received` date NOT NULL,
  `equipment_type` varchar(100) NOT NULL,
  `assigned_location` varchar(100) NOT NULL,
  `equipment_remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_inventory`
--

INSERT INTO `equipment_inventory` (`equipment_id`, `equipment_name`, `equipment_quantity`, `equipment_category`, `equipment_status`, `equipment_condition`, `date_received`, `equipment_type`, `assigned_location`, `equipment_remarks`) VALUES
(1, 'Wheelchair', 8, 'Mobility Aid', 'Available', 'Good', '2026-06-26', 'Manual', 'Storage Room', 'Ready stock\r\n'),
(2, 'Walker', 5, 'Mobility Aid', 'Available', 'Good', '2026-06-26', 'Manual', 'Storage Room', 'Ready for use'),
(4, 'Wheelchair', 5, 'Mobility Aid', 'Maintenance', 'Damaged', '2026-06-26', 'Manual', 'Storage Room', 'Needs wheels to be fixed');

-- --------------------------------------------------------

--
-- Table structure for table `transport_vehicles`
--

CREATE TABLE `transport_vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `vehicle_quantity` int(11) NOT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `vehicle_status` varchar(100) NOT NULL,
  `vehicle_condition` varchar(100) NOT NULL,
  `date_acquired` date NOT NULL,
  `assigned_location` varchar(100) NOT NULL,
  `vehicle_remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport_vehicles`
--

INSERT INTO `transport_vehicles` (`vehicle_id`, `vehicle_name`, `vehicle_quantity`, `vehicle_type`, `vehicle_status`, `vehicle_condition`, `date_acquired`, `assigned_location`, `vehicle_remarks`) VALUES
(5, 'Van', 5, 'Service Vehicle', 'Available', 'Good', '2026-06-27', 'Garage', 'Ready for transport');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment_inventory`
--
ALTER TABLE `equipment_inventory`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `transport_vehicles`
--
ALTER TABLE `transport_vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment_inventory`
--
ALTER TABLE `equipment_inventory`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transport_vehicles`
--
ALTER TABLE `transport_vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
