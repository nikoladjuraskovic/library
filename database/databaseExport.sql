
-- heidisql database export
-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for library
CREATE DATABASE IF NOT EXISTS `library` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `library`;

-- Dumping structure for table library.books
CREATE TABLE IF NOT EXISTS `books` (
                                       `BookID` int NOT NULL AUTO_INCREMENT,
                                       `Title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
                                       `Author` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
                                       `Year` int NOT NULL DEFAULT '0',
                                       `Amount` int NOT NULL,
                                       PRIMARY KEY (`BookID`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table library.books: ~9 rows (approximately)
INSERT INTO `books` (`BookID`, `Title`, `Author`, `Year`, `Amount`) VALUES
                                                                        (1, 'Lord of the Rings 1', 'J.R.R. Tolkien', 1954, 5),
                                                                        (2, 'Clean Code', 'Robert Cecil Martin', 2008, 3),
                                                                        (3, 'The Almanack of Naval Ravickant', 'Eric Jorgenson', 2020, 4),
                                                                        (68, 'Book11', 'Author11', 20211, 3),
                                                                        (69, 'Some Title', 'Some Author', 2024, 2),
                                                                        (70, 'Book33', 'Author33', 2033, 3),
                                                                        (71, 'Title2', 'AuthorNeki', 2323, 4),
                                                                        (72, 'Neki naslov', 'Neka knjiga', 1223, 5),
                                                                        (74, 'Learning PHP, MySQL & JavaScript', 'Robin Nixon', 2015, 3);

-- Dumping structure for table library.rents
CREATE TABLE IF NOT EXISTS `rents` (
                                       `RentID` int NOT NULL AUTO_INCREMENT,
                                       `BookID` int NOT NULL,
                                       `UserID` int NOT NULL,
                                       `Approved` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
                                       `Returned` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
                                       PRIMARY KEY (`RentID`),
                                       KEY `FK_rents_books` (`BookID`),
                                       KEY `FK_rents_users` (`UserID`),
                                       CONSTRAINT `FK_rents_books` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`),
                                       CONSTRAINT `FK_rents_users` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table library.rents: ~21 rows (approximately)
INSERT INTO `rents` (`RentID`, `BookID`, `UserID`, `Approved`, `Returned`) VALUES
                                                                               (10, 1, 1, 'Approved', 'Returned'),
                                                                               (11, 2, 1, 'Approved', 'Returned'),
                                                                               (12, 3, 1, 'Approved', 'Returned'),
                                                                               (13, 68, 1, 'Declined', '-'),
                                                                               (14, 69, 1, 'Approved', 'Returned'),
                                                                               (15, 1, 1, 'Approved', 'Returned'),
                                                                               (16, 2, 1, 'Declined', '-'),
                                                                               (17, 69, 1, 'Approved', 'Returned'),
                                                                               (18, 69, 1, 'Approved', 'Returned'),
                                                                               (19, 1, 1, 'Approved', 'Returned'),
                                                                               (20, 2, 1, 'Declined', '-'),
                                                                               (21, 3, 1, 'Approved', 'Returned'),
                                                                               (22, 1, 1, 'Approved', 'Returned'),
                                                                               (23, 2, 1, 'Declined', '-'),
                                                                               (24, 3, 1, 'Approved', 'Returned'),
                                                                               (25, 1, 1, 'Approved', 'Returned'),
                                                                               (26, 2, 1, 'Approved', 'Returned'),
                                                                               (27, 3, 1, 'Declined', '-'),
                                                                               (28, 2, 1, 'Approved', 'Returned'),
                                                                               (29, 1, 1, 'Declined', '-'),
                                                                               (30, 1, 1, 'Approved', 'Returned');

-- Dumping structure for table library.users
CREATE TABLE IF NOT EXISTS `users` (
                                       `UserID` int NOT NULL AUTO_INCREMENT,
                                       `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
                                       `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
                                       `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
                                       PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table library.users: ~0 rows (approximately)
INSERT INTO `users` (`UserID`, `username`, `password`, `role`) VALUES
                                                                   (1, 'user', '$2y$12$A0ihQNxWvwew6OFIq6wg3e.oV5PjBV.otqeEVnv8AM0sn1L6sBYjq', 'user'),
                                                                   (2, 'admin', '$2y$12$eTsp0eQgfKYWLCNY.ByXvuRWf2wUP5My8GibnfIT/OH5oxiYCALoa', 'admin');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
