-- MySQL dump 10.11
--
-- Host: localhost    Database: rv
-- ------------------------------------------------------
-- Server version	5.0.75-0ubuntu10.2

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
-- Current Database: `rv`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `rv` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `rv`;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `category` (
  `id` int(11) NOT NULL auto_increment,
  `parentId` int(11) default NULL,
  `name` varchar(256) NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (5,0,'Department','2009-08-13 08:37:09',0),(6,5,'Fine art','2009-08-13 11:50:28',0),(7,0,'Postion','2009-08-13 11:50:38',0),(8,5,'Graphic design','2009-08-13 11:50:52',0),(9,7,'student','2009-08-13 11:51:02',0),(10,7,'teacher','2009-08-13 11:51:10',0),(11,0,'Another one','2009-08-14 09:00:37',0);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `category_v`
--

DROP TABLE IF EXISTS `category_v`;
/*!50001 DROP VIEW IF EXISTS `category_v`*/;
/*!50001 CREATE TABLE `category_v` (
  `id` int(11),
  `name` varchar(256),
  `childid` int(11),
  `childname` varchar(256)
) ENGINE=MyISAM */;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `item` (
  `id` int(11) NOT NULL auto_increment,
  `itemId` int(11) NOT NULL,
  `parentId` int(11) default NULL,
  `localizationId` int(11) NOT NULL,
  `commonLn` tinyint(1) NOT NULL default '0',
  `categoryFilter` tinyint(1) default NULL,
  `userFilter` tinyint(1) default NULL,
  `namespaceId` int(11) NOT NULL,
  `allowChild` tinyint(1) NOT NULL default '0',
  `showChild` tinyint(1) NOT NULL default '1',
  `categoryId` int(11) default NULL,
  `year` tinyint(4) default NULL,
  `uploadNr` int(11) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  `ownerId` int(11) NOT NULL,
  `editorId` int(11) NOT NULL,
  `online` datetime NOT NULL,
  `offline` datetime default NULL,
  `title` varchar(256) NOT NULL,
  `text` text,
  `templateId` int(11) default NULL,
  `hidden` tinyint(1) NOT NULL default '0',
  `friendlyUrl` varchar(1024) default NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `localizationId` (`localizationId`),
  KEY `namespaceId` (`namespaceId`),
  KEY `categoryId` (`categoryId`),
  KEY `ownerId` (`ownerId`),
  KEY `editorId` (`editorId`),
  CONSTRAINT `Item_ibfk_1` FOREIGN KEY (`localizationId`) REFERENCES `localization` (`id`),
  CONSTRAINT `Item_ibfk_2` FOREIGN KEY (`namespaceId`) REFERENCES `namespace` (`id`),
  CONSTRAINT `Item_ibfk_3` FOREIGN KEY (`ownerId`) REFERENCES `user` (`id`),
  CONSTRAINT `Item_ibfk_4` FOREIGN KEY (`editorId`) REFERENCES `user` (`id`),
  CONSTRAINT `Item_ibfk_5` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (1,1,0,1,0,0,0,1,0,1,NULL,NULL,0,0,4,4,'0000-00-00 00:00:00','0000-00-00 00:00:00','School day 2006','This page is about the school day function 2006.So thats it. This page will have photos, news and other stuff about the school day function.',NULL,0,'school-day-2006','2009-08-31 19:21:57'),(2,1,0,2,0,0,0,1,0,1,NULL,NULL,0,0,4,4,'0000-00-00 00:00:00','0000-00-00 00:00:00','Schooldag 2006','Deze pagina gaat over de schooldag functie 2006.So thats it. Deze pagina zal nog foto&#39;s, nieuws en andere dingen over de school dag functie.',NULL,0,'schooldag-2006','2009-08-31 19:21:57'),(3,3,0,1,0,0,0,1,0,1,NULL,NULL,0,0,4,3,'2009-09-01 00:00:00','2009-09-30 00:00:00','National Day 2006','This is about the nation day 2006. And more news about it. It will have more images and other suff here. that\'s it.',NULL,0,'national-day-2006','2009-08-31 19:37:21'),(4,3,0,2,0,0,0,1,0,1,NULL,NULL,0,0,4,3,'2009-09-01 00:00:00','2009-09-30 00:00:00','Nationale Dag 2006','Dit is ongeveer de natie dag 2006. En meer nieuws over. Het zal meer afbeeldingen en andere Suff hier. dat is het.',NULL,0,'nationale-dag-2006','2009-08-31 19:37:21'),(10,10,1,1,1,0,0,2,1,0,NULL,127,0,0,4,4,'2009-09-02 00:00:00','2009-09-30 00:00:00','It was Great Fun','It was Great Fun, It was Great Fun, It was Great Fun',NULL,0,'it-was-great-fun','2009-08-31 20:15:02'),(11,10,1,2,1,0,0,2,1,0,NULL,127,0,0,4,4,'2009-09-02 00:00:00','2009-09-30 00:00:00','It was Great Fun','It was Great Fun, It was Great Fun, It was Great Fun',NULL,0,'it-was-great-fun','2009-08-31 20:15:02'),(12,12,0,1,0,1,1,5,1,1,NULL,NULL,0,1,4,3,'2009-09-01 00:00:00','0000-00-00 00:00:00','Everything',' Everything Everything Everything',NULL,0,'everything','2009-08-31 20:27:38'),(13,12,0,2,0,1,1,5,1,1,NULL,NULL,0,1,4,3,'2009-09-01 00:00:00','0000-00-00 00:00:00','Alles','Everything Everything Everything',NULL,0,'alles','2009-08-31 20:27:38');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemupload`
--

DROP TABLE IF EXISTS `itemupload`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `itemupload` (
  `id` int(11) NOT NULL auto_increment,
  `type` enum('upload','uploadFilter','uploadSelection','factbox','users','breakpoint') NOT NULL,
  `fileName` varchar(128) default NULL,
  `filePath` varchar(512) default NULL,
  `fileType` varchar(32) default NULL,
  `fileExtension` varchar(8) default NULL,
  `uploadSelectedItemId` int(11) default NULL,
  `uploadBreakpoint` tinyint(1) default NULL,
  `uploadFilterCount` int(11) default NULL,
  `uploadFactbox` text,
  `itemId` int(11) NOT NULL,
  `title` varchar(512) NOT NULL,
  `text` text,
  `position` tinyint(4) NOT NULL default '0',
  `created` datetime NOT NULL,
  `online` datetime NOT NULL,
  `offline` datetime default NULL,
  `localizationId` int(11) NOT NULL,
  `categoryId` int(11) default NULL,
  `namespaceId` int(11) default NULL,
  `ownerId` int(11) NOT NULL,
  `editorId` int(11) default NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `uploadSelectedItemId` (`uploadSelectedItemId`),
  KEY `itemId` (`itemId`),
  KEY `localizationId` (`localizationId`),
  KEY `categoryId` (`categoryId`),
  KEY `ownerId` (`ownerId`),
  KEY `editorId` (`editorId`),
  CONSTRAINT `ItemUpload_ibfk_1` FOREIGN KEY (`uploadSelectedItemId`) REFERENCES `item` (`id`),
  CONSTRAINT `ItemUpload_ibfk_2` FOREIGN KEY (`localizationId`) REFERENCES `localization` (`id`),
  CONSTRAINT `ItemUpload_ibfk_3` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  CONSTRAINT `ItemUpload_ibfk_4` FOREIGN KEY (`ownerId`) REFERENCES `user` (`id`),
  CONSTRAINT `ItemUpload_ibfk_5` FOREIGN KEY (`editorId`) REFERENCES `user` (`id`),
  CONSTRAINT `item_fk_constraint` FOREIGN KEY (`itemId`) REFERENCES `item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `itemupload`
--

LOCK TABLES `itemupload` WRITE;
/*!40000 ALTER TABLE `itemupload` DISABLE KEYS */;
INSERT INTO `itemupload` VALUES (2,'upload','a.jpg','images/items/11a.jpg.jpg','image/jpeg','jpg',NULL,NULL,NULL,NULL,11,'funnyPic','Its really pic :D',0,'2009-09-01 01:45:02','2009-09-01 00:00:00','0000-00-00 00:00:00',1,NULL,NULL,4,NULL,'2009-08-31 20:15:02'),(3,'upload','DownHairMSN.jpg','images/items/12DownHairMSN.jpg.jpg','image/jpeg','jpg',NULL,NULL,NULL,NULL,12,'upload','fds fdsf dsf dsf',0,'2009-09-01 01:57:38','2009-09-01 00:00:00','0000-00-00 00:00:00',1,NULL,NULL,4,NULL,'2009-08-31 20:27:38'),(4,'uploadFilter',NULL,'',NULL,NULL,NULL,NULL,1,NULL,12,'Filter','',1,'2009-09-01 01:57:38','2009-09-01 01:57:38','0000-00-00 00:00:00',1,NULL,2,4,NULL,'2009-08-31 20:27:38'),(5,'uploadSelection',NULL,'',NULL,NULL,4,NULL,NULL,NULL,12,'selection','',2,'2009-09-01 01:57:38','2009-09-01 01:57:38','0000-00-00 00:00:00',1,NULL,NULL,4,NULL,'2009-08-31 20:27:38'),(6,'factbox',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,12,'fact','factbox',3,'2009-09-01 01:57:38','2009-09-01 01:57:38','0000-00-00 00:00:00',1,NULL,NULL,4,NULL,'2009-08-31 20:27:38'),(7,'users',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,12,'users','',4,'2009-09-01 01:57:38','2009-09-01 01:57:38','0000-00-00 00:00:00',1,NULL,NULL,4,NULL,'2009-08-31 20:27:38'),(8,'breakpoint',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,12,'','',5,'2009-09-01 01:57:38','2009-09-01 01:57:38','0000-00-00 00:00:00',1,NULL,NULL,4,NULL,'2009-08-31 20:27:38');
/*!40000 ALTER TABLE `itemupload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemuploadfilter`
--

DROP TABLE IF EXISTS `itemuploadfilter`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `itemuploadfilter` (
  `itemUploadId` int(11) NOT NULL,
  `categoryId` int(11) default NULL,
  `namespaceId` int(11) default NULL,
  `itemsPerPage` int(11) NOT NULL,
  `totalItem` int(11) default NULL COMMENT '0 -> Alll and -1 -> fillup',
  KEY `itemUploadId` (`itemUploadId`),
  KEY `categoryId` (`categoryId`),
  KEY `namespaceId` (`namespaceId`),
  CONSTRAINT `ItemUploadFilter_ibfk_1` FOREIGN KEY (`itemUploadId`) REFERENCES `itemupload` (`id`),
  CONSTRAINT `ItemUploadFilter_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  CONSTRAINT `ItemUploadFilter_ibfk_3` FOREIGN KEY (`namespaceId`) REFERENCES `namespace` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `itemuploadfilter`
--

LOCK TABLES `itemuploadfilter` WRITE;
/*!40000 ALTER TABLE `itemuploadfilter` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemuploadfilter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemuploaduploads`
--

DROP TABLE IF EXISTS `itemuploaduploads`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `itemuploaduploads` (
  `itemUploadId` int(11) default NULL,
  `filename` varchar(128) NOT NULL,
  `path` varchar(512) NOT NULL,
  `type` varchar(32) default NULL,
  `extension` varchar(8) NOT NULL,
  KEY `itemUploadId` (`itemUploadId`),
  CONSTRAINT `ItemUploadUploads_ibfk_1` FOREIGN KEY (`itemUploadId`) REFERENCES `itemupload` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `itemuploaduploads`
--

LOCK TABLES `itemuploaduploads` WRITE;
/*!40000 ALTER TABLE `itemuploaduploads` DISABLE KEYS */;
/*!40000 ALTER TABLE `itemuploaduploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itemuploaduser`
--

DROP TABLE IF EXISTS `itemuploaduser`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `itemuploaduser` (
  `itemUploadId` int(11) NOT NULL,
  `userId` int(11) default NULL,
  `userGroupId` int(11) default NULL,
  KEY `itemUploadId` (`itemUploadId`),
  KEY `userGroupId` (`userGroupId`),
  KEY `userId` (`userId`),
  CONSTRAINT `ItemUploadUser_ibfk_1` FOREIGN KEY (`itemUploadId`) REFERENCES `itemupload` (`id`),
  CONSTRAINT `ItemUploadUser_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  CONSTRAINT `ItemUploadUser_ibfk_3` FOREIGN KEY (`userGroupId`) REFERENCES `usergroup` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `itemuploaduser`
--

LOCK TABLES `itemuploaduser` WRITE;
/*!40000 ALTER TABLE `itemuploaduser` DISABLE KEYS */;
INSERT INTO `itemuploaduser` VALUES (7,3,NULL),(7,4,NULL);
/*!40000 ALTER TABLE `itemuploaduser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `localization`
--

DROP TABLE IF EXISTS `localization`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `localization` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL,
  `language` varchar(16) NOT NULL,
  `culture` varchar(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `localization`
--

LOCK TABLES `localization` WRITE;
/*!40000 ALTER TABLE `localization` DISABLE KEYS */;
INSERT INTO `localization` VALUES (1,'en-US','English','US'),(2,'nl-NL','nl','island');
/*!40000 ALTER TABLE `localization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `namespace`
--

DROP TABLE IF EXISTS `namespace`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `namespace` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(256) character set utf8 collate utf8_bin NOT NULL,
  `commonLn` tinyint(1) NOT NULL default '0',
  `allowChildren` tinyint(1) NOT NULL default '0',
  `showChildren` tinyint(1) NOT NULL default '0',
  `yearDimension` tinyint(1) NOT NULL default '0',
  `categoryFilter` tinyint(1) NOT NULL default '0',
  `userFilter` tinyint(1) NOT NULL default '0',
  `shared` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `namespace`
--

LOCK TABLES `namespace` WRITE;
/*!40000 ALTER TABLE `namespace` DISABLE KEYS */;
INSERT INTO `namespace` VALUES (1,'Page',0,0,1,0,0,0,0),(2,'News',0,0,0,1,0,0,0),(3,'Project',1,1,1,0,0,0,0),(4,'Graduation',1,1,1,1,1,1,0),(5,'Custom',0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `namespace` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!50001 DROP VIEW IF EXISTS `roles`*/;
/*!50001 CREATE TABLE `roles` (
  `name` varchar(256),
  `type` bigint(11),
  `description` text,
  `bizrule` text,
  `data` text
) ENGINE=MyISAM */;

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `task` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `task`
--

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` VALUES ('dummyAction',2,'its dummy action test',NULL,NULL),('authenticated',2,'all authenticated users','return !Yii::app()->user->isGuest;',NULL),('guest',2,'guest users','return !Yii::app()->user->isGuest;',NULL);
/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taskRoles`
--

DROP TABLE IF EXISTS `taskRoles`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `taskRoles` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY  (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `taskRoles`
--

LOCK TABLES `taskRoles` WRITE;
/*!40000 ALTER TABLE `taskRoles` DISABLE KEYS */;
INSERT INTO `taskRoles` VALUES ('administrator','dummyAction');
/*!40000 ALTER TABLE `taskRoles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `userId` varchar(256) default NULL,
  `groupId` int(11) NOT NULL,
  `categoryId` int(11) default NULL,
  `email` varchar(512) NOT NULL,
  `password` varchar(512) NOT NULL,
  `year` tinyint(4) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  `graduated` tinyint(1) NOT NULL default '0',
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  KEY `user_fk_constraint` (`groupId`),
  KEY `category_fk_constraint` (`categoryId`),
  CONSTRAINT `category_fk_constraint` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  CONSTRAINT `user_fk_constraint` FOREIGN KEY (`groupId`) REFERENCES `usergroup` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (3,'SA123',2,NULL,'kjartanf@gmail.com','9d3b37707999a5a8fcffb49bb3d7d41b',1,1,0,'2009-08-24 07:43:48'),(4,'antobinish',2,NULL,'antobinish@ec.is','0cc175b9c0f1b6a831c399e269772661',1,1,1,'2009-08-24 20:41:01');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `userRoles`
--

DROP TABLE IF EXISTS `userRoles`;
/*!50001 DROP VIEW IF EXISTS `userRoles`*/;
/*!50001 CREATE TABLE `userRoles` (
  `itemname` varchar(256),
  `userid` int(11),
  `bizrule` binary(0),
  `data` binary(0)
) ENGINE=MyISAM */;

--
-- Table structure for table `usergroup`
--

DROP TABLE IF EXISTS `usergroup`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(256) NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `usergroup`
--

LOCK TABLES `usergroup` WRITE;
/*!40000 ALTER TABLE `usergroup` DISABLE KEYS */;
INSERT INTO `usergroup` VALUES (1,'Page','2009-08-11 12:41:10',1),(2,'administrator','2009-08-13 11:44:40',0),(3,'student','2009-08-24 10:07:53',0),(4,'teacher','2009-08-24 10:08:00',0);
/*!40000 ALTER TABLE `usergroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `webtree`
--

DROP TABLE IF EXISTS `webtree`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `webtree` (
  `uniqueId` int(11) NOT NULL auto_increment,
  `id` int(11) NOT NULL,
  `parentId` int(11) default NULL,
  `localizationId` int(11) NOT NULL,
  `url` varchar(512) NOT NULL,
  `friendlyUrl` varchar(512) default NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`uniqueId`),
  KEY `localizationId` (`localizationId`),
  CONSTRAINT `local_fk_constraint` FOREIGN KEY (`localizationId`) REFERENCES `localization` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `webtree`
--

LOCK TABLES `webtree` WRITE;
/*!40000 ALTER TABLE `webtree` DISABLE KEYS */;
/*!40000 ALTER TABLE `webtree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `rv`
--

USE `rv`;

--
-- Final view structure for view `category_v`
--

/*!50001 DROP TABLE `category_v`*/;
/*!50001 DROP VIEW IF EXISTS `category_v`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `category_v` AS select `p`.`id` AS `id`,`p`.`name` AS `name`,`c`.`id` AS `childid`,`c`.`name` AS `childname` from (`category` `p` left join `category` `c` on((`p`.`id` = `c`.`parentId`))) where (`p`.`parentId` = 0) order by `p`.`id`,`c`.`parentId` */;

--
-- Final view structure for view `roles`
--

/*!50001 DROP TABLE `roles`*/;
/*!50001 DROP VIEW IF EXISTS `roles`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`tester`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `roles` AS select `usergroup`.`name` AS `name`,1 AS `type`,_utf8'' AS `description`,NULL AS `bizrule`,NULL AS `data` from `usergroup` where (`usergroup`.`deleted` = 0) union select `task`.`name` AS `name`,`task`.`type` AS `type`,`task`.`description` AS `description`,`task`.`bizrule` AS `bizrule`,`task`.`data` AS `data` from `task` */;

--
-- Final view structure for view `userRoles`
--

/*!50001 DROP TABLE `userRoles`*/;
/*!50001 DROP VIEW IF EXISTS `userRoles`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`tester`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `userRoles` AS select `g`.`name` AS `itemname`,`u`.`id` AS `userid`,NULL AS `bizrule`,NULL AS `data` from (`user` `u` join `usergroup` `g` on((`u`.`groupId` = `g`.`id`))) where (`g`.`deleted` = 0) */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-09-01 10:38:21