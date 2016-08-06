SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `conferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `venue` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `start` char(10) NOT NULL,
  `end` char(10) NOT NULL,
  `days` int(11) NOT NULL,
  `day_change` varchar(8) NOT NULL,
  `timeslot_duration` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conference_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `subtitle` varchar(100) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `abstract` text,
  `description` text,
  `language` char(2) DEFAULT NULL,
  `room` int(11) NOT NULL,
  `track` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `room` (`room`),
  KEY `track` (`track`),
  KEY `type` (`type`),
  KEY `conference_id` (`conference_id`),
  CONSTRAINT `events_ibfk_5` FOREIGN KEY (`conference_id`) REFERENCES `conferences` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `events_ibfk_6` FOREIGN KEY (`type`) REFERENCES `event_types` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `events_ibfk_7` FOREIGN KEY (`track`) REFERENCES `tracks` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `events_ibfk_8` FOREIGN KEY (`room`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `events_people` (
  `event_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  UNIQUE KEY `person_id_event_id` (`person_id`,`event_id`),
  KEY `person_id` (`person_id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `events_people_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `events_people_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `event_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `tracks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
