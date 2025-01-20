-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.36 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for travelpedia
CREATE DATABASE IF NOT EXISTS `travelpedia` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `travelpedia`;

-- Dumping structure for table travelpedia.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `verification_code` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `admincol_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.admin: ~1 rows (approximately)
INSERT IGNORE INTO `admin` (`fname`, `lname`, `email`, `verification_code`) VALUES
	('Sanjuna', 'Delpitiya', 'sanjunadelpitiya1@gmail.com', '667e832579e02');

-- Dumping structure for table travelpedia.booking
CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `resort_id` int NOT NULL,
  `description` varchar(200) NOT NULL,
  `total` int NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `date_booked` datetime NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `fk_booking_resort1_idx` (`resort_id`),
  KEY `fk_booking_user1_idx` (`user_email`),
  CONSTRAINT `fk_booking_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`),
  CONSTRAINT `fk_booking_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.booking: ~4 rows (approximately)
INSERT IGNORE INTO `booking` (`booking_id`, `user_email`, `resort_id`, `description`, `total`, `check_in`, `check_out`, `date_booked`) VALUES
	('66095d6830bcb', 'realmonkey@gmail.com', 2, '  1 40$ Double Room(s)  1 50$ Triple Room(s) booked', 90, '2024-04-02', '2024-04-03', '2024-03-31 18:26:08'),
	('66095da830c11', 'realmonkey@gmail.com', 2, '  1 40$ Double Room(s)  1 50$ Triple Room(s) booked', 90, '2024-04-05', '2024-04-06', '2024-03-31 18:27:40'),
	('660a62187f39a', 'sanjunadelpitiya1@gmail.com', 3, '  1 30$ Double Room(s) booked', 30, '2024-04-02', '2024-04-03', '2024-04-01 12:59:03'),
	('660d1da4c8248', 'shehalimeemure32@yahoo.com', 3, '  1 30$ Double Room(s) booked', 30, '2024-04-06', '2024-04-07', '2024-04-03 14:43:46');

