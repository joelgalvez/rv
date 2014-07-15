-- phpMyAdmin SQL Dump
-- version 3.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 04, 2014 at 09:00 PM
-- Server version: 5.1.63
-- PHP Version: 5.2.17

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `GRAsite`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `category_v`
--
CREATE TABLE `category_v` (
`id` int(11)
,`name` varchar(256)
,`childid` int(11)
,`childname` varchar(256)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `enitemuploadsview`
--
CREATE TABLE `enitemuploadsview` (
`id` int(11)
,`uploadId` int(11)
,`title` varchar(256)
,`text` text
,`friendlyUrl` varchar(1024)
,`namespaceId` int(11)
,`uploadTitle` varchar(512)
,`uploadText` text
,`owner` varchar(256)
,`category` varchar(256)
);
-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemId` int(11) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  `localizationId` int(11) DEFAULT NULL,
  `commonLn` tinyint(1) NOT NULL DEFAULT '0',
  `categoryFilter` tinyint(1) DEFAULT NULL,
  `userFilter` tinyint(1) DEFAULT NULL,
  `namespaceId` int(11) NOT NULL,
  `allowChild` tinyint(1) NOT NULL DEFAULT '0',
  `showChild` tinyint(1) NOT NULL DEFAULT '1',
  `categoryId` int(11) DEFAULT NULL,
  `year` varchar(6) CHARACTER SET utf8 DEFAULT NULL,
  `uploadNr` int(11) NOT NULL DEFAULT '0',
  `shared` tinyint(1) NOT NULL DEFAULT '0',
  `ownerId` int(11) NOT NULL,
  `editorId` int(11) NOT NULL,
  `online` datetime NOT NULL,
  `offline` datetime DEFAULT NULL,
  `title` varchar(256) CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8,
  `templateId` varchar(24) CHARACTER SET utf8 DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `friendlyUrl` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
  `titleNl` varchar(256) CHARACTER SET utf8 DEFAULT NULL,
  `textNl` text CHARACTER SET utf8,
  `friendlyUrlNl` varchar(1024) CHARACTER SET utf8 DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `yearFilter` tinyint(4) DEFAULT NULL,
  `priority` tinyint(4) NOT NULL,
  `maxYear` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `localizationId` (`localizationId`),
  KEY `namespaceId` (`namespaceId`),
  KEY `categoryId` (`categoryId`),
  KEY `ownerId` (`ownerId`),
  KEY `editorId` (`editorId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itemupload`
--

CREATE TABLE `itemupload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('upload','uploadFilter','uploadSelection','factbox','users','breakpoint') NOT NULL,
  `uploadtype` smallint(2) DEFAULT NULL,
  `fileName` varchar(128) DEFAULT NULL,
  `filePath` varchar(512) DEFAULT NULL,
  `fileType` varchar(32) DEFAULT NULL,
  `fileExtension` varchar(8) DEFAULT NULL,
  `videolink` varchar(2056) DEFAULT NULL,
  `uploadSelectedItemId` int(11) DEFAULT NULL,
  `uploadBreakpoint` tinyint(1) DEFAULT NULL,
  `uploadFilterCount` int(11) DEFAULT NULL,
  `uploadFactbox` text,
  `itemId` int(11) NOT NULL,
  `title` varchar(512) NOT NULL,
  `text` text,
  `position` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `online` datetime NOT NULL,
  `offline` datetime DEFAULT NULL,
  `localizationId` int(11) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `namespaceId` int(11) DEFAULT NULL,
  `year` char(4) CHARACTER SET latin1 NOT NULL,
  `userGroupId` int(11) NOT NULL,
  `ownerId` int(11) NOT NULL,
  `editorId` int(11) DEFAULT NULL,
  `fileNameNl` varchar(128) DEFAULT NULL,
  `filePathNl` varchar(512) DEFAULT NULL,
  `fileTypeNl` varchar(32) DEFAULT NULL,
  `fileExtensionNl` varchar(8) NOT NULL,
  `videoLinkNl` varchar(2056) DEFAULT NULL,
  `titleNl` varchar(512) DEFAULT NULL,
  `textNl` text,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `imageWidth` int(11) DEFAULT NULL,
  `imageHeight` int(11) DEFAULT NULL,
  `factboxType` enum('text','link','file','anchor','deadline') DEFAULT NULL,
  `maxUploadFetch` int(11) NOT NULL DEFAULT '1',
  `itemNamespaceId` int(11) DEFAULT NULL,
  `imageWidthNl` int(11) DEFAULT NULL,
  `imageHeightNl` int(11) DEFAULT NULL,
  `priority` tinyint(4) NOT NULL,
  `onlyOnline` tinyint(4) NOT NULL,
  `orderByOnline` tinyint(4) NOT NULL,
  `randomOrder` int(11) NOT NULL,
  `filterYear` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploadSelectedItemId` (`uploadSelectedItemId`),
  KEY `itemId` (`itemId`),
  KEY `localizationId` (`localizationId`),
  KEY `categoryId` (`categoryId`),
  KEY `ownerId` (`ownerId`),
  KEY `editorId` (`editorId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `itemuploadfilter`
--

CREATE TABLE `itemuploadfilter` (
  `itemUploadId` int(11) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `namespaceId` int(11) DEFAULT NULL,
  `itemsPerPage` int(11) NOT NULL,
  `totalItem` int(11) DEFAULT NULL COMMENT '0 -> Alll and -1 -> fillup',
  KEY `itemUploadId` (`itemUploadId`),
  KEY `categoryId` (`categoryId`),
  KEY `namespaceId` (`namespaceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `itemuploaduploads`
--

CREATE TABLE `itemuploaduploads` (
  `itemUploadId` int(11) DEFAULT NULL,
  `filename` varchar(128) NOT NULL,
  `path` varchar(512) NOT NULL,
  `type` varchar(32) DEFAULT NULL,
  `extension` varchar(8) NOT NULL,
  KEY `itemUploadId` (`itemUploadId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `itemuploaduser`
--

CREATE TABLE `itemuploaduser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemUploadId` int(11) NOT NULL,
  `userId` int(11) NOT NULL DEFAULT '0',
  `userGroupId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `itemUploadId` (`itemUploadId`),
  KEY `userGroupId` (`userGroupId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `itemuploadusersinfo`
--
CREATE TABLE `itemuploadusersinfo` (
`id` int(11)
,`userId` varchar(256)
,`name` varchar(256)
,`groupId` int(11)
,`categoryId` int(11)
,`email` varchar(512)
,`password` varchar(512)
,`year` char(4)
,`active` tinyint(1)
,`graduated` tinyint(1)
,`modified` timestamp
,`friendlyName` varchar(50)
,`uploadCount` bigint(21)
,`categoryName` varchar(256)
,`uploadId` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `itemuserinfo`
--
CREATE TABLE `itemuserinfo` (
`id` int(11)
,`itemId` int(11)
,`parentId` int(11)
,`localizationId` int(11)
,`commonLn` tinyint(1)
,`categoryFilter` tinyint(1)
,`userFilter` tinyint(1)
,`namespaceId` int(11)
,`allowChild` tinyint(1)
,`showChild` tinyint(1)
,`categoryId` int(11)
,`year` varchar(6)
,`uploadNr` int(11)
,`shared` tinyint(1)
,`ownerId` int(11)
,`editorId` int(11)
,`online` datetime
,`offline` datetime
,`title` varchar(256)
,`text` text
,`templateId` varchar(24)
,`hidden` tinyint(1)
,`friendlyUrl` varchar(1024)
,`titleNl` varchar(256)
,`textNl` text
,`friendlyUrlNl` varchar(1024)
,`modified` timestamp
,`yearFilter` tinyint(4)
,`priority` tinyint(4)
,`maxYear` int(11)
,`friendlyName` varchar(50)
);
-- --------------------------------------------------------

--
-- Table structure for table `localization`
--

CREATE TABLE `localization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `language` varchar(16) NOT NULL,
  `culture` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `namespace`
--

CREATE TABLE `namespace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `commonLn` tinyint(1) NOT NULL DEFAULT '0',
  `allowChildren` tinyint(1) NOT NULL DEFAULT '0',
  `showChildren` tinyint(1) NOT NULL DEFAULT '0',
  `yearDimension` tinyint(1) NOT NULL DEFAULT '0',
  `categoryFilter` tinyint(1) NOT NULL DEFAULT '0',
  `userFilter` tinyint(1) NOT NULL DEFAULT '0',
  `shared` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `nlitemuploadsview`
--
CREATE TABLE `nlitemuploadsview` (
`id` int(11)
,`uploadId` int(11)
,`title` varchar(256)
,`text` text
,`friendlyUrl` varchar(1024)
,`namespaceId` int(11)
,`uploadTitle` varchar(512)
,`uploadText` text
,`owner` varchar(256)
,`category` varchar(256)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `roles`
--
CREATE TABLE `roles` (
`name` varchar(256)
,`type` bigint(11)
,`description` text
,`bizrule` text
,`data` text
);
-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taskRoles`
--

CREATE TABLE `taskRoles` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `temp_grad2011`
--

CREATE TABLE `temp_grad2011` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `seconds` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` varchar(256) CHARACTER SET latin1 DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `groupId` int(11) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `email` varchar(512) CHARACTER SET latin1 NOT NULL,
  `password` varchar(512) NOT NULL,
  `year` char(4) CHARACTER SET latin1 NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `graduated` tinyint(1) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pwdResetkey` varchar(256) NOT NULL,
  `requested` int(11) NOT NULL DEFAULT '0',
  `lastRequested` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `friendlyName` varchar(50) NOT NULL,
  `categories` varchar(65) DEFAULT NULL,
  `categoryId1` int(11) DEFAULT NULL,
  `categoryId2` int(11) DEFAULT NULL,
  `categoryId3` int(11) DEFAULT NULL,
  `categoryId4` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `userId` (`userId`),
  KEY `user_fk_constraint` (`groupId`),
  KEY `category_fk_constraint` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `userinfo`
--
CREATE TABLE `userinfo` (
`id` int(11)
,`userId` varchar(256)
,`name` varchar(256)
,`groupId` int(11)
,`categoryId` int(11)
,`email` varchar(512)
,`password` varchar(512)
,`year` char(4)
,`active` tinyint(1)
,`graduated` tinyint(1)
,`modified` timestamp
,`friendlyName` varchar(50)
,`uploadCount` bigint(21)
,`categoryName` varchar(256)
,`categoryName1` varchar(256)
,`categoryName2` varchar(256)
,`categoryName3` varchar(256)
,`categoryName4` varchar(256)
,`categoryId1` int(11)
,`categoryId2` int(11)
,`categoryId3` int(11)
,`categoryId4` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `userRoles`
--
CREATE TABLE `userRoles` (
`itemname` varchar(256)
,`userid` int(11)
,`bizrule` binary(0)
,`data` binary(0)
);
-- --------------------------------------------------------

--
-- Table structure for table `webtree`
--

CREATE TABLE `webtree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `localizationId` int(11) DEFAULT NULL,
  `url` varchar(512) NOT NULL,
  `friendlyUrl` varchar(512) DEFAULT NULL,
  `depth` int(11) NOT NULL,
  `defaultPage` tinyint(1) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `localizationId` (`localizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure for view `category_v`
--
DROP TABLE IF EXISTS `category_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `category_v` AS select `p`.`id` AS `id`,`p`.`name` AS `name`,`c`.`id` AS `childid`,`c`.`name` AS `childname` from (`category` `p` left join `category` `c` on((`p`.`id` = `c`.`parentId`))) where (`p`.`parentId` = 0) order by `p`.`id`,`c`.`parentId`;

-- --------------------------------------------------------

--
-- Structure for view `enitemuploadsview`
--
DROP TABLE IF EXISTS `enitemuploadsview`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `enitemuploadsview` AS select `i`.`id` AS `id`,`u`.`id` AS `uploadId`,`i`.`title` AS `title`,`i`.`text` AS `text`,`i`.`friendlyUrl` AS `friendlyUrl`,`i`.`namespaceId` AS `namespaceId`,`u`.`title` AS `uploadTitle`,`u`.`text` AS `uploadText`,`ur`.`name` AS `owner`,`c`.`name` AS `category` from (((`item` `i` join `itemupload` `u` on((`i`.`id` = `u`.`itemId`))) left join `category` `c` on((`i`.`categoryId` = `c`.`id`))) left join `user` `ur` on((`i`.`ownerId` = `ur`.`id`))) where (`i`.`hidden` = 0);

-- --------------------------------------------------------

--
-- Structure for view `itemuploadusersinfo`
--
DROP TABLE IF EXISTS `itemuploadusersinfo`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `itemuploadusersinfo` AS select `u`.`id` AS `id`,`u`.`userId` AS `userId`,`u`.`name` AS `name`,`u`.`groupId` AS `groupId`,`u`.`categoryId` AS `categoryId`,`u`.`email` AS `email`,`u`.`password` AS `password`,`u`.`year` AS `year`,`u`.`active` AS `active`,`u`.`graduated` AS `graduated`,`u`.`modified` AS `modified`,`u`.`friendlyName` AS `friendlyName`,`u`.`uploadCount` AS `uploadCount`,`u`.`categoryName` AS `categoryName`,`iu`.`itemUploadId` AS `uploadId` from (`userinfo` `u` join `itemuploaduser` `iu` on((`u`.`id` = `iu`.`userId`)));

-- --------------------------------------------------------

--
-- Structure for view `itemuserinfo`
--
DROP TABLE IF EXISTS `itemuserinfo`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `itemuserinfo` AS select `i`.`id` AS `id`,`i`.`itemId` AS `itemId`,`i`.`parentId` AS `parentId`,`i`.`localizationId` AS `localizationId`,`i`.`commonLn` AS `commonLn`,`i`.`categoryFilter` AS `categoryFilter`,`i`.`userFilter` AS `userFilter`,`i`.`namespaceId` AS `namespaceId`,`i`.`allowChild` AS `allowChild`,`i`.`showChild` AS `showChild`,`i`.`categoryId` AS `categoryId`,`i`.`year` AS `year`,`i`.`uploadNr` AS `uploadNr`,`i`.`shared` AS `shared`,`i`.`ownerId` AS `ownerId`,`i`.`editorId` AS `editorId`,`i`.`online` AS `online`,`i`.`offline` AS `offline`,`i`.`title` AS `title`,`i`.`text` AS `text`,`i`.`templateId` AS `templateId`,`i`.`hidden` AS `hidden`,`i`.`friendlyUrl` AS `friendlyUrl`,`i`.`titleNl` AS `titleNl`,`i`.`textNl` AS `textNl`,`i`.`friendlyUrlNl` AS `friendlyUrlNl`,`i`.`modified` AS `modified`,`i`.`yearFilter` AS `yearFilter`,`i`.`priority` AS `priority`,`i`.`maxYear` AS `maxYear`,`u`.`friendlyName` AS `friendlyName` from (`item` `i` join `user` `u` on((`i`.`ownerId` = `u`.`id`))) where (`i`.`hidden` = 0);

-- --------------------------------------------------------

--
-- Structure for view `nlitemuploadsview`
--
DROP TABLE IF EXISTS `nlitemuploadsview`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `nlitemuploadsview` AS select `i`.`id` AS `id`,`u`.`id` AS `uploadId`,`i`.`titleNl` AS `title`,`i`.`textNl` AS `text`,`i`.`friendlyUrlNl` AS `friendlyUrl`,`i`.`namespaceId` AS `namespaceId`,`u`.`titleNl` AS `uploadTitle`,`u`.`textNl` AS `uploadText`,`ur`.`name` AS `owner`,`c`.`name` AS `category` from (((`item` `i` join `itemupload` `u` on((`i`.`id` = `u`.`itemId`))) left join `category` `c` on((`i`.`categoryId` = `c`.`id`))) left join `user` `ur` on((`i`.`ownerId` = `ur`.`id`))) where (`i`.`hidden` = 0);

-- --------------------------------------------------------

--
-- Structure for view `roles`
--
DROP TABLE IF EXISTS `roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `roles` AS select `usergroup`.`name` AS `name`,1 AS `type`,_utf8'' AS `description`,NULL AS `bizrule`,NULL AS `data` from `usergroup` where (`usergroup`.`deleted` = 0) union select `task`.`name` AS `name`,`task`.`type` AS `type`,`task`.`description` AS `description`,`task`.`bizrule` AS `bizrule`,`task`.`data` AS `data` from `task`;

-- --------------------------------------------------------

--
-- Structure for view `userinfo`
--
DROP TABLE IF EXISTS `userinfo`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `userinfo` AS select `u`.`id` AS `id`,`u`.`userId` AS `userId`,`u`.`name` AS `name`,`u`.`groupId` AS `groupId`,`u`.`categoryId` AS `categoryId`,`u`.`email` AS `email`,`u`.`password` AS `password`,`u`.`year` AS `year`,`u`.`active` AS `active`,`u`.`graduated` AS `graduated`,`u`.`modified` AS `modified`,`u`.`friendlyName` AS `friendlyName`,count(`i`.`ownerId`) AS `uploadCount`,`c`.`name` AS `categoryName`,`c1`.`name` AS `categoryName1`,`c2`.`name` AS `categoryName2`,`c3`.`name` AS `categoryName3`,`c4`.`name` AS `categoryName4`,`u`.`categoryId1` AS `categoryId1`,`u`.`categoryId2` AS `categoryId2`,`u`.`categoryId3` AS `categoryId3`,`u`.`categoryId4` AS `categoryId4` from ((((((`user` `u` left join `itemupload` `i` on((`u`.`id` = `i`.`ownerId`))) left join `category` `c` on((`u`.`categoryId` = `c`.`id`))) left join `category` `c1` on((`u`.`categoryId1` = `c1`.`id`))) left join `category` `c2` on((`u`.`categoryId2` = `c2`.`id`))) left join `category` `c3` on((`u`.`categoryId3` = `c3`.`id`))) left join `category` `c4` on((`u`.`categoryId4` = `c4`.`id`))) group by `u`.`id`;

-- --------------------------------------------------------

--
-- Structure for view `userRoles`
--
DROP TABLE IF EXISTS `userRoles`;

CREATE ALGORITHM=UNDEFINED DEFINER=CURRENT_USER SQL SECURITY DEFINER VIEW `userRoles` AS select `g`.`name` AS `itemname`,`u`.`id` AS `userid`,NULL AS `bizrule`,NULL AS `data` from (`user` `u` join `usergroup` `g` on((`u`.`groupId` = `g`.`id`))) where (`g`.`deleted` = 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `Item_ibfk_1` FOREIGN KEY (`localizationId`) REFERENCES `localization` (`id`),
  ADD CONSTRAINT `Item_ibfk_2` FOREIGN KEY (`namespaceId`) REFERENCES `namespace` (`id`),
  ADD CONSTRAINT `Item_ibfk_3` FOREIGN KEY (`ownerId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `Item_ibfk_4` FOREIGN KEY (`editorId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `Item_ibfk_5` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`);

--
-- Constraints for table `itemupload`
--
ALTER TABLE `itemupload`
  ADD CONSTRAINT `ItemUpload_ibfk_1` FOREIGN KEY (`uploadSelectedItemId`) REFERENCES `item` (`id`),
  ADD CONSTRAINT `ItemUpload_ibfk_2` FOREIGN KEY (`localizationId`) REFERENCES `localization` (`id`),
  ADD CONSTRAINT `ItemUpload_ibfk_4` FOREIGN KEY (`ownerId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `ItemUpload_ibfk_5` FOREIGN KEY (`editorId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `item_fk_constraint` FOREIGN KEY (`itemId`) REFERENCES `item` (`id`);

--
-- Constraints for table `itemuploadfilter`
--
ALTER TABLE `itemuploadfilter`
  ADD CONSTRAINT `ItemUploadFilter_ibfk_1` FOREIGN KEY (`itemUploadId`) REFERENCES `itemupload` (`id`),
  ADD CONSTRAINT `ItemUploadFilter_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `ItemUploadFilter_ibfk_3` FOREIGN KEY (`namespaceId`) REFERENCES `namespace` (`id`);

--
-- Constraints for table `itemuploaduploads`
--
ALTER TABLE `itemuploaduploads`
  ADD CONSTRAINT `ItemUploadUploads_ibfk_1` FOREIGN KEY (`itemUploadId`) REFERENCES `itemupload` (`id`);

--
-- Constraints for table `itemuploaduser`
--
ALTER TABLE `itemuploaduser`
  ADD CONSTRAINT `ItemUploadUser_ibfk_1` FOREIGN KEY (`itemUploadId`) REFERENCES `itemupload` (`id`),
  ADD CONSTRAINT `ItemUploadUser_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `ItemUploadUser_ibfk_3` FOREIGN KEY (`userGroupId`) REFERENCES `usergroup` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_fk_constraint` FOREIGN KEY (`groupId`) REFERENCES `usergroup` (`id`);

SET FOREIGN_KEY_CHECKS=1;
