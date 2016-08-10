-- MySQL dump 10.15  Distrib 10.0.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: linuxday2016
-- ------------------------------------------------------
-- Server version	10.0.26-MariaDB-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chapter`
--

DROP TABLE IF EXISTS `chapter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chapter` (
  `chapter_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chapter_uid` varchar(32) CHARACTER SET utf8 NOT NULL,
  `chapter_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`chapter_ID`),
  UNIQUE KEY `chapter_uid` (`chapter_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conference`
--

DROP TABLE IF EXISTS `conference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conference` (
  `conference_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `conference_uid` varchar(64) CHARACTER SET utf8 NOT NULL,
  `conference_title` varchar(64) CHARACTER SET utf8 NOT NULL,
  `conference_subtitle` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `conference_venue` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `conference_city` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `conference_start` datetime NOT NULL,
  `conference_end` datetime NOT NULL,
  `conference_days` int(11) NOT NULL,
  `conference_day_change` varchar(8) CHARACTER SET utf8 NOT NULL,
  `conference_timeslot_duration` varchar(8) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`conference_ID`),
  UNIQUE KEY `conference_uid` (`conference_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `event_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_uid` varchar(100) CHARACTER SET utf8 NOT NULL,
  `event_title` varchar(100) CHARACTER SET utf8 NOT NULL,
  `event_subtitle` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `event_abstract` text CHARACTER SET utf8,
  `event_description` text CHARACTER SET utf8,
  `event_language` char(2) CHARACTER SET utf8 DEFAULT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `conference_ID` int(10) unsigned NOT NULL,
  `room_ID` int(10) unsigned NOT NULL,
  `track_ID` int(10) unsigned NOT NULL,
  `chapter_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`event_ID`),
  UNIQUE KEY `event_uid` (`event_uid`),
  KEY `room_ID` (`room_ID`),
  KEY `track_ID` (`track_ID`),
  KEY `chapter_ID` (`chapter_ID`),
  KEY `conference_ID` (`conference_ID`),
  CONSTRAINT `events_ibfk_5` FOREIGN KEY (`conference_ID`) REFERENCES `conference` (`conference_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `events_ibfk_6` FOREIGN KEY (`chapter_ID`) REFERENCES `chapter` (`chapter_ID`) ON UPDATE NO ACTION,
  CONSTRAINT `events_ibfk_7` FOREIGN KEY (`track_ID`) REFERENCES `track` (`track_ID`) ON UPDATE NO ACTION,
  CONSTRAINT `events_ibfk_8` FOREIGN KEY (`room_ID`) REFERENCES `room` (`room_ID`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_user`
--

DROP TABLE IF EXISTS `event_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_user` (
  `event_ID` int(10) unsigned NOT NULL,
  `user_ID` int(10) unsigned NOT NULL,
  UNIQUE KEY `user_ID_event_ID` (`event_ID`,`user_ID`),
  KEY `user_ID` (`user_ID`),
  KEY `event_ID` (`event_ID`),
  CONSTRAINT `event_user_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `event_user_ibfk_2` FOREIGN KEY (`event_ID`) REFERENCES `event` (`event_ID`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `room_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_uid` varchar(64) CHARACTER SET utf8 NOT NULL,
  `room_name` varchar(64) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`room_ID`),
  UNIQUE KEY `room_uid` (`room_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `track`
--

DROP TABLE IF EXISTS `track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `track` (
  `track_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `track_uid` varchar(64) CHARACTER SET utf8 NOT NULL,
  `track_name` varchar(64) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`track_ID`),
  UNIQUE KEY `track_uid` (`track_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_uid` varchar(20) CHARACTER SET utf8 NOT NULL,
  `user_name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `user_surname` varchar(20) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(32) CHARACTER SET utf8 NOT NULL,
  `user_site` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`user_ID`),
  UNIQUE KEY `user_uid` (`user_uid`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-10 11:30:22
