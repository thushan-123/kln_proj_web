-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 05:31 AM
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
-- Database: `stayfinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_ID` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_approval`
--

CREATE TABLE `admin_approval` (
  `approval_ID` int(11) NOT NULL,
  `admin_ID` int(11) NOT NULL,
  `house_ID` int(11) NOT NULL,
  `approval_status` enum('approved','pending','rejected') NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE `listings` (
  `house_ID` int(11) NOT NULL,
  `owner_ID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` decimal(6,0) NOT NULL,
  `address_no` varchar(10) NOT NULL,
  `address_street` varchar(100) NOT NULL,
  `address_city` varchar(100) NOT NULL,
  `rating` tinyint(5) NOT NULL,
  `room_count` tinyint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listings`
--

INSERT INTO `listings` (`house_ID`, `owner_ID`, `title`, `description`, `price`, `address_no`, `address_street`, `address_city`, `rating`, `room_count`) VALUES
(4, 1, 'House for rent in Colombo Suburbs', 'A large house that can accomodate upto 7 people', 50000, '101', 'main lane', 'colombo 9', 0, 3),
(6, 1, 'House for Rent in Kelaniya', 'Spacious house with 2 bedrooms in kelaniya, close to amenities and transportation.', 25000, '101', 'Main Street', 'Kelaniya', 0, 2),
(7, 2, 'Apartment for Rent in Kandy', 'Modern apartment with 3 bedrooms, located in a vibrant area of Kandy, ideal for students or professionals.', 30000, '202', 'Broadway Avenue', 'Kandy', 0, 3),
(8, 3, 'House for Rent in Kotte', 'Beautiful 4-bedroom house in a Kotte, perfect for a students looking forspace.', 32000, '303', 'Elm Street', 'Kotte', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `listing_photos`
--

CREATE TABLE `listing_photos` (
  `photo_ID` int(11) NOT NULL,
  `house_ID` int(11) NOT NULL,
  `photo` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_ID` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `address_no` varchar(10) NOT NULL,
  `address_street` varchar(100) NOT NULL,
  `address_city` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`owner_ID`, `email`, `password`, `first_name`, `last_name`, `contact_no`, `address_no`, `address_street`, `address_city`) VALUES
(1, 'john@email.com', 'password123', 'john', 'doe', '0123456789', '123', 'example street', 'city1'),
(2, 'jane@email.com', 'SecurePass456', 'jane', 'smith', '0445123993', '202', 'main street', 'example city'),
(3, 'mike@email.com', 'MyPass789!', 'mike', 'johnson', '0234889912', '100', 'second street', 'nice city');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_ID` int(10) NOT NULL,
  `seeker_ID` int(10) NOT NULL,
  `house_ID` int(10) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `rating` tinyint(5) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seeker`
--

CREATE TABLE `seeker` (
  `seeker_ID` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `subscription_ID` int(10) NOT NULL,
  `plan_ID` int(10) NOT NULL,
  `owner_ID` int(11) NOT NULL,
  `date` date NOT NULL,
  `expiration_date` date NOT NULL,
  `subscription_status` enum('active','expired','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_payment`
--

CREATE TABLE `subscription_payment` (
  `payment_ID` int(10) NOT NULL,
  `date` date NOT NULL,
  `owner_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `plan_ID` int(11) NOT NULL,
  `plan_type` varchar(100) NOT NULL,
  `plan_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`plan_ID`, `plan_type`, `plan_price`) VALUES
(1, '1 month', 600.00),
(2, '6 months', 2500.00),
(3, '1 year', 4800.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indexes for table `admin_approval`
--
ALTER TABLE `admin_approval`
  ADD PRIMARY KEY (`approval_ID`),
  ADD KEY `fk_house_approval` (`house_ID`),
  ADD KEY `fk_admin` (`admin_ID`);

--
-- Indexes for table `listings`
--
ALTER TABLE `listings`
  ADD PRIMARY KEY (`house_ID`),
  ADD KEY `advertising` (`owner_ID`);

--
-- Indexes for table `listing_photos`
--
ALTER TABLE `listing_photos`
  ADD PRIMARY KEY (`photo_ID`),
  ADD KEY `fk_photos` (`house_ID`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_ID`),
  ADD KEY `fk_review` (`seeker_ID`);

--
-- Indexes for table `seeker`
--
ALTER TABLE `seeker`
  ADD PRIMARY KEY (`seeker_ID`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password` (`password`),
  ADD UNIQUE KEY `contact` (`contact_no`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscription_ID`),
  ADD KEY `fk_plan` (`plan_ID`),
  ADD KEY `fk_owner` (`owner_ID`);

--
-- Indexes for table `subscription_payment`
--
ALTER TABLE `subscription_payment`
  ADD PRIMARY KEY (`payment_ID`),
  ADD KEY `fk_subscription_payment` (`owner_ID`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`plan_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `listings`
--
ALTER TABLE `listings`
  MODIFY `house_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `plan_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_approval`
--
ALTER TABLE `admin_approval`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`admin_ID`) REFERENCES `admin` (`admin_ID`),
  ADD CONSTRAINT `fk_house_approval` FOREIGN KEY (`house_ID`) REFERENCES `listings` (`house_ID`);

--
-- Constraints for table `listings`
--
ALTER TABLE `listings`
  ADD CONSTRAINT `advertising` FOREIGN KEY (`owner_ID`) REFERENCES `owner` (`owner_ID`);

--
-- Constraints for table `listing_photos`
--
ALTER TABLE `listing_photos`
  ADD CONSTRAINT `fk_photos` FOREIGN KEY (`house_ID`) REFERENCES `listings` (`house_ID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_review` FOREIGN KEY (`seeker_ID`) REFERENCES `seeker` (`seeker_ID`);

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`owner_ID`) REFERENCES `owner` (`owner_ID`),
  ADD CONSTRAINT `fk_plan` FOREIGN KEY (`plan_ID`) REFERENCES `subscription_plans` (`plan_ID`);

--
-- Constraints for table `subscription_payment`
--
ALTER TABLE `subscription_payment`
  ADD CONSTRAINT `fk_subscription_payment` FOREIGN KEY (`owner_ID`) REFERENCES `owner` (`owner_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
