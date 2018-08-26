-- MySQL dump 10.15  Distrib 10.0.30-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: linuxday2016
-- ------------------------------------------------------
-- Server version	10.0.30-MariaDB-0+deb8u2

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
-- Table structure for table `ldto_chapter`
--

DROP TABLE IF EXISTS `ldto_chapter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_chapter` (
  `chapter_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chapter_uid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chapter_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`chapter_ID`),
  UNIQUE KEY `chapter_uid` (`chapter_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_chapter`
--

LOCK TABLES `ldto_chapter` WRITE;
/*!40000 ALTER TABLE `ldto_chapter` DISABLE KEYS */;
INSERT INTO `ldto_chapter` VALUES (1,'talk','Talk');
INSERT INTO `ldto_chapter` VALUES (2,'party','Linux Installation Party');
INSERT INTO `ldto_chapter` VALUES (3,'coderdojo','Coderdojo');
INSERT INTO `ldto_chapter` VALUES (4,'learning','Corso');
/*!40000 ALTER TABLE `ldto_chapter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_conference`
--

DROP TABLE IF EXISTS `ldto_conference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_conference` (
  `conference_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `conference_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conference_title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conference_subtitle` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conference_acronym` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conference_persons_url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Not part of frab/Pentabarf standard',
  `conference_events_url` varchar(512) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Not part of frab/Pentabarf standard',
  `conference_quote` text COLLATE utf8mb4_unicode_ci,
  `conference_city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Has to be removed',
  `conference_description` text COLLATE utf8mb4_unicode_ci,
  `conference_start` datetime NOT NULL,
  `conference_end` datetime NOT NULL,
  `conference_days` int(11) NOT NULL,
  `location_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`conference_ID`),
  UNIQUE KEY `conference_uid` (`conference_uid`),
  KEY `location_ID` (`location_ID`),
  CONSTRAINT `ldto_conference_ibfk_1` FOREIGN KEY (`location_ID`) REFERENCES `ldto_location` (`location_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_conference`
--

LOCK TABLES `ldto_conference` WRITE;
/*!40000 ALTER TABLE `ldto_conference` DISABLE KEYS */;
INSERT INTO `ldto_conference` VALUES (1,'2016','Linux Day Torino 2016',NULL,'LDTO16','http://linuxdaytorino.org/2016/user/%1$s','http://linuxdaytorino.org/2016/talk/%1$s',NULL,'Torino',NULL,'2016-10-22 14:00:00','2016-10-22 18:00:00',1,1);
INSERT INTO `ldto_conference` VALUES (2,'2015','LDTO15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2015-10-24 14:00:00','2015-10-24 18:00:00',1,2);
INSERT INTO `ldto_conference` VALUES (3,'2017','Linux Day Torino 2017',NULL,'LDTO16','http://linuxdaytorino.org/2017/user/%1$s','http://linuxdaytorino.org/2017/talk/%1$s',NULL,'Torino',NULL,'2017-10-28 14:00:00','2017-10-28 18:00:00',1,1);
/*!40000 ALTER TABLE `ldto_conference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_event`
--

DROP TABLE IF EXISTS `ldto_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_event` (
  `event_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_uid` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_subtitle` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_abstract` text COLLATE utf8mb4_unicode_ci,
  `event_description` text COLLATE utf8mb4_unicode_ci,
  `event_note` text COLLATE utf8mb4_unicode_ci,
  `event_language` char(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_start` datetime NOT NULL,
  `event_end` datetime NOT NULL,
  `event_img` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_subscriptions` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Enable subscriptions',
  `conference_ID` int(10) unsigned NOT NULL,
  `room_ID` int(10) unsigned NOT NULL,
  `track_ID` int(10) unsigned NOT NULL,
  `chapter_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`event_ID`),
  UNIQUE KEY `event_uid` (`event_uid`,`conference_ID`),
  KEY `room_ID` (`room_ID`),
  KEY `track_ID` (`track_ID`),
  KEY `chapter_ID` (`chapter_ID`),
  KEY `conference_ID` (`conference_ID`),
  KEY `event_start` (`event_start`),
  CONSTRAINT `events_ibfk_5` FOREIGN KEY (`conference_ID`) REFERENCES `ldto_conference` (`conference_ID`) ON DELETE CASCADE,
  CONSTRAINT `events_ibfk_6` FOREIGN KEY (`chapter_ID`) REFERENCES `ldto_chapter` (`chapter_ID`),
  CONSTRAINT `events_ibfk_7` FOREIGN KEY (`track_ID`) REFERENCES `ldto_track` (`track_ID`),
  CONSTRAINT `events_ibfk_8` FOREIGN KEY (`room_ID`) REFERENCES `ldto_room` (`room_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_event`
--

LOCK TABLES `ldto_event` WRITE;
/*!40000 ALTER TABLE `ldto_event` DISABLE KEYS */;
INSERT INTO `ldto_event` VALUES (17,'talk-base-1','Didattica del coding',NULL,NULL,'Le basi del coding sono fondamentali, come leggere e scrivere.\nQuali strumenti e metodi didattici hanno a disposizione insegnanti e genitori?',NULL,NULL,'2016-10-22 14:30:00','2016-10-22 15:30:00',NULL,0,1,11,1,1);
INSERT INTO `ldto_event` VALUES (21,'talk-dev-1','Introduzione alla programmazione con JavaScript',NULL,NULL,'Un viaggio nel magico mondo della programmazione con consigli pratici e tecnici per chi aspira a creare software e non solo subirlo.',NULL,NULL,'2016-10-22 14:00:00','2016-10-22 15:00:00','/2016/static/libre-icons/javascript.png',0,1,2,2,1);
INSERT INTO `ldto_event` VALUES (22,'talk-sys-1','Non bisogna aver paura di IPv6',NULL,NULL,'Una breve presentazione non tecnica di IPv6, dalle caratteristiche alle potenzialità, le differenze da IPv4 e l\'implementazione in ambiente GNU/Linux.',NULL,NULL,'2016-10-22 14:00:00','2016-10-22 15:00:00','/2016/static/libre-icons/ipv6.png',0,1,3,3,1);
INSERT INTO `ldto_event` VALUES (23,'talk-misc-1','La tecnologia LoRa e le sue applicazioni IoT',NULL,NULL,NULL,NULL,NULL,'2016-10-22 14:00:00','2016-10-22 15:00:00',NULL,0,1,4,4,1);
INSERT INTO `ldto_event` VALUES (24,'talk-base-2','Rinascimento 2.0',NULL,NULL,'Non è una lezione di storia... o forse sì. Stiamo scrivendo la storia che leggeranno i nostri pronipoti. Siamo spesso troppo presi dai gadget tecnologici per accorgerci che è in corso una rivoluzione, stiamo entrando in una nuova era.',NULL,NULL,'2016-10-22 15:00:00','2016-10-22 16:00:00',NULL,0,1,1,1,1);
INSERT INTO `ldto_event` VALUES (25,'talk-base-3','Utilizzi di GNU/Linux',NULL,NULL,'Il partecipanti saranno coinvolti in un sondaggio interattivo sugli utilizzi del software libero della vita di tutti i giorni. Si suggerisce di invitare il vostro classico conoscente scettico e/o fanboy (╯°□°)╯.','Il talk doveva prevedere un sondaggio interattivo con [OpenCV](https://it.wikipedia.org/wiki/OpenCV) ma purtroppo l\'idea è stata soppressa per mancanza di tempo e la presentazione è diventata una cozzaglia di argomenti messi insieme :D\r\n\r\nAl minuto 12 del talk si è detto che «la casa madre di un e-book non è autore di tale e-book», nel senso che non è *soltanto* autore di tale tecnologia, ma ne è anche *padrone*, fintanto che non ci sarà un software libero per utilizzarlo.\r\n\r\nAl minuto 18 si voleva intendere che alcuni sminuiscono il software libero paragonandolo al *comunismo* pensando che uccida il commercio. In realtà molti *freelance* (eccomi!) si guadagnano da vivere sviluppando software libero per aziende che semplicemente apprezzano di essere gli unici a detenere il totale controllo sui propri sistemi.\r\n\r\nAl minuto 27 mi sono dimenticato di mostrare qualche esempio con Blender, tipo [Tears of Steel](https://www.youtube.com/watch?v=R6MlUcmOul8&t=6m18s).\r\n\r\nAl minuto 31 ho accennato al fatto di aver caricato la presentazione sul sito da soli cinque minuti. L\'informazione è scorretta: era stata caricata sul sito da circa un\'ora. In ogni caso è stata fatta la notte dello stesso giorno. :D\r\n\r\nAl minuto 33 non ho fatto abbastanza capire bene quanto odio uTorrent. Per favore basta usare uTorrent! Perchè conoscerlo quando c\'è Transmission, Deluge, etc.? In ogni caso ecco la geniale [rappresentazione del protocollo bittorrent](http://mg8.org/processing/bt.html).\r\n\r\nAl minuto 39 ho citato [Aaron Swartz](https://it.wikipedia.org/wiki/Aaron_Swartz) e il documentario a lui dedicato [The Internet\'s Own Boy: The Story of Aaron Swartz](https://it.wikipedia.org/wiki/The_Internet%27s_Own_Boy:_The_Story_of_Aaron_Swartz). L\'informazione corretta è che Aaron Swartz si suicidò dopo aver subito una multa di 4 milioni di dollari e una potenziale detenzione fino a 50 anni.\r\n\r\nAl minuto 43 è stato citato un popolare e controverso software proprietario di tracciamento dei visitatori. Se possiedi un sito web, utilizza [Piwik](https://piwik.org) per fare le stesse cose ma senza regalare i dati dei tuoi utenti ad altri intermediari.',NULL,'2016-10-22 16:00:00','2016-10-22 17:00:00',NULL,0,1,1,1,1);
INSERT INTO `ldto_event` VALUES (26,'talk-base-4','Linux al Comune di Torino',NULL,NULL,NULL,NULL,NULL,'2016-10-22 17:00:00','2016-10-22 18:00:00',NULL,0,1,1,1,1);
INSERT INTO `ldto_event` VALUES (27,'talk-dev-2','Yocto Project, un generatore automatico di distribuzioni linux embedded',NULL,NULL,'Lo Yocto Project è un progetto di collaborazione open source che fornisce modelli, strumenti e metodi che consentono di creare sistemi Linux-based personalizzati per i prodotti embedded indipendenti dall\'architettura hardware. Il progetto è stato creato nel 2010 come una collaborazione tra molti produttori di hardware, fornitori di sistemi operativi open-source e aziende di elettronica per portare un po\' di ordine nel caos di sviluppo di Linux Embedded. Perché usare il Progetto Yocto? Perchè è un ambiente di sviluppo Linux embedded completo con gli strumenti, i metadati e la documentazione - tutto ciò che serve. Gli strumenti gratuiti che Yocto mette a disposizione sono potenti e facilmente generabili (compresi gli ambienti di emulazione, debugger, un toolkit di generatore di applicazioni, ecc) e permettono di realizzare e portare avanti progetti, senza causare la perdita delle ottimizzazioni e degli investimenti effettuati nel corso del fase di prototipazione. Il Progetto Yocto favorisce l\'adozione di questa tecnologia da parte della comunità open source permettendo agli utenti di concentrarsi sulle caratteristiche e lo sviluppo del proprio prodotto.',NULL,NULL,'2016-10-22 15:00:00','2016-10-22 16:00:00',NULL,0,1,2,2,1);
INSERT INTO `ldto_event` VALUES (28,'talk-dev-3','Dieci anni dietro a FidoCadJ',NULL,NULL,'Dietro le quinte del progetto open source [FidoCadJ](http://darwinne.github.io/FidoCadJ/): un editor per l\'elettronica (e non solo), usato in diversi forum italiani.',NULL,NULL,'2016-10-22 16:00:00','2016-10-22 17:00:00','/2016/static/libre-icons/fidocadj.png',0,1,2,2,1);
INSERT INTO `ldto_event` VALUES (29,'talk-dev-4','Un bot di Telegram con Python',NULL,'Usare Python e la libreria Telepot per sviluppare un semplice bot su Telegram che tira un dado da 6 per noi. Il tutto su un Raspberry Pi, piccolo, economico e parco in consumi.','Slide con esempi di codice e presentazione del Raspberry dal vivo, se c\'è connettività e tempo una breve dimostrazione.',NULL,NULL,'2016-10-22 17:00:00','2016-10-22 18:00:00','/2016/static/libre-icons/bot_father.jpg',0,1,2,2,1);
INSERT INTO `ldto_event` VALUES (30,'talk-sys-2','Docker: distribuiamo applicazioni',NULL,NULL,'Una introduzione ai sistemi distribuiti tramite la gestione dei container realizzati con Docker.\nUna risposta alle domande: Docker a cosa serve? Come si installa? Come si gestisce?',NULL,NULL,'2016-10-22 15:00:00','2016-10-22 16:00:00','/2016/static/libre-icons/docker.png',0,1,3,3,1);
INSERT INTO `ldto_event` VALUES (31,'talk-sys-4','Hadoop - BigData in streaming',NULL,NULL,'Big Data, cosa sono e dove vanno? Use case di un cluster Hadoop per l\'elaborazione in streaming con Apache NiFi, Kafka e Solr.',NULL,NULL,'2016-10-22 17:00:00','2016-10-22 18:00:00','/2016/static/libre-icons/hadoop.png',0,1,3,3,1);
INSERT INTO `ldto_event` VALUES (32,'talk-sys-3','InfoSec. Istruzioni per l\'uso.',NULL,NULL,'InfoSec → Information Security → Sicurezza delle informazioni.\n\nIl talk illustrerà gli applicativi e darà i giusti consigli per poter tenere maggiormente al sicuro la propria \"vita digitale\".',NULL,NULL,'2016-10-22 16:00:00','2016-10-22 17:00:00',NULL,0,1,3,3,1);
INSERT INTO `ldto_event` VALUES (33,'talk-misc-2','Sostenibilità e Open Culture all\'Università',NULL,'Le apparecchiature guaste sono una risorsa più che un rifiuto. Al Politecnico un gruppo di studenti intende costituire un team dove i ragazzi possano rigenerare le apparecchiature guaste, condividere informazioni e fornire alla società circostante apparecchiature elettroniche funzionanti gratuitamente.',NULL,NULL,NULL,'2016-10-22 15:00:00','2016-10-22 16:00:00',NULL,0,1,4,4,1);
INSERT INTO `ldto_event` VALUES (34,'talk-misc-3','Wikidata: la base di conoscenza libera',NULL,NULL,NULL,NULL,NULL,'2016-10-22 16:00:00','2016-10-22 17:00:00','/2016/static/libre-icons/wikidata.png',0,1,4,4,1);
INSERT INTO `ldto_event` VALUES (35,'talk-misc-4','Wikipedia',NULL,NULL,NULL,NULL,NULL,'2016-10-22 17:00:00','2016-10-22 18:00:00','/2016/static/libre-icons/wikipedia.png',0,1,4,4,1);
INSERT INTO `ldto_event` VALUES (37,'lip','LIP','Linux Installation Party','Installazione di varie distribuzioni GNU/Linux.','Linux Installation Party e assistenza tecnica distribuzioni GNU/Linux. Gestito da volontari.',NULL,NULL,'2016-10-22 14:00:00','2016-10-22 18:00:00',NULL,0,1,9,5,2);
INSERT INTO `ldto_event` VALUES (38,'coderdojo','Coderdojo',NULL,'Laboratorio di coding per i più piccoli a tema Linux Day.','Ebbene sì. Per la prima volta nelle edizioni torinesi del Linux Day, si è deciso di ospitare un CoderDojo, un po\' particolare, dove i ninja si confronteranno con tematiche fondamentali, come il Software Libero e lo sviluppo Open Source. Entra a far parte della gang del Software Libero! =D<br>\n<br>\n<a href=\"https://attendize.ldto.it/e/3/coderdojo-at-linuxday\">Clicca qui per prenotare</a>.\n<br>\n<br>\nUn ringraziamento particolare ai due gruppi che hanno reso possibile quest\'iniziativa CoderDojo Torino e CoderDojo Torino 2.',NULL,NULL,'2016-10-22 14:30:00','2016-10-22 17:30:00',NULL,0,1,10,5,3);
INSERT INTO `ldto_event` VALUES (45,'gnu-linux-base','Lezione introduttiva corso GNU/Linux',NULL,NULL,'Questa è stata la prima lezione introduttiva dell\'iniziativa del comitato Linux Day Torino.\n\nSi è trattata di un\'introduzione a GNU/Linux e al mondo del software libero.',NULL,NULL,'2016-11-15 18:00:00','2016-11-15 19:30:00','/2016/static/corsi-unito.png',1,1,12,1,4);
INSERT INTO `ldto_event` VALUES (46,'gnu-linux-base-installation','Installiamo insieme una distribuzione GNU/Linux',NULL,NULL,'Questa è la seconda lezione di un\'iniziativa promossa dal comitato Linux Day Torino.',NULL,NULL,'2016-11-23 18:00:00','2016-11-23 19:30:00','/2016/static/corsi-unito.png',1,1,10,1,4);
INSERT INTO `ldto_event` VALUES (47,'gnu-linux-base-debian-maintenance','Manutenzione di un sistema basato su Debian',NULL,NULL,'La gestione di un sistema Debian-like (Debian, varie Ubuntu, etc.).\n\nQuesta è la terza lezione di un\'iniziativa promossa dal comitato Linux Day Torino.',NULL,NULL,'2016-11-30 18:00:00','2016-11-30 19:30:00','/2016/static/corsi-unito.png',1,1,10,1,4);
INSERT INTO `ldto_event` VALUES (48,'gnu-linux-base-command-line','I comandi di base di un sistema GNU/Linux',NULL,NULL,'Conoscere i comandi di base per l\'amministrazione del filesystem e di altre parti del tuo sistema GNU/Linux.\n\nQuesta è la quarta lezione di un\'iniziativa promossa dal comitato Linux Day Torino.',NULL,NULL,'2016-12-07 18:00:00','2016-12-07 19:30:00','/2016/static/corsi-unito.png',1,1,10,1,4);
INSERT INTO `ldto_event` VALUES (49,'gnu-linux-base-sysadmin','Gestione del sistema e dei servizi in un sistema GNU/Linux',NULL,NULL,'Conoscere quali servizi e quali parti compongono un sistema GNU/Linux e come amministrarli al meglio.\n\nQuesta è la quinta lezione di un\'iniziativa promossa dal comitato Linux Day Torino.',NULL,NULL,'2016-12-14 18:00:00','2016-12-14 19:30:00','/2016/static/corsi-unito.png',1,1,10,1,4);
INSERT INTO `ldto_event` VALUES (50,'gnu-linux-base-award-ceremony','Consegna degli attestati',NULL,NULL,'I più meritevoli e i più presenti saranno premiati con attestati e adesivi!\n\nQuesta giornata conclude le lezioni frutto di un\'iniziativa promossa dal comitato Linux Day Torino.',NULL,NULL,'2016-12-21 18:00:00','2016-12-21 19:30:00','/2016/static/corsi-unito.png',1,1,10,1,4);
/*!40000 ALTER TABLE `ldto_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_event_user`
--

DROP TABLE IF EXISTS `ldto_event_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_event_user` (
  `event_ID` int(10) unsigned NOT NULL,
  `user_ID` int(10) unsigned NOT NULL,
  `event_user_order` int(11) NOT NULL,
  UNIQUE KEY `user_ID_event_ID` (`event_ID`,`user_ID`),
  KEY `user_ID` (`user_ID`),
  KEY `event_ID` (`event_ID`),
  KEY `order` (`event_user_order`),
  CONSTRAINT `ldto_event_user_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `ldto_user` (`user_ID`) ON DELETE CASCADE,
  CONSTRAINT `ldto_event_user_ibfk_2` FOREIGN KEY (`event_ID`) REFERENCES `ldto_event` (`event_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_event_user`
--

LOCK TABLES `ldto_event_user` WRITE;
/*!40000 ALTER TABLE `ldto_event_user` DISABLE KEYS */;
INSERT INTO `ldto_event_user` VALUES (17,3,0);
INSERT INTO `ldto_event_user` VALUES (21,8,0);
INSERT INTO `ldto_event_user` VALUES (22,13,0);
INSERT INTO `ldto_event_user` VALUES (23,18,0);
INSERT INTO `ldto_event_user` VALUES (23,25,0);
INSERT INTO `ldto_event_user` VALUES (23,26,0);
INSERT INTO `ldto_event_user` VALUES (24,7,0);
INSERT INTO `ldto_event_user` VALUES (25,1,0);
INSERT INTO `ldto_event_user` VALUES (26,27,0);
INSERT INTO `ldto_event_user` VALUES (27,10,0);
INSERT INTO `ldto_event_user` VALUES (28,11,0);
INSERT INTO `ldto_event_user` VALUES (29,12,0);
INSERT INTO `ldto_event_user` VALUES (30,14,0);
INSERT INTO `ldto_event_user` VALUES (31,15,0);
INSERT INTO `ldto_event_user` VALUES (31,16,0);
INSERT INTO `ldto_event_user` VALUES (32,17,0);
INSERT INTO `ldto_event_user` VALUES (33,20,0);
INSERT INTO `ldto_event_user` VALUES (34,23,0);
INSERT INTO `ldto_event_user` VALUES (35,21,0);
INSERT INTO `ldto_event_user` VALUES (45,1,0);
INSERT INTO `ldto_event_user` VALUES (46,28,0);
INSERT INTO `ldto_event_user` VALUES (47,1,0);
INSERT INTO `ldto_event_user` VALUES (48,29,0);
INSERT INTO `ldto_event_user` VALUES (49,2,0);
INSERT INTO `ldto_event_user` VALUES (33,24,1);
/*!40000 ALTER TABLE `ldto_event_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_location`
--

DROP TABLE IF EXISTS `ldto_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_location` (
  `location_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_note` text COLLATE utf8mb4_unicode_ci,
  `location_geothumb` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_lat` float NOT NULL,
  `location_lng` float NOT NULL,
  `location_zoom` int(1) DEFAULT NULL,
  PRIMARY KEY (`location_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_location`
--

LOCK TABLES `ldto_location` WRITE;
/*!40000 ALTER TABLE `ldto_location` DISABLE KEYS */;
INSERT INTO `ldto_location` VALUES (1,'dipartimento-di-informatica-di-torino','Dipartimento di Informatica','Torino, Via Pessinetto 12','Puoi prendere il tram n°**9** e n°**3**, scendendo alla fermata *Ospedale Amedeo di Savoia / Dipartimento di Informatica*.\n\nDalla fermata della metropolitana *XVIII Dicembre* puoi prendere il pullman n°**59** e n°**59/** scendendo alla fermata *Svizzera*.','/2016/static/openstreetmap-unito.svg',45.09,7.65917,NULL);
INSERT INTO `ldto_location` VALUES (2,'dipartimento-di-biotecnologie','Dipartimento di Biotecnologie','Via Nizza 52, Torino','La fermata **Nizza** della metropolitana è a 50 metri dal Dipartimento di Biotecnologie.','http://linuxdaytorino.org/2015/images/biotech.jpg',9.999,7.674,NULL);
/*!40000 ALTER TABLE `ldto_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_room`
--

DROP TABLE IF EXISTS `ldto_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_room` (
  `room_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`room_ID`),
  UNIQUE KEY `room_uid` (`room_uid`),
  KEY `location_ID` (`location_ID`),
  CONSTRAINT `ldto_room_ibfk_1` FOREIGN KEY (`location_ID`) REFERENCES `ldto_location` (`location_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_room`
--

LOCK TABLES `ldto_room` WRITE;
/*!40000 ALTER TABLE `ldto_room` DISABLE KEYS */;
INSERT INTO `ldto_room` VALUES (1,'a','Aula B',1);
INSERT INTO `ldto_room` VALUES (2,'b','Aula A',1);
INSERT INTO `ldto_room` VALUES (3,'c','Aula D',1);
INSERT INTO `ldto_room` VALUES (4,'d','Aula C',1);
INSERT INTO `ldto_room` VALUES (5,'lab-1','Spazio Coderdojo',1);
INSERT INTO `ldto_room` VALUES (6,'lab-2','Spazio Restart',1);
INSERT INTO `ldto_room` VALUES (8,'first-floor','Primo piano',2);
INSERT INTO `ldto_room` VALUES (9,'lab-turing','Laboratorio Turing',1);
INSERT INTO `ldto_room` VALUES (10,'lab-dijkstra','Laboratorio Dijkstra',1);
INSERT INTO `ldto_room` VALUES (11,'f','Aula F',1);
INSERT INTO `ldto_room` VALUES (12,'lab-von-neumann','Laboratorio von Neumann',1);
/*!40000 ALTER TABLE `ldto_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_sharable`
--

DROP TABLE IF EXISTS `ldto_sharable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_sharable` (
  `sharable_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sharable_title` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Is this useful?',
  `sharable_path` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sharable_type` enum('video','image','document','youtube') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sharable_mimetype` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Must be set for videos',
  `sharable_license` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`sharable_ID`),
  KEY `event_ID` (`event_ID`),
  CONSTRAINT `ldto_sharable_ibfk_1` FOREIGN KEY (`event_ID`) REFERENCES `ldto_event` (`event_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_sharable`
--

LOCK TABLES `ldto_sharable` WRITE;
/*!40000 ALTER TABLE `ldto_sharable` DISABLE KEYS */;
INSERT INTO `ldto_sharable` VALUES (1,NULL,'/2016/static/uploads/Telegram_bot.odp','document',NULL,'cc-by-sa-4.0',29);
INSERT INTO `ldto_sharable` VALUES (2,NULL,'/2016/static/uploads/FidoCadJ.pdf','document',NULL,'cc-by-sa-4.0',28);
INSERT INTO `ldto_sharable` VALUES (3,NULL,'/2016/static/uploads/Utilizzi_di_GNU_Linux.odp','document',NULL,'cc-by-sa-4.0',25);
INSERT INTO `ldto_sharable` VALUES (4,NULL,'3V2mhlOce6E','youtube',NULL,'cc-by-sa-4.0',24);
INSERT INTO `ldto_sharable` VALUES (6,NULL,'dCMvkmztdjk','youtube',NULL,'cc-by-sa-4.0',25);
INSERT INTO `ldto_sharable` VALUES (7,NULL,'//static.reyboz.it/2016/linux-day-torino/dieci-anni-FidoCadJ.mp4','video','video/mp4','cc-by-sa-4.0',28);
INSERT INTO `ldto_sharable` VALUES (8,NULL,'/2016/static/uploads/intro-programmazione-js.pdf','document',NULL,'cc-by-sa-4.0',21);
INSERT INTO `ldto_sharable` VALUES (9,NULL,'//static.reyboz.it/2016/linux-day-torino/telegram-bot-python.mp4','video','video/mp4','cc-by-sa-4.0',29);
INSERT INTO `ldto_sharable` VALUES (10,NULL,'//static.reyboz.it/2016/linux-day-torino/yocto-project.mp4','video','video/mp4','cc-by-sa-4.0',27);
INSERT INTO `ldto_sharable` VALUES (11,NULL,'ftp://ftp.koansoftware.com/public/talks/LinuxDay2016/LinuxDay-2016-Yocto-Koan.pdf','document','','cc-by-sa-3.0',27);
INSERT INTO `ldto_sharable` VALUES (12,NULL,'/2016/static/uploads/Docker.odp','document','','cc-by-nc-sa-4.0',30);
INSERT INTO `ldto_sharable` VALUES (13,NULL,'/2016/static/learning/unito/terminale.html','document',NULL,'cc-by-sa-4.0',48);
INSERT INTO `ldto_sharable` VALUES (14,NULL,'//static.reyboz.it/2016/linux-day-torino/corsi-unito-dip-info/glossario-del-software-libero.odp','document',NULL,'cc-by-sa-4.0',45);
INSERT INTO `ldto_sharable` VALUES (15,NULL,'//static.reyboz.it/2016/linux-day-torino/corsi-unito-dip-info/glossario-del-software-libero.pdf','document',NULL,'cc-by-sa-4.0',45);
INSERT INTO `ldto_sharable` VALUES (16,NULL,'//static.reyboz.it/2016/linux-day-torino/corsi-unito-dip-info/debian-gnu-linux-installation.pdf','document',NULL,'wtfpl',46);
INSERT INTO `ldto_sharable` VALUES (17,NULL,'//static.reyboz.it/2016/linux-day-torino/corsi-unito-dip-info/debian-gnu-linux-installation.odp','document',NULL,'wtfpl',46);
INSERT INTO `ldto_sharable` VALUES (18,NULL,'/2016/static/learning/unito/debian-base.md','document',NULL,'cc-by-nc-sa-4.0',47);
/*!40000 ALTER TABLE `ldto_sharable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_skill`
--

DROP TABLE IF EXISTS `ldto_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_skill` (
  `skill_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `skill_uid` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skill_title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skill_type` enum('programming','subject') COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`skill_ID`),
  UNIQUE KEY `skill_uid` (`skill_uid`),
  KEY `skill_type` (`skill_type`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_skill`
--

LOCK TABLES `ldto_skill` WRITE;
/*!40000 ALTER TABLE `ldto_skill` DISABLE KEYS */;
INSERT INTO `ldto_skill` VALUES (1,'asd','asd','subject');
INSERT INTO `ldto_skill` VALUES (2,'php','PHP','programming');
INSERT INTO `ldto_skill` VALUES (3,'js','JavaScript','programming');
INSERT INTO `ldto_skill` VALUES (4,'microsoft-windows','Microsoft Windows','subject');
INSERT INTO `ldto_skill` VALUES (5,'node-js','NodeJS','programming');
INSERT INTO `ldto_skill` VALUES (6,'apple','Apple','subject');
INSERT INTO `ldto_skill` VALUES (7,'java','Java','programming');
INSERT INTO `ldto_skill` VALUES (8,'cpp','C++','programming');
INSERT INTO `ldto_skill` VALUES (9,'ubuntu','Ubuntu','subject');
INSERT INTO `ldto_skill` VALUES (10,'gnu-linux','GNU/Linux','subject');
INSERT INTO `ldto_skill` VALUES (11,'turbo-pascal','Turbo Pascal','programming');
INSERT INTO `ldto_skill` VALUES (12,'free-software','Software Libero','subject');
INSERT INTO `ldto_skill` VALUES (13,'debian','Debian','subject');
INSERT INTO `ldto_skill` VALUES (14,'inkscape','Inkscape','subject');
INSERT INTO `ldto_skill` VALUES (15,'adobe-illustrator','Adobe Illustrator','subject');
INSERT INTO `ldto_skill` VALUES (16,'svg','Immagini vettoriali','subject');
INSERT INTO `ldto_skill` VALUES (17,'teach','Insegnare','subject');
INSERT INTO `ldto_skill` VALUES (18,'raee','Recupero del RAEE','subject');
INSERT INTO `ldto_skill` VALUES (19,'blender','Blender','subject');
INSERT INTO `ldto_skill` VALUES (20,'c','C','programming');
INSERT INTO `ldto_skill` VALUES (21,'wiki','Wikipedia','subject');
INSERT INTO `ldto_skill` VALUES (22,'embedded','Embedded','subject');
INSERT INTO `ldto_skill` VALUES (23,'haskell','Haskell','programming');
/*!40000 ALTER TABLE `ldto_skill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_subscription`
--

DROP TABLE IF EXISTS `ldto_subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_subscription` (
  `subscription_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subscription_email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `subscription_date` datetime NOT NULL,
  `subscription_token` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_ID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`subscription_ID`),
  UNIQUE KEY `subscription_email` (`event_ID`,`subscription_email`),
  CONSTRAINT `ldto_subscription_ibfk_1` FOREIGN KEY (`event_ID`) REFERENCES `ldto_event` (`event_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_subscription`
--

LOCK TABLES `ldto_subscription` WRITE;
/*!40000 ALTER TABLE `ldto_subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `ldto_subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_track`
--

DROP TABLE IF EXISTS `ldto_track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_track` (
  `track_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `track_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `track_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `track_order` smallint(1) NOT NULL,
  `track_label` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`track_ID`),
  UNIQUE KEY `track_uid` (`track_uid`),
  KEY `track_order` (`track_order`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_track`
--

LOCK TABLES `ldto_track` WRITE;
/*!40000 ALTER TABLE `ldto_track` DISABLE KEYS */;
INSERT INTO `ldto_track` VALUES (1,'base','Base',2,'Adatto ad un pubblico senza pre-conoscenze particolari');
INSERT INTO `ldto_track` VALUES (2,'dev','Dev',3,'Area sviluppatori');
INSERT INTO `ldto_track` VALUES (3,'sys','Sys',4,'Area sistemisti');
INSERT INTO `ldto_track` VALUES (4,'misc','Misc',1,'Argomenti relativi alla conoscenza e alla libertà digitale.');
INSERT INTO `ldto_track` VALUES (5,'altro','Altro',5,'Di tutto un po\'');
/*!40000 ALTER TABLE `ldto_track` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_user`
--

DROP TABLE IF EXISTS `ldto_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_user` (
  `user_ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_uid` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `user_public` tinyint(1) NOT NULL DEFAULT '1',
  `user_active` tinyint(4) NOT NULL DEFAULT '0',
  `user_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_surname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_title` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_image` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Gravatar when NULL',
  `user_password` varchar(40) COLLATE utf8mb4_unicode_ci,
  `user_site` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_lovelicense` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_bio` text COLLATE utf8mb4_unicode_ci,
  `user_rss` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_twtr` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_fb` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_lnkd` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_googl` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_github` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_ID`),
  UNIQUE KEY `user_uid` (`user_uid`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_user`
--

LOCK TABLES `ldto_user` WRITE;
/*!40000 ALTER TABLE `ldto_user` DISABLE KEYS */;
INSERT INTO `ldto_user` VALUES (1,'boz','admin',1,1,'Valerio','Bozzolan',NULL,NULL,NULL,'https://boz.reyboz.it','gnu-gpl','Qualcuno ha detto... software libero?','https://blog.reyboz.it','ValerioBozzolan',NULL,NULL,NULL,'valerio-bozzolan');
INSERT INTO `ldto_user` VALUES (2,'oirasor','admin',1,1,'Rosario','Antoci',NULL,NULL,NULL,'','gnu-gpl','Studente di Ingegneria Informatica, appassionato di tante cose (forse troppe).\n\nNon mi piace la tecnologia che provoca il gadgettame, ma il suo continuo avanzare per migliorare le risorse e la conoscenza di tutti.\n\nMi è capitato di organizzare il Linux Day 2016. =P\n\nSuonatore di Floppy, appassionato di Dama e Retrocomputing.',NULL,'0iras0r',NULL,NULL,NULL,'0iras0r');
INSERT INTO `ldto_user` VALUES (3,'dario','user',1,0,'Dario','Sera',NULL,NULL,'!',NULL,NULL,'Dario Sera, 22 anni, studente di Ingegneria Informatica con la passione per la didattica. Co-fondatore di [CoderDojo Torino2](http://www.coderdojotorino2.it) e di [Merende Digitali](http://www.merendedigitali.it).\n\nUtilizzo GNU/Linux da molti anni, e collaboro con il Linux Day Torino dal 2010.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (7,'renzo','user',1,0,'Renzo','Davoli',NULL,'/2016/static/user/davoli.jpg','!',NULL,NULL,'Ricercatore, Maker, Insegnante, Sviluppatore...\nCinquantenne all\'anagrafe, continua a giocare e a pensare liberamente.\nIn realtà vuole salvare il mondo, ma non ditelo a nessuno.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (8,'luigi.maselli','user',1,0,'Luigi','Maselli',NULL,NULL,'!','https://grigio.org','mit','Fondatore <http://corso-javascript.it> e TorinoJS, software developer freelance.',NULL,'grigi0',NULL,NULL,NULL,'grigio');
INSERT INTO `ldto_user` VALUES (10,'marco.cavallini','user',1,0,'Marco','Cavallini',NULL,'/2016/static/user/cavallini.jpg','!',NULL,NULL,'Marco Cavallini è un programmatore C/C++ sin dalla metà degli anni \'80. Inizia l\'attività di evangelizzazione all\'Open Source e Linux embedded nel 1999 con le prime schede StrongArm.\n\nÈ membro di OpenEmbedded dal 2009 e Yocto Project advocate dal 2012. Marco ha fondato KOAN nel 1996, una software house specializzata in software embedded con sede in Italia, che offre servizi di sviluppo del kernel e formazione per i sistemi Linux embedded. Quando non si utilizza i computer, è solitamente interessato a mescolare la Fisica con la Filosofia.',NULL,NULL,NULL,'marcocavallini',NULL,NULL);
INSERT INTO `ldto_user` VALUES (11,'davide','user',1,0,'Davide','Bucci',NULL,NULL,'!','http://davbucci.chez-alice.fr',NULL,'Davide è viaggiatore transalpino, programmatore della domenica (se non fa bello, non c\'è neve e non si va a sciare) e qualche volta anche del sabato pomeriggio. Ogni tanto racconta a dei ragazzi e delle ragazze come si usano gli amplificatori operazionali, in altre occasioni canta a squarciagola con altre persone. Appassionato di vecchi computer e di elettronica analogica, si tiene in casa un numero imbarazzante di oscilloscopi, tracciacurve, una macchina da scrivere ed un pianoforte. Coordinatore del progetto open source FidoCadJ, Davide è sensibile al fascino delle automobili scoperte a due posti, soprattutto se a motore centrale.\n\nDavide pratica abbastanza spesso Java, il C ed il C++, sa costruire un generatore ad impulsi con diodi step recovery, ha un\'idea abbastanza precisa su cosa sia un intervallo di quarta eccedente, come funzioni lo scambio ionico su vetro e come calcolare un modo di propagazione in una guida d\'onda dielettrica.',NULL,'davbucci',NULL,NULL,NULL,'DarwinNE');
INSERT INTO `ldto_user` VALUES (12,'francesco','user',1,0,'Francesco','Tucci',NULL,NULL,'!','http://www.iltucci.com',NULL,'Si diverte quando ha a che fare con tutto ciò che ha dei bit o della corrente, sistemista di professione, maker per diletto, podcaster (<http://geekcookies.github.io> e <http://www.pilloledib.it>) almeno una volta al mese.\n\nMini CV delle mie passioni: sistemi Win/Linux/Mac, Arduino, Raspberry Pi e altre schedine embedded, basi di elettronica, programmatore a tempo perso (quali linguaggi? non è importante, impararne la sintassi non è la cosa che mi ostacola).',NULL,'cesco_78','francesco.tucci',NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (13,'massimo','user',1,0,'Massimo','Nuvoli',NULL,'/2016/static/user/massimo.jpg','!',NULL,NULL,'Architetto di Sistemi presso Progetto Archivio SRL e Dicobit.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (14,'elia','user',1,0,'Elia','Bellussi',NULL,NULL,'!',NULL,NULL,'Elia Bellussi, 35 anni, è fondatore del Museo Internazionale dell\'Informatica (già Museo Piemontese dell\'Informatica) e di CoderDojo Torino. Socio di AICA, Stati Generali dell\'Innovazione e di Nord Est Digitale. Consulente informatico si occupa di system engineering.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (15,'davide.isoardi','user',1,0,'Davide','Isoardi',NULL,NULL,'!',NULL,NULL,'Big Data System Architect e sysadmin.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (16,'davide.vergari','user',1,0,'Davide','Vergari',NULL,NULL,'!',NULL,NULL,'Big Data System Architect e sysadmin.',NULL,'DavideVergari',NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (17,'davide.mainardi','user',1,0,'Davide','Mainardi',NULL,NULL,'!',NULL,NULL,'Ingegnere informatico, Open Source enthusiast, focalizzato su privacy e sicurezza informatica, full stack Java developer, Consigliere della Fondazione dell\'Ordine degli Ingegneri della Provincia di Torino.',NULL,'ingmainardi',NULL,NULL,NULL,'dmainardi');
INSERT INTO `ldto_user` VALUES (18,'gianfranco.poncini','user',1,0,'Gianfranco','Poncini',NULL,NULL,'!',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (20,'marco.signoretto','user',1,0,'Marco','Signoretto',NULL,'/2016/static/user/signoretto.jpg','!','http://www.olivelab.it',NULL,'The trash king!\n\nNato e cresciuto a Torino, Marco ha speso i suoi ultimi anni di Politecnico a studiare l\'ultima parte della filiera ovvero l’immondizia. Nel 2015 si è laureato in Ecodesign con una tesi sulla gestione dei RAEE a livello aziendale.\n\nOggi ha aperto il piccolo studio creativo Olive Creative Lab intenzionato a muoversi in tutti i campi della creatività: dal product design alla grafica, dall\'interaction design alla sostenibilità.',NULL,'MarcoSignorett','marco.signoretto.9','marco-signoretto-326003a7',NULL,NULL);
INSERT INTO `ldto_user` VALUES (21,'simone','user',1,0,'Simone','Massi',NULL,NULL,'!',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (23,'alessio','user',1,0,'Alessio','Melandri',NULL,'/2016/static/user/alessio.jpg','!',NULL,NULL,'Appassionato di troppe cose, ho costretto il mio entusiasmo per la conoscenza e per la tecnologia ad incontrarsi nell\'informatica. Lavoro ogni giorno coi dati presso Synapta, ne aggiungo di nuovi su Wikipedia, Wikidata e OpenStreetMap e non vedo l\'ora di poter navigare in un Web semantico. Mi piace giocare a scacchi e bere aranciata. Anche non contemporaneamente.',NULL,NULL,NULL,'alessiomelandri',NULL,'alemela');
INSERT INTO `ldto_user` VALUES (24,'mario.lacaj','user',1,0,'Mario','Lacaj',NULL,'/2016/static/user/mario_lacaj.jpg','',NULL,NULL,'Piacere di conoscerti! Sono uno dei rappresentanti degli studenti del Dipartimento di Informatica di Torino.\n\nCosa c\'entro? Te lo dico subito in questa intervista:\n\n<https://blog.linuxdaytorino.org/2016/10/04/intervista-e-sopralluogo-al-dipartimento/>',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (25,'valerio.sacchetto','user',1,0,'Valerio','Sacchetto',NULL,NULL,'!',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (26,'gloria.puppi','user',1,0,'Gloria','Puppi',NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (27,'madbob','user',1,0,'Roberto','Guido',NULL,NULL,'','http://www.madbob.org',NULL,'Presidente [Italian Linux Society](http://www.ils.org/).','http://blog.madbob.org','madbob',NULL,NULL,NULL,'madbob');
INSERT INTO `ldto_user` VALUES (28,'silux','user',1,0,'Valerio','Cietto',NULL,NULL,'','https://siluxmedia.wordpress.com','gnu-gpl','Vivo fin dal lontano \'92, la mia vocazione è di fare il mago.\n\nVisto che non è possibile, ho iniziato a scrivere incantesimi, demoni, scrivere in un antico linguaggio per incantare oggetti e materializzare oggetti dalla plastica, e mi diverto tantissimo a farlo.\n\nL’Open source e l’open hardware è quello di cui c\'è bisogno per usare al meglio la meravigliosa tecnologia intorno a noi.\n\nAmo usare la licenza [WTFPL](https://it.wikipedia.org/wiki/WTFPL) per esempi e per chi non legge mai i testi delle licenze.',NULL,NULL,'valerio.cietto','valerio-cietto-2ba01958',NULL,'ValerioCietto');
INSERT INTO `ldto_user` VALUES (29,'tinytanic','user',1,0,'Luca','Aguzzoli',NULL,NULL,'','http://aguzzoliluca.it','gnu-gpl','Linux user dal 2010 iniziato da una Ubuntu con GNOME 2 (<3) su un muletto che neanche nel 1983 sarebbe stato un buon computer.\n\nOra cerco di sviluppare il mio futuro libero... e tu?',NULL,NULL,'luka.agu','lucaaguzzoli',NULL,'TinyTanic');
/*!40000 ALTER TABLE `ldto_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ldto_user_skill`
--

DROP TABLE IF EXISTS `ldto_user_skill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldto_user_skill` (
  `user_ID` int(10) unsigned NOT NULL,
  `skill_ID` int(10) unsigned NOT NULL,
  `skill_score` int(11) NOT NULL,
  PRIMARY KEY (`user_ID`,`skill_ID`),
  KEY `skill_ID` (`skill_ID`),
  KEY `skill_score` (`skill_score`),
  CONSTRAINT `ldto_user_skill_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `ldto_user` (`user_ID`) ON DELETE CASCADE,
  CONSTRAINT `ldto_user_skill_ibfk_2` FOREIGN KEY (`skill_ID`) REFERENCES `ldto_skill` (`skill_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_user_skill`
--

LOCK TABLES `ldto_user_skill` WRITE;
/*!40000 ALTER TABLE `ldto_user_skill` DISABLE KEYS */;
INSERT INTO `ldto_user_skill` VALUES (1,11,-4);
INSERT INTO `ldto_user_skill` VALUES (20,15,-4);
INSERT INTO `ldto_user_skill` VALUES (1,4,-2);
INSERT INTO `ldto_user_skill` VALUES (1,6,-2);
INSERT INTO `ldto_user_skill` VALUES (1,5,-1);
INSERT INTO `ldto_user_skill` VALUES (1,7,0);
INSERT INTO `ldto_user_skill` VALUES (11,7,0);
INSERT INTO `ldto_user_skill` VALUES (1,3,2);
INSERT INTO `ldto_user_skill` VALUES (1,8,2);
INSERT INTO `ldto_user_skill` VALUES (1,13,2);
INSERT INTO `ldto_user_skill` VALUES (20,14,2);
INSERT INTO `ldto_user_skill` VALUES (20,19,2);
INSERT INTO `ldto_user_skill` VALUES (24,2,2);
INSERT INTO `ldto_user_skill` VALUES (24,3,2);
INSERT INTO `ldto_user_skill` VALUES (24,20,2);
INSERT INTO `ldto_user_skill` VALUES (24,23,2);
INSERT INTO `ldto_user_skill` VALUES (1,2,3);
INSERT INTO `ldto_user_skill` VALUES (8,5,3);
INSERT INTO `ldto_user_skill` VALUES (10,8,3);
INSERT INTO `ldto_user_skill` VALUES (10,20,3);
INSERT INTO `ldto_user_skill` VALUES (10,22,3);
INSERT INTO `ldto_user_skill` VALUES (11,8,3);
INSERT INTO `ldto_user_skill` VALUES (11,20,3);
INSERT INTO `ldto_user_skill` VALUES (20,16,3);
INSERT INTO `ldto_user_skill` VALUES (20,17,3);
INSERT INTO `ldto_user_skill` VALUES (20,18,3);
INSERT INTO `ldto_user_skill` VALUES (23,5,3);
INSERT INTO `ldto_user_skill` VALUES (23,13,3);
INSERT INTO `ldto_user_skill` VALUES (23,21,3);
INSERT INTO `ldto_user_skill` VALUES (24,7,3);
INSERT INTO `ldto_user_skill` VALUES (1,12,4);
INSERT INTO `ldto_user_skill` VALUES (7,12,4);
INSERT INTO `ldto_user_skill` VALUES (8,3,4);
INSERT INTO `ldto_user_skill` VALUES (8,12,4);
/*!40000 ALTER TABLE `ldto_user_skill` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-12  0:47:18
