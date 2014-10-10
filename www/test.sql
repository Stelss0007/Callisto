# SQL Manager 2010 for MySQL 4.5.0.9
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : test

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `test`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `test`;

#
# Structure for the `object` table : 
#

CREATE TABLE `object` (
  `guid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) unsigned DEFAULT NULL,
  `owner_id` int(11) unsigned NOT NULL DEFAULT '0',
  `time_create` int(11) unsigned DEFAULT NULL,
  `time_update` int(11) unsigned DEFAULT NULL,
  `active` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`guid`),
  UNIQUE KEY `guid` (`guid`),
  KEY `type` (`type`),
  KEY `time_create` (`time_create`),
  KEY `time_update` (`time_update`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=cp1251;

#
# Structure for the `object_field` table : 
#

CREATE TABLE `object_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `field` (`field`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

#
# Structure for the `object_type` table : 
#

CREATE TABLE `object_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=cp1251;

#
# Structure for the `object_value` table : 
#

CREATE TABLE `object_value` (
  `guid` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `value` text,
  KEY `guid` (`guid`),
  KEY `field_id` (`field_id`),
  KEY `value` (`value`(40)),
  KEY `field_guid` (`guid`,`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_group` table : 
#

CREATE TABLE `sys_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_displayname` varchar(60) NOT NULL DEFAULT '',
  `group_description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_user` table : 
#

CREATE TABLE `sys_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) unsigned NOT NULL,
  `login` varchar(20) DEFAULT NULL,
  `pass` varchar(40) DEFAULT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '0',
  `addtime` int(11) unsigned DEFAULT NULL,
  `last_visit` int(11) unsigned DEFAULT NULL,
  `mail` varchar(40) DEFAULT NULL,
  `displayname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `pass` (`pass`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=cp1251;

#
# Structure for the `sys_user_group_permission` table : 
#

CREATE TABLE `sys_user_group_permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `weight` int(11) unsigned DEFAULT NULL,
  `level` smallint(6) unsigned DEFAULT NULL,
  `pattern` varchar(250) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251;

#
# Structure for the `test` table : 
#

CREATE TABLE `test` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251;

#
# Data for the `object` table  (LIMIT 0,500)
#

INSERT INTO `object` (`guid`, `type`, `owner_id`, `time_create`, `time_update`, `active`) VALUES 
  (2,1,0,1348407441,1348407441,'1'),
  (3,1,0,1348475152,1348475152,'1'),
  (4,1,0,1348483819,1348483819,'1'),
  (7,1,0,1348484275,1348665028,'1'),
  (8,1,0,1349349404,1349349404,'1');
COMMIT;

#
# Data for the `object_field` table  (LIMIT 0,500)
#

INSERT INTO `object_field` (`id`, `field`) VALUES 
  (1,'arg1'),
  (2,'arg2');
COMMIT;

#
# Data for the `object_type` table  (LIMIT 0,500)
#

INSERT INTO `object_type` (`id`, `type`) VALUES 
  (1,'test');
COMMIT;

#
# Data for the `object_value` table  (LIMIT 0,500)
#

INSERT INTO `object_value` (`guid`, `field_id`, `value`) VALUES 
  (2,1,'1'),
  (2,2,'3'),
  (3,1,'1'),
  (3,2,'2'),
  (4,1,'1'),
  (4,2,'1'),
  (8,2,'2'),
  (8,1,'1'),
  (7,1,'44'),
  (7,2,'55'),
  (2,1,'3');
COMMIT;

#
# Data for the `sys_group` table  (LIMIT 0,500)
#

INSERT INTO `sys_group` (`id`, `group_displayname`, `group_description`) VALUES 
  (1,'??????????????','?????????????? ?????'),
  (2,'????????????','???????????? ?????'),
  (3,'??????????','?????????? ?????'),
  (9,'?????????','????????? ?????'),
  (10,'??????? 1?','??????? 1?');
COMMIT;

#
# Data for the `sys_user` table  (LIMIT 0,500)
#

INSERT INTO `sys_user` (`id`, `gid`, `login`, `pass`, `active`, `addtime`, `last_visit`, `mail`, `displayname`) VALUES 
  (3,1,'www','698d51a19d8a121ce581499d7b701668','0',1320340312,NULL,'stelss007@rambler.ru',NULL),
  (4,2,'aaa','698d51a19d8a121ce581499d7b701668','0',1322259668,NULL,'stelss@rambler.ru',NULL),
  (8,2,'2222','934b535800b1cba8f96a5d72f72f1611','1',1322345001,NULL,'sss@dddd.ru',NULL),
  (9,2,'000','c6f057b86584942e415435ffb1fa93d4','1',1322398476,NULL,'222@fff.ru',NULL);
COMMIT;

#
# Data for the `sys_user_group_permission` table  (LIMIT 0,500)
#

INSERT INTO `sys_user_group_permission` (`id`, `gid`, `weight`, `level`, `pattern`, `description`) VALUES 
  (1,1,1,20,'.*',NULL),
  (3,1,NULL,50,'.*1111','22222'),
  (4,-1,1,70,'test::user::view_list1::*.','234');
COMMIT;

#
# Data for the `test` table  (LIMIT 0,500)
#

INSERT INTO `test` (`id`, `name`, `description`) VALUES 
  (1,'11111','wwwwww'),
  (2,'2222','dddddddd');
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;