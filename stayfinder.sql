/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.4.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: stayfinder
-- ------------------------------------------------------
-- Server version	11.4.3-MariaDB-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `admin_ID` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_ID`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES
(1,'thush','madhu','thush@gmail.com','$2y$10$x.kS/Eon3e/M4uAW00HU1.0CBJl3NFy83Z2WJ64RuOgrApWEB.VJG');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_approval`
--

DROP TABLE IF EXISTS `admin_approval`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_approval` (
  `approval_ID` int(11) NOT NULL,
  `admin_ID` int(11) NOT NULL,
  `house_ID` int(11) NOT NULL,
  `approval_status` enum('approved','pending','rejected') NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`approval_ID`),
  KEY `fk_house_approval` (`house_ID`),
  KEY `fk_admin` (`admin_ID`),
  CONSTRAINT `fk_admin` FOREIGN KEY (`admin_ID`) REFERENCES `admin` (`admin_ID`),
  CONSTRAINT `fk_house_approval` FOREIGN KEY (`house_ID`) REFERENCES `listings` (`house_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_approval`
--

LOCK TABLES `admin_approval` WRITE;
/*!40000 ALTER TABLE `admin_approval` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_approval` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `category_id` int(5) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES
(1,'ac'),
(2,'dafaf'),
(3,'asdd');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `house_images`
--

