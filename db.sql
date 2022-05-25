drop database if exists forum;
create database forum;
use forum;


-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: forum
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `date` datetime NOT NULL,
  `pid` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `fid` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`cid`),
  KEY `Comment_fk0` (`pid`),
  KEY `Comment_fk1` (`uid`),
  KEY `Comment_fk2` (`fid`),
  CONSTRAINT `Comment_fk0` FOREIGN KEY (`pid`) REFERENCES `post` (`pid`),
  CONSTRAINT `Comment_fk1` FOREIGN KEY (`uid`) REFERENCES `user` (`UID`),
  CONSTRAINT `Comment_fk2` FOREIGN KEY (`fid`) REFERENCES `comment` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (30,'Fusce a euismod sapien. Nunc id nulla justo. Quisque sagittis augue et nulla consequat, ac tristique eros faucibus. Aliquam egestas libero eu suscipit venenatis. In id massa quis eros placerat blandit vitae porta lorem. Etiam scelerisque purus at ipsum porttitor ultrices. Nulla facilisi. Sed sed convallis nunc, at convallis mauris. Vivamus non efficitur eros.','2022-05-25 16:46:42',67,1,NULL),(31,'Ut risus ex, hendrerit ut dolor a, porttitor laoreet ante. Nam feugiat, urna at luctus gravida, enim mauris euismod neque, vitae iaculis elit massa ut lectus. Suspendisse potenti. Curabitur eget dapibus lacus. Maecenas consectetur cursus quam quis laoreet. Ut ut libero in orci sollicitudin bibendum. Quisque sagittis libero id ornare laoreet. Proin a magna elit. Sed odio magna, malesuada ut maximus tempus, maximus in dui. Sed eu hendrerit urna.','2022-05-25 16:46:51',67,1,NULL),(32,'Etiam elementum purus ac massa bibendum ornare. Suspendisse nisl nibh, laoreet sed mollis sit amet, aliquam eu tellus. Sed hendrerit, risus sit amet imperdiet ultrices, urna nibh tincidunt risus, id auctor purus metus at libero. Cras consectetur, ligula non elementum placerat, nunc lectus ultricies nunc, gravida venenatis risus augue varius nisl. Fusce at rutrum erat, quis fermentum nisl. Mauris quis gravida leo. Aliquam arcu ex, feugiat eu maximus sed, lacinia et quam. Mauris suscipit bibendum imperdiet. Sed malesuada mauris augue, nec placerat tortor pretium quis. Aenean blandit diam ut velit lacinia bibendum.','2022-05-25 16:47:11',67,4,30),(33,'Fusce a euismod sapien. Nunc id nulla justo. Quisque sagittis augue et nulla consequat, ac tristique eros faucibus. Aliquam egestas libero eu suscipit venenatis. In id massa quis eros placerat blandit vitae porta lorem. Etiam scelerisque purus at ipsum porttitor ultrices. Nulla facilisi. Sed sed convallis nunc, at convallis mauris. Vivamus non efficitur eros.','2022-05-25 16:47:26',67,4,32);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `pid` bigint(20) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Text` text NOT NULL,
  `Image` varchar(250) DEFAULT NULL,
  `date` datetime NOT NULL,
  `uid` bigint(20) NOT NULL,
  `tid` bigint(20) NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `Post_fk0` (`uid`),
  KEY `fk_tid` (`tid`),
  CONSTRAINT `Post_fk0` FOREIGN KEY (`uid`) REFERENCES `user` (`UID`),
  CONSTRAINT `fk_tid` FOREIGN KEY (`tid`) REFERENCES `theme` (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (66,'Red Pandas','Donec mattis vel justo eu dictum. Donec interdum, sapien eget condimentum eleifend, massa magna euismod dolor, nec viverra enim urna nec neque. Aenean sem augue, molestie id massa vel, viverra consequat lectus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam vel dolor in felis semper hendrerit. Curabitur eros nisl, euismod id est ac, tincidunt rhoncus neque. Nunc tempus a tortor eget convallis. Vivamus iaculis et felis a vehicula. Quisque pharetra at ante nec iaculis. Maecenas ultricies tincidunt ligula sed pellentesque. Integer lectus risus, porttitor sit amet dolor eu, interdum ultricies turpis. Nunc et luctus urna. Etiam laoreet augue in felis convallis hendrerit vitae et est. Quisque vitae tincidunt sapien.',NULL,'2022-05-25 16:42:40',4,1),(67,'Attack','Etiam vitae lorem viverra, volutpat neque ac, rhoncus arcu. Aliquam sodales justo volutpat massa posuere, sed auctor turpis vestibulum. Donec eget fringilla erat. In dignissim mi sed nulla dignissim, vel cursus lacus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris purus dui, efficitur ac pulvinar a, ultricies id ante. Morbi dictum gravida metus id luctus. Suspendisse in rhoncus turpis, eu efficitur dolor. Nullam vitae fringilla metus, eu pellentesque sapien. Maecenas eget ex tempus, venenatis ligula vitae, posuere purus. Nulla in lacus eget leo pretium feugiat vel ut massa. Ut eleifend finibus lacus, vel pretium est viverra ut.','League_of_Legends_LsL6OjXE67.png','2022-05-25 16:43:39',4,5),(68,'Koalas together strong.','Sed non lorem ultrices, commodo ex eget, bibendum neque. Donec aliquet ante nisi, finibus iaculis massa aliquet ut. Nam tristique ligula vitae est fringilla tincidunt. Nullam odio tortor, placerat sed ultricies non, sodales ac purus. Etiam est mauris, lacinia vitae maximus ut, rutrum in nisi. Cras euismod tempor ante, feugiat consectetur augue. Aenean vehicula eget lectus sed sollicitudin. Nulla mollis bibendum laoreet. Nunc consectetur aliquet nibh, id vehicula orci lobortis sit amet. Aliquam erat volutpat.',NULL,'2022-05-25 16:44:18',1,1),(69,'Pikachu','In ultrices risus sit amet lectus lobortis placerat. Mauris justo purus, fermentum in tellus hendrerit, fermentum malesuada mi. Pellentesque sodales massa non est semper, at imperdiet ante faucibus. Nunc sodales pulvinar ultrices. Phasellus nec consectetur orci. Proin lobortis nunc diam, eu fermentum leo placerat sit amet. Integer lobortis lacus lorem. Mauris eget velit lacus. Cras sollicitudin libero a eros pellentesque, a aliquam arcu dignissim. Curabitur ullamcorper nunc a suscipit consequat. Nullam non massa sit amet nisi ornare dictum ut nec tortor. Donec ut ipsum ultrices, imperdiet quam sit amet, pulvinar dui. Vestibulum scelerisque lobortis justo sit amet ullamcorper. Donec id erat turpis. Aenean ultrices tellus a ipsum gravida, at viverra quam porta. Nulla fringilla imperdiet mi, ut volutpat enim consectetur sed.','brave_BO1X50qwr7.png','2022-05-25 16:45:36',1,6);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `theme` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theme`
--

LOCK TABLES `theme` WRITE;
/*!40000 ALTER TABLE `theme` DISABLE KEYS */;
INSERT INTO `theme` VALUES (1,'Animals','Theme intended to share animal information and pictures to other animal lovers.'),(5,'Politics','Posts related to politic.'),(6,'Pokemon','Thread about Pokemons.');
/*!40000 ALTER TABLE `theme` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `UID` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`UID`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'user','test','2022-05-13'),(4,'medo','medo','2022-05-13');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-25 16:51:24
