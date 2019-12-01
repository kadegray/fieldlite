# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.24)
# Database: subscribersfields
# Generation Time: 2019-11-30 10:10:22 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table field_subscriber
# ------------------------------------------------------------

DROP TABLE IF EXISTS `field_subscriber`;

CREATE TABLE `field_subscriber` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_type_id` int(10) unsigned NOT NULL,
  `subscriber_id` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `subscriber_id` (`subscriber_id`,`field_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table field_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `field_types`;

CREATE TABLE `field_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `field_types` WRITE;
/*!40000 ALTER TABLE `field_types` DISABLE KEYS */;

INSERT INTO `field_types` (`id`, `type`, `title`, `updated_at`, `created_at`)
VALUES
	(1,'string','Phone Number','2019-11-28 07:45:39','2019-11-28 07:45:32'),
	(2,'string','Country','2019-11-28 07:46:21','2019-11-28 07:46:21'),
	(3,'string','Post Code','2019-11-28 07:46:41','2019-11-28 07:46:41'),
	(4,'date','Date of Birth','2019-11-28 07:47:43','2019-11-28 07:46:57'),
	(5,'boolean','Engaged Customer','2019-11-28 07:51:01','2019-11-28 07:51:01');

/*!40000 ALTER TABLE `field_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subscribers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subscribers`;

CREATE TABLE `subscribers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `state` int(10) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_address` (`email_address`),
  KEY `state` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
