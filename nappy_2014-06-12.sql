# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.34)
# Database: nappy
# Generation Time: 2014-06-12 13:03:20 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table nap_babysittings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nap_babysittings`;

CREATE TABLE `nap_babysittings` (
  `id_babysittings` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `babysitterId` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `datebs` date DEFAULT NULL,
  `adressbs` varchar(255) DEFAULT NULL,
  `children` varchar(100) DEFAULT NULL,
  `childrenId` varchar(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `debut` varchar(4) DEFAULT NULL,
  `fin` varchar(4) DEFAULT NULL,
  `message` varchar(400) DEFAULT NULL,
  `date_demande` varchar(10) DEFAULT NULL,
  `reponse_babysitter` varchar(400) DEFAULT NULL,
  `date_reponse` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_babysittings`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nap_children
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nap_children`;

CREATE TABLE `nap_children` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `firstname` varchar(11) CHARACTER SET latin1 DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `description` varchar(700) CHARACTER SET latin1 DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nap_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nap_comments`;

CREATE TABLE `nap_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `babysitterId` int(11) DEFAULT NULL,
  `babysittingId` int(11) DEFAULT NULL,
  `comment` varchar(400) CHARACTER SET latin1 DEFAULT NULL,
  `note` int(1) DEFAULT '0',
  `favoris` int(1) DEFAULT '0',
  `date_comment` date DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nap_demandes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nap_demandes`;

CREATE TABLE `nap_demandes` (
  `id_demandes` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT NULL,
  `babysitterId` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `datebs` date DEFAULT NULL,
  `adressbs` varchar(255) DEFAULT NULL,
  `children` varchar(100) DEFAULT NULL,
  `childrenId` varchar(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `debut` varchar(4) DEFAULT NULL,
  `fin` varchar(4) DEFAULT NULL,
  `message` varchar(400) DEFAULT NULL,
  `date_demande` varchar(10) DEFAULT NULL,
  `reponse_babysitter` varchar(400) DEFAULT NULL,
  `date_reponse` varchar(10) DEFAULT NULL,
  `notif_type` int(1) DEFAULT '1',
  `notif_state` int(1) DEFAULT '1',
  PRIMARY KEY (`id_demandes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nap_disponibilites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nap_disponibilites`;

CREATE TABLE `nap_disponibilites` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `babysitterId` int(11) DEFAULT NULL,
  `datedispo` date DEFAULT NULL,
  `heure_debut` varchar(11) DEFAULT NULL,
  `heure_fin` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nap_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nap_users`;

CREATE TABLE `nap_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `name` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(256) CHARACTER SET latin1 DEFAULT NULL,
  `account_type` decimal(1,0) DEFAULT NULL,
  `user_type` decimal(1,0) DEFAULT NULL,
  `birth` date DEFAULT '0000-00-00',
  `last_connected` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET latin1 DEFAULT 'default.jpg',
  `adress` varchar(255) CHARACTER SET latin1 DEFAULT 'Non-indiquÃ©',
  `phone` varchar(20) CHARACTER SET latin1 DEFAULT 'Ã€ complÃ©ter',
  `enfants` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `parent1` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `phoneparent1` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `parent2` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `phoneparent2` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `urgence1` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `urgencephone1` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `urgence2` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `urgencephone2` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `docteurname` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `docteurphone` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `docteuradress` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `important` varchar(600) CHARACTER SET latin1 DEFAULT NULL,
  `favorite_bs` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `qui` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
  `experience` varchar(500) CHARACTER SET latin1 DEFAULT NULL,
  `prix_euro` int(2) DEFAULT '0',
  `prix_cent` int(2) DEFAULT '0',
  `age_debut` varchar(2) DEFAULT '1',
  `age_fin` varchar(2) DEFAULT '12',
  `new_born` tinyint(1) DEFAULT '1',
  `avis_bs` varchar(400) DEFAULT NULL,
  `nb_fav` varchar(200) DEFAULT '0',
  `nb_com` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
