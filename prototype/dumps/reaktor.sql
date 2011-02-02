-- MySQL dump 10.11
--
-- Host: localhost    Database: reaktor
-- ------------------------------------------------------
-- Server version	5.0.51a-6ubuntu3

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
-- Table structure for table `admin_message`
--

DROP TABLE IF EXISTS `admin_message`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `admin_message` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) default NULL,
  `message` text NOT NULL,
  `author` int(11) NOT NULL,
  `updated_at` datetime default NULL,
  `expires_at` datetime NOT NULL,
  `is_deleted` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `admin_message_FI_1` (`author`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `admin_message`
--

LOCK TABLES `admin_message` WRITE;
/*!40000 ALTER TABLE `admin_message` DISABLE KEYS */;
INSERT INTO `admin_message` VALUES (1,NULL,'System has been updated!',1,'2008-08-07 10:55:02','2008-08-07 10:57:02',0);
/*!40000 ALTER TABLE `admin_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `article` (
  `id` int(11) NOT NULL auto_increment,
  `created_at` datetime default NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `permalink` varchar(255) NOT NULL,
  `ingress` text,
  `content` text NOT NULL,
  `updated_at` datetime default NULL,
  `updated_by` int(11) NOT NULL default '0',
  `article_type` int(11) NOT NULL,
  `article_order` int(11) NOT NULL,
  `expires_at` datetime default NULL,
  `deleted` int(11) NOT NULL default '0',
  `published` int(11) NOT NULL default '0',
  `published_at` datetime default NULL,
  `banner_file_id` int(11) default '0',
  `is_sticky` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `article_FI_1` (`author_id`),
  KEY `article_FI_2` (`banner_file_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (1,'2008-08-07 10:55:02',4,'Lorem Ipsum','Lorem_Ipsum','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Suspendisse consequat sagittis dui. Aenean tincidunt pulvinar neque. In fermentum, purus eu iaculis ultricies, augue urna accumsan arcu, vel pulvinar turpis massa non neque. Nunc congue dapibus libero. Vivamus ut quam. In pede. Proin ac leo. Phasellus fermentum lacus quis eros. Sed dignissim elit volutpat massa interdum rutrum. Cras non felis vel dolor vestibulum lacinia.','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Suspendisse consequat sagittis dui. Aenean tincidunt pulvinar neque. In fermentum, purus eu iaculis ultricies, augue urna accumsan arcu, vel pulvinar turpis massa non neque. Nunc congue dapibus libero. Vivamus ut quam. In pede. Proin ac leo. Phasellus fermentum lacus quis eros. Sed dignissim elit volutpat massa interdum rutrum. Cras non felis vel dolor vestibulum lacinia.\n\nNullam porttitor purus in nunc. Sed quis pede vel orci faucibus aliquet. Duis adipiscing. Cras at leo. Morbi tortor nunc, adipiscing at, facilisis quis, lobortis imperdiet, ligula. Donec faucibus consequat mauris. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam erat volutpat. Phasellus ipsum. Duis et turpis ac augue dictum accumsan. Curabitur dictum risus non justo. Sed consequat, ligula vel varius euismod, arcu justo accumsan massa, ut porta elit massa sed tellus. Praesent eleifend euismod sapien. Proin pede mi, condimentum vitae, rhoncus ut, facilisis eu, justo. In tellus odio, aliquet quis, adipiscing a, tristique mollis, justo. Pellentesque ac leo nec est iaculis pellentesque.\n\nNam id nunc. Donec magna ante, elementum sed, venenatis at, ornare in, ipsum. Aliquam erat volutpat. Aliquam ac lectus. Phasellus consequat odio et sapien. Vivamus eu ligula ac libero varius congue. Pellentesque tincidunt, justo vitae ultricies tincidunt, mauris justo aliquam pede, ac tristique nibh leo in dui. Nunc ut lacus. Nulla eu lectus. Nullam pretium, diam sit amet euismod viverra, leo lectus imperdiet odio, at elementum ipsum nulla eget est. In hac habitasse platea dictumst. Praesent ut mi. Fusce ultricies, erat vel blandit porta, justo nisi tempus metus, sed bibendum velit mi et lorem. Suspendisse id arcu sit amet elit semper pellentesque. Maecenas risus lacus, iaculis non, consequat id, iaculis id, tortor. Aenean ipsum leo, aliquet vitae, adipiscing a, eleifend sit amet, augue. Donec congue sagittis risus. Pellentesque eu turpis. Integer fringilla dictum metus.','2008-08-07 10:55:02',0,1,0,NULL,0,1,NULL,0,0),(2,'2008-08-07 10:55:02',4,'What is Lorem Ipsum?','What_is_Lorem_Ipsum_','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.','What is Lorem Ipsum?\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\n\nWhy do we use it?\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\n\nWhere does it come from?\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.','2008-08-07 10:55:02',0,1,0,NULL,0,1,NULL,0,0),(3,'2008-08-07 10:55:02',4,'What is up in the tech world?','What_is_up_in_the_tech_world_','This is an example of how to include RSS feeds in your articles','Here are the latest stories from OSNews.com:\n[feed=http://osnews.com/files/recent.xml]4[/feed]\n\n<b>Where does it come from?</b>\nThis is automatically fetched from the URL provided in this article. Sweet!','2008-08-07 10:55:02',0,6,0,NULL,0,1,NULL,0,0);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_article_relation`
--

DROP TABLE IF EXISTS `article_article_relation`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `article_article_relation` (
  `id` int(11) NOT NULL auto_increment,
  `created_at` datetime default NULL,
  `first_article` int(11) NOT NULL,
  `second_article` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `article_article_relation_FI_1` (`first_article`),
  KEY `article_article_relation_FI_2` (`second_article`),
  KEY `article_article_relation_FI_3` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `article_article_relation`
--

LOCK TABLES `article_article_relation` WRITE;
/*!40000 ALTER TABLE `article_article_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_article_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_artwork_relation`
--

DROP TABLE IF EXISTS `article_artwork_relation`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `article_artwork_relation` (
  `id` int(11) NOT NULL auto_increment,
  `created_at` datetime default NULL,
  `article_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `article_artwork_relation_FI_1` (`article_id`),
  KEY `article_artwork_relation_FI_2` (`artwork_id`),
  KEY `article_artwork_relation_FI_3` (`created_by`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `article_artwork_relation`
--

LOCK TABLES `article_artwork_relation` WRITE;
/*!40000 ALTER TABLE `article_artwork_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_artwork_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_attachment`
--

DROP TABLE IF EXISTS `article_attachment`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `article_attachment` (
  `article_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `article_attachment_FI_1` (`article_id`),
  KEY `article_attachment_FI_2` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `article_attachment`
--

LOCK TABLES `article_attachment` WRITE;
/*!40000 ALTER TABLE `article_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_category`
--

DROP TABLE IF EXISTS `article_category`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `article_category` (
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `article_category_FI_1` (`article_id`),
  KEY `article_category_FI_2` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `article_category`
--

LOCK TABLES `article_category` WRITE;
/*!40000 ALTER TABLE `article_category` DISABLE KEYS */;
INSERT INTO `article_category` VALUES (1,1,1),(2,55,2);
/*!40000 ALTER TABLE `article_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_file`
--

DROP TABLE IF EXISTS `article_file`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `article_file` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `uploaded_at` datetime NOT NULL,
  `description` varchar(255) default NULL,
  `file_mimetype_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `article_file_FI_1` (`uploaded_by`),
  KEY `article_file_FI_2` (`file_mimetype_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `article_file`
--

LOCK TABLES `article_file` WRITE;
/*!40000 ALTER TABLE `article_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_subreaktor`
--

DROP TABLE IF EXISTS `article_subreaktor`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `article_subreaktor` (
  `article_id` int(11) NOT NULL,
  `subreaktor_id` int(11) NOT NULL,
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`),
  KEY `article_subreaktor_FI_1` (`article_id`),
  KEY `article_subreaktor_FI_2` (`subreaktor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `article_subreaktor`
--

LOCK TABLES `article_subreaktor` WRITE;
/*!40000 ALTER TABLE `article_subreaktor` DISABLE KEYS */;
INSERT INTO `article_subreaktor` VALUES (1,1,1),(2,6,2);
/*!40000 ALTER TABLE `article_subreaktor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artwork_status`
--

DROP TABLE IF EXISTS `artwork_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `artwork_status` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `artwork_status`
--

LOCK TABLES `artwork_status` WRITE;
/*!40000 ALTER TABLE `artwork_status` DISABLE KEYS */;
INSERT INTO `artwork_status` VALUES (1,'Draft'),(2,'Ready for approval'),(3,'Approved'),(4,'Rejected'),(5,'Removed'),(6,'Approved hidden');
/*!40000 ALTER TABLE `artwork_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artwork_status_i18n`
--

DROP TABLE IF EXISTS `artwork_status_i18n`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `artwork_status_i18n` (
  `id` int(11) NOT NULL,
  `description` varchar(30) NOT NULL,
  `culture` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`,`culture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `artwork_status_i18n`
--

LOCK TABLES `artwork_status_i18n` WRITE;
/*!40000 ALTER TABLE `artwork_status_i18n` DISABLE KEYS */;
INSERT INTO `artwork_status_i18n` VALUES (1,'Draft','no'),(1,'Draft','en'),(1,'Draft','nn'),(2,'Ready for approval','no'),(2,'Ready for approval','en'),(2,'Ready for approval','nn'),(3,'Approved','no'),(3,'Approved','en'),(3,'Approved','nn'),(4,'Rejected','no'),(4,'Rejected','en'),(4,'Rejected','nn'),(5,'Removed','no'),(5,'Removed','en'),(5,'Removed','nn'),(6,'Approved hidden','no'),(6,'Approved hidden','en'),(6,'Approved hidden','nn');
/*!40000 ALTER TABLE `artwork_status_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogue`
--

DROP TABLE IF EXISTS `catalogue`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `catalogue` (
  `cat_id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `source_lang` varchar(100) NOT NULL default '',
  `target_lang` varchar(100) NOT NULL default '',
  `date_created` int(11) NOT NULL default '0',
  `date_modified` int(11) NOT NULL default '0',
  `author` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `catalogue`
--

LOCK TABLES `catalogue` WRITE;
/*!40000 ALTER TABLE `catalogue` DISABLE KEYS */;
INSERT INTO `catalogue` VALUES (1,'messages.no','en','no',0,1197401129,'username','Bokmål'),(2,'messages.nn','en','nn',0,1197401130,'username','Nynorsk'),(3,'messages.en','en','en',0,1197401102,'username','English');
/*!40000 ALTER TABLE `catalogue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `category` (
  `id` int(11) NOT NULL auto_increment,
  `basename` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'arkitektur'),(2,'barn'),(3,'dyr'),(4,'kjøretøy'),(5,'landskap'),(6,'makro'),(7,'manipulasjon'),(8,'mennesker'),(9,'nattbilder'),(10,'natur'),(11,'portrett'),(12,'reise'),(13,'sport'),(14,'stilleben'),(15,'undervannsfoto'),(16,'datagrafikk'),(17,'3d'),(18,'maleri'),(19,'skisser'),(20,'tegning'),(21,'animasjonsfilm'),(22,'dataanimasjon'),(23,'dokumentar'),(24,'kortfilm'),(25,'musikkvideo'),(26,'blues'),(27,'elektronika'),(28,'folkemusikk'),(29,'hip hop'),(30,'jazz'),(31,'klassisk musikk'),(32,'pop'),(33,'rock'),(34,'hørespill'),(35,'intervjuer'),(36,'lydeffekter'),(37,'opplesninger'),(38,'rockabilly'),(39,'techno'),(40,'viser'),(41,'world music'),(42,'biografisk'),(43,'drama'),(44,'fantasy'),(45,'funny animals'),(46,'historisk'),(47,'humor'),(48,'manga'),(49,'samfunnssatire'),(50,'science fiction'),(51,'skrekk'),(52,'spenning'),(53,'superhelter'),(54,'western'),(55,'essays'),(56,'eventyr'),(57,'fabler'),(58,'filmmanus'),(59,'foredrag'),(60,'fortellinger'),(61,'haikudikt'),(62,'krim'),(63,'noveller'),(64,'prosadikt'),(65,'rollespill'),(66,'science rollespill'),(67,'animals'),(68,'mitsetegning'),(69,'metaserie'),(70,'arrangementer');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_artwork`
--

DROP TABLE IF EXISTS `category_artwork`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `category_artwork` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `artwork_id` int(11) default NULL,
  `added_by` int(11) default NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `category_artwork_FI_1` (`category_id`),
  KEY `category_artwork_FI_2` (`artwork_id`),
  KEY `category_artwork_FI_3` (`added_by`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `category_artwork`
--

LOCK TABLES `category_artwork` WRITE;
/*!40000 ALTER TABLE `category_artwork` DISABLE KEYS */;
INSERT INTO `category_artwork` VALUES (1,12,1,2,'2008-05-15 18:01:09'),(2,8,1,2,'2008-05-15 18:01:11'),(3,4,2,2,'2008-05-15 18:01:27'),(4,8,2,2,'2008-05-15 18:01:29'),(5,12,2,2,'2008-05-15 18:01:34'),(6,55,3,2,'2008-05-15 18:01:52'),(7,63,3,2,'2008-05-15 18:01:55'),(8,24,4,2,'2008-05-15 18:02:03'),(9,23,4,2,'2008-05-15 18:02:05'),(10,40,5,2,'2008-05-15 18:02:14'),(11,36,5,2,'2008-05-15 18:02:16'),(12,55,6,2,'2008-05-15 18:02:23'),(13,60,6,2,'2008-05-15 18:02:24'),(14,64,6,2,'2008-05-15 18:02:28'),(15,3,7,2,'2008-05-15 18:02:34'),(16,10,7,2,'2008-05-15 18:02:37'),(17,3,8,2,'2008-05-15 18:02:48'),(18,10,8,2,'2008-05-15 18:02:49'),(19,53,9,2,'2008-05-15 18:03:04'),(20,47,9,2,'2008-05-15 18:02:58'),(21,43,9,2,'2008-05-15 18:03:07'),(22,19,10,2,'2008-05-15 18:03:29'),(23,21,11,2,'2008-05-15 18:03:29'),(24,22,11,2,'2008-05-15 18:03:29');
/*!40000 ALTER TABLE `category_artwork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_i18n`
--

DROP TABLE IF EXISTS `category_i18n`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `category_i18n` (
  `name` varchar(25) NOT NULL,
  `id` int(11) NOT NULL,
  `culture` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`,`culture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `category_i18n`
--

LOCK TABLES `category_i18n` WRITE;
/*!40000 ALTER TABLE `category_i18n` DISABLE KEYS */;
INSERT INTO `category_i18n` VALUES ('arkitektur',1,'no'),('barn',2,'no'),('dyr',3,'no'),('kjøretøy',4,'no'),('landskap',5,'no'),('makro',6,'no'),('manipulasjon',7,'no'),('mennesker',8,'no'),('nattbilder',9,'no'),('natur',10,'no'),('portrett',11,'no'),('reise',12,'no'),('sport',13,'no'),('stilleben',14,'no'),('undervannsfoto',15,'no'),('datagrafikk',16,'no'),('3d',17,'no'),('maleri',18,'no'),('skisser',19,'no'),('tegning',20,'no'),('animasjonsfilm',21,'no'),('dataanimasjon',22,'no'),('dokumentar',23,'no'),('kortfilm',24,'no'),('musikkvideo',25,'no'),('blues',26,'no'),('elektronika',27,'no'),('folkemusikk',28,'no'),('hip hop',29,'no'),('jazz',30,'no'),('klassisk musikk',31,'no'),('pop',32,'no'),('rock',33,'no'),('hørespill',34,'no'),('intervjuer',35,'no'),('lydeffekter',36,'no'),('opplesninger',37,'no'),('rockabilly',38,'no'),('techno',39,'no'),('viser',40,'no'),('world music',41,'no'),('biografisk',42,'no'),('drama',43,'no'),('fantasy',44,'no'),('funny animals',45,'no'),('historisk',46,'no'),('humor',47,'no'),('manga',48,'no'),('samfunnssatire',49,'no'),('science fiction',50,'no'),('skrekk',51,'no'),('spenning',52,'no'),('superhelter',53,'no'),('western',54,'no'),('essays',55,'no'),('eventyr',56,'no'),('fabler',57,'no'),('filmmanus',58,'no'),('foredrag',59,'no'),('fortellinger',60,'no'),('haikudikt',61,'no'),('krim',62,'no'),('noveller',63,'no'),('prosadikt',64,'no'),('rollespill',65,'no'),('science rollespill',66,'no'),('animals',67,'no'),('mitsetegning',68,'no'),('metaserie',69,'no'),('arrangementer',70,'no'),('architecture',1,'en'),('children',2,'en'),('animals',3,'en'),('vehicles',4,'en'),('landscape',5,'en'),('macro',6,'en'),('manipulation',7,'en'),('people',8,'en'),('night pictures',9,'en'),('nature',10,'en'),('portrait',11,'en'),('travel',12,'en'),('sport',13,'en'),('still life',14,'en'),('underwater photo',15,'en'),('computer graphics',16,'en'),('3d',17,'en'),('painting',18,'en'),('sketch',19,'en'),('drawing',20,'en'),('animation',21,'en'),('computer animation',22,'en'),('documentary',23,'en'),('short film',24,'en'),('music video',25,'en'),('blues',26,'en'),('electronica',27,'en'),('folk music',28,'en'),('hip hop',29,'en'),('jazz',30,'en'),('classical music',31,'en'),('pop',32,'en'),('rock',33,'en'),('radio entertainment',34,'en'),('interview',35,'en'),('sound effects',36,'en'),('recitals',37,'en'),('rockabilly',38,'en'),('techno',39,'en'),('demonstration',40,'en'),('world music',41,'en'),('biography',42,'en'),('drama',43,'en'),('fantasy',44,'en'),('funny animals',45,'en'),('historical',46,'en'),('humor',47,'en'),('manga',48,'en'),('satire',49,'en'),('science fiction',50,'en'),('horror',51,'en'),('suspense',52,'en'),('super heroes',53,'en'),('western',54,'en'),('essays',55,'en'),('events',56,'en'),('fables',57,'en'),('film scripts',58,'en'),('speech',59,'en'),('story telling',60,'en'),('haiku poems',61,'en'),('crime',62,'en'),('novels',63,'en'),('prose poems',64,'en'),('roleplay',65,'en'),('science roleplay',66,'en'),('animals',67,'en'),('funny drawing',68,'en'),('meta series',69,'en'),('arrangements',70,'en'),('arkitektur',1,'nn'),('barn',2,'nn'),('dyr',3,'nn'),('kjøretøy',4,'nn'),('landskap',5,'nn'),('makro',6,'nn'),('manipulasjon',7,'nn'),('mennesker',8,'nn'),('nattbilder',9,'nn'),('natur',10,'nn'),('portrett',11,'nn'),('reise',12,'nn'),('sport',13,'nn'),('stilleban',14,'nn'),('undervannsfoto',15,'nn'),('datagrafikk',16,'nn'),('3d',17,'nn'),('maleri',18,'nn'),('skisser',19,'nn'),('tegning',20,'nn'),('animasjonsfilm',21,'nn'),('dataanimasjon',22,'nn'),('dokumentar',23,'nn'),('kortfilm',24,'nn'),('musikkvideo',25,'nn'),('blues',26,'nn'),('elektronika',27,'nn'),('folkemusikk',28,'nn'),('hip hop',29,'nn'),('jazz',30,'nn'),('klassisk musikk',31,'nn'),('pop',32,'nn'),('rock',33,'nn'),('hørespill',34,'nn'),('intervjuer',35,'nn'),('lydeffekter',36,'nn'),('opplesninger',37,'nn'),('rockabilly',38,'nn'),('techno',39,'nn'),('viser',40,'nn'),('world music',41,'nn'),('biografisk',42,'nn'),('drama',43,'nn'),('fantasy',44,'nn'),('funny animals',45,'nn'),('historisk',46,'nn'),('humor',47,'nn'),('manga',48,'nn'),('samfunnssatire',49,'nn'),('science fiction',50,'nn'),('skrekk',51,'nn'),('spenning',52,'nn'),('superhelter',53,'nn'),('western',54,'nn'),('essays',55,'nn'),('eventyr',56,'nn'),('fabler',57,'nn'),('filmmanus',58,'nn'),('foredrag',59,'nn'),('fortellinger',60,'nn'),('haikudikt',61,'nn'),('krim',62,'nn'),('noveller',63,'nn'),('prosadikt',64,'nn'),('rollespill',65,'nn'),('science rollespill',66,'nn'),('animals',67,'nn'),('mitsetegning',68,'nn'),('metaserie',69,'nn'),('arrangementer',70,'nn');
/*!40000 ALTER TABLE `category_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_subreaktor`
--

DROP TABLE IF EXISTS `category_subreaktor`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `category_subreaktor` (
  `id` int(11) NOT NULL auto_increment,
  `category_id` int(11) default NULL,
  `subreaktor_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `category_subreaktor_FI_1` (`category_id`),
  KEY `category_subreaktor_FI_2` (`subreaktor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `category_subreaktor`
--

LOCK TABLES `category_subreaktor` WRITE;
/*!40000 ALTER TABLE `category_subreaktor` DISABLE KEYS */;
INSERT INTO `category_subreaktor` VALUES (1,1,1),(2,2,1),(3,3,1),(4,4,1),(5,5,1),(6,6,1),(7,7,1),(8,8,1),(9,9,1),(10,10,1),(11,11,1),(12,12,1),(13,13,1),(14,14,1),(15,15,1),(16,16,2),(17,17,2),(18,18,2),(19,19,2),(20,20,2),(21,21,3),(22,22,3),(23,23,3),(24,24,3),(25,25,3),(26,26,4),(27,27,4),(28,28,4),(29,29,4),(30,30,4),(31,31,4),(32,32,4),(33,33,4),(34,34,4),(35,35,4),(36,36,4),(37,37,4),(38,38,4),(39,39,4),(40,40,4),(41,41,4),(42,25,4),(43,42,5),(44,43,5),(45,44,5),(46,45,5),(47,46,5),(48,47,5),(49,48,5),(50,49,5),(51,50,5),(52,51,5),(53,52,5),(54,53,5),(55,54,5),(56,55,6),(57,56,6),(58,57,6),(59,44,6),(60,58,6),(61,59,6),(62,60,6),(63,61,6),(64,47,6),(65,34,6),(66,62,6),(67,63,6),(68,64,6),(69,65,6),(70,66,6),(71,68,5),(72,69,5);
/*!40000 ALTER TABLE `category_subreaktor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favourite`
--

DROP TABLE IF EXISTS `favourite`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `favourite` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `fav_type` varchar(8) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `favourite_FI_1` (`user_id`),
  KEY `favourite_FI_2` (`artwork_id`),
  KEY `favourite_FI_3` (`article_id`),
  KEY `favourite_FI_4` (`friend_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `favourite`
--

LOCK TABLES `favourite` WRITE;
/*!40000 ALTER TABLE `favourite` DISABLE KEYS */;
INSERT INTO `favourite` VALUES (1,2,2,0,0,'artwork'),(2,4,2,0,0,'artwork'),(3,3,4,0,0,'artwork'),(4,4,1,0,0,'artwork'),(5,5,6,0,0,'artwork'),(6,6,2,0,0,'artwork'),(7,1,2,0,0,'artwork'),(8,2,0,0,1,'user'),(9,2,0,0,4,'user'),(10,2,0,0,5,'user'),(11,2,0,0,6,'user'),(12,6,0,0,2,'user');
/*!40000 ALTER TABLE `favourite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_metadata`
--

DROP TABLE IF EXISTS `file_metadata`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `file_metadata` (
  `id` int(11) NOT NULL auto_increment,
  `file` int(11) NOT NULL,
  `meta_element` varchar(100) NOT NULL,
  `meta_qualifier` varchar(100) NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `file_metadata_FI_1` (`file`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `file_metadata`
--

LOCK TABLES `file_metadata` WRITE;
/*!40000 ALTER TABLE `file_metadata` DISABLE KEYS */;
INSERT INTO `file_metadata` VALUES (1,1,'creator','','Spartacus'),(2,2,'creator','','Uncle Sam'),(3,6,'creator','','Bob'),(4,6,'description','abstract','Something Kjellm uploaded'),(5,6,'description','creation','Kinda out there...'),(6,6,'relation','references','http://www.google.co.uk\nhttp://eatmymonkeydust.com'),(7,6,'subject','','text, latin, filler, snow, ski, marianne, sam'),(8,6,'license','','free_use'),(9,1,'license','','free_use'),(10,2,'license','','contact'),(11,3,'license','','free_use'),(12,1,'title','','Japan subway'),(13,2,'title','','PHP Cookbook'),(14,3,'title','','Filming in Saudi Arabia'),(15,6,'title','','My first nice sound clip'),(16,5,'title','','Some crazy fingers'),(17,7,'license','','free_use'),(18,6,'license','','no_allow'),(19,5,'license','','contact'),(20,1,'description','abstract','What is this crazy lady doing?\nWell, I suppose if you spend every day on the subway... !'),(21,1,'subject','','japan, rest, subway, lady'),(22,2,'description','abstract','It might be a picture of my car, but underneath lies a useful PDF :o)'),(23,2,'description','creation','I didn\'t produce this, although I did take the picture for the thumbnail!'),(24,2,'subject','','php, cookbook, car, ford, focus'),(25,3,'description','abstract','On the water between Bahrain and Saudi Arabia, filming an interview'),(26,3,'description','creation','Clearly I didn\'t take this picture, that was probably Sean!'),(27,3,'subject','','Saudi Arabia, Bahrain, Squash, boat, water, psalive'),(28,3,'creator','','Sean'),(29,5,'description','abstract','Something Kjellm uploaded'),(30,5,'description','creation','No idea who created this, or why!'),(31,5,'subject','','fingers, strange, count'),(32,5,'creator','','Some dude'),(33,7,'description','abstract','Something Kjellm uploaded'),(34,7,'description','creation','Somebody pressed the latin filler text button'),(35,7,'subject','','text, latin, filler'),(36,7,'creator','','Spartacus'),(37,7,'title','','Random plain text'),(38,7,'license','','contact'),(39,4,'description','abstract','Taken inside the Eden Project'),(40,4,'description','creation','EOS 350D\nf/2.8\n1/80\nISO: 100\n50mm'),(41,4,'subject','','bird, wet, Eden project'),(42,4,'creator','','Russ'),(43,4,'title','','Wet Robin'),(44,4,'license','','contact'),(45,8,'description','abstract','Loving the B&W'),(46,8,'description','creation','EOS 350D\nf/6.3\n1/50\nISO: 100\n40mm'),(47,8,'subject','','abigail, statue, frogner'),(48,8,'creator','','Russ'),(49,8,'title','','Abigail at Frogner'),(50,8,'license','','contact'),(51,9,'description','creation','Me and my camera'),(52,9,'type','','image/jpeg'),(53,9,'format','width','2996'),(54,9,'format','height','2084'),(55,9,'date','creation','2007:06:19 14:37:01'),(56,9,'format','size','5280277'),(57,9,'creator','','dave'),(58,9,'title','','Cute monkeys'),(59,9,'description','abstract','Cute monkeys!!'),(60,9,'license','','contact'),(61,10,'description','creation','Me and my camera'),(62,10,'type','','image/jpeg'),(63,10,'format','width','1432'),(64,10,'format','height','1040'),(65,10,'date','creation','2007:06:19 11:29:26'),(66,10,'format','size','1302543'),(67,10,'creator','','dave'),(68,10,'title','','Nice monkeys'),(69,10,'description','abstract','Actually Lemurs... !'),(70,10,'license','','no_allow'),(71,11,'creator','','June'),(72,11,'title','','Nice cartoon'),(73,11,'description','abstract','A cartoon I don\'t understand...'),(74,11,'description','creation','June uploaded it and I nicked it to put in the fixtures'),(75,11,'license','','free_use'),(76,12,'creator','','dave'),(77,12,'title','','Magic roundabout - Swindon'),(78,12,'relation','references','http://en.wikipedia.org/wiki/Magic_Roundabout_(Swindon)'),(79,12,'license','','free_use'),(80,12,'description','abstract','Yes it exists'),(81,12,'description','creation','Nicked it from Google images'),(82,13,'title','','Magic animations'),(83,13,'description','abstract','\'tis my magic animation file! Watch it! Oh, and you need sound.'),(84,13,'license','','by-sa');
/*!40000 ALTER TABLE `file_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_mimetype`
--

DROP TABLE IF EXISTS `file_mimetype`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `file_mimetype` (
  `id` int(11) NOT NULL auto_increment,
  `mimetype` varchar(100) NOT NULL,
  `identifier` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `file_mimetype`
--

LOCK TABLES `file_mimetype` WRITE;
/*!40000 ALTER TABLE `file_mimetype` DISABLE KEYS */;
INSERT INTO `file_mimetype` VALUES (1,'image/png','image'),(2,'image/jpeg','image'),(3,'application/pdf','pdf'),(4,'video/flv','video'),(5,'audio/mpeg','audio'),(6,'application/x-shockwave-flash','flash_animation'),(7,'image/gif','image'),(8,'image/tiff','image'),(9,'text/plain','text'),(10,'video/mpeg','video'),(11,'video/quicktime','video'),(12,'video/x-msvideo','video'),(13,'video/ogg','video'),(14,'audio/ogg','audio'),(15,'audio/flac','audio'),(16,'application/ogg','video'),(17,'audio/x-wav','audio'),(18,'video/avi','video'),(19,'video/x-ms-wmv','video'),(20,'video/mp4','video'),(21,'audio/mid','audio'),(22,'image/pjpeg','image'),(23,'audio/x-ms-wma','audio'),(24,'image/x-png','image'),(25,'audio/wav','audio'),(26,'audio/midi','audio'),(27,'text/html','text'),(28,'application/octet-stream','video'),(29,'video/x-flv','video');
/*!40000 ALTER TABLE `file_mimetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `history` (
  `id` int(11) NOT NULL auto_increment,
  `created_at` datetime default NULL,
  `action_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `object_id` int(11) default NULL,
  `extra_details` text,
  PRIMARY KEY  (`id`),
  KEY `history_FI_1` (`action_id`),
  KEY `history_FI_2` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (1,'2008-07-11 19:10:15',8,2,2,'reaktorArtwork');
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_action`
--

DROP TABLE IF EXISTS `history_action`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `history_action` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `history_action`
--

LOCK TABLES `history_action` WRITE;
/*!40000 ALTER TABLE `history_action` DISABLE KEYS */;
INSERT INTO `history_action` VALUES (1,'File reported'),(2,'File removed'),(3,'File restored'),(4,'Tag approved'),(5,'Article Created'),(6,'File marked for discussion'),(7,'File unmarked from discussion'),(8,'Artwork marked for discussion'),(9,'Artwork unmarked from discussion'),(10,'Article edited');
/*!40000 ALTER TABLE `history_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history_action_i18n`
--

DROP TABLE IF EXISTS `history_action_i18n`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `history_action_i18n` (
  `description` text NOT NULL,
  `id` int(11) NOT NULL,
  `culture` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`,`culture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `history_action_i18n`
--

LOCK TABLES `history_action_i18n` WRITE;
/*!40000 ALTER TABLE `history_action_i18n` DISABLE KEYS */;
INSERT INTO `history_action_i18n` VALUES ('Fil rapportert',1,'no'),('Fil fjernet',2,'no'),('Fil gjenopprettet',3,'no'),('Tag godkjent',4,'no'),('Artikkel opprettet',5,'no'),('Fil markert for diskusjon',6,'no'),('Fil fjernet fra diskusjonen',7,'no'),('Verk merket for diskusjon',8,'no'),('Verk fjernet fra diskusjonen',9,'no'),('Artikkel endret',10,'no');
/*!40000 ALTER TABLE `history_action_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lokalreaktor_artwork`
--

DROP TABLE IF EXISTS `lokalreaktor_artwork`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lokalreaktor_artwork` (
  `id` int(11) NOT NULL auto_increment,
  `subreaktor_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `lokalreaktor_artwork_FI_1` (`subreaktor_id`),
  KEY `lokalreaktor_artwork_FI_2` (`artwork_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `lokalreaktor_artwork`
--

LOCK TABLES `lokalreaktor_artwork` WRITE;
/*!40000 ALTER TABLE `lokalreaktor_artwork` DISABLE KEYS */;
INSERT INTO `lokalreaktor_artwork` VALUES (1,7,1),(2,7,3),(3,7,5),(4,7,8);
/*!40000 ALTER TABLE `lokalreaktor_artwork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lokalreaktor_residence`
--

DROP TABLE IF EXISTS `lokalreaktor_residence`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `lokalreaktor_residence` (
  `id` int(11) NOT NULL auto_increment,
  `created_at` datetime default NULL,
  `subreaktor_id` int(11) NOT NULL,
  `residence_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `lokalreaktor_residence_FI_1` (`subreaktor_id`),
  KEY `lokalreaktor_residence_FI_2` (`residence_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `lokalreaktor_residence`
--

LOCK TABLES `lokalreaktor_residence` WRITE;
/*!40000 ALTER TABLE `lokalreaktor_residence` DISABLE KEYS */;
/*!40000 ALTER TABLE `lokalreaktor_residence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL auto_increment,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `subject` varchar(255) default NULL,
  `message` text,
  `timestamp` datetime NOT NULL,
  `deleted_by_from` int(11) NOT NULL default '0',
  `deleted_by_to` int(11) NOT NULL default '0',
  `is_read` int(11) NOT NULL default '0',
  `is_ignored` int(11) NOT NULL default '0',
  `is_archived` int(11) NOT NULL default '0',
  `reply_to` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `messages_FI_1` (`to_user_id`),
  KEY `messages_FI_2` (`from_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages_ignored_user`
--

DROP TABLE IF EXISTS `messages_ignored_user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `messages_ignored_user` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `ignores_user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `messages_ignored_user_FI_1` (`user_id`),
  KEY `messages_ignored_user_FI_2` (`ignores_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `messages_ignored_user`
--

LOCK TABLES `messages_ignored_user` WRITE;
/*!40000 ALTER TABLE `messages_ignored_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages_ignored_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaktor_artwork`
--

DROP TABLE IF EXISTS `reaktor_artwork`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `reaktor_artwork` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `artwork_identifier` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `submitted_at` datetime default NULL,
  `actioned_at` datetime default NULL,
  `modified_flag` datetime default NULL,
  `title` varchar(255) NOT NULL,
  `actioned_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` text,
  `modified_note` text,
  `artwork_order` int(11) default '0',
  `average_rating` float default '0',
  `team_id` int(11) NOT NULL,
  `under_discussion` int(1) NOT NULL default '0',
  `multi_user` int(1) NOT NULL default '0',
  `deleted` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `reaktor_artwork_FI_1` (`user_id`),
  KEY `reaktor_artwork_FI_2` (`status`),
  KEY `reaktor_artwork_FI_3` (`team_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `reaktor_artwork`
--

LOCK TABLES `reaktor_artwork` WRITE;
/*!40000 ALTER TABLE `reaktor_artwork` DISABLE KEYS */;
INSERT INTO `reaktor_artwork` VALUES (1,3,'image','2008-03-05 18:30:37','2008-03-02 21:28:08',NULL,NULL,'The wonderful painting',0,2,'This painting is wonderful',NULL,0,0,5,0,0,0),(2,3,'image','2008-03-05 18:30:37','2008-02-20 21:30:54','2008-03-10 21:00:00',NULL,'The fancy gallery',1,3,'This is an awesome gallery',NULL,0,5.5,5,1,0,0),(3,3,'pdf','2008-03-05 18:30:37','2008-01-23 21:31:21','2008-03-03 21:31:27',NULL,'My Pdf',0,3,'This pdf is the bomb',NULL,0,3.5,5,0,0,0),(4,2,'video','2008-03-05 18:30:37','2008-03-02 21:31:35','2008-03-02 21:31:41',NULL,'Fingers',0,3,'Fingers, what more do you want?',NULL,0,4.5,8,0,0,0),(5,2,'audio','2008-03-05 18:30:37','2008-02-14 21:31:50',NULL,NULL,'Spacy',0,2,'woooooosh',NULL,0,0,6,0,0,0),(6,2,'text','2008-03-05 18:30:37','2008-01-07 21:32:05',NULL,NULL,'Dolor Sit',0,2,'Lorem Ipsum blah blah blah',NULL,0,0,7,0,0,0),(7,5,'image','2008-04-07 21:28:03','2008-04-07 21:28:03',NULL,NULL,'Cute monkeys',0,2,'Awwwww, so cute',NULL,0,0,5,0,0,0),(8,5,'image','2008-04-07 21:33:25','2008-04-07 21:33:25','2008-04-08 21:31:27',NULL,'Nice monkeys',1,3,'W00t',NULL,0,0,5,0,0,0),(9,6,'image','2008-05-06 13:45:41','2008-05-06 13:45:41','2008-05-06 13:46:27',NULL,'Nice cartoon',1,3,'Did it make you laugh too?',NULL,0,0,10,0,0,0),(10,6,'image','2008-05-15 11:56:46','2008-05-15 11:56:46','2008-05-15 11:57:39',NULL,'Magic roundabout - Swindon',1,3,'It\'s magic, don\'t you think?',NULL,0,0,5,0,0,0),(11,2,'flash_animation','2008-07-23 13:05:38','2008-07-23 13:05:38','2008-07-23 13:05:38',NULL,'Magic animations',1,3,'\'tis my magic animation file! Watch it! Oh, and you need sound.',NULL,0,0,10,0,0,0);
/*!40000 ALTER TABLE `reaktor_artwork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaktor_artwork_file`
--

DROP TABLE IF EXISTS `reaktor_artwork_file`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `reaktor_artwork_file` (
  `artwork_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `file_order` int(11) default '1',
  PRIMARY KEY  (`artwork_id`,`file_id`),
  KEY `reaktor_artwork_file_FI_2` (`file_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `reaktor_artwork_file`
--

LOCK TABLES `reaktor_artwork_file` WRITE;
/*!40000 ALTER TABLE `reaktor_artwork_file` DISABLE KEYS */;
INSERT INTO `reaktor_artwork_file` VALUES (1,1,1),(2,3,1),(2,4,1),(2,8,1),(3,2,1),(4,5,1),(5,6,1),(6,7,1),(7,9,1),(8,10,1),(9,11,1),(10,12,1),(11,13,1);
/*!40000 ALTER TABLE `reaktor_artwork_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaktor_artwork_history`
--

DROP TABLE IF EXISTS `reaktor_artwork_history`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `reaktor_artwork_history` (
  `id` int(11) NOT NULL auto_increment,
  `artwork_id` int(11) default NULL,
  `file_id` int(11) default NULL,
  `created_at` datetime default NULL,
  `modified_flag` datetime default NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `comment` text,
  PRIMARY KEY  (`id`),
  KEY `reaktor_artwork_history_FI_1` (`artwork_id`),
  KEY `reaktor_artwork_history_FI_2` (`file_id`),
  KEY `reaktor_artwork_history_FI_3` (`user_id`),
  KEY `reaktor_artwork_history_FI_4` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `reaktor_artwork_history`
--

LOCK TABLES `reaktor_artwork_history` WRITE;
/*!40000 ALTER TABLE `reaktor_artwork_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `reaktor_artwork_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaktor_file`
--

DROP TABLE IF EXISTS `reaktor_file`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `reaktor_file` (
  `id` int(11) NOT NULL auto_increment,
  `filename` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL,
  `realpath` varchar(300) NOT NULL,
  `thumbpath` varchar(300) NOT NULL,
  `originalpath` varchar(300) NOT NULL,
  `original_mimetype_id` int(11) NOT NULL,
  `converted_mimetype_id` int(11) NOT NULL,
  `thumbnail_mimetype_id` int(11) NOT NULL,
  `uploaded_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  `reported_at` datetime default NULL,
  `reported` int(8) NOT NULL default '0',
  `total_reported_ever` int(8) NOT NULL default '0',
  `marked_unsuitable` int(1) NOT NULL default '0',
  `under_discussion` int(1) NOT NULL default '0',
  `identifier` varchar(20) NOT NULL,
  `hidden` int(1) NOT NULL default '0',
  `deleted` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `reaktor_file_FI_1` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `reaktor_file`
--

LOCK TABLES `reaktor_file` WRITE;
/*!40000 ALTER TABLE `reaktor_file` DISABLE KEYS */;
INSERT INTO `reaktor_file` VALUES (1,'myimage.jpg',3,'image0044.jpg','image0044.jpg','image0044.jpg',2,2,2,'2008-02-10 12:54:08','2008-02-10 12:54:08',NULL,0,0,0,0,'image',0,0),(2,'mydoc.pdf',3,'1202926111_1__O__Reilly__PHP__Cookbook_.pdf','1202926111_1__O__Reilly__PHP__Cookbook_.pdf.jpg','1202926111_1__O__Reilly__PHP__Cookbook_.pdf',3,3,2,'2008-02-12 13:12:09','2008-02-12 13:12:09',NULL,0,0,0,0,'pdf',0,0),(3,'lovely.jpg',3,'1204733647_1_IMG_5382.JPG','1204733647_1_IMG_5382.JPG','1204733647_1_IMG_5382.JPG',2,2,2,'2007-01-01 01:01:54','2007-01-01 01:01:54',NULL,0,0,0,0,'image',0,0),(4,'wetbird.jpg',3,'1204735759_1_IMG_1252.jpg','1204735759_1_IMG_1252.jpg','1204735759_1_IMG_1252.jpg',2,2,2,'2007-02-01 01:01:54','2007-02-01 01:01:54',NULL,0,0,0,0,'image',0,0),(5,'fingers.flv',2,'fingers.flv','fingers.flv.jpg','fingers.flv',4,4,2,'2008-02-10 14:54:08','2008-02-10 14:54:08',NULL,0,0,0,0,'video',0,0),(6,'space-door.mp3',2,'space-door.mp3','space-door.mp3.jpg','space-door.mp3',5,5,2,'2008-02-10 14:54:09','2008-02-10 14:54:09',NULL,0,0,0,0,'audio',0,0),(7,'dolor_sit.txt',2,'dolor_sit.txt','dolor_sit.txt.jpg','dolor_sit.txt',9,9,2,'2008-02-20 13:10:17','2008-02-20 13:10:17',NULL,0,0,0,0,'text',0,0),(8,'abigail_frogner.jpg',3,'1204736133_1_IMG_3154x.jpg','1204736133_1_IMG_3154x.jpg','1204736133_1_IMG_3154x.jpg',2,2,2,'2007-03-01 01:01:54','2007-03-01 01:01:54',NULL,0,0,0,0,'image',0,0),(9,'IMG_0318.JPG',5,'1207596441_5_IMG_0318.JPG','1207596441_5_IMG_0318.JPG','1207596441_5_IMG_0318.JPG',2,2,2,'2008-04-07 21:27:23','2008-04-07 21:27:23',NULL,0,0,0,0,'image',0,0),(10,'IMG_0057c.jpg',5,'1207596762_5_IMG_0057c.jpg','1207596762_5_IMG_0057c.jpg','1207596762_5_IMG_0057c.jpg',2,2,2,'2008-04-07 21:32:43','2008-04-07 21:32:43','2008-04-08 22:14:10',6,24,0,0,'image',0,0),(11,'mcartoon.gif',6,'1210074241_1_mcartoon.gif','1210074241_1_mcartoon.gif','1210074241_1_mcartoon.gif',7,7,7,'2008-05-06 13:44:02','2008-05-06 13:44:02',NULL,0,0,0,0,'image',0,0),(12,'swindonRAB.jpg',6,'1210845302_6_swindonRAB.jpg','1210845302_6_swindonRAB.jpg','1210845302_6_swindonRAB.jpg',2,2,2,'2008-05-15 11:55:03','2008-05-15 11:55:03',NULL,0,0,0,0,'image',0,0),(13,'31D108EFB82DBA8654FD35499218B9A111B3E96792071F3DDCC0FE97FD4D517E.swf',2,'1216811137_2_31D108EFB82DBA8654FD35499218B9A111B3E96792071F3DDCC0FE97FD4D517E.swf','','1216811137_2_31D108EFB82DBA8654FD35499218B9A111B3E96792071F3DDCC0FE97FD4D517E.swf',6,6,5,'2008-07-23 13:05:38','2008-07-23 13:05:38',NULL,0,0,0,0,'flash_animation',0,0);
/*!40000 ALTER TABLE `reaktor_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recommended_artwork`
--

DROP TABLE IF EXISTS `recommended_artwork`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `recommended_artwork` (
  `id` int(11) NOT NULL auto_increment,
  `artwork` int(11) NOT NULL,
  `subreaktor` int(11) NOT NULL,
  `localsubreaktor` int(11) default NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `recommended_artwork_FI_1` (`artwork`),
  KEY `recommended_artwork_FI_2` (`subreaktor`),
  KEY `recommended_artwork_FI_3` (`localsubreaktor`),
  KEY `recommended_artwork_FI_4` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `recommended_artwork`
--

LOCK TABLES `recommended_artwork` WRITE;
/*!40000 ALTER TABLE `recommended_artwork` DISABLE KEYS */;
INSERT INTO `recommended_artwork` VALUES (1,8,7,1,2,'2008-05-06 14:52:37'),(2,9,5,NULL,2,'2008-05-06 14:53:37');
/*!40000 ALTER TABLE `recommended_artwork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejection_type`
--

DROP TABLE IF EXISTS `rejection_type`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rejection_type` (
  `id` int(11) NOT NULL auto_increment,
  `basename` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `rejection_type`
--

LOCK TABLES `rejection_type` WRITE;
/*!40000 ALTER TABLE `rejection_type` DISABLE KEYS */;
INSERT INTO `rejection_type` VALUES (1,'Copyright violation'),(2,'Unsuitable artwork content'),(3,'Question of ownership'),(4,'Unsuitable description of content'),(5,'Other');
/*!40000 ALTER TABLE `rejection_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rejection_type_i18n`
--

DROP TABLE IF EXISTS `rejection_type_i18n`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `rejection_type_i18n` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `culture` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`,`culture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `rejection_type_i18n`
--

LOCK TABLES `rejection_type_i18n` WRITE;
/*!40000 ALTER TABLE `rejection_type_i18n` DISABLE KEYS */;
INSERT INTO `rejection_type_i18n` VALUES (1,'Copyright violation','This artwork is a copyright violation, and will not be displayed on reaktor.','no'),(1,'Copyright violation','This artwork is a copyright violation, and will not be displayed on reaktor.','en'),(1,'Copyright violation','This artwork is a copyright violation, and will not be displayed on reaktor.','nn'),(2,'Unsuitable artwork content','This artwork has unsuitable content that Reaktor cannot display.','no'),(2,'Unsuitable artwork content','This artwork has unsuitable content that Reaktor cannot display.','en'),(2,'Unsuitable artwork content','This artwork has unsuitable content that Reaktor cannot display.','nn'),(3,'Question of ownership','There are evidence indicating you are not the correct author of this artwork.','no'),(3,'Question of ownership','There are evidence indicating you are not the correct author of this artwork.','en'),(3,'Question of ownership','There are evidence indicating you are not the correct author of this artwork.','nn'),(4,'Unsuitable description of content','Your description of the artwork is completely wrong.','no'),(4,'Unsuitable description of content','Your description of the artwork is completely wrong.','en'),(4,'Unsuitable description of content','Your description of the artwork is completely wrong.','nn'),(5,'Other','Your artwork has been rejected.','no'),(5,'Other','Your artwork has been rejected.','en'),(5,'Other','Your artwork has been rejected.','nn');
/*!40000 ALTER TABLE `rejection_type_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `related_artwork`
--

DROP TABLE IF EXISTS `related_artwork`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `related_artwork` (
  `id` int(11) NOT NULL auto_increment,
  `first_artwork` int(11) NOT NULL,
  `second_artwork` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `order_by` int(11) default '0',
  PRIMARY KEY  (`id`),
  KEY `related_artwork_FI_1` (`first_artwork`),
  KEY `related_artwork_FI_2` (`second_artwork`),
  KEY `related_artwork_FI_3` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `related_artwork`
--

LOCK TABLES `related_artwork` WRITE;
/*!40000 ALTER TABLE `related_artwork` DISABLE KEYS */;
INSERT INTO `related_artwork` VALUES (1,1,3,'2008-05-06 15:51:44',4,0),(2,1,2,'2008-05-05 15:52:37',4,0),(3,2,3,'2008-05-06 14:52:37',4,0);
/*!40000 ALTER TABLE `related_artwork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_bookmark`
--

DROP TABLE IF EXISTS `report_bookmark`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `report_bookmark` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `args` text NOT NULL,
  `type` varchar(10) NOT NULL default 'artwork',
  `list_order` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `report_bookmark`
--

LOCK TABLES `report_bookmark` WRITE;
/*!40000 ALTER TABLE `report_bookmark` DISABLE KEYS */;
INSERT INTO `report_bookmark` VALUES (1,'All approved','All approved artworks - no other filters applied','subreaktor_id=1&category_id=17&tags=&editorial_team_id=5&editorial_team_member_id=1&status_check=1&status_value=3&from_date[day]=&from_date[month]=&from_date[year]=&to_date[day]=&to_date[month]=&to_date[year]=&commit=Generate+report','artwork',0),(2,'All rejected','All rejected artwork - no other filters applied','subreaktor_id=1&category_id=17&tags=&editorial_team_id=5&editorial_team_member_id=1&status_check=1&status_value=4&from_date[day]=&from_date[month]=&from_date[year]=&to_date[day]=&to_date[month]=&to_date[year]=&commit=Generate+report','artwork',2),(3,'All under discussion','All artwork that is currently marked under discussion','subreaktor_id=1&category_id=17&tags=&editorial_team_id=5&editorial_team_member_id=1&status_value=4&under_discussion_check=1&from_date[day]=&from_date[month]=&from_date[year]=&to_date[day]=&to_date[month]=&to_date[year]=&commit=Generate+report','artwork',1),(4,'All awaiting approval','All artwork that is currently submitted for approval','subreaktor_id=1&category_id=17&tags=&editorial_team_id=5&editorial_team_member_id=1&status_check=1&status_value=2&from_date[day]=&from_date[month]=&from_date[year]=&to_date[day]=&to_date[month]=&to_date[year]=&commit=Generate+report','artwork',5),(5,'All this month','Artworks that have been submitted in the current month (dynamic)','subreaktor_id=1&category_id=17&tags=&editorial_team_id=5&editorial_team_member_id=1&status_value=2&from_date%5Bday%5D=&from_date%5Bmonth%5D=&from_date%5Byear%5D=&to_date%5Bday%5D=&to_date%5Bmonth%5D=&to_date%5Byear%5D=&current_month_check=1&commit=Generate+report','artwork',0),(6,'Awaiting approval in Tekst','Artwork in tekst subreaktor that has been submitted and is awaiting approval','subreaktor_check=1&subreaktor_id=6&category_id=17&tags=&editorial_team_id=5&editorial_team_member_id=1&status_check=1&status_value=2&from_date%5Bday%5D=&from_date%5Bmonth%5D=&from_date%5Byear%5D=&to_date%5Bday%5D=&to_date%5Bmonth%5D=&to_date%5Byear%5D=&commit=Generate+report','artwork',3),(7,'All registered users','This report will return all the registered users on the system, regardless of status','residence=1&interest=0&sex=0&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&commentAndOr=0&voteAndOr=0&commit=Generate+report&execute=userReport','user',1),(8,'All registered this month','All the users that have registered this month (dynamic)','residence=1&interest=0&sex=0&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&current_month_check=1&commentAndOr=0&voteAndOr=0&commit=Generate+report&execute=userReport','user',2),(9,'Active uploaders this month','The users that have been most active when uploading content this month','reportType=0&subreaktor=0&sex=0&startActivityDate%5Bday%5D=&startActivityDate%5Bmonth%5D=&startActivityDate%5Byear%5D=&endActivityDate%5Bday%5D=&endActivityDate%5Bmonth%5D=&endActivityDate%5Byear%5D=&commit=Generate+report&execute=activityReport','user',3),(10,'Most comments this month','The users that have been most active at commenting this month','reportType=1&subreaktor=0&sex=0&startActivityDate%5Bday%5D=&startActivityDate%5Bmonth%5D=&startActivityDate%5Byear%5D=&endActivityDate%5Bday%5D=&endActivityDate%5Bmonth%5D=&endActivityDate%5Byear%5D=&current_month_activity_check=1&commit=Generate+report&execute=activityReport','user',4),(11,'Active users','Users that have commented or written comments or uploaded','residence=1&interest=0&sex=0&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&publishedArtwork=1&commentAndOr=0&commentedArtwork=1&voteAndOr=0&voted=1&commit=Generate+report&execute=userReport','user',5),(12,'Passive users','Users that have not uploaded, commented or voted','residence=1&interest=0&sex=0&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&notPublishedArtwork=1&commentAndOr=1&notCommentedArtwork=1&voteAndOr=1&notVoted=1&commit=Generate+report&execute=userReport','user',6),(13,'Active non-uploaders','Users who have commented and voted but have not published anything','residence=1&interest=0&sex=0&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&notPublishedArtwork=1&commentAndOr=1&commentedArtwork=1&voteAndOr=1&voted=1&commit=Generate+report&execute=userReport','user',7),(14,'Super-active male users','Male users that have uploaded, commented and voted','residence=1&interest=0&sex_check=1&sex=1&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&publishedArtwork=1&commentAndOr=1&commentedArtwork=1&voteAndOr=1&voted=1&commit=Generate+report&execute=userReport','user',8),(15,'Super-active Female users','Female users that have uploaded, commented and voted','residence=1&interest=0&sex_check=1&sex=2&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&publishedArtwork=1&commentAndOr=1&commentedArtwork=1&voteAndOr=1&voted=1&commit=Generate+report&execute=userReport','user',0),(16,'Active female users','Female users that have commented, uploaded or voted','residence=1&interest=0&sex_check=1&sex=2&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&publishedArtwork=1&commentAndOr=0&commentedArtwork=1&voteAndOr=0&voted=1&commit=Generate+report&execute=userReport','user',0),(17,'Active male users','Male users that have commented, voted or uploaded','residence=1&interest=0&sex_check=1&sex=1&startDateArr%5Bday%5D=&startDateArr%5Bmonth%5D=&startDateArr%5Byear%5D=&endDateArr%5Bday%5D=&endDateArr%5Bmonth%5D=&endDateArr%5Byear%5D=&publishedArtwork=1&commentAndOr=0&commentedArtwork=1&voteAndOr=0&voted=1&commit=Generate+report&execute=userReport','user',0);
/*!40000 ALTER TABLE `report_bookmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `residence`
--

DROP TABLE IF EXISTS `residence`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `residence` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `parent` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `residence_FI_1` (`level`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `residence`
--

LOCK TABLES `residence` WRITE;
/*!40000 ALTER TABLE `residence` DISABLE KEYS */;
INSERT INTO `residence` VALUES (1,'Akershus',4,NULL),(2,'Aust-Agder',4,NULL),(3,'Buskerud',4,NULL),(4,'Finnmark',4,NULL),(5,'Hedmark',4,NULL),(6,'Hordaland',4,NULL),(7,'Møre og Romsdal',4,NULL),(8,'Nordland',4,NULL),(9,'Nord-Trøndelag',4,NULL),(10,'Oppland',4,NULL),(11,'Rogaland',4,NULL),(12,'Sogn og Fjordane',4,NULL),(13,'Sør-Trøndelag',4,NULL),(14,'Telemark',4,NULL),(15,'Troms',4,NULL),(16,'Vest-Agder',4,NULL),(17,'Vestfold',4,NULL),(18,'Østfold',4,NULL),(19,'Bergen',2,NULL),(20,'Groruddalen',1,NULL),(21,'Kristiansand',2,NULL),(22,'Lillehammer',2,NULL),(23,'Oslo',2,NULL),(24,'Stavanger',2,NULL),(25,'Tromsø',2,NULL),(26,'Trondheim',2,NULL);
/*!40000 ALTER TABLE `residence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `residence_level`
--

DROP TABLE IF EXISTS `residence_level`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `residence_level` (
  `id` int(11) NOT NULL auto_increment,
  `levelname` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `residence_level`
--

LOCK TABLES `residence_level` WRITE;
/*!40000 ALTER TABLE `residence_level` DISABLE KEYS */;
INSERT INTO `residence_level` VALUES (1,'Bydel'),(2,'By'),(3,'Kommune'),(4,'Fylke');
/*!40000 ALTER TABLE `residence_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `residence_level_i18n`
--

DROP TABLE IF EXISTS `residence_level_i18n`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `residence_level_i18n` (
  `name` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `culture` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`,`culture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `residence_level_i18n`
--

LOCK TABLES `residence_level_i18n` WRITE;
/*!40000 ALTER TABLE `residence_level_i18n` DISABLE KEYS */;
INSERT INTO `residence_level_i18n` VALUES ('Bydel',1,'no'),('District',1,'en'),('Bydel',1,'nn'),('By',2,'no'),('City',2,'en'),('By',2,'nn'),('Kommune',3,'no'),('Municipality',3,'en'),('Kommune',3,'nn'),('Fylke',4,'no'),('County',4,'en'),('Fylkje',4,'nn');
/*!40000 ALTER TABLE `residence_level_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_comment`
--

DROP TABLE IF EXISTS `sf_comment`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_comment` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) default NULL,
  `commentable_model` varchar(30) default NULL,
  `commentable_id` int(11) default NULL,
  `namespace` varchar(50) default NULL,
  `title` text,
  `text` text,
  `author_id` int(11) NOT NULL,
  `author_name` varchar(50) default NULL,
  `author_email` varchar(100) default NULL,
  `created_at` datetime default NULL,
  `unsuitable` int(11) NOT NULL default '0',
  `email_notify` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `comments_index` (`namespace`,`commentable_model`,`commentable_id`),
  KEY `object_index` (`commentable_model`,`commentable_id`),
  KEY `author_index` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_comment`
--

LOCK TABLES `sf_comment` WRITE;
/*!40000 ALTER TABLE `sf_comment` DISABLE KEYS */;
INSERT INTO `sf_comment` VALUES (1,NULL,'ReaktorArtwork',1,'frontend','Something I made','She made me giggle when I saw her :D',3,NULL,NULL,'2008-04-07 13:18:36',0,0),(2,NULL,'ReaktorArtwork',3,'frontend','Nice PDF?','Anybody like my PDF?\n\nbøøøøøøøø',3,NULL,NULL,'2008-04-07 13:19:10',0,0),(3,NULL,'ReaktorArtwork',2,'frontend','This is a very fancy gallery, no?','Looks like I\'m the only person making comments then :(',3,NULL,NULL,'2008-04-07 13:19:45',0,0),(4,NULL,'ReaktorArtwork',4,'frontend','Hey Monkey!','Nice Vid :D\n\nI especially like the fingers',3,NULL,NULL,'2008-04-07 13:20:13',0,0),(5,4,'ReaktorArtwork',4,'frontend','Haha','Cheers Monkey',2,NULL,NULL,'2008-04-07 13:21:16',0,0),(6,NULL,'ReaktorArtwork',4,'frontend','My note... !','Personally, I like the way the fingers are all the same length... !',2,NULL,NULL,'2008-04-07 13:21:38',0,0),(7,NULL,'ReaktorArtwork',2,'frontend','Sheesh','Calm down Userboy... there aren\'t exactly a flood of visiors yet are there?\n\nGive it time... God Påske!',2,NULL,NULL,'2008-04-07 13:22:27',0,0),(8,NULL,'ReaktorArtwork',3,'frontend','Huh?','It\'s just a pdf... calm down.\n\nåøæøåøæøå &lt;--- Random :D',2,NULL,NULL,'2008-04-07 13:23:02',0,0),(9,NULL,'ReaktorArtwork',5,'frontend','Music to my ears','hmm... !',2,NULL,NULL,'2008-04-07 13:23:44',0,0),(10,NULL,'ReaktorArtwork',7,'frontend','Like my monkeys?','I do!',5,NULL,NULL,'2008-04-07 21:28:17',0,0),(11,NULL,'ReaktorArtwork',2,'frontend','Great','Great picture mate!',5,NULL,NULL,'2008-04-07 21:28:39',0,0),(12,NULL,'ReaktorArtwork',4,'frontend','WTF','I mean seriously, wtf?',5,NULL,NULL,'2008-04-07 21:29:06',1,0),(13,4,'ReaktorArtwork',4,'frontend','Not me','I have to disagree... they freak me out',5,NULL,NULL,'2008-04-07 21:29:23',0,0),(14,NULL,'ReaktorArtwork',2,'frontend','Wow','I love this pic mate! Nice one... !',5,NULL,NULL,'2008-04-07 21:30:18',0,0),(15,7,'ReaktorArtwork',2,'frontend','huh?','God what?',5,NULL,NULL,'2008-04-07 21:30:35',1,0),(16,NULL,'ReaktorArtwork',3,'frontend','What?','I come looking for porn and all I get is a lousy PDF :(\n\nI must say I am disappointed... !',5,NULL,NULL,'2008-04-07 21:32:35',0,0),(17,NULL,'ReaktorArtwork',3,'frontend','C1alis at net prices','Please your woman today!',5,NULL,NULL,'2008-05-07 13:15:15',2,0),(18,2,'ReaktorArtwork',3,'frontend','Short in bed?','Go to myenlargement.ru and give your p3n1s a lift!',5,NULL,NULL,'2008-05-07 13:15:15',1,0),(19,2,'ReaktorArtwork',3,'frontend','I hate Colin','Colin is nothing but a spongy stack of vapid grits',5,NULL,NULL,'2008-04-07 12:15:15',1,0),(20,NULL,'ReaktorArtwork',2,'administrator','A comment','I just wanted to comment',1,NULL,NULL,'2008-07-11 11:24:10',0,0);
/*!40000 ALTER TABLE `sf_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_group`
--

DROP TABLE IF EXISTS `sf_guard_group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_guard_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  `is_editorial_team` int(11) default '0',
  `is_enabled` int(11) default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sf_guard_group_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_guard_group`
--

LOCK TABLES `sf_guard_group` WRITE;
/*!40000 ALTER TABLE `sf_guard_group` DISABLE KEYS */;
INSERT INTO `sf_guard_group` VALUES (1,'admin','Administrator group',0,0),(2,'users','Normal users who can interact on the site',0,0),(3,'staff','Staff group',0,0),(4,'translators','Translator group',0,0),(11,'publishers','Publisher group',0,0);
/*!40000 ALTER TABLE `sf_guard_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_group_permission`
--

DROP TABLE IF EXISTS `sf_guard_group_permission`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_guard_group_permission` (
  `group_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY  (`group_id`,`permission_id`),
  KEY `sf_guard_group_permission_FI_2` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_guard_group_permission`
--

LOCK TABLES `sf_guard_group_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_group_permission` DISABLE KEYS */;
INSERT INTO `sf_guard_group_permission` VALUES (1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17),(1,18),(1,19),(1,20),(1,21),(1,22),(1,23),(1,24),(1,25),(1,26),(1,27),(1,28),(1,29),(1,30),(1,31),(1,32),(1,33),(1,34),(1,35),(1,36),(1,37),(1,38),(1,39),(1,40),(1,41),(1,42),(1,43),(1,44),(1,45),(2,8),(2,15),(2,24),(2,30),(2,31),(2,32),(2,33),(2,34),(2,35),(2,36),(3,1),(3,8),(3,12),(3,13),(3,15),(3,19),(3,25),(3,26),(3,29),(3,30),(3,31),(3,32),(3,33),(3,34),(3,35),(3,36),(3,37),(3,38),(3,39),(3,40),(4,23),(5,14),(5,17),(5,18),(5,27),(5,36),(5,40),(5,42),(5,45),(6,14),(6,17),(6,18),(6,27),(6,36),(6,40),(6,42),(6,45),(7,14),(7,17),(7,18),(7,27),(7,36),(7,40),(7,42),(7,45),(8,14),(8,17),(8,18),(8,27),(8,36),(8,40),(8,42),(8,45),(9,14),(9,17),(9,18),(9,27),(9,36),(9,40),(9,42),(9,45),(10,14),(10,17),(10,18),(10,27),(10,36),(10,40),(10,42),(10,45),(11,43),(11,44);
/*!40000 ALTER TABLE `sf_guard_group_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_permission`
--

DROP TABLE IF EXISTS `sf_guard_permission`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_guard_permission` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sf_guard_permission_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_guard_permission`
--

LOCK TABLES `sf_guard_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_permission` DISABLE KEYS */;
INSERT INTO `sf_guard_permission` VALUES (1,'staff'),(2,'listgroup'),(3,'editgroup'),(4,'deletegroup'),(5,'listpermission'),(6,'editpermission'),(7,'deletepermission'),(8,'listuser'),(9,'edituser'),(10,'deleteuser'),(11,'editprofile'),(12,'viewallcontent'),(13,'viewdetailederrors'),(14,'editusercontent'),(15,'isuser'),(16,'deletecontent'),(17,'approveartwork'),(18,'approvetags'),(19,'commentadmin'),(20,'tagadministrator'),(21,'subreaktoradministrator'),(22,'subreaktorcategorizer'),(23,'translator'),(24,'viewmetadata'),(25,'debug'),(26,'discussartwork'),(27,'recommendartwork'),(28,'sendcommentstoall'),(29,'adminmessages'),(30,'postnewcomments'),(31,'uploadcontent'),(32,'sendmessages'),(33,'rateartwork'),(34,'markfavourite'),(35,'addresources'),(36,'reruntranscoding'),(37,'createresidence'),(38,'deleteresidence'),(39,'listresidences'),(40,'viewreports'),(41,'phpmyadmin'),(42,'editcategories'),(43,'edit_articles'),(44,'publish_articles'),(45,'createcompositeartwork');
/*!40000 ALTER TABLE `sf_guard_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_permission_i18n`
--

DROP TABLE IF EXISTS `sf_guard_permission_i18n`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_guard_permission_i18n` (
  `description` text NOT NULL,
  `id` int(11) NOT NULL,
  `culture` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`,`culture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_guard_permission_i18n`
--

LOCK TABLES `sf_guard_permission_i18n` WRITE;
/*!40000 ALTER TABLE `sf_guard_permission_i18n` DISABLE KEYS */;
INSERT INTO `sf_guard_permission_i18n` VALUES ('Show admin links such as moderator box and admin portal',1,'en'),('Can list/view groups',2,'en'),('Can edit groups',3,'en'),('Can delete groups',4,'en'),('Can list/view permissions',5,'en'),('Can edit permissions',6,'en'),('Can delete permissions',7,'en'),('Can list/view users',8,'en'),('Can edit users',9,'en'),('Can delete users',10,'en'),('Can edit any users profile',11,'en'),('Can view all content, including unmoderated',12,'en'),('Will see enhanced error messages where available',13,'en'),('Can edit file/artwork details',14,'en'),('Is a registered user (used for yml checks)',15,'en'),('Can delete files from the system',16,'en'),('Can approve artworks',17,'en'),('Can approve and delete tags on artworks',18,'en'),('Can administer comments',19,'en'),('Can remove tags from the system',20,'en'),('Can add/remove/edit subreaktors',21,'en'),('Can add/remove/edit subreaktor tags',22,'en'),('Can access the translation interface',23,'en'),('Can view artwork/file metadata',24,'en'),('Can view extra debug information on the site',25,'en'),('Can view and discuss artwork under discussion',26,'en'),('Can mark artwork as recommended',27,'en'),('Can send comments to all users',28,'en'),('Can create admin messages',29,'en'),('Can post new comments',30,'en'),('Can upload new content',31,'en'),('Can send messages to other users',32,'en'),('Can rate artwork',33,'en'),('Can mark users or artworks as favourites',34,'en'),('Can add resources to their profile',35,'en'),('Can re-run transcoding if failed',36,'en'),('Can add a new residence',37,'en'),('Can delete a residence',38,'en'),('Can list all residences',39,'en'),('Can view and create reports',40,'en'),('Can use PHPMyAdmin with read only user',41,'en'),('Can add/remove categories on all artwork',42,'en'),('Can edit articles',43,'en'),('Can publish articles',44,'en'),('can create multi-user composite artwork',45,'en'),('Tilgang til å se admin-meny og moderator-boks, samt admin-portalen',1,'no'),('Kan se liste over brukergrupper og redaksjoner',2,'no'),('Kan redigere brukergrupper og redaksjoner',3,'no'),('Kan slette brukergrupper og redaksjoner',4,'no'),('Kan se liste over tilganger',5,'no'),('Kan redigere tilganger',6,'no'),('Kan slette tilganger',7,'no'),('Kan se liste over alle brukere',8,'no'),('Kan redigere brukere via admin-grensesnittet',9,'no'),('Kan slette enkeltbrukere',10,'no'),('Kan redigere brukeres profil',11,'no'),('Kan se alle verk, inkludert ikke-godkjente verk',12,'no'),('Får ekstra detaljerte feilmeldinger der disse er tilgjengelig',13,'no'),('Kan redigere alle verk og filer',14,'no'),('Er en registrert bruker (må være på alle grupper)',15,'no'),('Kan slette filer fullstendig',16,'no'),('Har generell tilgang til å redigere og moderere verk',17,'no'),('Kan moderere tagger på verk (fjerne fra verk + godkjenne)',18,'no'),('Kan redigere og moderere kommentarer',19,'no'),('Kan fjerne tagger fra systemet',20,'no'),('Kan redigere (endre, slette, legge til) subReaktorer',21,'no'),('Kan redigere (endre, slette, legge til) tagger på subReaktorer',22,'no'),('Har tilgang til grensesnittet for oversetting',23,'no'),('Kan se metadata på verk via egen side for metadata',24,'no'),('Får se debuggings-informasjon (kun til bruk ved problemer)',25,'no'),('Kan diskutere verk og se verk under diskusjon',26,'no'),('Kan anbefale verk i subReaktorer og på forsiden',27,'no'),('Kan sende meldinger til flere brukere samtidig',28,'no'),('Kan poste admin-meldinger',29,'no'),('Kan kommentere verk',30,'no'),('Kan laste opp filer og lage verk',31,'no'),('Kan sende meldinger til andre brukere',32,'no'),('Kan gi karakter på verk',33,'no'),('Kan merke brukere og verk som sine favoritter',34,'no'),('Kan lagre ressurser på \"Min side\"',35,'no'),('Kan kjøre transkoding på nytt ved feil',36,'no'),('Kan opprette nye bosted som brukere kan velge i sin profil',37,'no'),('Kan fjerne bosted fra systemet',38,'no'),('Kan se liste over alle bosteder',39,'no'),('Kan generere rapporter og lagre nye hurtigrapporter',40,'no'),('Har tilgang til PHPMyAdmin',41,'no'),('Kan redigere (legge til, fjerne) kategorier på verk',42,'no'),('Kan redigere og opprette artikler',43,'no'),('Kan publisere artikler',44,'no'),('Kan opprette sammensatte verk med filer fra flere brukere',45,'no');
/*!40000 ALTER TABLE `sf_guard_permission_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_remember_key`
--

DROP TABLE IF EXISTS `sf_guard_remember_key`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_guard_remember_key` (
  `user_id` int(11) NOT NULL,
  `remember_key` varchar(32) default NULL,
  `ip_address` varchar(15) NOT NULL,
  `created_at` datetime default NULL,
  PRIMARY KEY  (`user_id`,`ip_address`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_guard_remember_key`
--

LOCK TABLES `sf_guard_remember_key` WRITE;
/*!40000 ALTER TABLE `sf_guard_remember_key` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_remember_key` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user`
--

DROP TABLE IF EXISTS `sf_guard_user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_guard_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(128) NOT NULL,
  `algorithm` varchar(128) NOT NULL default 'sha1',
  `salt` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `created_at` datetime default NULL,
  `last_login` datetime default NULL,
  `is_active` int(11) NOT NULL default '1',
  `is_super_admin` int(11) NOT NULL default '0',
  `is_verified` int(11) default '0',
  `show_content` int(11) default '0',
  `culture` varchar(10) default 'no',
  `email` varchar(128) NOT NULL,
  `email_private` int(11) default '1',
  `new_email` varchar(128) default NULL,
  `new_email_key` varchar(128) default NULL,
  `new_password_key` varchar(128) default NULL,
  `key_expires` datetime default NULL,
  `name` varchar(128) default NULL,
  `name_private` int(11) default '0',
  `dob` date default NULL,
  `sex` int(1) NOT NULL,
  `description` longblob,
  `residence_id` int(11) NOT NULL,
  `avatar` varchar(255) default NULL,
  `msn` varchar(128) default NULL,
  `icq` int(11) default NULL,
  `homepage` varchar(256) default NULL,
  `phone` varchar(32) default NULL,
  `opt_in` int(11) default '0',
  `editorial_notification` int(11) default '0',
  `show_login_status` int(11) default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `sf_guard_user_username_unique` (`username`),
  KEY `sf_guard_user_FI_1` (`residence_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_guard_user`
--

LOCK TABLES `sf_guard_user` WRITE;
/*!40000 ALTER TABLE `sf_guard_user` DISABLE KEYS */;
INSERT INTO `sf_guard_user` VALUES (1,'admin','sha1','a9c1d211a340efcb03bd663b9edd0457','07cd197ef0808b66fe10f38ce08f8c3d7408a407','2008-03-05 18:30:37','2008-03-05 23:16:00',1,1,1,1,'no','reaktor-test@linpro.no',1,NULL,NULL,NULL,NULL,'admin',0,'1980-01-01',2,'Hest er best',1,NULL,'reaktor@msn.no',54321,'http://reaktor.lab.linpro.no',NULL,0,0,1),(2,'monkeyboy','sha1','f4fb213bc7db3c0bb024caa05efb898f','bf635d43c34970345c8ee3f2a79db9f18a5af521','2008-03-05 18:30:37',NULL,1,0,1,1,'no','monkeyboy@linpro.no',1,NULL,NULL,NULL,NULL,'monkey johns son',0,'1990-12-24',1,'Monkey is the name, coding is the game. Now - choose your weapon!',4,NULL,'monkeyboy@hotmail.com',55323,'http://reaktor.lab.linpro.no',NULL,1,0,1),(3,'userboy','sha1','cd925dd06bedf99cf73ae702762c9c43','1ea75378afccb7303160b2a6a90b57de6c68abb5','2008-03-05 18:30:37',NULL,1,0,1,1,'no','userboy@linpro.no',1,NULL,NULL,NULL,NULL,'User Boy',0,'2000-03-08',1,'I am a normal user, no groups or priveledges whatsoever <|:o(8',6,NULL,'userboy@hotmail.com',123456,'http://reaktor.lab.linpro.no',NULL,1,0,1),(4,'leo','sha1','9a6c5f26d4959f07208d80195f0fe68a','c04408a077d03b27f32f55f997f070fd0a76a6df','2008-03-05 18:30:37',NULL,1,0,1,1,'no','anne-lena.westrum@kie.oslo.kommune.no',1,NULL,NULL,NULL,NULL,'Anne-Lena Westrum',0,'1977-04-20',2,'I\'m the owner don\'t you know :)',4,NULL,NULL,NULL,'http://minreaktor.no',NULL,1,0,1),(5,'Kerry','sha1','bfd44fa271d570737be1d2a5fcbfe094','bbef4efab29791913bd637695ec7b8509a684b89','2008-04-07 21:00:00',NULL,1,0,1,1,'no','kerry@nowhere.com',0,NULL,NULL,NULL,NULL,'Kerry',1,'1979-07-02',2,'Just Kerry',2,NULL,NULL,NULL,'http://kerry.com',NULL,1,0,1),(6,'dave','sha1','0f94492baa6ec642330e13934bb94b4d','5665080c0f0be56cf55943b63617a3441d3eb7cb','2008-04-07 22:00:00',NULL,1,0,1,0,'no','dave@nowhere.com',1,NULL,NULL,NULL,NULL,'Dave',1,'1979-07-02',2,'Just Dave',7,NULL,NULL,NULL,'http://dave.com',NULL,0,0,1),(7,'languageboy','sha1','36792f1b1e8d666d2262efb8b76eeacf','952c926e015b45732cb6b2c9aa50340a5f10c2bc','2008-05-08 13:45:00',NULL,1,0,1,1,'no','languageboy@nowhere.com',1,NULL,NULL,NULL,NULL,'Language boy',1,'1979-07-02',1,'I am the LANGUAGE BOY!',7,NULL,NULL,NULL,'http://google.com/translate',NULL,0,0,1),(8,'editorialboy1','sha1','969d9a980c10364a966e0f328cc2b4d0','5c93a233e646b866af07a146dd4e3ccce4f481d0','2008-05-08 13:45:00',NULL,1,0,1,1,'no','reaktor-editorialboy1@linpro.no',1,NULL,NULL,NULL,NULL,'Ed I. Torialboy',1,'1973-12-12',1,'I am ED I. TORIALBOY!',7,NULL,NULL,NULL,'http://vg.no',NULL,0,0,1),(9,'editorialboy2','sha1','faf65f1e1d9e2d76b037e3297abf1648','32691da19ed1af2894e6b9d6fb7c51593b0b1def','2008-05-08 13:45:00',NULL,1,0,1,1,'no','reaktor-editorialboy2@linpro.no',1,NULL,NULL,NULL,NULL,'Ed I. Torialboy II',1,'1973-12-12',1,'I am ED I. TORIALBOY II!',7,NULL,NULL,NULL,'http://vg.no',NULL,0,0,1),(10,'editorialboy3','sha1','22b9040b348aaf897eaa07479b23d8d1','425b03b6f51a24bf0e8cc6d644c853b8cf049748','2008-05-08 13:45:00',NULL,1,0,1,1,'no','reaktor-editorialboy3@linpro.no',1,NULL,NULL,NULL,NULL,'Ed I. Torialboy III',1,'1973-12-12',1,'I am ED I. TORIALBOY III!',7,NULL,NULL,NULL,'http://vg.no',NULL,0,0,1),(11,'articleboy','sha1','8eef1cf1c3f7beed00b81b3d6d7f96d9','243f37b6a190443304969ae1cdaae53054abcfcd','2008-05-08 13:45:00',NULL,1,0,1,1,'no','reaktor-articleboy@linpro.no',1,NULL,NULL,NULL,NULL,'Article Boy',1,'1973-12-12',1,'I am Article Boy! Bow before me!',5,NULL,NULL,NULL,'http://dagbladet.no',NULL,0,0,1);
/*!40000 ALTER TABLE `sf_guard_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user_group`
--

DROP TABLE IF EXISTS `sf_guard_user_group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_guard_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`group_id`),
  KEY `sf_guard_user_group_FI_2` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_guard_user_group`
--

LOCK TABLES `sf_guard_user_group` WRITE;
/*!40000 ALTER TABLE `sf_guard_user_group` DISABLE KEYS */;
INSERT INTO `sf_guard_user_group` VALUES (1,1),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(7,4),(8,2),(8,3),(8,5),(8,6),(8,7),(9,3),(9,8),(10,3),(10,11),(11,3),(11,11);
/*!40000 ALTER TABLE `sf_guard_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_guard_user_permission`
--

DROP TABLE IF EXISTS `sf_guard_user_permission`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_guard_user_permission` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `exclude` int(11) default '0',
  PRIMARY KEY  (`user_id`,`permission_id`),
  KEY `sf_guard_user_permission_FI_2` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_guard_user_permission`
--

LOCK TABLES `sf_guard_user_permission` WRITE;
/*!40000 ALTER TABLE `sf_guard_user_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `sf_guard_user_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sf_ratings`
--

DROP TABLE IF EXISTS `sf_ratings`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `sf_ratings` (
  `id` int(11) NOT NULL auto_increment,
  `ratable_model` varchar(50) NOT NULL,
  `ratable_id` int(11) NOT NULL,
  `user_id` int(11) default NULL,
  `rating` int(11) NOT NULL default '1',
  `rated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `ratable_index` (`ratable_model`,`ratable_id`,`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `sf_ratings`
--

LOCK TABLES `sf_ratings` WRITE;
/*!40000 ALTER TABLE `sf_ratings` DISABLE KEYS */;
INSERT INTO `sf_ratings` VALUES (1,'ReaktorArtwork',4,3,4,'0000-00-00 00:00:00'),(2,'ReaktorArtwork',3,2,3,'0000-00-00 00:00:00'),(3,'ReaktorArtwork',2,2,6,'0000-00-00 00:00:00'),(4,'ReaktorArtwork',4,5,5,'0000-00-00 00:00:00'),(5,'ReaktorArtwork',2,5,5,'0000-00-00 00:00:00'),(6,'ReaktorArtwork',3,5,4,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `sf_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subreaktor`
--

DROP TABLE IF EXISTS `subreaktor`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `subreaktor` (
  `id` int(11) NOT NULL auto_increment,
  `reference` varchar(15) NOT NULL,
  `lokalreaktor` int(11) NOT NULL default '0',
  `live` int(11) NOT NULL default '0',
  `subreaktor_order` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `subreaktor`
--

LOCK TABLES `subreaktor` WRITE;
/*!40000 ALTER TABLE `subreaktor` DISABLE KEYS */;
INSERT INTO `subreaktor` VALUES (1,'foto',0,1,1),(2,'tegning',0,1,2),(3,'film',0,1,3),(4,'lyd',0,1,4),(5,'tegneserier',0,1,5),(6,'tekst',0,1,6),(7,'groruddalen',1,1,7);
/*!40000 ALTER TABLE `subreaktor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subreaktor_artwork`
--

DROP TABLE IF EXISTS `subreaktor_artwork`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `subreaktor_artwork` (
  `id` int(11) NOT NULL auto_increment,
  `subreaktor_id` int(11) NOT NULL,
  `artwork_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `subreaktor_artwork_FI_1` (`subreaktor_id`),
  KEY `subreaktor_artwork_FI_2` (`artwork_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `subreaktor_artwork`
--

LOCK TABLES `subreaktor_artwork` WRITE;
/*!40000 ALTER TABLE `subreaktor_artwork` DISABLE KEYS */;
INSERT INTO `subreaktor_artwork` VALUES (1,1,1),(2,1,2),(3,1,7),(4,1,8),(5,5,9),(6,6,3),(7,3,4),(8,4,5),(9,6,6),(10,2,10),(11,3,11);
/*!40000 ALTER TABLE `subreaktor_artwork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subreaktor_i18n`
--

DROP TABLE IF EXISTS `subreaktor_i18n`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `subreaktor_i18n` (
  `name` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `culture` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`,`culture`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `subreaktor_i18n`
--

LOCK TABLES `subreaktor_i18n` WRITE;
/*!40000 ALTER TABLE `subreaktor_i18n` DISABLE KEYS */;
INSERT INTO `subreaktor_i18n` VALUES ('Foto',1,'no'),('Foto',1,'nn'),('Photo',1,'en'),('Tegning/grafikk',2,'no'),('Tegning/grafikk',2,'nn'),('Drawing/graphics',2,'en'),('Film/animasjon',3,'no'),('Film/animasjon',3,'nn'),('Movie/animation',3,'en'),('Lyd/musikk',4,'no'),('Lyd/musikk',4,'nn'),('Sound/music',4,'en'),('Tegneserier',5,'no'),('Tegneserier',5,'nn'),('Cartoons',5,'en'),('Tekst',6,'no'),('Tekst',6,'nn'),('Text',6,'en'),('GroruddalsReaktor',7,'no'),('GroruddalsReaktor',7,'nn'),('GroruddalsReaktor',7,'en');
/*!40000 ALTER TABLE `subreaktor_i18n` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subreaktor_identifier`
--

DROP TABLE IF EXISTS `subreaktor_identifier`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `subreaktor_identifier` (
  `id` int(11) NOT NULL auto_increment,
  `subreaktor_id` int(11) NOT NULL,
  `identifier` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `subreaktor_identifier_FI_1` (`subreaktor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `subreaktor_identifier`
--

LOCK TABLES `subreaktor_identifier` WRITE;
/*!40000 ALTER TABLE `subreaktor_identifier` DISABLE KEYS */;
INSERT INTO `subreaktor_identifier` VALUES (1,1,'image'),(2,2,'image'),(3,5,'image'),(4,6,'pdf'),(5,4,'audio'),(6,3,'video'),(7,3,'flash_animation'),(8,4,'video'),(9,6,'text');
/*!40000 ALTER TABLE `subreaktor_identifier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `is_triple` int(11) default NULL,
  `triple_namespace` varchar(100) default NULL,
  `triple_key` varchar(100) default NULL,
  `triple_value` varchar(100) default NULL,
  `approved` tinyint(4) NOT NULL default '0',
  `approved_by` int(11) default NULL,
  `approved_at` datetime default NULL,
  `width` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `name` (`name`),
  KEY `triple1` (`triple_namespace`),
  KEY `triple2` (`triple_key`),
  KEY `triple3` (`triple_value`),
  KEY `tag_FI_1` (`approved_by`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'fred',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',4),(2,'bob',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',3),(3,'jim',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',3),(4,'elephant',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',8),(5,'sugar cube',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',10),(6,'monkeydust',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',10),(7,'zoidberg',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',8),(8,'gardening',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',9),(9,'japan',0,NULL,NULL,NULL,0,4,'2008-01-01 01:01:00',5),(10,'rest',0,NULL,NULL,NULL,0,4,'2008-01-01 01:01:00',4),(11,'subway',0,NULL,NULL,NULL,0,4,'2008-01-01 01:01:00',6),(12,'lady',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',4),(13,'php',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',3),(14,'cookbook',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',8),(15,'car',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',3),(16,'ford',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',4),(17,'focus',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',5),(18,'saudi arabia',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',12),(19,'bahrain',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',7),(20,'squash',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',6),(21,'boat',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',4),(22,'water',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',5),(23,'psalive',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',7),(24,'bird',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',4),(25,'wet',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',3),(26,'eden project',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',12),(27,'fingers',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',7),(28,'strange',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',7),(29,'count',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',5),(30,'text',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',4),(31,'filler',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',6),(32,'abigail',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',7),(33,'statue',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',6),(34,'frogner',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',7),(35,'dave',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',4),(36,'scuba diving',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',12),(37,'egypt',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',5),(38,'robin',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',5),(39,'space',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',5),(40,'sound',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',5),(41,'marianne',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',8),(42,'bus',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',3),(43,'latin',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',5),(44,'snow',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',4),(45,'ski',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',3),(46,'sam',0,NULL,NULL,NULL,1,4,'2008-01-01 01:01:00',3),(47,'bollocks',0,NULL,NULL,NULL,0,NULL,NULL,8),(48,'birds',0,NULL,NULL,NULL,0,NULL,NULL,5),(49,'random crappy long tag',0,NULL,NULL,NULL,0,NULL,NULL,22),(50,'monkey',0,NULL,NULL,NULL,1,4,'2008-04-07 21:52:30',6),(51,'fluffy',0,NULL,NULL,NULL,1,4,'2008-04-07 21:52:38',6),(52,'lake district',0,NULL,NULL,NULL,1,4,'2008-04-07 21:52:37',13),(53,'lemur',0,NULL,NULL,NULL,1,4,'2008-04-07 21:53:10',5),(54,'lakes',0,NULL,NULL,NULL,1,4,'2008-04-07 21:53:08',5),(55,'wildlife',0,NULL,NULL,NULL,1,4,'2008-04-07 21:53:06',8),(56,'animal',0,NULL,NULL,NULL,1,4,'2008-04-07 21:53:03',6),(57,'fuckit',0,NULL,NULL,NULL,0,NULL,NULL,6),(58,'bil',0,NULL,NULL,NULL,1,4,'2008-04-24 13:41:17',3),(59,'bike',0,NULL,NULL,NULL,1,4,'2008-04-24 13:41:15',4),(60,'filming',0,NULL,NULL,NULL,1,4,'2008-04-24 13:41:43',7),(61,'camera',0,NULL,NULL,NULL,1,4,'2008-04-24 13:41:42',6),(62,'crazy',0,NULL,NULL,NULL,0,NULL,NULL,5),(63,'funny',0,NULL,NULL,NULL,0,4,'2008-04-25 16:24:54',5),(64,'grass',0,NULL,NULL,NULL,1,4,'2008-04-25 16:27:23',5),(65,'field',0,NULL,NULL,NULL,1,4,'2008-04-25 16:27:21',5),(66,'camping',0,NULL,NULL,NULL,1,4,'2008-04-25 16:27:29',7),(67,'russ',0,NULL,NULL,NULL,1,4,'2008-04-25 16:28:22',4),(68,'red',0,NULL,NULL,NULL,1,4,'2008-04-25 16:29:23',3),(69,'silly',0,NULL,NULL,NULL,0,4,'2008-04-25 16:29:52',5),(70,'norefjell',0,NULL,NULL,NULL,1,4,'2008-04-25 16:30:17',9),(71,'coach',0,NULL,NULL,NULL,1,4,'2008-04-25 16:30:15',5),(72,'baby',0,NULL,NULL,NULL,1,4,'2008-04-25 16:30:52',4),(73,'cute',0,NULL,NULL,NULL,1,4,'2008-04-25 16:30:50',4),(74,'park',0,NULL,NULL,NULL,1,4,'2008-04-25 16:31:31',4),(75,'magic',0,NULL,NULL,NULL,1,2,'2008-05-15 11:57:59',NULL),(76,'roundabout',0,NULL,NULL,NULL,1,2,'2008-05-15 11:58:01',NULL),(77,'swindon',0,NULL,NULL,NULL,1,2,'2008-05-15 11:58:02',NULL),(78,'driving',0,NULL,NULL,NULL,1,2,'2008-05-15 11:57:56',NULL),(79,'tourist',0,NULL,NULL,NULL,1,2,'2008-05-15 11:58:04',NULL),(80,'england',0,NULL,NULL,NULL,1,2,'2008-05-15 11:57:58',NULL);
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tagging`
--

DROP TABLE IF EXISTS `tagging`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `tagging` (
  `id` int(11) NOT NULL auto_increment,
  `tag_id` int(11) NOT NULL,
  `taggable_model` varchar(30) default NULL,
  `taggable_id` int(11) default NULL,
  `parent_approved` tinyint(4) NOT NULL default '0',
  `parent_user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `tag` (`tag_id`),
  KEY `taggable` (`taggable_model`,`taggable_id`),
  KEY `tagging_FI_2` (`parent_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `tagging`
--

LOCK TABLES `tagging` WRITE;
/*!40000 ALTER TABLE `tagging` DISABLE KEYS */;
INSERT INTO `tagging` VALUES (1,9,'ReaktorFile',1,0,3),(2,11,'ReaktorFile',1,0,3),(3,1,'ReaktorFile',1,0,3),(4,15,'ReaktorFile',2,1,3),(5,17,'ReaktorFile',2,1,3),(6,58,'ReaktorFile',2,1,3),(7,59,'ReaktorFile',2,1,3),(8,52,'ReaktorFile',2,1,3),(9,54,'ReaktorFile',2,1,3),(10,60,'ReaktorFile',3,1,3),(11,18,'ReaktorFile',3,1,3),(12,61,'ReaktorFile',3,1,3),(13,21,'ReaktorFile',3,1,3),(14,24,'ReaktorFile',4,1,3),(15,51,'ReaktorFile',4,1,3),(16,26,'ReaktorFile',4,1,3),(17,38,'ReaktorFile',4,1,3),(18,27,'ReaktorFile',5,1,2),(19,62,'ReaktorFile',5,0,2),(20,41,'ReaktorFile',6,0,2),(21,44,'ReaktorFile',6,0,2),(22,44,'ReaktorFile',7,0,2),(23,46,'ReaktorFile',7,0,2),(24,41,'ReaktorFile',7,0,2),(25,45,'ReaktorFile',7,0,2),(26,32,'ReaktorFile',8,1,3),(27,34,'ReaktorFile',8,1,3),(28,33,'ReaktorFile',8,1,3),(29,50,'ReaktorFile',9,0,5),(30,54,'ReaktorFile',9,0,5),(31,52,'ReaktorFile',9,0,5),(32,55,'ReaktorFile',9,0,5),(33,53,'ReaktorFile',10,1,5),(34,50,'ReaktorFile',10,1,5),(35,54,'ReaktorFile',10,1,5),(36,55,'ReaktorFile',10,1,5),(37,63,'ReaktorFile',1,0,3),(38,64,'ReaktorFile',2,1,3),(39,65,'ReaktorFile',2,1,3),(40,66,'ReaktorFile',2,1,3),(41,67,'ReaktorFile',3,1,3),(42,67,'ReaktorFile',2,1,3),(43,22,'ReaktorFile',3,1,3),(44,64,'ReaktorFile',4,1,3),(45,8,'ReaktorFile',4,1,3),(46,66,'ReaktorFile',4,1,3),(47,61,'ReaktorFile',4,1,3),(48,68,'ReaktorFile',4,1,3),(49,9,'ReaktorFile',5,0,2),(50,11,'ReaktorFile',5,0,2),(51,10,'ReaktorFile',5,0,2),(52,69,'ReaktorFile',5,0,2),(53,63,'ReaktorFile',5,0,2),(54,70,'ReaktorFile',6,0,2),(55,45,'ReaktorFile',6,0,2),(56,71,'ReaktorFile',6,0,2),(57,42,'ReaktorFile',6,0,2),(58,70,'ReaktorFile',7,0,2),(59,72,'ReaktorFile',8,1,3),(60,73,'ReaktorFile',8,1,3),(61,64,'ReaktorFile',9,0,5),(62,56,'ReaktorFile',9,0,5),(63,63,'ReaktorFile',9,0,5),(64,73,'ReaktorFile',9,0,5),(65,69,'ReaktorFile',9,0,5),(66,74,'ReaktorFile',10,1,5),(67,51,'ReaktorFile',10,1,5),(68,73,'ReaktorFile',10,1,5),(69,74,'ReaktorFile',11,1,6),(70,62,'ReaktorFile',11,1,6),(71,1,'ReaktorFile',11,1,6),(72,75,'ReaktorFile',12,1,6),(73,76,'ReaktorFile',12,1,6),(74,77,'ReaktorFile',12,1,6),(75,78,'ReaktorFile',12,1,6),(76,79,'ReaktorFile',12,1,6),(77,80,'ReaktorFile',12,1,6),(78,43,'Article',1,1,4),(79,1,'Article',1,1,4),(80,43,'Article',2,1,4),(81,34,'Article',2,1,4),(82,31,'Article',2,1,4),(83,31,'Article',1,1,4),(84,70,'ReaktorFile',13,1,2),(85,12,'ReaktorFile',13,1,2);
/*!40000 ALTER TABLE `tagging` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trans_unit`
--

DROP TABLE IF EXISTS `trans_unit`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `trans_unit` (
  `msg_id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL default '1',
  `id` varchar(255) default '',
  `source` text NOT NULL,
  `target` text NOT NULL,
  `module` varchar(255) default '',
  `filename` varchar(255) default '',
  `comments` text,
  `date_added` int(11) NOT NULL default '0',
  `date_modified` int(11) NOT NULL default '0',
  `author` varchar(255) NOT NULL default '',
  `translated` int(1) NOT NULL default '0',
  PRIMARY KEY  (`msg_id`),
  KEY `trans_unit_FI_1` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `trans_unit`
--

LOCK TABLES `trans_unit` WRITE;
/*!40000 ALTER TABLE `trans_unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `trans_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_interest`
--

DROP TABLE IF EXISTS `user_interest`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_interest` (
  `user_id` int(11) NOT NULL,
  `subreaktor_id` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`,`subreaktor_id`),
  KEY `user_interest_FI_2` (`subreaktor_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_interest`
--

LOCK TABLES `user_interest` WRITE;
/*!40000 ALTER TABLE `user_interest` DISABLE KEYS */;
INSERT INTO `user_interest` VALUES (2,4),(3,1),(3,2),(3,3);
/*!40000 ALTER TABLE `user_interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_resource`
--

DROP TABLE IF EXISTS `user_resource`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_resource` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`,`user_id`),
  KEY `user_resource_FI_1` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_resource`
--

LOCK TABLES `user_resource` WRITE;
/*!40000 ALTER TABLE `user_resource` DISABLE KEYS */;
INSERT INTO `user_resource` VALUES (1,3,'http://photoshop.com'),(2,3,'http://gimp.org'),(3,3,'http://vg.no'),(4,3,'http://facebook.com'),(5,1,'http://photoshop.com'),(6,4,'http://gimp.org'),(7,2,'http://vg.no'),(8,5,'http://facebook.com');
/*!40000 ALTER TABLE `user_resource` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2008-08-07  8:58:43