-- Dumping structure for table travelpedia.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `chat_id` int NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  `date_time` datetime NOT NULL,
  `status` tinyint NOT NULL,
  `from` varchar(100) NOT NULL,
  `to` varchar(100) NOT NULL,
  PRIMARY KEY (`chat_id`),
  KEY `fk_chat_user1_idx` (`from`),
  KEY `fk_chat_user2_idx` (`to`),
  CONSTRAINT `fk_chat_user1` FOREIGN KEY (`from`) REFERENCES `user` (`email`),
  CONSTRAINT `fk_chat_user2` FOREIGN KEY (`to`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.chat: ~1 rows (approximately)
INSERT IGNORE INTO `chat` (`chat_id`, `content`, `date_time`, `status`, `from`, `to`) VALUES
	(58, 'hi', '2024-06-24 18:01:16', 0, 'sanjunadelpitiya1@gmail.com', 'sanjunadelpitiya1@gmail.com');

-- Dumping structure for table travelpedia.city
CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int NOT NULL AUTO_INCREMENT,
  `city_name` varchar(45) NOT NULL,
  `district_id` int NOT NULL,
  PRIMARY KEY (`city_id`),
  KEY `fk_city_region1_idx` (`district_id`),
  CONSTRAINT `fk_city_region1` FOREIGN KEY (`district_id`) REFERENCES `district` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.city: ~61 rows (approximately)
INSERT IGNORE INTO `city` (`city_id`, `city_name`, `district_id`) VALUES
	(1, 'Nuwara Eliya', 8),
	(2, 'Wadduwa', 2),
	(3, 'Pasikudah', 20),
	(4, 'Colombo 03', 1),
	(5, 'Negombo', 2),
	(6, 'Ella', 9),
	(7, 'Matara', 11),
	(8, 'Galle', 10),
	(9, 'Hikkaduwa', 10),
	(10, 'Yala', 12),
	(11, 'Mannar', 17),
	(12, 'Kurunegala', 19),
	(13, 'Dambulla', 7),
	(14, 'Yapahuwa', 7),
	(15, 'Dambadeniya', 7),
	(16, 'Batticaloa', 20),
	(17, 'Kalpitiya', 18),
	(18, 'Puttalam', 18),
	(19, 'Gampaha', 2),
	(20, 'Kalutara', 3),
	(21, 'Peradeniya', 6),
	(22, 'Hatton', 8),
	(23, 'Trincomalee', 22),
	(24, 'Nilaveli', 21),
	(25, 'Kalmunai', 21),
	(26, 'Arugam Bay', 20),
	(27, 'Batticaloa', 20),
	(28, 'Kataragama', 12),
	(29, 'Kirinda', 12),
	(30, 'Hambantota', 12),
	(31, 'Tangalle', 12),
	(32, 'Mirissa', 11),
	(33, 'Matara', 11),
	(34, 'Weligama', 11),
	(35, 'Ahungalla', 10),
	(36, 'Balapitiya', 10),
	(37, 'Ambalangoda', 10),
	(38, 'Beruwala', 3),
	(39, 'Katukurunda', 3),
	(40, 'Ratnapura', 4),
	(41, 'Balangoda', 4),
	(42, 'Kegalle', 5),
	(43, 'Kitulgala', 5),
	(44, 'Kandy', 6),
	(45, 'Pilimathalawa', 6),
	(46, 'Sigiriya', 7),
	(47, 'Matale', 7),
	(48, 'Jaffna', 14),
	(49, 'Mulattivu', 15),
	(50, 'Vavuniya', 16),
	(51, 'Madu', 17),
	(52, 'Welioya', 24),
	(53, 'Mihintale', 24),
	(54, 'Polonnaruwa', 24),
	(55, 'Balangoda', 4),
	(56, 'Monaragala', 25),
	(57, 'Buttala', 25),
	(58, 'Medawachchiya', 13),
	(59, 'Nallur', 14),
	(60, 'Kilinochchi', 13),
	(61, 'Bibila', 9);

-- Dumping structure for table travelpedia.deals
CREATE TABLE IF NOT EXISTS `deals` (
  `resort_id` int NOT NULL,
  `resort_user_email` varchar(100) NOT NULL,
  `percentage` int NOT NULL,
  PRIMARY KEY (`resort_id`),
  KEY `fk_resort_user_has_resort_resort1_idx` (`resort_id`),
  KEY `fk_resort_user_has_resort_resort_user1_idx` (`resort_user_email`),
  CONSTRAINT `fk_resort_user_has_resort_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`),
  CONSTRAINT `fk_resort_user_has_resort_resort_user1` FOREIGN KEY (`resort_user_email`) REFERENCES `resort_user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.deals: ~0 rows (approximately)

-- Dumping structure for table travelpedia.district
CREATE TABLE IF NOT EXISTS `district` (
  `id` int NOT NULL AUTO_INCREMENT,
  `district_name` varchar(45) NOT NULL,
  `province_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_district_province1_idx` (`province_id`),
  CONSTRAINT `fk_district_province1` FOREIGN KEY (`province_id`) REFERENCES `province` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.district: ~25 rows (approximately)
INSERT IGNORE INTO `district` (`id`, `district_name`, `province_id`) VALUES
	(1, 'Colombo', 1),
	(2, 'Gampaha', 1),
	(3, 'Kalutara', 1),
	(4, 'Ratnapura', 2),
	(5, 'Kegalle', 2),
	(6, 'Kandy', 3),
	(7, 'Matale', 3),
	(8, 'Nuwara Eliya', 3),
	(9, 'Badulla', 8),
	(10, 'Galle', 4),
	(11, 'Matara', 4),
	(12, 'Hambantota', 4),
	(13, 'Kilinochchi', 5),
	(14, 'Jaffna', 5),
	(15, 'Mullativu', 5),
	(16, 'Vavuniya', 5),
	(17, 'Mannar', 5),
	(18, 'Puttalam', 6),
	(19, 'Kurunegala', 6),
	(20, 'Batticaloa', 7),
	(21, 'Ampara', 7),
	(22, 'Trincomalee', 7),
	(23, 'Anuradhapura', 9),
	(24, 'Polonnaruwa', 9),
	(25, 'Moneragala', 8);

-- Dumping structure for table travelpedia.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `gender_id` int NOT NULL AUTO_INCREMENT,
  `gender_name` varchar(45) NOT NULL,
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.gender: ~2 rows (approximately)
INSERT IGNORE INTO `gender` (`gender_id`, `gender_name`) VALUES
	(1, 'Male'),
	(2, 'Female');

-- Dumping structure for table travelpedia.invoice
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int NOT NULL AUTO_INCREMENT,
  `booking_id` varchar(30) NOT NULL,
  `date_time` datetime NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `double` int NOT NULL,
  `triple` int NOT NULL,
  `suite` int NOT NULL,
  `double_type` varchar(45) NOT NULL,
  `triple_type` varchar(45) NOT NULL,
  `suite_type` varchar(45) NOT NULL,
  `total` double NOT NULL,
  `status` tinyint NOT NULL,
  `resort_id` int NOT NULL,
  `user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `fk_invoice_resort1_idx` (`resort_id`),
  KEY `fk_invoice_booking1_idx` (`booking_id`),
  KEY `fk_invoice_user1_idx` (`user_email`),
  CONSTRAINT `fk_invoice_booking1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`),
  CONSTRAINT `fk_invoice_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`),
  CONSTRAINT `fk_invoice_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.invoice: ~4 rows (approximately)
INSERT IGNORE INTO `invoice` (`invoice_id`, `booking_id`, `date_time`, `checkin`, `checkout`, `double`, `triple`, `suite`, `double_type`, `triple_type`, `suite_type`, `total`, `status`, `resort_id`, `user_email`) VALUES
	(1, '66095d6830bcb', '2024-03-31 18:26:08', '2024-04-02', '2024-04-03', 1, 1, 0, '40', '50', '100', 90, 0, 2, 'realmonkey@gmail.com'),
	(2, '66095da830c11', '2024-03-31 18:27:40', '2024-04-05', '2024-04-06', 1, 1, 0, '40', '50', '100', 90, 0, 2, 'realmonkey@gmail.com'),
	(3, '660a62187f39a', '2024-04-01 12:59:03', '2024-04-02', '2024-04-03', 1, 0, 0, '30', '60', '100', 30, 0, 3, 'sanjunadelpitiya1@gmail.com'),
	(4, '660d1da4c8248', '2024-04-03 14:43:46', '2024-04-06', '2024-04-07', 1, 0, 0, '30', '60', '100', 30, 0, 3, 'shehalimeemure32@yahoo.com');

-- Dumping structure for table travelpedia.profile_images
CREATE TABLE IF NOT EXISTS `profile_images` (
  `path` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_profile_images_user1_idx` (`email`),
  CONSTRAINT `fk_profile_images_user1` FOREIGN KEY (`email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.profile_images: ~2 rows (approximately)
INSERT IGNORE INTO `profile_images` (`path`, `email`) VALUES
	('../../resources/profile_img/Real_660d1cd086561.jpeg', 'realmonkey@gmail.com'),
	('../../resources/profile_img/Nimasha_660a5f726f010.jpeg', 'sanjunadelpitiya1@gmail.com');

-- Dumping structure for table travelpedia.province
CREATE TABLE IF NOT EXISTS `province` (
  `id` int NOT NULL AUTO_INCREMENT,
  `province_name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.province: ~9 rows (approximately)
INSERT IGNORE INTO `province` (`id`, `province_name`) VALUES
	(1, 'Western'),
	(2, 'Sabaragamuwa'),
	(3, 'Central'),
	(4, 'Southern'),
	(5, 'Nothern'),
	(6, 'North Western'),
	(7, 'Eastern'),
	(8, 'Uva'),
	(9, 'North Central');

-- Dumping structure for table travelpedia.recent
CREATE TABLE IF NOT EXISTS `recent` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `resort_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_recent_resort1_idx` (`resort_id`),
  KEY `fk_recent_user1_idx` (`user_email`),
  CONSTRAINT `fk_recent_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`),
  CONSTRAINT `fk_recent_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.recent: ~7 rows (approximately)
INSERT IGNORE INTO `recent` (`id`, `user_email`, `resort_id`) VALUES
	(1, 'realmonkey@gmail.com', 1),
	(2, 'realmonkey@gmail.com', 2),
	(3, 'realmonkey@gmail.com', 7),
	(4, 'sanjunadelpitiya1@gmail.com', 9),
	(5, 'sanjunadelpitiya1@gmail.com', 10),
	(6, 'sanjunadelpitiya1@gmail.com', 10),
	(7, 'sanjunadelpitiya1@gmail.com', 10);

-- Dumping structure for table travelpedia.resort
CREATE TABLE IF NOT EXISTS `resort` (
  `resort_id` int NOT NULL AUTO_INCREMENT,
  `resort_user_email` varchar(100) NOT NULL,
  `resort_name` varchar(150) NOT NULL,
  `resort_mobile` varchar(30) NOT NULL,
  `datetime_added` datetime NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`resort_id`),
  UNIQUE KEY `resort_name_UNIQUE` (`resort_name`),
  KEY `fk_resort_resort_user1_idx` (`resort_user_email`),
  CONSTRAINT `fk_resort_resort_user1` FOREIGN KEY (`resort_user_email`) REFERENCES `resort_user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.resort: ~17 rows (approximately)