DROP TABLE IF EXISTS `house_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `house_images` (
  `image_id` int(10) NOT NULL AUTO_INCREMENT,
  `house_id` varchar(50) NOT NULL,
  `image_name` text DEFAULT NULL,
  PRIMARY KEY (`image_id`),
  KEY `house_id` (`house_id`),
  CONSTRAINT `house_images_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`house_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `house_images`
--

LOCK TABLES `house_images` WRITE;
/*!40000 ALTER TABLE `house_images` DISABLE KEYS */;
INSERT INTO `house_images` VALUES
(1,'671df7f242032','671df7f242069.png'),
(2,'671e0d04e624a','671e0d04e81b7.png'),
(3,'671e0d04e624a','671e0d04ea399.png'),
(4,'671e0d04e624a','671e0d04eb6e0.png'),
(5,'671e0d04e624a','671e0d04ed45a.png'),
(6,'671fb432bf930','671fb432c0712.png'),
(7,'671fb432bf930','671fb432c13c7.png'),
(8,'671fb432bf930','671fb432c1f34.png');
/*!40000 ALTER TABLE `house_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `houses` (
  `house_id` varchar(50) NOT NULL,
  `category_id` int(5) DEFAULT NULL,
  `location_id` int(5) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT 0,
  `owner_ID` int(11) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `room_count` int(11) DEFAULT 0,
  PRIMARY KEY (`house_id`),
  KEY `category_id` (`category_id`),
  KEY `location_id` (`location_id`),
  KEY `owner_ID` (`owner_ID`),
  CONSTRAINT `houses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  CONSTRAINT `houses_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`),
  CONSTRAINT `houses_ibfk_3` FOREIGN KEY (`owner_ID`) REFERENCES `owner` (`owner_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `houses`
--

LOCK TABLES `houses` WRITE;
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
INSERT INTO `houses` VALUES
('671df7f242032',1,1,'sbsbsg','sdfsd','sdfbsdfb',3245,1,4,'2024-10-30',0),
('671e0d04e624a',1,1,'sdfb','sdfbds','fsdbdbf',423,1,4,'2024-10-29',0),
('671fb432bf930',1,2,'sadfgasd','asgsdg','asdgasdf',235235,0,4,NULL,30);
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `listings`
--

DROP TABLE IF EXISTS `listings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `listings` (
  `house_ID` int(11) NOT NULL AUTO_INCREMENT,
  `owner_ID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` decimal(6,0) NOT NULL,
  `address_no` varchar(10) NOT NULL,
  `address_street` varchar(100) NOT NULL,
  `address_city` varchar(100) NOT NULL,
  `rating` tinyint(5) NOT NULL,
  `room_count` tinyint(5) NOT NULL,
  `category_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`house_ID`),
  KEY `advertising` (`owner_ID`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `advertising` FOREIGN KEY (`owner_ID`) REFERENCES `owner` (`owner_ID`),
  CONSTRAINT `listings_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `listings`
--

LOCK TABLES `listings` WRITE;
/*!40000 ALTER TABLE `listings` DISABLE KEYS */;
INSERT INTO `listings` VALUES
(4,1,'House for rent in Colombo Suburbs','A large house that can accomodate upto 7 people',50000,'101','main lane','colombo 9',0,3,1),
(6,1,'House for Rent in Kelaniya','Spacious house with 2 bedrooms in kelaniya, close to amenities and transportation.',25000,'101','Main Street','Kelaniya',0,2,3),
(7,2,'Apartment for Rent in Kandy','Modern apartment with 3 bedrooms, located in a vibrant area of Kandy, ideal for students or professionals.',30000,'202','Broadway Avenue','Kandy',0,3,1),
(8,3,'House for Rent in Kotte','Beautiful 4-bedroom house in a Kotte, perfect for a students looking forspace.',32000,'303','Elm Street','Kotte',0,4,2);
/*!40000 ALTER TABLE `listings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `location_id` int(5) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(30) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES
(1,'gampha'),
(2,'colombo'),
(3,'kaluthara'),
(4,'kelaniya'),
(5,'kadawatha');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owner`
--

DROP TABLE IF EXISTS `owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owner` (
  `owner_ID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  PRIMARY KEY (`owner_ID`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owner`
--

LOCK TABLES `owner` WRITE;
/*!40000 ALTER TABLE `owner` DISABLE KEYS */;
INSERT INTO `owner` VALUES
(1,'john@email.com','password123','john','doe','0123456789'),
(2,'jane@email.com','SecurePass456','jane','smith','0445123993'),
(3,'mike@email.com','MyPass789!','mike','johnson','0234889912'),
(4,'thush@gmail.com','$2y$10$x.kS/Eon3e/M4uAW00HU1.0CBJl3NFy83Z2WJ64RuOgrApWEB.VJG','thush','madhu','785021666');
/*!40000 ALTER TABLE `owner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owner_plan`
--

DROP TABLE IF EXISTS `owner_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owner_plan` (
  `owner_ID` int(11) NOT NULL,
  `plan_ID` int(11) NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`owner_ID`,`plan_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owner_plan`
--

LOCK TABLES `owner_plan` WRITE;
/*!40000 ALTER TABLE `owner_plan` DISABLE KEYS */;
INSERT INTO `owner_plan` VALUES
(4,2,'2025-05-01');
/*!40000 ALTER TABLE `owner_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `review_ID` int(10) NOT NULL,
  `seeker_ID` int(10) NOT NULL,
  `house_ID` int(10) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `rating` tinyint(5) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`review_ID`),
  KEY `fk_review` (`seeker_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seeker`
--

DROP TABLE IF EXISTS `seeker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seeker` (
  `seeker_ID` int(5) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) DEFAULT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`seeker_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seeker`
--

LOCK TABLES `seeker` WRITE;
/*!40000 ALTER TABLE `seeker` DISABLE KEYS */;
INSERT INTO `seeker` VALUES
(1,'thush@gmail.com','thushan','madhu','$2y$10$eXwBVvX3e.fVYGOi/v86i.nY5TEFiGp7NHz9bOiUQvAM8Vg2EV.D.','0789414773');
/*!40000 ALTER TABLE `seeker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_payment`
--

DROP TABLE IF EXISTS `subscription_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription_payment` (
  `payment_ID` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `owner_ID` int(10) NOT NULL,
  PRIMARY KEY (`payment_ID`),
  KEY `fk_subscription_payment` (`owner_ID`),
  CONSTRAINT `fk_subscription_payment` FOREIGN KEY (`owner_ID`) REFERENCES `owner` (`owner_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_payment`
--

LOCK TABLES `subscription_payment` WRITE;
/*!40000 ALTER TABLE `subscription_payment` DISABLE KEYS */;
INSERT INTO `subscription_payment` VALUES
('672323ce62814','2024-10-31',4),
('6723244bac2a3','2024-10-31',4),
('67232477654ce','2024-10-31',4);
/*!40000 ALTER TABLE `subscription_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_plans`
--

DROP TABLE IF EXISTS `subscription_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription_plans` (
  `plan_ID` int(11) NOT NULL AUTO_INCREMENT,
  `plan_type` varchar(100) NOT NULL,
  `plan_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`plan_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_plans`
--

LOCK TABLES `subscription_plans` WRITE;
/*!40000 ALTER TABLE `subscription_plans` DISABLE KEYS */;
INSERT INTO `subscription_plans` VALUES
(1,'1 month',600.00),
(2,'6 months',2500.00),
(3,'1 year',4800.00);
/*!40000 ALTER TABLE `subscription_plans` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2024-10-31 12:03:02
