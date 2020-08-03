-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: verifierscan_public
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `article_id` int NOT NULL AUTO_INCREMENT,
  `domain_id` int NOT NULL,
  `article_url` mediumtext NOT NULL,
  `article_title` varchar(256) DEFAULT NULL,
  `writing_score` decimal(5,2) NOT NULL,
  `final_score` decimal(5,2) NOT NULL,
  PRIMARY KEY (`article_id`),
  UNIQUE KEY `article_id_UNIQUE` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=616 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `domains`
--

DROP TABLE IF EXISTS `domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `domains` (
  `domain_id` int NOT NULL AUTO_INCREMENT,
  `org_id` int NOT NULL,
  `domain_root` varchar(256) NOT NULL,
  `url_score` decimal(5,2) NOT NULL,
  `sec_score` decimal(5,2) NOT NULL,
  PRIMARY KEY (`domain_id`),
  UNIQUE KEY `domain_id_UNIQUE` (`domain_id`),
  UNIQUE KEY `domain_root_UNIQUE` (`domain_root`)
) ENGINE=InnoDB AUTO_INCREMENT=572 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forbidden_domain_chars`
--

DROP TABLE IF EXISTS `forbidden_domain_chars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forbidden_domain_chars` (
  `id` int NOT NULL AUTO_INCREMENT,
  `forbidden` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organizations` (
  `org_id` int NOT NULL AUTO_INCREMENT,
  `org_name` varchar(256) NOT NULL,
  `bbb_rating` varchar(45) DEFAULT NULL,
  `org_score` decimal(5,2) NOT NULL,
  PRIMARY KEY (`org_id`),
  UNIQUE KEY `org_id_UNIQUE` (`org_id`),
  UNIQUE KEY `org_name_UNIQUE` (`org_name`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `date_time` varchar(256) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1201 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-02 22:26:59