INSERT IGNORE INTO `resort` (`resort_id`, `resort_user_email`, `resort_name`, `resort_mobile`, `datetime_added`, `status`) VALUES
	(1, 'hasithadhana421@gmail.com', 'The Villas', '0712345678', '2024-03-29 20:31:29', 1),
	(2, 'manimekala@gmail.com', 'Blackpool Hotel', '0766554321', '2024-03-30 01:02:42', 1),
	(3, 'shenayahansali23@gmail.com', 'Cabana', '0777654321', '2024-03-31 12:51:57', 1),
	(5, 'shsrapmjt2@gmail.com', 'Kalpitiya Resort 01', '0741234123', '2024-04-05 08:00:40', 1),
	(7, 'shsrapmjt2@gmail.com', 'Arugam Bay Hotel 2', '0760123456', '2024-04-05 08:10:49', 1),
	(8, 'shenayahansali23@gmail.com', 'Balapitiya Resort 1', '0771231234', '2024-04-05 08:16:49', 1),
	(9, 'hasithadhana421@gmail.com', 'Bibile Resort', '0712312345', '2024-04-05 12:06:17', 1),
	(10, 'pkuruvi37@gmail.com', 'Medawachchiya Resort 1', '0711234554', '2024-04-05 12:10:11', 1),
	(11, 'pkuruvi37@gmail.com', 'ITC Ratnadipa', '0771224444', '2024-06-04 15:17:50', 1),
	(12, 'ruwanidelpitiya@gmail.com', 'Dels Haven', '0770095616', '2024-06-04 18:54:19', 1),
	(13, 'ruwanidelpitiya@gmail.com', 'Club Waskaduwa', '0770121234', '2024-06-04 19:09:45', 1),
	(14, 'amarupasinghe@gmail.com', 'W15 Hanthana', '0772151515', '2024-06-05 12:21:12', 1),
	(15, 'amarupasinghe@gmail.com', 'W15 Glenfall', '0771111515', '2024-06-05 12:32:09', 1),
	(16, 'amarupasinghe@gmail.com', 'W15 Weligama', '0771221515', '2024-06-05 12:40:46', 1),
	(17, 'amarupasinghe@gmail.com', 'W15 Ahangama Escape', '0775551515', '2024-06-05 12:54:04', 1),
	(18, 'amarupasinghe@gmail.com', 'Anantara Kalutara', '0772220222', '2024-06-05 13:07:44', 1),
	(19, 'amarupasinghe@gmail.com', 'Hotel A', '0771231234', '2024-06-28 15:09:42', 1);

