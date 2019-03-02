-- MySQL dump 10.16  Distrib 10.1.26-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ldto
-- ------------------------------------------------------
-- Server version	10.1.26-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
  `location_ID` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`conference_ID`),
  UNIQUE KEY `conference_uid` (`conference_uid`),
  KEY `location_ID` (`location_ID`),
  CONSTRAINT `ldto_conference_ibfk_1` FOREIGN KEY (`location_ID`) REFERENCES `ldto_location` (`location_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_conference`
--

LOCK TABLES `ldto_conference` WRITE;
/*!40000 ALTER TABLE `ldto_conference` DISABLE KEYS */;
INSERT INTO `ldto_conference` VALUES (1,'2016','Linux Day Torino 2016',NULL,'LDTO16','http://linuxdaytorino.org/2016/user/%1$s','http://linuxdaytorino.org/2016/talk/%1$s',NULL,'Torino',NULL,'2016-10-22 14:00:00','2016-10-22 18:00:00',1,1);
INSERT INTO `ldto_conference` VALUES (2,'2015','Linux Day Torino 2015',NULL,'LDTO15',NULL,NULL,NULL,'Torino',NULL,'2015-10-24 14:00:00','2015-10-24 18:00:00',1,2);
INSERT INTO `ldto_conference` VALUES (3,'2017','Linux Day Torino 2017',NULL,'LDTO17','http://linuxdaytorino.org/2017/user/%1$s','http://linuxdaytorino.org/2017/talk/%1$s',NULL,'Torino',NULL,'2017-10-28 14:00:00','2017-10-28 18:00:00',1,1);
INSERT INTO `ldto_conference` VALUES (4,'2009','Linux Day Torino 2009',NULL,'LDTO2009',NULL,NULL,NULL,'Torino',NULL,'2009-10-24 14:00:00','2009-10-24 18:00:00',1,NULL);
INSERT INTO `ldto_conference` VALUES (5,'2010','Linux Day Torino 2010',NULL,'LDTO2010',NULL,NULL,NULL,'Torino',NULL,'2010-10-23 10:00:00','2010-10-23 18:00:00',1,NULL);
INSERT INTO `ldto_conference` VALUES (6,'2011','Linux Day Torino 2011',NULL,'LDTO2011',NULL,NULL,NULL,'Torino',NULL,'2011-10-22 14:00:00','2011-10-22 18:00:00',1,NULL);
INSERT INTO `ldto_conference` VALUES (7,'2012','Linux Day Torino 2012',NULL,'LDTO2012',NULL,NULL,NULL,'Torino',NULL,'2012-10-26 10:00:00','2012-10-27 18:00:00',2,NULL);
INSERT INTO `ldto_conference` VALUES (8,'2013','Linux Day Torino 2013',NULL,'LDTO2013',NULL,NULL,NULL,'Torino',NULL,'2013-10-26 14:00:00','2013-10-26 18:00:00',1,NULL);
INSERT INTO `ldto_conference` VALUES (9,'2014','Linux Day Torino 2014',NULL,'LDTO2014',NULL,NULL,NULL,'Torino',NULL,'2014-10-25 14:00:00','2014-10-25 18:00:00',1,NULL);
INSERT INTO `ldto_conference` VALUES (10,'2001','Linux Day Torino 2001',NULL,'LDTO2001',NULL,NULL,NULL,'Torino',NULL,'2001-12-01 09:00:00','2001-12-01 15:30:00',1,NULL);
INSERT INTO `ldto_conference` VALUES (11,'2002','Linux Day Torino 2002',NULL,'LDTO2002',NULL,NULL,NULL,'Torino',NULL,'2002-11-23 09:00:00','2002-11-23 15:30:00',1,NULL);
INSERT INTO `ldto_conference` VALUES (12,'2008','Linux Day Torino 2008',NULL,'LDTO2008',NULL,NULL,NULL,'Torino',NULL,'2008-10-25 13:30:00','2008-10-25 18:00:00',1,NULL);
INSERT INTO `ldto_conference` VALUES (13,'2007','Linux Day Torino 2007',NULL,'LDTO2017',NULL,NULL,NULL,'Torino',NULL,'2007-10-27 14:00:00','2007-10-27 18:00:00',1,NULL);
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
  `room_ID` int(10) unsigned DEFAULT NULL,
  `track_ID` int(10) unsigned DEFAULT NULL,
  `chapter_ID` int(10) unsigned DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
INSERT INTO `ldto_event` VALUES (51,'primi-passi-con-linux','Primi passi con Linux',NULL,NULL,'Come e perchè iniziare, quali programmi usare',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (52,'giocare-con-linux','Giocare con Linux',NULL,NULL,'Divertirsi con il pinguino',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (53,'openofficeorg','OpenOffice.org',NULL,NULL,'Introduzione al software libero di produttivita\' personale',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (54,'firefox-e-thunderbird','Firefox e Thunderbird',NULL,NULL,'Ottieni il massimo da posta e web',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (55,'backup-facile-e-incrementale','Backup facile e incrementale',NULL,NULL,'Mantenere una copia di riserva dei propri dati',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (56,'niente-panico','Niente panico',NULL,NULL,'I trucchi per passare a Linux senza l\'aiuto degli esperti',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (57,'linux-community','Linux Community',NULL,NULL,'Districarsi tra gli strumenti della comunità',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (58,'linuxscuola','Linux@scuola',NULL,NULL,'Open-source a scuola: non solo utilizzatori, ma anche sviluppatori',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (59,'groupware-intranet','Groupware & Intranet',NULL,NULL,'Dal server al desktop!',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (60,'sicurezza-reti-wireless','Sicurezza reti wireless',NULL,NULL,'Vulnerabilità di una rete senza fili',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (61,'videoediting','Videoediting',NULL,NULL,'Tecniche e Software per il videoediting su GNU/Linux',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (62,'opensolaris','OpenSolaris',NULL,NULL,'OS Opensource non è solo Linux',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (63,'gimpblender','Gimp&Blender',NULL,NULL,'Grafica 2D e 3D',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (64,'green-it','Green IT',NULL,NULL,'Risparmio energetico con Linux',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (65,'python','Python',NULL,NULL,'Come diventare un hacker',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (66,'kernel-linux','Kernel Linux',NULL,NULL,'Ricompilazione ed Ottimizzazione del Sistema',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (67,'cloud-computing','Cloud Computing',NULL,NULL,'La nuova frontiera del calcolo distribuito',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (68,'arduino-e-linux','Arduino e Linux',NULL,NULL,'Hardware e software OpenSource insieme',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (69,'bash','Bash',NULL,NULL,'L\'interfaccia utente piu\' rapida al mondo',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (70,'subversion','Subversion',NULL,NULL,'Introduzione al Version Control',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (71,'sviluppo-web-con-cakephp','Sviluppo Web con CakePHP',NULL,NULL,'Introduzione al framework MVC con esempi pratici',NULL,'it','2009-10-24 00:00:00','2009-10-24 01:00:00',NULL,0,4,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (72,'linux-a-scuola','Linux a scuola',NULL,'Sophia Danesino, docente dell\'ITIS Peano di Torino, ha presentato insieme a altri colleghi la sua esperienza con il software libero a scuola, le impressioni degli alunni e la LIM (Lavagna Interattiva Multimediale).',NULL,NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (73,'linux-in-azienda-not-just-for-fun','Linux in azienda: \"not just for fun\"',NULL,'Fabrizio Reale, fondatore e proprietario di Redomino, ha presentato l\'uso di Linux in azienda e risposto alla domanda: «Si può fare business col software libero?».',NULL,NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (74,'plone-4','Plone 4',NULL,'Presentazione dal vivo della nuovissima release di Plone, uno dei più potenti CMS open source oggi disponibili. Plone è lo strumento ideale per la realizzazione di siti web, intranet, piattaforme di gestione documentale, e-learning ed e-commerce. L\'ultima versione introduce sostanziali innovazioni nelle performance, nell\'interfaccia e nell\'architettura. Scopriamole insieme!','Più veloce, più bello, più facile da usare!',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (75,'arduino-10','Arduino 1.0',NULL,'Arduino è il primo microcontrollore open source, e nasce in Piemonte cinque anni fa, con il preciso obiettivo di semplificare la prototipazione elettronica. Arduino ha semplificato la realizzazione di nuovi prodotti / progetti sia da un punto di vista della piattaforma elettronica (aperta, migliorabile dalla comunità), sia attraverso il programma di compilazione (opensource, crossplatform), e soprattutto attraverso l\'utilizzo di una licenza CC S-A. Arduino festeggia i suoi primi cinque anni, passando alla versione UNO. Tema del Talk é la breve storia della scheda, degli ultimi cambiamenti, e la presa in esame di alcuni progetti.','L\'evoluzione di Arduino e i suoi (infiniti?) utilizzi a scopo didattico',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (76,'imparare-a-usare-sw-open-a-scuola','Imparare a usare SW open a scuola',NULL,'Perché studiare l\'Open Source a scuola? esistono gli strumenti adatti? La discussione presenta alcune idee per studiare il software open source a scuola sia come oggetto diretto di studio sia come mezzo per l\'apprendimento di altre discipline. Attraverso l\'esperienza dell\'adozione di un libro di testo che contiene delle parti rivolte al software open source si vuole riflettere sul ruolo e sulle potenzialità che ha il software Open nella didattica e nell\'insegnamento. Il libro, edito dalla casa editrice Petrini, offre parecchi spunti per la discussione. Saranno presenti gli autori. Una descrizione del libro la trovate','Un libro per imparare a usare anche l\'Open Source',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (77,'net-gnulinux-nemici-o-amici','.NET & GNU/Linux: Nemici o Amici',NULL,'Ormai da qualche anno Mono è l\'implementazione di riferimento (anche se non l\'unica) del framework .NET di Microsoft in ambiente GNU/Linux. Il linguaggio C#, una matura libreria di base e l\'Integrated Development Environment (IDE) MonoDevelop insieme forniscono un ambiente nel quale programmare -oltre che essere divertente- è anche estremamente produttivo. Sempre che la Microsoft non vi faccia causa. Amato, deriso ed osteggiato, Mono è comunque una realtà e nel corso dell\'intervento vedremo cos\'è, come funziona, cosa si può fare in C# e quanto ci sia di vero nelle voci che lo vogliono il cavallo di troia che la MS userà per conquistare Linux.','Programmare in C# su Linux e vivere (quasi) felici',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (78,'html-5','HTML 5',NULL,'HTML5 è uno standard (attualmente in discussione) che racchiude una lunga serie di funzionalità per lo sviluppo di applicazioni web. Dopo una breve storia dello sviluppo web fino ad ora, esploreremo le nuove funzionalità introdotte dall\'html5: geolocalizzazione, storage locale e applicazioni offline, video e audio embedded, funzioni grafiche 2D(3D), form, microformati e semantica... Infine proveremo a delineare cosa ci riserva il futuro dello sviluppo di applicazioni web e non solo.','Le nuove frontiere del web',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (79,'html5-mobile-apps-offline','HTML5 Mobile Apps Offline',NULL,'L\'evoluzione degli standard W3C quali HTML5/CSS3 e il continuo diffondersi di disposivi mobili con web browser evoluti hanno aperto delle nuove strade per lo sviluppo di applicazioni multipiattaforma. Dover imparare una nuova SDK per ogni nuova piattaforma e il dover sottostare a limitanti condizioni degli \"AppStore\" non è l\'ideale, quando invece sarebbe molto più semplice condividere le funzionalità attraverso un sito internet. HTML5 unito a un framework open source MVC come Ruby on Rails possono essere una buona ricetta per iniziare a realizzare webapp avanzate che possano accedere a dispositivi hardware (es GPS) senza complicarci troppo la vita. Visto che gli standard permetteranno al browser di accedere a sempre più hardware, aspettatevi di trovare in futuro una webapp per tutto.','Potenzialità e limiti delle ultime tecnologie web che funzionano anche offline',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (80,'harald-dente-blu-ed-il-bluetooth','Harald Dente Blu ed il bluetooth',NULL,'Dopo una breve introduzione al nome ed alla nascita del bluetooth daremo un\'occhiata alla sua struttura (i layers fisico e di trasporto), ai profili (per esempio DUN,FTP,OBEX) e vedremo brevemente cosa servono i comandi della suite bluez (hciattach, hciconfig; bluetooth-agent, hcitool, rfcomm, l2ping, sdptool) e come usarli.','Che ce ne facciamo dei comandi di bluez',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (81,'asterisk','Asterisk',NULL,'Dall\'invenzione del primo combinatore telefonico manuale di Almon B. Strowger, il mondo della telefonia è diventato sempre più efficiente, complesso e semplice da gestire. Oggigiorno chiunque possiede un computer e un po\' di tempo libero può assemblare la propria centrale telefonica. Questo seminario descriverà una panoramica di Asterisk: quali sono le sue potenzialità, quali le funzionalità e come lo si può integrare nel mondo reale.','La Telefonia open source e la sua integrazione nel mondo reale',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (82,'camera-oscura-digitale','Camera oscura digitale',NULL,'Presentazione dei migliori software per lo sviluppo e la gestione delle fotografia digitale come alternativa ad Adobe LightRoom e Adobe CameraRaw. Sviluppo in \"camera chiara\" dei files in formato RAW, post-produzione preliminare delle proprie fotografie, realizzazione di foto HDR, gestione dei dati EXIF, montaggio di foto panoramiche. Dedicato agli appassionati di fotografia digitale.','Come ottenere il meglio dalle proprie foto',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (83,'tuffarsi-in-vim','Tuffarsi in Vim',NULL,'Trucchi e segreti per utilizzare al meglio quello che sembra solo un semplice editor di testo ma che invece ha alle spalle più di 20 anni di storia.','vim - un editor, una leggenda',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (84,'regular-expressions','Regular Expressions',NULL,'Sfruttare la potenza delle espressioni regolari nei Command LIne tools più usati: grep, sed, awk, find, locate. Il talk parte da una introduzione all\'uso delle espressioni regolari per spiegarne l\'utilità e la sintassi. Verranno poi proposti diversi esempi utili in attività comuni di gestione del filesystem o nella elaborazione di documenti di testo via riga di comando. Non sono richieste competenze preliminari, anche se si il talk si rivolge a chi ha già un buon grado di familiarità con la shell.','Sfruttare le regexp in grep, sed, awk e find',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (85,'apache-directory-server','Apache Directory Server',NULL,'Verrà mostrata una panoramica delle funzionalità del server LDAP sviluppato in Java, la semplicità della configurazione, l\'inserimento degli utenti e la creazione di un DIT per mezzo di Apache Directory Studio su Apache Directory Server, l\'analisi delle proprietà dell\'editor, la configurazione delle connessioni, SSL, ricerche, integrazione in Eclipse e gestione degli schema. Se opportuno in base all\'uditorio verrà mostrato il funzionamento di base delle acl e l\'integrazione con altri strumenti (Apache, PAM, ecc.).','Ldap diventa semplice',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (86,'bacula-il-backup-enterprise','Bacula: il backup enterprise',NULL,'Dice il saggio \"Il backup è buono, il backup è bello, il backup mi fa dormire sereno la notte\". Quando si ha a che fare con molte macchine distribuite e una mole di dati elevata, il backup può diventare un incubo. Bacula è una soluzione opensource cross-plataform che aiuta a risolvere problemi come questi. Verrà mostrata la complessa struttura di una piattaforma di backup con una panoramica sulle potenzialità del tool.','Dormire sereni la notte',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (87,'sviluppo-su-android','Sviluppo su Android',NULL,'Il talk si propone di fornire una panoramica sullo sviluppo di applicazioni Android, utilizzando l\'SDK basato su Eclipse e Java. Dopo una breve introduzione, verranno illustrati alcuni concetti fondamentali dell\'architettura Android, tra cui Activities, Intents, Layout XML, risorse e Drawables. Durante il talk verrà creata una semplice applicazione di esempio e fatta girare sull\'emulatore oltre che su un dispositivo reale. I prerequisiti preferenziali per fruire del talk sono: conoscenza minima del linguaggio Java e XML, infarinatura delle tematiche si sviluppo su piattaforma mobile.','creazione pratica di una applicazione mobile',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (88,'bash-41','Bash 4.1',NULL,'Il talk presenta una serie di comode funzionalità dell\'interprete, meno famose, ma decisamente utili. Verrà presentato un cheatsheet con soluzioni rapide ad esigenze comuni. Verranno esaminate alcune forme di espansione di variabili come l\'indirezione e verranno approfondite le principali funzionalità introdotte negli ultimi 2 anni (versioni 4.X), come ad esempio gli array associativi. Il talk si rivolge ad utenti che abbiano già esperienze, anche poche, di scripting in bash.','Comodi trucchi da usare con bash',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (89,'db-nosql','DB NoSQL',NULL,'Una delle più importanti sfide all’elaborazione distribuita è rappresentata dalla necessità di implementare alcuni requisiti come la scalabilità delle soluzioni relative le basi di dati attraverso una famiglia di soluzioni che rientra in un generico termine NoSQL il quale indica sommariamente i database che non sfruttano la sintassi SQL e che spesso vengono anche classificati come “non relazionali”.','Database Not Only SQL',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (90,'wireshark-revealed','Wireshark revealed',NULL,'L\'intervento verterà sul software wireshark e sul suo uso per capire le logiche delle rete, con focus sulle reti IP. Si partirà dai concetti di sniffer e network analyzer per poi passare a descrivere l\'architettura delle libpcap (in generale) ed i concetti di filtri (pcap e wireshark). Si passerà poi ad approfondire wireshark, presentando una serie di use-case che metteranno in luce i principali aspetti peculiari del software, con dimostrazioni di live-capture e di uso dei tool incorporati al suo interno.','Un occhio nei meandri della rete',NULL,'it','2010-10-23 00:00:00','2010-10-23 01:00:00',NULL,0,5,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (91,'20-anni-di-linux','20 Anni di Linux',NULL,NULL,'Quest\'anno ricorrono i primi 20 anni dalla nascita del kernel Linux. Come è nato, chi ci ha lavorato, e come ha impattato la sua esistenza nel corso della breve (ma intensa)...',NULL,'it','2011-10-22 15:00:00','2011-10-22 16:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (92,'android-chromiumos-meego-quale-sicurezza','Android, ChromiumOS, MeeGo: Quale Sicurezza?',NULL,NULL,'Da qualche anno i dispositivi mobile sono entrati prepotentemente nella nostra vita. A loro affidiamo molti dei nostri dati più importanti anche se non tutti affrontano la...',NULL,'it','2011-10-22 17:00:00','2011-10-22 18:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (93,'caelinux-per-le-applicazioni-ingegneristiche','CaeLinux per le Applicazioni Ingegneristiche',NULL,NULL,'EDF (Electricitè de France) ha sviluppato una serie di programmi per progettare e costruire centrali idroelettriche e nucleari. Il pacchetto comprende un CAD tridimensionale, un \"...',NULL,'it','2011-10-22 14:00:00','2011-10-22 15:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (94,'come-ottenere-di-piu-da-gimp','Come Ottenere di Più da Gimp',NULL,NULL,'The Gimp, il programma freesoftware per il fotoritocco alternativo a PhotoShop, già offre una gran quantità di funzioni ed opzioni, ma grazie a...',NULL,'it','2011-10-22 16:00:00','2011-10-22 17:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (95,'contribuire-al-kernel-linux','Contribuire al Kernel Linux',NULL,NULL,'L\'intervento verterà su una esperienza nell\'inviare una patch al kernel Linux. Oltre ad alcuni brevi dettagli tecnici verrà data enfasi a come nasce una patch, come la si sviluppa...',NULL,'it','2011-10-22 17:00:00','2011-10-22 18:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (96,'editing-fotografico','Editing Fotografico',NULL,NULL,'Panoramica sulle applicazioni per Linux dedicate all\'editing fotografico piu\' o meno avanzato.',NULL,'it','2011-10-22 15:00:00','2011-10-22 16:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (97,'hardware-obsoleto-e-ltsp-sessione-pratica','Hardware Obsoleto e LTSP: Sessione Pratica',NULL,NULL,'Troppo spesso i laboratori informatici delle scuole presentano hardware obsoleto e non aggiornato. La soluzione a questo problema puo\' essere LTSP,...',NULL,'it','2011-10-22 15:00:00','2011-10-22 16:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (98,'hardware-obsoleto-e-ltsp-sessione-teorica','Hardware Obsoleto e LTSP: Sessione Teorica',NULL,NULL,'Troppo spesso i laboratori informatici delle scuole presentano hardware obsoleto e non aggiornato. La soluzione a questo problema puo\' essere LTSP...',NULL,'it','2011-10-22 14:00:00','2011-10-22 15:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (99,'i-desktop-di-linux-gnome3-shell-e-unity','I Desktop di Linux, GNOME3 Shell e Unity',NULL,NULL,'Dalla versione 11.04 Ubuntu si presenta con un nuovo ambiente grafico, denominato Unity. Come funziona? Quali sono le sue caratteristiche? Qual\'è il metodo migliore per sfruttare...',NULL,'it','2011-10-22 14:00:00','2011-10-22 15:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (100,'impatto-nelluso-del-floss-nelle-piccole-e-medie-imprese','Impatto nell\'uso del FLOSS nelle Piccole e Medie Imprese',NULL,NULL,'Il software libero ed opensource può essere estremamente utile non solo a casa ma anche (e soprattutto) in azienda. Meno costoso, più sicuro, maggiormente personalizzabile, e...',NULL,'it','2011-10-22 17:00:00','2011-10-22 18:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (101,'introduzione-a-blender','Introduzione a Blender',NULL,NULL,'Quando si parla di grafica 3D su Linux è impossibile non parlare di Blender. In questo talk una rapida introduzione al programma ed alle sue...',NULL,'it','2011-10-22 17:00:00','2011-10-22 18:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (102,'introduzione-a-vim','Introduzione a VIM',NULL,NULL,'Chi penserebbe che uno dei più potenti IDE del pianeta sia una applicazione senza grafica, senza icone, ma con centinaia di comandi testuali per elaborare in pochi istanti i...',NULL,'it','2011-10-22 15:00:00','2011-10-22 16:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (103,'le-migliori-estensioni-per-firefox','Le Migliori Estensioni per Firefox',NULL,NULL,'Tutti conoscono - e magari usano - Firefox, il browser web alternativo a Internet Explorer, ma non tutti conoscono le...',NULL,'it','2011-10-22 14:00:00','2011-10-22 15:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (104,'primi-passi-con-linux','Primi Passi con Linux',NULL,NULL,'Una introduzione a Linux ed al software libero: cos\'è, com\'è, e perché è davvero così importante avere accesso pieno ed incondizionato al codice degli applicativi che si usano sul...',NULL,'it','2011-10-22 14:00:00','2011-10-22 15:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (105,'primi-passi-con-linux-a-scuola','Primi Passi con Linux... A Scuola',NULL,NULL,'Una introduzione a Linux ed al software libero, con un approfondimento speciale al mondo della scuola ed all\'utilizzo di strumenti (e di metodologie) open per la didattica.',NULL,'it','2011-10-22 14:00:00','2011-10-22 15:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (106,'programmazione-in-qt','Programmazione in Qt',NULL,NULL,'Nel panorama dei dispositivi mobili vediamo purtroppo una mancanza di un sistema con un modello di sviluppo aperto, sul modello di quanto succede in ambiente desktop, con progetti...',NULL,'it','2011-10-22 15:00:00','2011-10-22 16:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (107,'sabayon-fedora-openmamba-confronto-tra-distribuzioni','Sabayon, Fedora, openmamba: confronto tra distribuzioni',NULL,NULL,'Quando si parla di Linux quasi tutti parlano di Ubuntu, ma esistono molte altre soluzioni più o meno diffuse ognuna delle quali gode di sue specifiche peculiarità. Insieme a Fabio...',NULL,'it','2011-10-22 16:00:00','2011-10-22 17:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (108,'shotwell-come-organizzare-le-foto-su-linux','Shotwell: come Organizzare le Foto su Linux',NULL,NULL,'Approfondimento su Shotwell, diffusa applicazione open per organizzare al meglio le proprio fotografie. Dedicato a tutti coloro che hanno...',NULL,'it','2011-10-22 16:00:00','2011-10-22 17:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (109,'software-libero-in-classe-esperienze-di-vita-vissuta','Software Libero in Classe: Esperienze di Vita Vissuta',NULL,NULL,'Spesso si propone di introdurre Linux a scuola, ma qualcuno ci ha già provato? Esperienze pratiche e sincere di software libero tra i banchi: cosa è andato bene, cosa è andato...',NULL,'it','2011-10-22 16:00:00','2011-10-22 17:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (110,'software-libero-in-classe-prove-di-liberta','Software Libero in Classe: Prove di Libertà',NULL,NULL,'La cultura dominante impone modelli applicativi in ogni ambito della conoscenza: deve la scuola accettare questi modelli e progettare una formazione che vada incontro alle...',NULL,'it','2011-10-22 15:00:00','2011-10-22 16:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (111,'software-libero-solidale-gasdotto','Software Libero Solidale: GASdotto',NULL,NULL,'Presentazione di una applicazione freesoftware \"made in Torino\", GASdotto, utilizzata da diversi Gruppi di Acquisto della zona ed insieme a loro...',NULL,'it','2011-10-22 15:00:00','2011-10-22 16:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (112,'the-document-foundation-un-anno-dopo','The Document Foundation: un Anno Dopo',NULL,NULL,'La Document Foundation e\' nata circa un anno fa\' per promuovere lo sviluppo e la diffusione di LibreOffice, fork della ben nota...',NULL,'it','2011-10-22 17:00:00','2011-10-22 18:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (113,'un-sito-in-50-minuti-con-drupal','Un Sito in 50 Minuti con Drupal',NULL,NULL,'I siti Internet non sono tutti uguali, cosiccome non tutti uguali sono gli strumenti. Vediamo come Drupal, noto CMS opensource, è stato utilizzato...',NULL,'it','2011-10-22 14:00:00','2011-10-22 15:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (114,'videogiochi-open','Videogiochi Open',NULL,NULL,'Linux è solo per i server? Decisamente no, a giudicare dalla quantità di videogiochi (liberi e gratuiti) a disposizione! Una panoramica sui videogames più popolari, dagli...',NULL,'it','2011-10-22 16:00:00','2011-10-22 17:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (115,'webapp-html5-e-json-con-ruby-on-rails-31','Webapp HTML5 e JSON con Ruby on Rails 3.1',NULL,NULL,'Talk sulla versione 3.1 del framework Rails, e sulle tecnologie web associate: HTML5, Javascript e JSON.',NULL,'it','2011-10-22 16:00:00','2011-10-22 17:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (116,'wiild-la-lavagna-interattiva-multimediale-low-cost','WiiLD: la Lavagna Interattiva Multimediale Low-Cost',NULL,NULL,'Tanto si è parlato di Lavagna Interattiva Multimediale (nota anche come LIM), la quale però costa svariate migliaia di euro e a volte presenta qualche problema tecnico. In questo...',NULL,'it','2011-10-22 16:00:00','2011-10-22 17:00:00',NULL,0,6,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (117,'software-libero-nella-piccola-impresa-un-caso-concreto','Software Libero nella Piccola Impresa: un Caso Concreto',NULL,NULL,'La cooperativa MAG4 Piemonte (strumenti di finanza etica e di economia solidale) utilizza da diversi anni software libero per il proprio funzionamento: Debian, MySQL,...',NULL,'it','2012-10-27 10:00:00','2012-10-27 11:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (118,'politiche-per-lopen-source','Politiche per l’Open Source?',NULL,NULL,'Una panoramica sul ruolo strategico del FLOSS.\n\n\nMariella Berra - Dipartimento di Scienze della Comunicazione dell\'Universita\' di Torino',NULL,'it','2012-10-27 10:30:00','2012-10-27 11:30:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (119,'le-competenze-automotive-di-akhela-nellambito-di-genivi','Le Competenze Automotive di Akhela nell\'Ambito di Genivi',NULL,NULL,'Akhela è da tempo impegnata in molti settori dello sviluppo software per il mercato dell\'Automotive. Uno dei campi nei quali Akhela si è distinta presso i più importanti Car...',NULL,'it','2012-10-27 11:00:00','2012-10-27 12:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (120,'il-piemonte-di-fronte-alle-sfide-dellagenda-digitale','Il Piemonte di Fronte alle Sfide dell\'Agenda Digitale',NULL,NULL,'Il Piemonte di fronte alle sfide dell\'Agenda Digitale: appropriazione e utilizzo delle ICT da parte degli attori del sistema regionale.\n\n\nAlessandro Sciullo - Gruppo di...',NULL,'it','2012-10-27 11:30:00','2012-10-27 12:30:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (121,'conclusioni','Conclusioni',NULL,NULL,'Conclusioni del convegno, a cura dell\'Assessore al Lavoro, Formazione Professionale e Orientamento per il Mercato del Lavoro della Provincia di Torino.',NULL,'it','2012-10-27 12:00:00','2012-10-27 13:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (122,'free-software-e-open-source','Free Software e Open Source',NULL,NULL,'Codice, soldi, libertà e divertimento: ovvero perché il software libero e aperto è buono per chi lo usa e per chi lo fa.\n\n\nUn talk alla portata di tutti per capire cosa...',NULL,'it','2012-10-27 14:00:00','2012-10-27 15:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (123,'mozilla-in-mobilita','Mozilla in Mobilità',NULL,NULL,'Negli ultimi anni il mercato degli smartphone e della connettività mobile in genere è aumentato e sta aumentando moltissimo.\n\n\nDi pari passo, Mozilla si sta muovendo...',NULL,'it','2012-10-27 14:00:00','2012-10-27 15:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (124,'open-data','Open Data',NULL,NULL,'Cosa sono gli Open Data e come distinguerli dall\' openfuffa. Best Practices, geolocalizzazione, strumenti per l\'analisi ed esempi italiani e internazionali.\n...',NULL,'it','2012-10-27 14:00:00','2012-10-27 15:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (125,'how-a-10-million-dollars-company-uses-free-software','How a 10 Million Dollars Company uses Free Software',NULL,NULL,'Come viene usato il free software per creare un sito da un milione di visitatori al giorno?\n\n\nQuali strumenti usano le grandi aziende per ottimizzare lo stack...',NULL,'it','2012-10-27 15:00:00','2012-10-27 16:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (126,'open-source-vfx-in-blender-tears-of-steel','Open Source VFX in Blender: \"Tears of Steel\"',NULL,NULL,'\"Tears of Steel\" - \"progetto Mango\" è il quarto open movie della Blender Foundation.\n\n\nPresentazione generale del progetto e degli strumenti di VFX 3D open source di...',NULL,'it','2012-10-27 15:00:00','2012-10-27 16:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (127,'primi-passi-con-linux','Primi Passi con Linux',NULL,NULL,'Una introduzione a Linux ed al software libero: cos\'è, com\'è, e perché è davvero così importante avere accesso pieno ed incondizionato al codice degli applicativi che si usano...',NULL,'it','2012-10-27 14:00:00','2012-10-27 15:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (128,'hello-nodejs','Hello node.js',NULL,NULL,'Node.js è una piattaforma per costruire facilmente applicazioni di rete veloci e scalabili. In questo talk vedremo quali sono i vantaggi di questa piattaforma, come cominciare...',NULL,'it','2012-10-27 16:00:00','2012-10-27 17:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (129,'raspberry-pi-un-ponte-tra-it-e-embedded','Raspberry Pi: un Ponte tra IT e Embedded',NULL,NULL,'Raspberry Pi, il nuovo, piccolissimo PC basato su ARM e su Linux, per via del suo bassissimo costo puo\' essere usato sia come tradizionale postazione di lavoro che come...',NULL,'it','2012-10-27 16:00:00','2012-10-27 17:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (130,'ploomcake-il-cms-plone-con-steroidi','Ploomcake: il CMS Plone con steroidi!',NULL,NULL,'Ploomcake è un\'evoluzione del CMS Plone che rende più semplice la creazione di siti web, intranet e portali collaborativi con una particolare attenzione ai dispositivi mobile...',NULL,'it','2012-10-27 17:00:00','2012-10-27 18:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (131,'software-libero-nelle-pa-novita-normative','Software Libero nelle P.A.: Novità Normative',NULL,NULL,'Nell\'ultimo anno si sono succedute molte novità normative che riguardano il software libero:\n\n\nla legge della Repubblica Italiana n. 214/2011\nla legge...',NULL,'it','2012-10-27 17:00:00','2012-10-27 18:00:00',NULL,0,7,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (132,'primi-passi-con-linux','Primi passi con Linux',NULL,'Ci siamo lasciati convincere dall\'immancabile amico smanettone e finalmente abbiamo installato Linux. Subito cominciano le cattive notizie: è diverso da Windows! Ma dove sono i nostri programmi? Perchè xyz.exe non si installa? Come si installa nuovo software? E se non funzionano le periferiche? Come si fa ad \"andare su Internet\"? Introduzione alla sopravvivenza in ambienti (operativi) ostili.',NULL,NULL,'it','2013-10-26 00:00:00','2013-10-26 01:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (133,'installiamo-insieme-debian','Installiamo insieme Debian',NULL,'Installazione dal vivo di Debian Live 7.0 LXDE, utile per verificare la compatibilità dell\'hardware, adatta a computer nuovi o un po\' datati, facile da mantenere aggiornata: insomma un ottimo esempio di Software libero!',NULL,NULL,'it','2013-10-26 15:00:00','2013-10-26 16:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (134,'come-e-strutturato-un-sistema-gnulinux','Come è strutturato un Sistema GNU/Linux',NULL,'Conoscere come è fatto GNU/Linux potrebbe esservi utile per non fare errori durante l\'installazione, o  banalmente per sfruttarlo meglio.Vediamo di capire semplicemente come è fatto, seguendolo dall\'accensione al lancio di una applicazione in ambiente grafico.Cercheremo anche di dare risposte a domande come \"32 o 64 bit?\" o \"metto tutto in una partizione?\" e altre che emergeranno durante la conversazione.',NULL,NULL,'it','2013-10-26 16:00:00','2013-10-26 17:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (135,'corsi-online-per-insegnanti','Corsi Online per Insegnanti',NULL,'Breve storia del percorso che dalla legge regionale sul Software Libero ha portato alla piattaforma teachmood.it e alla realizzazione di corsi per i docenti su diversi software liberi utilizzabili nella didattica. Presentazione della piattaforma e dei corsi.',NULL,NULL,'it','2013-10-26 17:00:00','2013-10-26 18:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (136,'fotografia-digitale','Fotografia Digitale',NULL,'Panoramiche a 360 gradi con utilizzo del programma Hugin Panorama photo stitcher e Gimp per ritocco finale del cielo blu ed esportazione in jpeg compresso. Utilizzo di fotocamera digitale non reflex con obiettivi intercambiabili, utilizzo di vecchi obiettivi (di 40 anni fa) a focale fissa (non zoom), esposizione manuale e messa a fuoco manuale (fatta una sola volta per tutte le foto), uso del cavalletto, filo telecomando per scatti antivibrazioni.',NULL,NULL,'it','2013-10-26 14:00:00','2013-10-26 15:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (137,'il-terminale-per-tutti','Il terminale per tutti',NULL,'Un talk per \"assaggiare\" la potenza del terminale, farvi venire la voglia di utilizzare questo strumento nella vita quotidiana e consigliarvi qualche trucchetto.',NULL,NULL,'it','2013-10-26 15:00:00','2013-10-26 16:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (138,'arduino-yun','Arduino Yún',NULL,'Introduzione ad Arduino Yún, la prima scheda Arduino dotata di un processore dedicato a Linux che affianca e potenzia le capacità del microcontrollore.',NULL,NULL,'it','2013-10-26 16:00:00','2013-10-26 17:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (139,'quante-ne-sai','Quante ne sai?',NULL,'Torna a grande richiesta il talk interattivo tra hacking e fooling: \"premi la patata\" e rispondi alle domande! Quante SLOC ci sono in Debian? Kryptonite è un manuale di ...? Qual è la nave più veloce della galassia? Ispirato senza ritegno ai blasonati contest della costa ovest: un\'oretta di svago tra nozioni tecniche, meno tecniche e decisamente bizzarre. Ricchi premi e cotillons. Con il supporto di: Raspberry Pi, node.js e gli immancabili, celeberrimi biscotti.',NULL,NULL,'it','2013-10-26 17:00:00','2013-10-26 18:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (140,'privacy-ed-anonimato-su-internet','Privacy ed anonimato su Internet',NULL,'Il talk si prefigge di illustrare il modo in cui le nostre informazioni personali viaggino in rete: il tracking, il filter-bubbling dei motori di ricerca ed il caso PRISM. Successivamente si presenteranno tecniche e software open-source per navigare al sicuro da ogni tracciabilità ed eventualmente in anonimato.',NULL,NULL,'it','2013-10-26 14:00:00','2013-10-26 15:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (141,'asterisk-centralino-voip-floss','Asterisk: centralino VoIP FLOSS',NULL,'Configurazione di un centralino telefonico (PBX) basato su Asterisk comprensivo di periferiche (telefoni VoIP, PortAdapter analogici, GSMbox, ecc.). Non tutti sanno che con un PC, GNU/Linux e Asterisk è possibile realizzare un centralino telefonico. Poche nozioni teoriche per passare subito alla configurazione del PBX Asterisk e delle periferiche che saranno utilizzate in diretta dai partecipanti.',NULL,NULL,'it','2013-10-26 15:00:00','2013-10-26 16:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (142,'zabbix-monitoring-is-possible','Zabbix: Monitoring is possible',NULL,'Introduzione a Zabbix, soluzione di Monitoring Opensource adattabile a varie realta\', dal privato all\'Enterprise. Concetti, caratteristiche di base e scenari di utilizzo.',NULL,NULL,'it','2013-10-26 16:00:00','2013-10-26 17:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (143,'fastboot-in-sistemi-embedded','Fastboot in sistemi embedded',NULL,'Il talk ha l\'obiettivo di introdurre le tecniche utilizzate per ottimizzare la sequenza di startup di un sistema embedded. Si partirà con la descrizione del bootloader (u-boot), passando per la configurazione del kernel e infine descrivendo la gestione dell\'avvio di servizi in user space (systemd).',NULL,NULL,'it','2013-10-26 17:00:00','2013-10-26 18:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (144,'mitm-e-webapp','MITM e webapp',NULL,'Partendo da concetti di base come ARP ed SSL si parlerà di tecniche di MITM in relazione con le tecnologie web con dimostrazioni pratiche e suggerimenti sia per la sicurezza personale sia che per quella della propria infrastruttura.',NULL,NULL,'it','2013-10-26 14:00:00','2013-10-26 15:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (145,'quando-il-nuovo-rende-insicure-le-vpn','Quando il nuovo rende insicure le VPN',NULL,'Sfruttando il poco conosciuto IPv6 si può creare una condizione di rete per la quale il traffico, normalmente diretto su una vpn sicura, viene deviato verso un proxy dell\'attaccante.',NULL,NULL,'it','2013-10-26 15:00:00','2013-10-26 16:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (146,'penetration-test-con-kali-linux','Penetration Test con Kali Linux',NULL,'Il crescente trend dei cyber attacchi pone a chiunque lavori nel campo IT alcuni importanti quesiti: Quali sono le armi che vengono usate? Siamo pronti? Per rispondere, parleremo di Kali Linux: distribuzione pensata per la sicurezza informatica e i suoi strumenti, che possono identificare una vulnerabilità o compromettere un sitema.  Il talk si snoderà affrontando alcuni aspetti di un attacco informatico, concludendo infine con alcune possibili contromisure.',NULL,NULL,'it','2013-10-26 16:00:00','2013-10-26 17:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (147,'mifare-ultralight-istruzioni-per-luso','Mifare Ultralight: Istruzioni per l\'uso',NULL,'Uno degli utilizzi più comuni dei chip NFC riguarda i sistemi di trasporto pubblico, in cui spesso si può riscontrare una scorretta implementazione del protocollo Mifare Ultralight. Essendo sprovvisto di un sistema di cifratura hardware, è semplice interagire con il chip e accedere ai dati memorizzati sullo stesso. La nostra ricerca si prefigge di illustrare a tutti le caratteristiche di un biglietto NFC Mifare Ultralight ed evidenziare l’utilizzo adeguato dei bytes del settore \"OTP\".',NULL,NULL,'it','2013-10-26 17:00:00','2013-10-26 18:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (148,'i-database-non-relazionali','I Database non Relazionali',NULL,'I database non relazionali, pur non essendo una novità assoluta, hanno registrato una crescita esponenziale nel loro sviluppo e utilizzo negli ultimi anni grazie al sempre più crescente bisogno di scalare in orizzontale, dove i classici RDBMS (database relazionali) presentano diverse limitazioni. I giganti del web, che si trovano a dover gestire database di dimensioni veramente imponenti, hanno sviluppato (o contribuito allo sviluppo) vari NRDBMS (database non relazionali).',NULL,NULL,'it','2013-10-26 14:00:00','2013-10-26 15:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (149,'redis-per-linux','Redis per Linux',NULL,'Redis come sistema di storage di configurazioni, Etcd. Oltre le sessioni: pub/sub (chat), hipache, AWS ElastiCache per Redis. Master/slave config (il problema di Twilio). Redis come logger e/o queue broker (Logstash)',NULL,NULL,'it','2013-10-26 15:00:00','2013-10-26 16:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (150,'meteorjs-webapp-in-realtime','MeteorJS & webapp in Realtime',NULL,'Le applicazioni web per essere reattive e sicure devono fare controlli sia lato client che lato server, questo comporta duplicazione di codice e spesso l\'utilizzo di diversi linguaggi di programmazione. MeteorJS, basato su NodeJS, offre un ambiente unico per poter programmare in javascript codice che potrà girare indifferentemente sul browser o sul server o su entrambi.',NULL,NULL,'it','2013-10-26 16:00:00','2013-10-26 17:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (151,'plone-cms-ploomcake','Plone CMS & Ploomcake',NULL,'Plone è un gestore di contenuti open source sviluppato in Python. Il suo punto di forza è la flessibilità. Con Plone si possono creare siti web, cataloghi prodotti, intranet, gestori documentali, gestori di progetti. Vediamo insieme alcuni esempi da fare in 10 minuti partendo da Ploomcake, una distribuzione Plone.',NULL,NULL,'it','2013-10-26 17:00:00','2013-10-26 18:00:00',NULL,0,8,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (152,'primi-passi-con-linux','Primi passi con Linux',NULL,'Linux è un sistema semplice, veloce e adatto a tutti. Si può usare per navigare su Internet, salvare e modificare fotografie, scrivere documenti, e molto altro: sempre mantenendo la piena compatibilità con le persone intorno a noi. Una panoramica introduttiva su pregi e difetti del sistema operativo più stabile che c\'è.',NULL,NULL,'it','2014-10-25 00:00:00','2014-10-25 01:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (153,'ma-che-e-sto-linux-day','Ma che è \'sto Linux Day?',NULL,'Un meta-talk sul Linux Day, e non solo quello di Torino: come funziona (o non funziona) la più grande manifestazione nazionale a supporto di Linux e del software libero, dal coordinamento centrale al gruppo organizzatore più disperso.',NULL,NULL,'it','2014-10-25 15:00:00','2014-10-25 16:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (154,'creative-commons-e-open-data','Creative Commons e Open Data',NULL,'Le licenze Creative Commons permettono a singoli creatori o istituzioni di condividere le proprie opere secondo il modello \"alcuni diritti riservati\". Le licenze CC sono l\'infrastruttura giuridica di un ecosistema di contenuti aperti complementare a quello del software libero. Gli esempi proposti si concentreranno sull\'uso delle licenze Creative Commons per la messa a disposizione di dati.',NULL,NULL,'it','2014-10-25 16:00:00','2014-10-25 17:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (155,'uefi','UEFI',NULL,'Si fa prima una breve introduzione al processo di booting ed al ruolo che vi gioca(va) il BIOS ed i suoi limiti. Si fa quindi una breve storia del EFI e UEFI, infine si introduce il concetto del Secure Boot e di come alcune distro convivano con le ultime versioni del sistema operativo della Microsoft.',NULL,NULL,'it','2014-10-25 14:00:00','2014-10-25 15:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (156,'reti-p2p','Reti P2P',NULL,'Si partirà dalle basi per comprendere ed esplorare i concetti fondamentali e strutturali di diverse categorie di reti peer to peer, evidenziando le differenze tra le più conosciute (FreeNet, BOINC, Gnutella ecc.) ed i vari problemi che esse hanno affrontato con successo.',NULL,NULL,'it','2014-10-25 15:00:00','2014-10-25 16:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (157,'privacy-e-anonimato-su-android','Privacy e anonimato su Android',NULL,'La rapida diffusione degli smartphone, in grado di connettere gli individui in modo quanto mai personale, ha portato l\'informatica al di fuori dei confini tradizionali. Il talk si prefigge di illustrare quanti e quali siano i dati che inconsapevolmente vengono inviati all\'esterno. Successivamente verranno presentate le tecniche ed i software necessari per limitare la fuga di tali informazioni.',NULL,NULL,'it','2014-10-25 16:00:00','2014-10-25 17:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (158,'conosci-il-software-libero','Conosci il software libero?',NULL,'A grande richiesta, torna il quiz interattivo tra hacking e fooling! Quante SLOC ci sono in Debian? Chi organizza il Caos Communication Camp? Qual è la licenza meno compatibile con la GNU GPL 3? Ispirato senza ritegno ai blasonati contest della costa ovest: un\'oretta di svago tra nozioni tecniche, meno tecniche e decisamente bizzarre. Iron e Abacus faranno ballare la scimmia. Useranno: Raspberry Pi, node.js ...e ortaggi freschi dagli Antichi Borghi. (Non è una metafora: è proprio verdura.) Con la partecipazione di Elia dal MuPin. Ricchi premi e cotillons.Porta il tuo smartphone: gioca anche il pubblico!Sei un drago? Sali sul palco e vinci! Manda QUIZ14 a quantenesai14@ivnb.info :)',NULL,NULL,'it','2014-10-25 17:00:00','2014-10-25 18:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (159,'reverse-engineering-101','Reverse engineering 101',NULL,'Verranno introdotti gli strumenti più utili per fare reverse engineering e verrà analizzato e risolto, passo dopo passo, un \"crackme\" (pseudo-programma che richiede una password, un codice seriale o altro, creato per scopo puramente didattico).',NULL,NULL,'it','2014-10-25 14:00:00','2014-10-25 15:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (160,'meteorjs-e-le-infografiche-realtime','MeteorJS e le infografiche realtime',NULL,'L\'approccio client/server sta sempre più stretto per le nuove web/app, MeteorJS rivoluziona il paradigma e propone un\'alternava per scrivere codice javascript che funzioni sul client, sul server o da entrambe le parti. In questo talk vedremo un\'introduzione al framework isomorfico e alcuni esempi che utilizzano dati in streaming o opendata.',NULL,NULL,'it','2014-10-25 15:00:00','2014-10-25 16:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (161,'strumenti-per-lo-sviluppo-web','Strumenti per lo sviluppo web',NULL,'Migliora la tua esperienza di sviluppatore web adottando strumenti avanzati per automatizzare operazioni ripetitive e noiose: scaffolding nuovi progetti, css performance tooling, live reload browser, javascript linting, merge e minificazione asset, uncss, cdn, integrazione con framework web e tematiche legate al deploy.',NULL,NULL,'it','2014-10-25 16:00:00','2014-10-25 17:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (162,'scrivere-driver-per-il-kernel','Scrivere driver per il kernel',NULL,'Un\'introduzione alla programmazione in spazio kernel. Dopo la presentazione di alcuni concetti di base e delle strutture dati che tengono insieme tutto il sistema, si passa a scrivere un semplice driver, sotto forma di modulo del kernel per pilotare un\'ipotetica periferica.  La scrittura del codice direttamente in sala permette di motivare le scelte fatte e vedere, in piccolo, il modo in cui normalmente si imposta il codice in spazio kernel.',NULL,NULL,'it','2014-10-25 17:00:00','2014-10-25 18:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (163,'shield-e-librerie-raspberrypi','Shield e librerie RaspberryPi',NULL,'RaspberryPi non è solo un microcomputer per applicazioni classiche, ma una vera board per lo sviluppo e la comunicazione con altri sistemi Embedded. In questo talk vedremo come è possibile progettare degli Shield per la piccola Pi tramite gli strumenti open-source come KiCad e l\'utilizzo delle periferiche per mettere in comunicazione la nostra scheda tramite le porte di connessione con il mondo esterno (GPIO, I2C, seriale etc.). Al termine del talk vedremo come sfruttare le potenzialità del linguaggio di programmazione Golang, progettato per architetture ARM, sulla RaspberryPi così da utilizzare in un linguaggio di alto livello per le librerie di comunicazione verso le altre periferiche!',NULL,NULL,'it','2014-10-25 14:00:00','2014-10-25 15:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (164,'videosorveglianza-raspberrypi','Videosorveglianza RaspberryPi',NULL,'Comprare una videocamera per la sorveglianza e il motion detection già configurata e funzionante è troppo facile. Partiamo dal RaspberryPi, il suo modulo videocamera, Twitter, un po\' di programmazione ed ecco fatta la videosorveglianza gestita completamente via Twitter, che vi avvisa se succede qualcosa nella zona che volete controllare mentre voi non ci siete.',NULL,NULL,'it','2014-10-25 15:00:00','2014-10-25 16:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (165,'arduino','Arduino',NULL,'Forse la più famosa scheda elettronica al mondo, raccontata da chi ci lavora tutto il giorno: la community, la gamma di piattaforme, progetti pratici e spunti operativi. L\'opensource allo stato solido!',NULL,NULL,'it','2014-10-25 16:00:00','2014-10-25 17:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (166,'openwrt','OpenWRT',NULL,'OpenWrt, soprannominatosi \"wireless freedom\", è una distribuzione Linux ultraleggera per sistemi embedded, presente in molti wireless router. Ora i cinesi hanno reso disponibili sistemi non chiusi, ma programmabili, atti a costruire sistemi Wi-Fi portatili e indossabili. Nell\'arena si è ora gettata Intel con il modulo Edison, che non è OpenWrt, ma è sempre Linux. Chi vincerà?',NULL,NULL,'it','2014-10-25 17:00:00','2014-10-25 18:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (167,'ettercap-sicurezza-in-lan','Ettercap, sicurezza in LAN',NULL,'Ettercap è un software libero, strumento progettato per la sicurezza della rete dagli attacchi LAN. Può essere usato per l\'analisi della rete e controllarne quindi la sicurezza. Ettercap è in grado di intercettare il traffico nel segmento di rete, catturare le password e condurre intercettazioni attive contro una serie di protocolli comuni.',NULL,NULL,'it','2014-10-25 14:00:00','2014-10-25 15:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (168,'virtualizzazione-con-kvm','Virtualizzazione con KVM',NULL,'La virtualizzazione è una delle tecnologie chiave dell\'Informatica attuale, ma non tutti la conoscono e apprezzano per quello che realmente permette di fare. Oltre a introdurre qualche aspetto teorico si cercherà di fare vedere in funzione qemu e kvm, anche utilizzando l\'interfaccia virt-manager.',NULL,NULL,'it','2014-10-25 15:00:00','2014-10-25 16:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (169,'virtualizzazione-con-docker','Virtualizzazione con Docker',NULL,'Docker è uno dei progetti open source più giovani, ma con la sua grande velocità e scalabilità promette di rivoluzionare la virtualizzazione e i processi di deploy. Andremo ad introdurre il concetto di container rispetto alla virtualizzazione classica per poi analizzare docker e alcune possibilità di utilizzo in vari ambiti.',NULL,NULL,'it','2014-10-25 16:00:00','2014-10-25 17:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (170,'zabbix','Zabbix',NULL,'Zabbix è uno tra i più noti software di monitoring open source, nato nel lontano 1999 da un\'idea di Alexei Vladishev, ad oggi è una delle soluzioni più promettenti nel mercato mondiale. In questo talk cercherò di trasmettere le basi fondamentali su come installarlo e poter monitorare un host tramite soglie di allarme.',NULL,NULL,'it','2014-10-25 17:00:00','2014-10-25 18:00:00',NULL,0,9,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (171,'il-software-libero-per-tutti','Il Software Libero per Tutti',NULL,NULL,'Dopo avere analizzato i concetti che stanno alla base del software libero, valuteremo insieme i passi che un utente può effettuare per migrare un computer ad una distribuzione libera senza difficoltà.',NULL,'it','2015-10-24 17:00:00','2015-10-24 18:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (172,'adotta-un-software','Adotta un Software',NULL,NULL,'Cosa fare quando il tuo programma preferito non viene più sviluppato, ovvero come diventare un developer KDE per pigrizia e fare parte di un progetto open source. Ispirato ad una storia vera.',NULL,'it','2015-10-24 17:00:00','2015-10-24 18:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (173,'storage-cose-e-come-e-fatto','Storage: Cos\'è e Come è Fatto',NULL,NULL,'Struttura di un sistema storage, dai dischi alle interfacce di comunicazione: carrellata non tecnica sui contenuti di questi sistemi di archiviazione, sempre più diffusi anche in ambito casalingo.',NULL,'it','2015-10-24 17:00:00','2015-10-24 18:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (174,'f-droid-libera-il-tuo-smartphone','F-Droid, Libera il tuo Smartphone!',NULL,NULL,'Lo smartphone è il libro (aperto) della tua vita privata. Puoi continuare a restare nel \"Grande Fratello\", se lo desideri, ma una via di uscita esiste. (A fine talk, installation-party sugli Android).',NULL,'it','2015-10-24 17:00:00','2015-10-24 18:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (175,'un-pinguino-in-comune','Un Pinguino in Comune',NULL,NULL,'Non tutti sanno che in numerosi laboratori didattici nelle scuole di Torino si trova Linux. E la storia di come ci sia arrivato parte dall\'assessorato all\'istruzione...',NULL,'it','2015-10-24 15:00:00','2015-10-24 16:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (176,'fare-il-software-libero','Fare il Software Libero',NULL,NULL,'Sviluppare software libero non vuol dire solamente mettere dei sorgenti su GitHub: lo scopo del talk è fornire le basi tecniche (e non) per sviluppare nuovi progetti e contribuire a quelli esistenti.',NULL,'it','2015-10-24 15:00:00','2015-10-24 16:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (177,'non-ce-cloud-senza-storage','Non c\'è Cloud senza Storage',NULL,NULL,'Eravamo abituati a RAID, ARRAY e dischi, ma il mondo evolve e questi sono un ricordo. Ceph è un Distributed Storage tra i più interessanti e pone le basi per le future soluzioni di memorizzazione dati.',NULL,'it','2015-10-24 15:00:00','2015-10-24 16:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (178,'libera-un-chromebook','Libera un Chromebook',NULL,NULL,'Saremo destinati ad utilizzare solo applicazioni cloud? Forse. Nel frattempo godiamoci l\'accesso hardware, decloudizziamo un Chromebook, installiamo GNU/Linux e godiamoci il 100% delle sue potenzialità.',NULL,'it','2015-10-24 15:00:00','2015-10-24 16:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (179,'installiamo-linux','Installiamo Linux!',NULL,NULL,'Consigli, dritte e warning su come installare sul proprio computer una delle distribuzioni Linux più famose. Installeremo Linux su un computer di prova per vedere \"live\" tutti i passaggi necessari.',NULL,'it','2015-10-24 16:00:00','2015-10-24 17:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (180,'nel-labirinto-dei-codec-futuri','Nel Labirinto dei Codec Futuri',NULL,NULL,'Negli ultimi anni abbiamo visto nuovi standard che promettono di essere superiori: HEVC, VP9/VP10, Daala ed Opus. L\'intervento mira a dare una introduzione sugli specifici format e spiegare a che punto siamo.',NULL,'it','2015-10-24 16:00:00','2015-10-24 17:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (181,'ibm-bluemix-digital-innovation-platform','IBM Bluemix, Digital Innovation Platform',NULL,NULL,'IBM Bluemix è la piattaforma cloud basata su open standard, per lo sviluppo, test e esecuzione di applicazioni in modalità PaaS. Qui una presentazione ed una dimostrazione live.',NULL,'it','2015-10-24 16:00:00','2015-10-24 17:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (182,'riservatezza-digitale-missione-impossibile','Riservatezza Digitale: Missione Impossibile?',NULL,NULL,'Oggigiorno i dispositivi personali ci accompagnano ovunque, registrando e trasmettendo tutte le attività. È ancora possibile fare uso dello strumento digitale tutelando al contempo la propria privacy?',NULL,'it','2015-10-24 16:00:00','2015-10-24 17:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (183,'e-con-linux-che-programmi-uso','E con Linux che Programmi uso?',NULL,NULL,'Panoramica sui programmi più utili da installare sulla vostra nuova installazione di Linux, per non sentire la mancanza di Windows e rimanere sorpresi dalla varietà e qualità. Con regalo a fine talk.',NULL,'it','2015-10-24 17:00:00','2015-10-24 18:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (184,'a-summary-of-the-daala-project','A Summary of the Daala Project',NULL,NULL,'Daala is a \"next-next generation\" video codec project sponsored by Mozilla and Xiph.Org. The talk will cover what worked, what didn\'t and where we plan to go from here.',NULL,'it','2015-10-24 17:00:00','2015-10-24 18:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (185,'ninux-e-reti-wireless-comunitarie','Ninux e Reti Wireless Comunitarie',NULL,NULL,'Ninux.org, la più grande community wireless italiana in salsa open source. Liberi di condividere e sperimentare. Teoria e pratica delle reti wireless comunitarie.',NULL,'it','2015-10-24 17:00:00','2015-10-24 18:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (186,'copyright-copyleft','Copyright-Copyleft',NULL,NULL,'Capire insieme quali sono i diritti di chi fruisce e diffonde e di chi crea e produce contenuti in rete, per sapere cosa fare e prevedere come andrà a finire la battaglia sui contenuti in rete.',NULL,'it','2015-10-24 17:00:00','2015-10-24 18:00:00',NULL,0,2,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (187,'primi-passi-con-linux','Primi Passi con Linux',NULL,NULL,'14:30',NULL,'it','2017-10-28 14:00:00','2017-10-28 15:00:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (188,'privacy','Privacy',NULL,NULL,'15:30',NULL,'it','2017-10-28 15:30:00','2017-10-28 16:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (189,'il-nostro-diritto-digitale-alla-citta','Il Nostro Diritto Digitale alla Città',NULL,NULL,'16:30',NULL,'it','2017-10-28 16:30:00','2017-10-28 17:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (190,'quando-un-dato-e-cancellato','Quando un dato è cancellato',NULL,NULL,'17:30',NULL,'it','2017-10-28 17:30:00','2017-10-28 18:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (191,'rust-perche-e-perche-no','Rust, perché e perché no',NULL,NULL,'14:30',NULL,'it','2017-10-28 14:30:00','2017-10-28 15:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (192,'blockchain-da-zero-al-codice','Blockchain, da zero al codice',NULL,NULL,'15:30',NULL,'it','2017-10-28 15:30:00','2017-10-28 16:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (193,'embedded','Embedded',NULL,NULL,'16:30',NULL,'it','2017-10-28 16:30:00','2017-10-28 17:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (194,'far-parlare-i-dispositivi-iot','Far parlare i dispositivi IoT',NULL,NULL,'17:30',NULL,'it','2017-10-28 17:30:00','2017-10-28 18:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (195,'big-data-rt-analytics','Big Data RT Analytics',NULL,NULL,'14:30',NULL,'it','2017-10-28 14:30:00','2017-10-28 15:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (196,'fun-with-zabbix-iot','Fun with Zabbix & IoT',NULL,NULL,'15:30',NULL,'it','2017-10-28 15:30:00','2017-10-28 16:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (197,'da-ipv4-a-ipv6','Da IPv4 a IPv6',NULL,NULL,'16:30',NULL,'it','2017-10-28 16:30:00','2017-10-28 17:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (198,'varnish-quando-la-cache-conta','Varnish: quando la cache conta',NULL,NULL,'17:30',NULL,'it','2017-10-28 17:30:00','2017-10-28 18:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (199,'dispositivi-iot-con-iottly','Dispositivi IoT con iottly',NULL,NULL,'14:30',NULL,'it','2017-10-28 14:30:00','2017-10-28 15:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (200,'odoo-erp-open-per-lazienda','Odoo, ERP open per l\'azienda',NULL,NULL,'15:30',NULL,'it','2017-10-28 15:30:00','2017-10-28 16:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (201,'quali-alternative-a-whatsapp','Quali alternative a WhatsApp?',NULL,NULL,'16:30',NULL,'it','2017-10-28 16:30:00','2017-10-28 17:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (202,'bitcoin-e-monero','Bitcoin e Monero',NULL,NULL,'17:30',NULL,'it','2017-10-28 17:30:00','2017-10-28 18:30:00',NULL,0,3,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (203,'lug-torino','LUG Torino',NULL,NULL,NULL,NULL,'it','2001-12-01 09:15:00','2001-12-01 10:15:00',NULL,0,10,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (204,'debian-gnulinux-news','Debian GNU/Linux news',NULL,NULL,NULL,NULL,'it','2001-12-01 10:00:00','2001-12-01 11:00:00',NULL,0,10,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (205,'billing-tools-with-free-software-free-software-for-network-monitoring','Billing tools with free software / Free software for network monitoring',NULL,NULL,NULL,NULL,'it','2001-12-01 10:45:00','2001-12-01 11:00:00',NULL,0,10,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (206,'software-libero-e-impresa','Software libero e impresa',NULL,NULL,NULL,NULL,'it','2001-12-01 11:30:00','2001-12-01 12:00:00',NULL,0,10,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (207,'open-media-streaming','Open Media Streaming',NULL,NULL,NULL,NULL,'it','2001-12-01 13:00:00','2001-12-01 14:00:00',NULL,0,10,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (208,'mosix','MOSIX',NULL,NULL,NULL,NULL,'it','2001-12-01 13:45:00','2001-12-01 14:00:00',NULL,0,10,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (209,'presentazione-del-libro-informatica-solidale','presentazione del libro \"Informatica solidale\"',NULL,NULL,NULL,NULL,'it','2001-12-01 14:30:00','2001-12-01 15:00:00',NULL,0,10,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (210,'le-attivita-del-gnulinux-users-group-torino','Le attività del GNU/Linux Users Group Torino',NULL,NULL,NULL,NULL,'it','2002-11-23 09:15:00','2002-11-23 10:00:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (211,'software-libero-nuove-opportunita-per-la-pubblica-amministrazione-la-scuola-e-le-imprese','Software Libero, nuove opportunità per la Pubblica Amministrazione, la scuola e le imprese',NULL,NULL,NULL,NULL,'it','2002-11-23 09:30:00','2002-11-23 10:00:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (212,'software-libero-e-pubblica-amministrazione-la-proposta-di-mozione-nel-comune-di-torino','Software Libero e Pubblica Amministrazione: la proposta di mozione nel Comune di Torino',NULL,NULL,NULL,NULL,'it','2002-11-23 10:00:00','2002-11-23 11:00:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (213,'cluster-linux-per-il-calcolo-ad-alte-prestazioni-in-ambito-automotive','Cluster Linux per il calcolo ad alte prestazioni in ambito Automotive',NULL,NULL,NULL,NULL,'it','2002-11-23 10:15:00','2002-11-23 11:00:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (214,'informatica-solidale-perche-conviene-cooperare','Informatica solidale: perchè conviene cooperare?',NULL,NULL,NULL,NULL,'it','2002-11-23 10:45:00','2002-11-23 11:45:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (215,'il-passaggio-del-liases-allopen-source','Il passaggio del LIASES all\'Open Source',NULL,NULL,NULL,NULL,'it','2002-11-23 11:30:00','2002-11-23 12:00:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (216,'un-sistema-webmail-per-lintegrazione-della-comunicazione-aziendale','Un sistema webmail per l\'integrazione della comunicazione aziendale',NULL,NULL,NULL,NULL,'it','2002-11-23 12:00:00','2002-11-23 13:00:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (217,'gnulinux-una-piattaforma-flessibile-per-lazienda','GNU/Linux: una piattaforma flessibile per l\'azienda',NULL,NULL,NULL,NULL,'it','2002-11-23 12:30:00','2002-11-23 13:30:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (218,'procedura-di-gestione-interventi-tecnici','Procedura di gestione interventi tecnici',NULL,NULL,NULL,NULL,'it','2002-11-23 14:00:00','2002-11-23 15:00:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (219,'watch-penguin-affrontare-la-sicurezza-aziendale','Watch-Penguin: affrontare la sicurezza aziendale',NULL,NULL,NULL,NULL,'it','2002-11-23 14:30:00','2002-11-23 15:30:00',NULL,0,11,NULL,NULL,1);
INSERT INTO `ldto_event` VALUES (220,'soluzioni-gnulinux-dal-mercato-enterprise-alla-pmi','Soluzioni GNU/Linux: dal mercato enterprise alla PMI',NULL,NULL,NULL,NULL,'it','2002-11-23 15:00:00','2002-11-23 16:00:00',NULL,0,11,NULL,NULL,1);
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
INSERT INTO `ldto_event_user` VALUES (51,31,1);
INSERT INTO `ldto_event_user` VALUES (52,32,1);
INSERT INTO `ldto_event_user` VALUES (53,33,1);
INSERT INTO `ldto_event_user` VALUES (54,143,1);
INSERT INTO `ldto_event_user` VALUES (55,8,1);
INSERT INTO `ldto_event_user` VALUES (56,34,1);
INSERT INTO `ldto_event_user` VALUES (57,32,1);
INSERT INTO `ldto_event_user` VALUES (58,35,1);
INSERT INTO `ldto_event_user` VALUES (59,36,1);
INSERT INTO `ldto_event_user` VALUES (60,31,1);
INSERT INTO `ldto_event_user` VALUES (61,37,1);
INSERT INTO `ldto_event_user` VALUES (62,38,1);
INSERT INTO `ldto_event_user` VALUES (63,39,1);
INSERT INTO `ldto_event_user` VALUES (64,40,1);
INSERT INTO `ldto_event_user` VALUES (65,41,1);
INSERT INTO `ldto_event_user` VALUES (66,42,1);
INSERT INTO `ldto_event_user` VALUES (67,43,1);
INSERT INTO `ldto_event_user` VALUES (68,44,1);
INSERT INTO `ldto_event_user` VALUES (69,46,1);
INSERT INTO `ldto_event_user` VALUES (70,47,1);
INSERT INTO `ldto_event_user` VALUES (71,48,1);
INSERT INTO `ldto_event_user` VALUES (72,35,1);
INSERT INTO `ldto_event_user` VALUES (73,36,1);
INSERT INTO `ldto_event_user` VALUES (74,36,1);
INSERT INTO `ldto_event_user` VALUES (75,44,1);
INSERT INTO `ldto_event_user` VALUES (76,54,1);
INSERT INTO `ldto_event_user` VALUES (77,57,1);
INSERT INTO `ldto_event_user` VALUES (78,41,1);
INSERT INTO `ldto_event_user` VALUES (79,8,1);
INSERT INTO `ldto_event_user` VALUES (80,58,1);
INSERT INTO `ldto_event_user` VALUES (81,59,1);
INSERT INTO `ldto_event_user` VALUES (82,143,1);
INSERT INTO `ldto_event_user` VALUES (83,143,1);
INSERT INTO `ldto_event_user` VALUES (84,47,1);
INSERT INTO `ldto_event_user` VALUES (85,60,1);
INSERT INTO `ldto_event_user` VALUES (86,46,1);
INSERT INTO `ldto_event_user` VALUES (87,49,1);
INSERT INTO `ldto_event_user` VALUES (88,47,1);
INSERT INTO `ldto_event_user` VALUES (89,61,1);
INSERT INTO `ldto_event_user` VALUES (90,62,1);
INSERT INTO `ldto_event_user` VALUES (91,27,1);
INSERT INTO `ldto_event_user` VALUES (92,63,1);
INSERT INTO `ldto_event_user` VALUES (93,18,1);
INSERT INTO `ldto_event_user` VALUES (94,64,1);
INSERT INTO `ldto_event_user` VALUES (95,62,1);
INSERT INTO `ldto_event_user` VALUES (96,65,1);
INSERT INTO `ldto_event_user` VALUES (97,66,1);
INSERT INTO `ldto_event_user` VALUES (98,73,1);
INSERT INTO `ldto_event_user` VALUES (99,8,1);
INSERT INTO `ldto_event_user` VALUES (100,74,1);
INSERT INTO `ldto_event_user` VALUES (101,75,1);
INSERT INTO `ldto_event_user` VALUES (102,76,1);
INSERT INTO `ldto_event_user` VALUES (103,77,1);
INSERT INTO `ldto_event_user` VALUES (104,143,1);
INSERT INTO `ldto_event_user` VALUES (105,143,1);
INSERT INTO `ldto_event_user` VALUES (106,79,1);
INSERT INTO `ldto_event_user` VALUES (107,80,1);
INSERT INTO `ldto_event_user` VALUES (108,82,1);
INSERT INTO `ldto_event_user` VALUES (109,83,1);
INSERT INTO `ldto_event_user` VALUES (110,84,1);
INSERT INTO `ldto_event_user` VALUES (111,85,1);
INSERT INTO `ldto_event_user` VALUES (112,86,1);
INSERT INTO `ldto_event_user` VALUES (113,87,1);
INSERT INTO `ldto_event_user` VALUES (114,143,1);
INSERT INTO `ldto_event_user` VALUES (115,8,1);
INSERT INTO `ldto_event_user` VALUES (116,51,1);
INSERT INTO `ldto_event_user` VALUES (117,88,1);
INSERT INTO `ldto_event_user` VALUES (118,89,1);
INSERT INTO `ldto_event_user` VALUES (119,90,1);
INSERT INTO `ldto_event_user` VALUES (120,91,1);
INSERT INTO `ldto_event_user` VALUES (121,92,1);
INSERT INTO `ldto_event_user` VALUES (122,93,1);
INSERT INTO `ldto_event_user` VALUES (123,94,1);
INSERT INTO `ldto_event_user` VALUES (124,8,1);
INSERT INTO `ldto_event_user` VALUES (125,60,1);
INSERT INTO `ldto_event_user` VALUES (126,75,1);
INSERT INTO `ldto_event_user` VALUES (127,143,1);
INSERT INTO `ldto_event_user` VALUES (128,41,1);
INSERT INTO `ldto_event_user` VALUES (129,18,1);
INSERT INTO `ldto_event_user` VALUES (130,36,1);
INSERT INTO `ldto_event_user` VALUES (131,95,1);
INSERT INTO `ldto_event_user` VALUES (132,73,1);
INSERT INTO `ldto_event_user` VALUES (133,88,1);
INSERT INTO `ldto_event_user` VALUES (134,13,1);
INSERT INTO `ldto_event_user` VALUES (135,96,1);
INSERT INTO `ldto_event_user` VALUES (136,98,1);
INSERT INTO `ldto_event_user` VALUES (137,99,1);
INSERT INTO `ldto_event_user` VALUES (138,100,1);
INSERT INTO `ldto_event_user` VALUES (139,77,1);
INSERT INTO `ldto_event_user` VALUES (140,17,1);
INSERT INTO `ldto_event_user` VALUES (141,101,1);
INSERT INTO `ldto_event_user` VALUES (142,102,1);
INSERT INTO `ldto_event_user` VALUES (143,103,1);
INSERT INTO `ldto_event_user` VALUES (144,143,1);
INSERT INTO `ldto_event_user` VALUES (145,105,1);
INSERT INTO `ldto_event_user` VALUES (146,106,1);
INSERT INTO `ldto_event_user` VALUES (147,108,1);
INSERT INTO `ldto_event_user` VALUES (148,109,1);
INSERT INTO `ldto_event_user` VALUES (149,60,1);
INSERT INTO `ldto_event_user` VALUES (150,8,1);
INSERT INTO `ldto_event_user` VALUES (151,111,1);
INSERT INTO `ldto_event_user` VALUES (152,77,1);
INSERT INTO `ldto_event_user` VALUES (153,27,1);
INSERT INTO `ldto_event_user` VALUES (154,112,1);
INSERT INTO `ldto_event_user` VALUES (155,113,1);
INSERT INTO `ldto_event_user` VALUES (156,143,1);
INSERT INTO `ldto_event_user` VALUES (157,17,1);
INSERT INTO `ldto_event_user` VALUES (158,77,1);
INSERT INTO `ldto_event_user` VALUES (159,114,1);
INSERT INTO `ldto_event_user` VALUES (160,8,1);
INSERT INTO `ldto_event_user` VALUES (161,53,1);
INSERT INTO `ldto_event_user` VALUES (162,115,1);
INSERT INTO `ldto_event_user` VALUES (163,116,1);
INSERT INTO `ldto_event_user` VALUES (164,12,1);
INSERT INTO `ldto_event_user` VALUES (165,118,1);
INSERT INTO `ldto_event_user` VALUES (166,18,1);
INSERT INTO `ldto_event_user` VALUES (167,119,1);
INSERT INTO `ldto_event_user` VALUES (168,13,1);
INSERT INTO `ldto_event_user` VALUES (169,120,1);
INSERT INTO `ldto_event_user` VALUES (170,102,1);
INSERT INTO `ldto_event_user` VALUES (171,2,1);
INSERT INTO `ldto_event_user` VALUES (172,121,1);
INSERT INTO `ldto_event_user` VALUES (173,13,1);
INSERT INTO `ldto_event_user` VALUES (174,1,1);
INSERT INTO `ldto_event_user` VALUES (175,122,1);
INSERT INTO `ldto_event_user` VALUES (176,123,1);
INSERT INTO `ldto_event_user` VALUES (177,102,1);
INSERT INTO `ldto_event_user` VALUES (178,8,1);
INSERT INTO `ldto_event_user` VALUES (179,99,1);
INSERT INTO `ldto_event_user` VALUES (180,124,1);
INSERT INTO `ldto_event_user` VALUES (181,125,1);
INSERT INTO `ldto_event_user` VALUES (182,17,1);
INSERT INTO `ldto_event_user` VALUES (183,12,1);
INSERT INTO `ldto_event_user` VALUES (184,126,1);
INSERT INTO `ldto_event_user` VALUES (185,143,1);
INSERT INTO `ldto_event_user` VALUES (186,127,1);
INSERT INTO `ldto_event_user` VALUES (190,128,1);
INSERT INTO `ldto_event_user` VALUES (200,130,1);
INSERT INTO `ldto_event_user` VALUES (203,131,1);
INSERT INTO `ldto_event_user` VALUES (204,57,1);
INSERT INTO `ldto_event_user` VALUES (205,132,1);
INSERT INTO `ldto_event_user` VALUES (206,133,1);
INSERT INTO `ldto_event_user` VALUES (207,134,1);
INSERT INTO `ldto_event_user` VALUES (208,131,1);
INSERT INTO `ldto_event_user` VALUES (209,52,1);
INSERT INTO `ldto_event_user` VALUES (211,52,1);
INSERT INTO `ldto_event_user` VALUES (212,135,1);
INSERT INTO `ldto_event_user` VALUES (213,136,1);
INSERT INTO `ldto_event_user` VALUES (214,89,1);
INSERT INTO `ldto_event_user` VALUES (215,137,1);
INSERT INTO `ldto_event_user` VALUES (216,138,1);
INSERT INTO `ldto_event_user` VALUES (217,139,1);
INSERT INTO `ldto_event_user` VALUES (218,140,1);
INSERT INTO `ldto_event_user` VALUES (219,141,1);
INSERT INTO `ldto_event_user` VALUES (220,142,1);
INSERT INTO `ldto_event_user` VALUES (68,45,2);
INSERT INTO `ldto_event_user` VALUES (71,49,2);
INSERT INTO `ldto_event_user` VALUES (72,50,2);
INSERT INTO `ldto_event_user` VALUES (76,55,2);
INSERT INTO `ldto_event_user` VALUES (89,40,2);
INSERT INTO `ldto_event_user` VALUES (97,67,2);
INSERT INTO `ldto_event_user` VALUES (105,78,2);
INSERT INTO `ldto_event_user` VALUES (107,63,2);
INSERT INTO `ldto_event_user` VALUES (135,97,2);
INSERT INTO `ldto_event_user` VALUES (139,15,2);
INSERT INTO `ldto_event_user` VALUES (143,104,2);
INSERT INTO `ldto_event_user` VALUES (146,107,2);
INSERT INTO `ldto_event_user` VALUES (147,78,2);
INSERT INTO `ldto_event_user` VALUES (148,110,2);
INSERT INTO `ldto_event_user` VALUES (158,15,2);
INSERT INTO `ldto_event_user` VALUES (163,117,2);
INSERT INTO `ldto_event_user` VALUES (167,104,2);
INSERT INTO `ldto_event_user` VALUES (190,129,2);
INSERT INTO `ldto_event_user` VALUES (72,51,3);
INSERT INTO `ldto_event_user` VALUES (76,56,3);
INSERT INTO `ldto_event_user` VALUES (97,35,3);
INSERT INTO `ldto_event_user` VALUES (107,81,3);
INSERT INTO `ldto_event_user` VALUES (72,52,4);
INSERT INTO `ldto_event_user` VALUES (97,68,4);
INSERT INTO `ldto_event_user` VALUES (107,27,4);
INSERT INTO `ldto_event_user` VALUES (72,53,5);
INSERT INTO `ldto_event_user` VALUES (97,69,5);
INSERT INTO `ldto_event_user` VALUES (97,70,6);
INSERT INTO `ldto_event_user` VALUES (97,71,7);
INSERT INTO `ldto_event_user` VALUES (97,72,8);
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_location`
--

LOCK TABLES `ldto_location` WRITE;
/*!40000 ALTER TABLE `ldto_location` DISABLE KEYS */;
INSERT INTO `ldto_location` VALUES (1,'dipartimento-di-informatica-di-torino','Dipartimento di Informatica','Via Pessinetto 12, Torino','Puoi prendere il tram n°**9** e n°**3**, scendendo alla fermata *Ospedale Amedeo di Savoia / Dipartimento di Informatica*.\r\n\r\nDalla fermata della metropolitana *XVIII Dicembre* puoi prendere il pullman n°**59** e n°**59/** scendendo alla fermata *Svizzera*.','/2016/static/openstreetmap-unito.svg',45.09,7.65917,NULL);
INSERT INTO `ldto_location` VALUES (2,'dipartimento-di-biotecnologie','Dipartimento di Biotecnologie','Via Nizza 52, Torino','La fermata **Nizza** della metropolitana è a 50 metri dal Dipartimento di Biotecnologie.','http://linuxdaytorino.org/2015/images/biotech.jpg',45.0499,7.67328,NULL);
INSERT INTO `ldto_location` VALUES (3,'politecnico-di-torino-sede-centrale','Politecnico di Torino (sede centrale)','Corso Duca degli Abruzzi 24, Torino',NULL,NULL,45.0624,7.66164,NULL);
INSERT INTO `ldto_location` VALUES (4,'politecnico-di-torino-cittadella','Politecnico di Torino (cittadella)','Corso Castelfidardo 34, Torino',NULL,NULL,45.065,7.65818,NULL);
INSERT INTO `ldto_location` VALUES (5,'cascina-roccafranca','Cascina Roccafranca','Via Edoardo Rubino 45, Torino',NULL,NULL,45.0409,7.62376,NULL);
INSERT INTO `ldto_location` VALUES (6,'cortile-del-maglio','Cortile del Maglio','Via Vittorio Andreis 18, Torino',NULL,NULL,45.0808,7.68108,NULL);
INSERT INTO `ldto_location` VALUES (7,'sala-consiglieri-della-provincia-di-torino','Sala Consiglieri della Provincia di Torino','Via Maria Vittoria 12, Torino','Palazzo Cisterna',NULL,45.0671,7.68531,NULL);
INSERT INTO `ldto_location` VALUES (8,'cdq','Casa del Quartiere','Via Oddino Morgari 14, Torino',NULL,NULL,45.0542,7.67816,NULL);
INSERT INTO `ldto_location` VALUES (9,'torino-incontra','Torino Incontra','Via Nino Costa 8, Torino',NULL,NULL,45.0648,7.68596,NULL);
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
  `location_ID` int(10) unsigned NOT NULL,
  `room_uid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`room_ID`),
  UNIQUE KEY `room_uid` (`room_uid`),
  KEY `location_ID` (`location_ID`),
  CONSTRAINT `ldto_room_ibfk_1` FOREIGN KEY (`location_ID`) REFERENCES `ldto_location` (`location_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_room`
--

LOCK TABLES `ldto_room` WRITE;
/*!40000 ALTER TABLE `ldto_room` DISABLE KEYS */;
INSERT INTO `ldto_room` VALUES (1,1,'a','Aula B');
INSERT INTO `ldto_room` VALUES (2,1,'b','Aula A');
INSERT INTO `ldto_room` VALUES (3,1,'c','Aula D');
INSERT INTO `ldto_room` VALUES (4,1,'d','Aula C');
INSERT INTO `ldto_room` VALUES (5,1,'lab-1','Spazio Coderdojo');
INSERT INTO `ldto_room` VALUES (6,1,'lab-2','Spazio Restart');
INSERT INTO `ldto_room` VALUES (8,2,'first-floor','Primo piano');
INSERT INTO `ldto_room` VALUES (9,1,'lab-turing','Laboratorio Turing');
INSERT INTO `ldto_room` VALUES (10,1,'lab-dijkstra','Laboratorio Dijkstra');
INSERT INTO `ldto_room` VALUES (11,1,'f','Aula F');
INSERT INTO `ldto_room` VALUES (12,1,'lab-von-neumann','Laboratorio von Neumann');
INSERT INTO `ldto_room` VALUES (13,4,'aula-1i','Aula 1I');
INSERT INTO `ldto_room` VALUES (14,4,'aula-3i','Aula 3I');
INSERT INTO `ldto_room` VALUES (15,4,'aula-5i','Aula 5I');
INSERT INTO `ldto_room` VALUES (16,4,'aula-2i','Aula 2I');
INSERT INTO `ldto_room` VALUES (17,4,'aula-4i','Aula 4I');
INSERT INTO `ldto_room` VALUES (18,3,'aula-2','Aula 2');
INSERT INTO `ldto_room` VALUES (19,3,'aula-4','Aula 4');
INSERT INTO `ldto_room` VALUES (20,3,'aula-6','Aula 6');
INSERT INTO `ldto_room` VALUES (21,3,'aula-8','Aula 8');
INSERT INTO `ldto_room` VALUES (22,3,'aula-7','Aula 7');
INSERT INTO `ldto_room` VALUES (23,4,'aula-7i','Aula 7I');
INSERT INTO `ldto_room` VALUES (24,5,'aula-corsi-1','Aula corsi 1');
INSERT INTO `ldto_room` VALUES (25,5,'aula-corsi-2','Aula corsi 2');
INSERT INTO `ldto_room` VALUES (26,5,'incubatore','Incubatore');
INSERT INTO `ldto_room` VALUES (27,5,'bottega','Bottega');
INSERT INTO `ldto_room` VALUES (28,5,'salone','Salone');
INSERT INTO `ldto_room` VALUES (29,3,'sala-consiglio-di-facolta','Sala Consiglio di Facoltà');
INSERT INTO `ldto_room` VALUES (30,9,'sala-einaudi','Sala Einaudi');
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
INSERT INTO `ldto_track` VALUES (6,'intermediate','Intermedio',6,'Adatto ad un pubblico abbastanza smanettone');
INSERT INTO `ldto_track` VALUES (7,'advanced','Avanzato',7,'Adatto ad un pubblico di nerd disperati');
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
  `user_gravatar` char(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_image` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Gravatar when NULL',
  `user_password` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ldto_user`
--

LOCK TABLES `ldto_user` WRITE;
/*!40000 ALTER TABLE `ldto_user` DISABLE KEYS */;
INSERT INTO `ldto_user` VALUES (1,'boz','admin',1,1,'Valerio','Bozzolan',NULL,NULL,'93f0cce15047436217cd3dfc8a73dadc',NULL,NULL,'https://boz.reyboz.it','gnu-gpl','Qualcuno ha detto... software libero?','https://blog.reyboz.it','ValerioBozzolan',NULL,NULL,NULL,'valerio-bozzolan');
INSERT INTO `ldto_user` VALUES (2,'oirasor','admin',1,1,'Rosario','Antoci',NULL,NULL,'3fe5e057f1207e609a93aa3796f63004',NULL,NULL,NULL,'gnu-gpl','Studente di Ingegneria Informatica, appassionato di tante cose (forse troppe).\n\nNon mi piace la tecnologia che provoca il gadgettame, ma il suo continuo avanzare per migliorare le risorse e la conoscenza di tutti.\n\nMi è capitato di organizzare il Linux Day 2016. =P\n\nSuonatore di Floppy, appassionato di Dama e Retrocomputing.',NULL,'0iras0r',NULL,NULL,NULL,'0iras0r');
INSERT INTO `ldto_user` VALUES (3,'dario','user',1,0,'Dario','Sera',NULL,NULL,'4c1fcda45d79c0618bc91446e2009872',NULL,NULL,NULL,NULL,'Dario Sera, 22 anni, studente di Ingegneria Informatica con la passione per la didattica. Co-fondatore di [CoderDojo Torino2](http://www.coderdojotorino2.it) e di [Merende Digitali](http://www.merendedigitali.it).\n\nUtilizzo GNU/Linux da molti anni, e collaboro con il Linux Day Torino dal 2010.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (7,'renzo','user',1,0,'Renzo','Davoli',NULL,NULL,'32c8c9d7c965d23df604a56597540138','/2016/static/user/davoli.jpg',NULL,NULL,NULL,'Ricercatore, Maker, Insegnante, Sviluppatore...\nCinquantenne all\'anagrafe, continua a giocare e a pensare liberamente.\nIn realtà vuole salvare il mondo, ma non ditelo a nessuno.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (8,'luigi.maselli','user',1,0,'Luigi','Maselli',NULL,NULL,'e79a3fd6f28fc611c455e8ebc67a3080',NULL,NULL,'https://grigio.org','mit','Fondatore <http://corso-javascript.it> e TorinoJS, software developer freelance.',NULL,'grigi0',NULL,NULL,NULL,'grigio');
INSERT INTO `ldto_user` VALUES (10,'marco.cavallini','user',1,0,'Marco','Cavallini',NULL,NULL,'ff90f7c12341042f5227398edc1cf4e1','/2016/static/user/cavallini.jpg',NULL,NULL,NULL,'Marco Cavallini è un programmatore C/C++ sin dalla metà degli anni \'80. Inizia l\'attività di evangelizzazione all\'Open Source e Linux embedded nel 1999 con le prime schede StrongArm.\n\nÈ membro di OpenEmbedded dal 2009 e Yocto Project advocate dal 2012. Marco ha fondato KOAN nel 1996, una software house specializzata in software embedded con sede in Italia, che offre servizi di sviluppo del kernel e formazione per i sistemi Linux embedded. Quando non si utilizza i computer, è solitamente interessato a mescolare la Fisica con la Filosofia.',NULL,NULL,NULL,'marcocavallini',NULL,NULL);
INSERT INTO `ldto_user` VALUES (11,'davide','user',1,0,'Davide','Bucci',NULL,NULL,'4632994b4d358fe36b0ee14f84737dce',NULL,NULL,'http://davbucci.chez-alice.fr',NULL,'Davide è viaggiatore transalpino, programmatore della domenica (se non fa bello, non c\'è neve e non si va a sciare) e qualche volta anche del sabato pomeriggio. Ogni tanto racconta a dei ragazzi e delle ragazze come si usano gli amplificatori operazionali, in altre occasioni canta a squarciagola con altre persone. Appassionato di vecchi computer e di elettronica analogica, si tiene in casa un numero imbarazzante di oscilloscopi, tracciacurve, una macchina da scrivere ed un pianoforte. Coordinatore del progetto open source FidoCadJ, Davide è sensibile al fascino delle automobili scoperte a due posti, soprattutto se a motore centrale.\n\nDavide pratica abbastanza spesso Java, il C ed il C++, sa costruire un generatore ad impulsi con diodi step recovery, ha un\'idea abbastanza precisa su cosa sia un intervallo di quarta eccedente, come funzioni lo scambio ionico su vetro e come calcolare un modo di propagazione in una guida d\'onda dielettrica.',NULL,'davbucci',NULL,NULL,NULL,'DarwinNE');
INSERT INTO `ldto_user` VALUES (12,'francesco','user',1,0,'Francesco','Tucci',NULL,NULL,'e93f71f84334e8aee586069ce0dd1ad2',NULL,NULL,'http://www.iltucci.com',NULL,'Si diverte quando ha a che fare con tutto ciò che ha dei bit o della corrente, sistemista di professione, maker per diletto, podcaster (<http://geekcookies.github.io> e <http://www.pilloledib.it>) almeno una volta al mese.\n\nMini CV delle mie passioni: sistemi Win/Linux/Mac, Arduino, Raspberry Pi e altre schedine embedded, basi di elettronica, programmatore a tempo perso (quali linguaggi? non è importante, impararne la sintassi non è la cosa che mi ostacola).',NULL,'cesco_78','francesco.tucci',NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (13,'massimo','user',1,0,'Massimo','Nuvoli',NULL,NULL,'5f4846fa67388fd5a92638407ed501a8','/2016/static/user/massimo.jpg',NULL,NULL,NULL,'Architetto di Sistemi presso Progetto Archivio SRL e Dicobit.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (14,'elia','user',1,0,'Elia','Bellussi',NULL,NULL,'8b0e2f9c8927ae8527071f82e9ba8eb0',NULL,NULL,NULL,NULL,'Elia Bellussi, 35 anni, è fondatore del Museo Internazionale dell\'Informatica (già Museo Piemontese dell\'Informatica) e di CoderDojo Torino. Socio di AICA, Stati Generali dell\'Innovazione e di Nord Est Digitale. Consulente informatico si occupa di system engineering.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (15,'davide.isoardi','user',1,0,'Davide','Isoardi',NULL,NULL,'1e6f2656299bbe943ca1cf27f2cd06b1',NULL,NULL,NULL,NULL,'Big Data System Architect e sysadmin.',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (16,'davide.vergari','user',1,0,'Davide','Vergari',NULL,'',NULL,NULL,NULL,NULL,NULL,'Big Data System Architect e sysadmin.',NULL,'DavideVergari',NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (17,'davide.mainardi','user',1,0,'Davide','Mainardi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Ingegnere informatico, Open Source enthusiast, focalizzato su privacy e sicurezza informatica, full stack Java developer, Consigliere della Fondazione dell\'Ordine degli Ingegneri della Provincia di Torino.',NULL,'ingmainardi',NULL,NULL,NULL,'dmainardi');
INSERT INTO `ldto_user` VALUES (18,'gianfranco.poncini','user',1,0,'Gianfranco','Poncini',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (20,'marco.signoretto','user',1,0,'Marco','Signoretto',NULL,NULL,'19fb231f51568df3a2a3cd63626f41ca','/2016/static/user/signoretto.jpg',NULL,'http://www.olivelab.it',NULL,'The trash king!\n\nNato e cresciuto a Torino, Marco ha speso i suoi ultimi anni di Politecnico a studiare l\'ultima parte della filiera ovvero l’immondizia. Nel 2015 si è laureato in Ecodesign con una tesi sulla gestione dei RAEE a livello aziendale.\n\nOggi ha aperto il piccolo studio creativo Olive Creative Lab intenzionato a muoversi in tutti i campi della creatività: dal product design alla grafica, dall\'interaction design alla sostenibilità.',NULL,'MarcoSignorett','marco.signoretto.9','marco-signoretto-326003a7',NULL,NULL);
INSERT INTO `ldto_user` VALUES (21,'simone','user',1,0,'Simone','Massi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (23,'alessio','user',1,0,'Alessio','Melandri',NULL,NULL,NULL,'/2016/static/user/alessio.jpg',NULL,NULL,NULL,'Appassionato di troppe cose, ho costretto il mio entusiasmo per la conoscenza e per la tecnologia ad incontrarsi nell\'informatica. Lavoro ogni giorno coi dati presso Synapta, ne aggiungo di nuovi su Wikipedia, Wikidata e OpenStreetMap e non vedo l\'ora di poter navigare in un Web semantico. Mi piace giocare a scacchi e bere aranciata. Anche non contemporaneamente.',NULL,NULL,NULL,'alessiomelandri',NULL,'alemela');
INSERT INTO `ldto_user` VALUES (24,'mario.lacaj','user',1,0,'Mario','Lacaj',NULL,NULL,'6e1344b291eecd75d0dab6ce0fa64b6a','/2016/static/user/mario_lacaj.jpg',NULL,NULL,NULL,'Piacere di conoscerti! Sono uno dei rappresentanti degli studenti del Dipartimento di Informatica di Torino.\n\nCosa c\'entro? Te lo dico subito in questa intervista:\n\n<https://blog.linuxdaytorino.org/2016/10/04/intervista-e-sopralluogo-al-dipartimento/>',NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (25,'valerio.sacchetto','user',1,0,'Valerio','Sacchetto',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (26,'gloria.puppi','user',1,0,'Gloria','Puppi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (27,'madbob','user',1,0,'Roberto','Guido',NULL,NULL,'3d2b05e0cb8dac9f22072a3e40b6483b',NULL,NULL,'http://www.madbob.org',NULL,'Presidente [Italian Linux Society](http://www.ils.org/).','http://blog.madbob.org','madbob',NULL,NULL,NULL,'madbob');
INSERT INTO `ldto_user` VALUES (28,'silux','user',1,0,'Valerio','Cietto',NULL,NULL,'773c7e55047cf650c68c03446548211a',NULL,NULL,'https://siluxmedia.wordpress.com','gnu-gpl','Vivo fin dal lontano \'92, la mia vocazione è di fare il mago.\n\nVisto che non è possibile, ho iniziato a scrivere incantesimi, demoni, scrivere in un antico linguaggio per incantare oggetti e materializzare oggetti dalla plastica, e mi diverto tantissimo a farlo.\n\nL’Open source e l’open hardware è quello di cui c\'è bisogno per usare al meglio la meravigliosa tecnologia intorno a noi.\n\nAmo usare la licenza [WTFPL](https://it.wikipedia.org/wiki/WTFPL) per esempi e per chi non legge mai i testi delle licenze.',NULL,NULL,'valerio.cietto','valerio-cietto-2ba01958',NULL,'ValerioCietto');
INSERT INTO `ldto_user` VALUES (29,'tinytanic','user',1,0,'Luca','Aguzzoli',NULL,NULL,'4ae444c7e81d97da4f8340d50c375aed',NULL,NULL,'http://aguzzoliluca.it','gnu-gpl','Linux user dal 2010 iniziato da una Ubuntu con GNOME 2 (<3) su un muletto che neanche nel 1983 sarebbe stato un buon computer.\n\nOra cerco di sviluppare il mio futuro libero... e tu?',NULL,NULL,'luka.agu','lucaaguzzoli',NULL,'TinyTanic');
INSERT INTO `ldto_user` VALUES (31,'fox','user',1,0,'Giuseppe','Treccarichi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (32,'hox','user',1,0,'Andrea','Carron',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (33,'giuseppe-castagno','user',1,0,'Giuseppe','Castagno',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (34,'karletto','user',1,0,'Carlo','Camarda',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (35,'sophia-danesino','user',1,0,'Sophia','Danesino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (36,'fabrizio-reale','user',1,0,'Fabrizio','Reale',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (37,'michele-di-serio','user',1,0,'Michele','di Serio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (38,'alessandro-peppino','user',1,0,'Alessandro','Peppino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (39,'luca-zamboni','user',1,0,'Luca','Zamboni',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (40,'rodolfo-boraso','user',1,0,'Rodolfo','Boraso',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (41,'maurizio-lupo','user',1,0,'Maurizio','Lupo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (42,'proto','user',1,0,'Mirco','Chinelli',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (43,'diego-feruglio','user',1,0,'Diego','Feruglio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (44,'davide-gomba','user',1,0,'Davide','Gomba',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (45,'vittorio-zuccala','user',1,0,'Vittorio','Zuccalà',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (46,'leso','user',1,0,'Simone','Martina',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (47,'francio','user',1,0,'Francesco','Golia',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (48,'andrea-chiarottino','user',1,0,'Andrea','Chiarottino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (49,'francesco-ronchi','user',1,0,'Francesco','Ronchi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (50,'maria-aliberti','user',1,0,'Maria','Aliberti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (51,'alessandro-rabbone','user',1,0,'Alessandro','Rabbone',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (52,'angelo-raffaele-meo','user',1,0,'Angelo Raffaele','Meo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (53,'davide-moro','user',1,0,'Davide','Moro',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (54,'tommaso-marino','user',1,0,'Tommaso','Marino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (55,'alessio-drivet','user',1,0,'Alessio','Drivet',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (56,'emanuela-re','user',1,0,'Emanuela','Re',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (57,'federico-di-gregorio','user',1,0,'Federico','Di Gregorio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (58,'igor-pesando','user',1,0,'Igor','Pesando',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (59,'parantido','user',1,0,'Danilo','Santoro',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (60,'luca-cipriani','user',1,0,'Luca','Cipriani',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (61,'diego-guenzi','user',1,0,'Diego','Guenzi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (62,'dario-lombardo','user',1,0,'Dario','Lombardo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (63,'francesco-daluisio','user',1,0,'Francesco','D\'Aluisio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (64,'lorenzo-bassi','user',1,0,'Lorenzo','Bassi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (65,'michele-tameni','user',1,0,'Michele','Tameni',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (66,'p-ballauri','user',1,0,'P.','Ballauri',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (67,'r-di-giorgio','user',1,0,'R.','Di Giorgio',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (68,'l-galassi','user',1,0,'L.','Galassi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (69,'i-lazorec','user',1,0,'I.','Lazorec',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (70,'a-pellegrinelli','user',1,0,'A.','Pellegrinelli',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (71,'g-salvagno','user',1,0,'G.','Salvagno',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (72,'r-russo','user',1,0,'R.','Russo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (73,'marco-dorigo','user',1,0,'Marco','Dorigo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (74,'alessandro-ugo','user',1,0,'Alessandro','Ugo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (75,'nicolo-zubbini','user',1,0,'Nicolò','Zubbini',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (76,'roberto-preziusi','user',1,0,'Roberto','Preziusi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (77,'ironbishop','user',1,0,'Flavio','Pastore',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (78,'eagle1753','user',1,0,'Matteo','Collura',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (79,'marco-martin','user',1,0,'Marco','Martin',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (80,'fabio-erculiani','user',1,0,'Fabio','Erculiani',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (81,'silvan-calarco','user',1,0,'Silvan','Calarco',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (82,'luigi-massa','user',1,0,'Luigi','Massa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (83,'nicola-ambrosino','user',1,0,'Nicola','Ambrosino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (84,'fabrizio-ferrari','user',1,0,'Fabrizio','Ferrari',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (85,'pier-carlo-devoti','user',1,0,'Pier Carlo','Devoti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (86,'italo-vignoli','user',1,0,'Italo','Vignoli',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (87,'stefano-cannillo','user',1,0,'Stefano','Cannillo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (88,'guido-audino','user',1,0,'Guido','Audino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (89,'mariella-berra','user',1,0,'Mariella','Berra',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (90,'gino-nuzzi','user',1,0,'Gino','Nuzzi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (91,'alessandro-sciullo','user',1,0,'Alessandro','Sciullo',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (92,'carlo-chiama','user',1,0,'Carlo','Chiama',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (93,'andrea-ratto','user',1,0,'Andrea','Ratto',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (94,'iacopo-benesperi','user',1,0,'Iacopo','Benesperi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (95,'marco-ciurcina','user',1,0,'Marco','Ciurcina',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (96,'marco-bodrato','user',1,0,'Marco','Bodrato',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (97,'nicola-franzese','user',1,0,'Nicola','Franzese',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (98,'giorgio-ferrero','user',1,0,'Giorgio','Ferrero',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (99,'simone-capodicasa','user',1,0,'Simone','Capodicasa',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (100,'federico-fissore','user',1,0,'Federico','Fissore',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (101,'marco-zanasso','user',1,0,'Marco','Zanasso',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (102,'dimitri-bellini','user',1,0,'Dimitri','Bellini',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (103,'paolo-doz','user',1,0,'Paolo','Doz',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (104,'ilario-pittau','user',1,0,'Ilario','Pittau',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (105,'keivan-motavalli','user',1,0,'Keivan','Motavalli',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (106,'paolo-stagno','user',1,0,'Paolo','Stagno',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (107,'luca-poletti','user',1,0,'Luca','Poletti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (108,'bughardy','user',1,0,'Matteo','Beccaro',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (109,'andrea-negro','user',1,0,'Andrea','Negro',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (110,'mariano-fiorentino','user',1,0,'Mariano','Fiorentino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (111,'andrea-deste','user',1,0,'Andrea','D\'Este',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (112,'federico-morando','user',1,0,'Federico','Morando',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (113,'igor-pesandro','user',1,0,'Igor','Pesandro',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (114,'flavio-giobergia','user',1,0,'Flavio','Giobergia',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (115,'alessandro-rubini','user',1,0,'Alessandro','Rubini',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (116,'walter-dal-mut','user',1,0,'Walter','Dal Mut',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'walterdalmut',NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (117,'francesco-ficili','user',1,0,'Francesco','Ficili',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (118,'federico-vanzati','user',1,0,'Federico','Vanzati',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (119,'gianfranco-costamagn','user',1,0,'Gianfranco','Costamagna',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (120,'gilberto-conti','user',1,0,'Gilberto','Conti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (121,'davide-gianforte','user',1,0,'Davide','Gianforte',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (122,'mariagrazia-pellerin','user',1,0,'Mariagrazia','Pellerino','assessore',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (123,'riccardo-magliocchet','user',1,0,'Riccardo','Magliocchetti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (124,'luca-barbato','user',1,0,'Luca','Barbato',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (125,'greta-boffi','user',1,0,'Greta','Boffi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (126,'timothy-b-terriberry','user',1,0,'Timothy','B. Terriberry',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (127,'carlo-blengino','user',1,0,'Carlo','Blengino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (128,'ludovico-pavesi','user',1,0,'Ludovico','Pavesi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (129,'stefano-enrico-mendo','user',1,0,'Stefano Enrico','Mendola',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (130,'giacomo-grasso','user',1,0,'Giacomo','Grasso',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (131,'carlo-perassi','user',1,0,'Carlo','Perassi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (132,'marco-delaurenti','user',1,0,'Marco','Delaurenti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (133,'vittorio-pasteris','user',1,0,'Vittorio','Pasteris',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (134,'davide-quaglia','user',1,0,'Davide','Quaglia',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (135,'marco-steffenino','user',1,0,'Marco','Steffenino',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (136,'roberto-strano','user',1,0,'Roberto','Strano',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (137,'sergio-margarita','user',1,0,'Sergio','Margarita',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (138,'michele-lionetti','user',1,0,'Michele','Lionetti',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (139,'gianpaolo-perego','user',1,0,'Gianpaolo','Perego',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (140,'dario-guerrieri','user',1,0,'Dario','Guerrieri',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (141,'jean-francois-panico','user',1,0,'Jean François','Panico',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (142,'marco-musso','user',1,0,'Marco','Musso',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `ldto_user` VALUES (143,'admin','admin',1,1,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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

-- Dump completed on 2019-03-02 14:59:34