-- Dumping structure for table travelpedia.resort_address
CREATE TABLE IF NOT EXISTS `resort_address` (
  `resort_address_id` int NOT NULL AUTO_INCREMENT,
  `no` varchar(10) DEFAULT NULL,
  `street1` varchar(45) DEFAULT NULL,
  `street2` varchar(45) DEFAULT NULL,
  `city_id` int NOT NULL,
  `resort_id` int NOT NULL,
  PRIMARY KEY (`resort_address_id`),
  KEY `fk_resort_address_city1_idx` (`city_id`),
  KEY `fk_resort_address_resort1_idx` (`resort_id`),
  CONSTRAINT `fk_resort_address_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`),
  CONSTRAINT `fk_resort_address_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.resort_address: ~17 rows (approximately)
INSERT IGNORE INTO `resort_address` (`resort_address_id`, `no`, `street1`, `street2`, `city_id`, `resort_id`) VALUES
	(1, '48', 'Station Rd', 'Off Galle Rd', 2, 1),
	(2, '570', 'Mahagastota Rd', 'Blackpool', 1, 2),
	(3, '10', 'Negombo Rd', '', 5, 3),
	(4, '82', 'Beach Side Rd', 'Kalpitiya Rd', 17, 5),
	(5, '13', 'Off Batticaloa Rd', 'Batticaloa Rd', 16, 7),
	(6, '31', 'Balapitiya Mawatha', 'Galle Rd', 36, 8),
	(7, '9', 'Seruwawala Mawatha', 'Monaragala Rd', 61, 9),
	(8, '10', 'Medawala 2nd Lane', 'Jaffna Rd', 58, 10),
	(9, '26', 'Galle Face Centre Road', '', 4, 11),
	(10, '180', 'Moon Plains Rd', 'Outer Lake Rd', 1, 12),
	(11, '211', 'Jayanthi Mawatha ', 'Waskaduwa', 2, 13),
	(12, '947 ', 'Uduwela Road', 'Udugama West', 44, 14),
	(13, '55 ', 'Upper Lake Rd', '', 1, 15),
	(14, '506 ', 'New Galle Road', '', 34, 16),
	(15, '10', 'Mahavihara Rd', 'Ahangama', 7, 17),
	(16, '30', 'St. Sebastian Rd', '', 20, 18),
	(17, '12', 'Galle Rd', '', 4, 19);

-- Dumping structure for table travelpedia.resort_images
CREATE TABLE IF NOT EXISTS `resort_images` (
  `image` varchar(150) NOT NULL,
  `resort_id` int NOT NULL,
  PRIMARY KEY (`image`),
  UNIQUE KEY `image_UNIQUE` (`image`),
  KEY `fk_resort_images_resort1_idx` (`resort_id`),
  CONSTRAINT `fk_resort_images_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.resort_images: ~53 rows (approximately)
INSERT IGNORE INTO `resort_images` (`image`, `resort_id`) VALUES
	('../../resources//resort-images//1_0_6606d8170b5d7.jpg', 1),
	('../../resources//resort-images//1_1_6606d81717448.jpg', 1),
	('../../resources//resort-images//1_2_6606d8171ac30.jpg', 1),
	('../../resources//resort-images//1_3_6606d8171fd4e.jpg', 1),
	('../../resources//resort-images//2_0_6607181c92306.jpg', 2),
	('../../resources//resort-images//2_1_6607181c9b0ae.jpg', 2),
	('../../resources//resort-images//3_0_66090f8dd6a5b.jpg', 3),
	('../../resources//resort-images//3_1_66090f8ddf5fb.jpg', 3),
	('../../resources//resort-images//7_0_660f654f5849b.jpg', 7),
	('../../resources//resort-images//7_1_660f654f5fd4b.jpg', 7),
	('../../resources//resort-images//7_2_660f654f61901.jpg', 7),
	('../../resources//resort-images//7_3_660f654f6371b.jpg', 7),
	('../../resources//resort-images//8_0_660f669aa6d9f.jpg', 8),
	('../../resources//resort-images//8_1_660f669aab8e9.jpg', 8),
	('../../resources//resort-images//8_2_660f669aadb57.jpg', 8),
	('../../resources//resort-images//8_3_660f669ab02c2.jpg', 8),
	('../../resources//resort-images//9_0_660f9c3b4225a.jpg', 9),
	('../../resources//resort-images//9_1_660f9c3b484df.jpg', 9),
	('../../resources//resort-images//9_2_660f9c3b49c4c.jpg', 9),
	('../../resources//resort-images//9_3_660f9c3b4bba0.jpg', 9),
	('../../resources//resort-images//10_0_660f9d5b71d3f.jpg', 10),
	('../../resources//resort-images//10_1_660f9d5b7ea48.jpg', 10),
	('../../resources//resort-images//11_0_665f0a5483849.jpg', 11),
	('../../resources//resort-images//11_1_665f0a5487ae2.jpg', 11),
	('../../resources//resort-images//11_2_665f0a5489329.jpg', 11),
	('../../resources//resort-images//11_3_665f0a548b3ba.jpg', 11),
	('../../resources//resort-images//12_0_665f16a87e500.jpg', 12),
	('../../resources//resort-images//12_1_665f16a883b0a.jpg', 12),
	('../../resources//resort-images//12_2_665f16a88553a.jpg', 12),
	('../../resources//resort-images//12_3_665f16a886dad.jpg', 12),
	('../../resources//resort-images//13_0_665f19a08cfc1.jpg', 13),
	('../../resources//resort-images//13_1_665f19a0945a3.jpg', 13),
	('../../resources//resort-images//13_2_665f19a096749.jpg', 13),
	('../../resources//resort-images//13_3_665f19a097e0d.jpg', 13),
	('../../resources//resort-images//14_0_66600b245b5ae.svg', 14),
	('../../resources//resort-images//14_1_66600b2461a32.svg', 14),
	('../../resources//resort-images//14_2_66600b246332b.svg', 14),
	('../../resources//resort-images//14_3_66600b2465124.svg', 14),
	('../../resources//resort-images//16_0_66600fb175b95.svg', 16),
	('../../resources//resort-images//16_1_66600fb18075b.svg', 16),
	('../../resources//resort-images//16_2_66600fb181fc0.svg', 16),
	('../../resources//resort-images//16_3_66600fb18380d.svg', 16),
	('../../resources//resort-images//17_0_666012ebaaf0a.jpg', 17),
	('../../resources//resort-images//17_1_666012ebb6f26.jpg', 17),
	('../../resources//resort-images//17_2_666012ebb8c7f.jpg', 17),
	('../../resources//resort-images//17_3_666012ebba961.jpg', 17),
	('../../resources//resort-images//18_0_666015fc4d03b.jpg', 18),
	('../../resources//resort-images//18_1_666015fc549cb.jpg', 18),
	('../../resources//resort-images//18_2_666015fc58168.jpg', 18),
	('../../resources//resort-images//18_3_666015fc5a854.jpg', 18),
	('../../resources//resort-images//19_1_667e857e856f6.jpg', 19),
	('../../resources//resort-images//19_2_667e857e8d8c9.png', 19),
	('../../resources//resort-images//19_3_667e857e909e5.png', 19);

-- Dumping structure for table travelpedia.resort_roomcount
CREATE TABLE IF NOT EXISTS `resort_roomcount` (
  `resort_id` int NOT NULL,
  `double` int NOT NULL,
  `triple` int DEFAULT NULL,
  `suite` int DEFAULT NULL,
  PRIMARY KEY (`resort_id`),
  KEY `fk_resort_roomcount_resort1_idx` (`resort_id`),
  CONSTRAINT `fk_resort_roomcount_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.resort_roomcount: ~17 rows (approximately)
INSERT IGNORE INTO `resort_roomcount` (`resort_id`, `double`, `triple`, `suite`) VALUES
	(1, 20, 20, 1),
	(2, 10, 10, 1),
	(3, 8, 10, 2),
	(5, 10, 10, 2),
	(7, 28, 28, 4),
	(8, 22, 22, 1),
	(9, 20, 20, 2),
	(10, 16, 16, 2),
	(11, 60, 80, 20),
	(12, 2, 2, 1),
	(13, 40, 40, 10),
	(14, 5, 5, 1),
	(15, 3, 3, 1),
	(16, 4, 4, 2),
	(17, 6, 6, 2),
	(18, 60, 60, 21),
	(19, 5, 8, 2);

-- Dumping structure for table travelpedia.resort_thumbnail
CREATE TABLE IF NOT EXISTS `resort_thumbnail` (
  `resort_thumbnail` varchar(150) NOT NULL,
  `resort_id` int NOT NULL,
  PRIMARY KEY (`resort_thumbnail`),
  KEY `fk_resort_thumbnail_resort1_idx` (`resort_id`),
  CONSTRAINT `fk_resort_thumbnail_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.resort_thumbnail: ~17 rows (approximately)
INSERT IGNORE INTO `resort_thumbnail` (`resort_thumbnail`, `resort_id`) VALUES
	('../../resources//resort-tn-images//The Villas_6606d7c991418.jpeg', 1),
	('../../resources//resort-tn-images//Blackpool Hotel_6607175a22e55.jpeg', 2),
	('../../resources//resort-tn-images//Cabana_66090f15f1d5b.jpeg', 3),
	('../../resources//resort-tn-images//Kalpitiya Resort 01_660f6250ae832.jpeg', 5),
	('../../resources//resort-tn-images//Arugam Bay Hotel 2_660f64b1676b1.jpeg', 7),
	('../../resources//resort-tn-images//Balapitiya Resort 1_660f661917eff.jpeg', 8),
	('../../resources//resort-tn-images//Bibile Resort_660f9be191117.jpeg', 9),
	('../../resources/resort-tn-images/gamodh-citadel-resort.svg', 10),
	('../../resources//resort-tn-images//ITC Ratnadipa_665ee2c67c316.jpeg', 11),
	('../../resources//resort-tn-images//Dels Haven_665f1583343e1.jpeg', 12),
	('../../resources//resort-tn-images//Club Waskaduwa_665f19210fdcd.png', 13),
	('../../resources//resort-tn-images//W15 Hanthana_66600ae0dd5ef.svg', 14),
	('../../resources//resort-tn-images//W15 Nuwara Eliya_66600d71b9316.svg', 15),
	('../../resources//resort-tn-images//W15 Weligama_66600f76cb993.svg', 16),
	('../../resources//resort-tn-images//W15 Ahangama Escape_66601294adbfd.jpeg', 17),
	('../../resources//resort-tn-images//Anantara Kalutara_666015c80d751.jpeg', 18),
	('../../resources//resort-tn-images//Hotel A_667e84de0aab6.png', 19);

-- Dumping structure for table travelpedia.resort_user
CREATE TABLE IF NOT EXISTS `resort_user` (
  `email` varchar(100) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `mobile_number` varchar(11) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `gender_id` int DEFAULT NULL,
  `joined_datetime` datetime NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `verification_code` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_user_gender1_idx` (`gender_id`),
  CONSTRAINT `fk_user_gender10` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`gender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.resort_user: ~5 rows (approximately)
INSERT IGNORE INTO `resort_user` (`email`, `fname`, `lname`, `mobile_number`, `password`, `gender_id`, `joined_datetime`, `status`, `verification_code`) VALUES
	('amarupasinghe@gmail.com', 'Amarabandu', 'Rupasinghe', '0770123456', 'amaru_Rupa321', 1, '2024-06-05 12:12:47', 1, NULL),
	('pkuruvi37@gmail.com', 'Peter', 'Kuruvita', '0771003737', 'ChaChing_123', 1, '2024-06-03 12:00:35', 1, NULL),
	('rahulraigamage@gmail.com', 'Rahul', 'Raigamage', '0777123123', '_Ra1gam_', 1, '2024-06-08 17:17:31', 1, NULL),
	('realmonkey@gmail.com', 'Real', 'Monkey', '0771122334', 'fakePass!', 2, '2024-05-30 16:23:04', 1, NULL),
	('ruwanidelpitiya@gmail.com', 'Ruwani', 'Delpitiya', '0712345678', 'Roaring_L1on!', 2, '2024-06-04 18:42:51', 1, NULL);

-- Dumping structure for table travelpedia.room_rates
CREATE TABLE IF NOT EXISTS `room_rates` (
  `resort_id` int NOT NULL,
  `hb_double` int DEFAULT NULL,
  `fb_double` int DEFAULT NULL,
  `hb_triple` int DEFAULT NULL,
  `fb_triple` int DEFAULT NULL,
  `hb_suite` int DEFAULT NULL,
  `fb_suite` int DEFAULT NULL,
  PRIMARY KEY (`resort_id`),
  KEY `fk_rates_resort1_idx` (`resort_id`),
  CONSTRAINT `fk_rates_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.room_rates: ~17 rows (approximately)
INSERT IGNORE INTO `room_rates` (`resort_id`, `hb_double`, `fb_double`, `hb_triple`, `fb_triple`, `hb_suite`, `fb_suite`) VALUES
	(1, 60, 80, 70, 93, 110, 140),
	(2, 40, 55, 50, 70, 75, 100),
	(3, 30, 40, 60, 80, 80, 100),
	(5, 40, 50, 60, 70, 80, 90),
	(7, 80, 100, 120, 140, 200, 240),
	(8, 55, 75, 85, 105, 150, 200),
	(9, 60, 80, 80, 100, 120, 150),
	(10, 45, 60, 60, 75, 115, 150),
	(11, 140, 180, 200, 240, NULL, 260),
	(12, 35, 50, 60, 75, NULL, 150),
	(13, 100, 130, 150, 180, 200, 250),
	(14, 400, 480, 500, 600, 750, 900),
	(15, 150, 175, 180, 210, 300, 360),
	(16, 100, 125, 145, 180, 220, 280),
	(17, 90, 120, 120, 160, 200, 260),
	(18, 139, 189, 169, 219, 224, 279),
	(19, 30, 40, 50, 65, 75, 100);

-- Dumping structure for table travelpedia.ru_profile_images
CREATE TABLE IF NOT EXISTS `ru_profile_images` (
  `path` varchar(100) NOT NULL,
  `resort_user_email` varchar(100) NOT NULL,
  PRIMARY KEY (`path`),
  KEY `fk_ru_profile_images_resort_user1_idx` (`resort_user_email`),
  CONSTRAINT `fk_ru_profile_images_resort_user1` FOREIGN KEY (`resort_user_email`) REFERENCES `resort_user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.ru_profile_images: ~2 rows (approximately)
INSERT IGNORE INTO `ru_profile_images` (`path`, `resort_user_email`) VALUES
	('../../resources/profile_img/Peter_665dbad2a1af5.jpeg', 'pkuruvi37@gmail.com'),
	('../../resources/profile_img/Ruwani_665f142293301.jpeg', 'ruwanidelpitiya@gmail.com');

-- Dumping structure for table travelpedia.user
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(100) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `mobile_number` varchar(11) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `gender_id` int DEFAULT NULL,
  `joined_datetime` datetime NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `verification_code` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_user_gender1_idx` (`gender_id`),
  CONSTRAINT `fk_user_gender1` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`gender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.user: ~13 rows (approximately)
INSERT IGNORE INTO `user` (`email`, `fname`, `lname`, `mobile_number`, `password`, `gender_id`, `joined_datetime`, `status`, `verification_code`) VALUES
	('ashenlala@gmail.com', 'Ashen', 'Lalantha', '0771231234', 'Password!0', 1, '2024-05-05 13:25:36', 1, NULL),
	('hasithadhana421@gmail.com', 'Hasitha', 'Dhananjaya', '0770012345', 'A12345678', 1, '2024-04-19 08:17:54', 1, NULL),
	('logged482@gmail.com', 'New', 'User', '0771231212', 'Alpha!omega!_321', 1, '2024-05-31 14:17:47', 1, NULL),
	('nuwthush79@gmail.com', 'Nuwan', 'Thushantha', '0770023248', 'Nuw79Thu', 1, '2024-04-05 12:31:18', 1, NULL),
	('realmonkey@gmail.com', 'Real', 'Monkey', '0773417417', 'Monkey1sCool', 2, '2024-03-31 18:52:29', 1, '66584d3511f7e'),
	('sanjunadelpitiya1@gmail.com', 'Sanjuna', 'Delpitiya', '0712345650', 'testPass321', 1, '2024-03-30 11:39:05', 1, '663749bcb2ddf'),
	('sanjunadelpitiya@gmail.com', 'Sanjuna', 'Delpitiya', NULL, 'passworD321!', NULL, '2024-06-03 14:35:59', 1, NULL),
	('shehalimeemure32@yahoo.com', 'Shehali', 'Meemure', '0704321321', 'Hal1_Me3ms', 1, '2024-04-19 08:28:30', 1, NULL),
	('shenayahansali23@gmail.com', 'Shenaya', 'Hansali', '0770012345', 'S002h003', 2, '2024-04-19 08:20:57', 1, NULL),
	('shevdelpi14@gmail.com', 'Shevon', 'Delpachithra', '0776543543', 'Sh3v_p1', 1, '2024-04-19 08:31:36', 1, NULL),
	('shsrapmjt2@gmail.com', 'Sahasra', 'Pamujitha', '0741231234', 'S258p904', 1, '2024-04-19 08:23:56', 1, NULL),
	('user-sampleAsh@hotmail.com', 'Ashan ', 'Jayawardana', '0712345678', 'passKey3', 1, '2024-03-31 18:39:31', 1, NULL),
	('xlr8adrsd@gmail.com', 'xlr8', 'Adrsd', NULL, NULL, NULL, '2024-06-03 11:21:06', 1, NULL);

-- Dumping structure for table travelpedia.user_address
CREATE TABLE IF NOT EXISTS `user_address` (
  `user_address_id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `no` varchar(10) NOT NULL,
  `street1` varchar(45) DEFAULT NULL,
  `street2` varchar(45) DEFAULT NULL,
  `city_id` int NOT NULL,
  PRIMARY KEY (`user_address_id`),
  KEY `fk_user_address_city1_idx` (`city_id`),
  KEY `fk_user_address_user1_idx` (`user_email`),
  CONSTRAINT `fk_user_address_city1` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`),
  CONSTRAINT `fk_user_address_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.user_address: ~3 rows (approximately)
INSERT IGNORE INTO `user_address` (`user_address_id`, `user_email`, `no`, `street1`, `street2`, `city_id`) VALUES
	(4, 'sanjunadelpitiya1@gmail.com', '34', 'Street 5', 'Colombo-Batticaloa Highway (A4)', 3),
	(7, 'realmonkey@gmail.com', '123', 'Street 1', 'Street 2', 1),
	(8, 'hasithadhana421@gmail.com', '23', 'South Road', 'Madiwela', 5);

-- Dumping structure for table travelpedia.wishlist
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `resort_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_has_resort_resort1_idx` (`resort_id`),
  KEY `fk_wishlist_user1_idx` (`user_email`),
  CONSTRAINT `fk_user_has_resort_resort1` FOREIGN KEY (`resort_id`) REFERENCES `resort` (`resort_id`),
  CONSTRAINT `fk_wishlist_user1` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb3;

-- Dumping data for table travelpedia.wishlist: ~1 rows (approximately)
INSERT IGNORE INTO `wishlist` (`id`, `user_email`, `resort_id`) VALUES
	(59, 'sanjunadelpitiya@gmail.com', 8);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
