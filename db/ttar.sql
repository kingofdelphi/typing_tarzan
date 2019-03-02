-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: ttar
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.17.04.1

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
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` timestamp NULL DEFAULT NULL,
  `text_id` int(11) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'2017-07-31 05:00:37',NULL,'hi'),(2,'2017-07-31 05:00:54',NULL,'hi'),(3,'2017-07-31 05:10:58',NULL,'ok'),(4,'2017-07-31 05:16:14',1,'hi'),(5,'2017-07-31 05:17:49',1,'a'),(6,'2017-07-31 05:18:00',2,'a'),(7,'2017-07-31 05:46:00',2,'ok'),(8,'2017-07-31 05:49:37',2,'ukvsbihan');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `texts`
--

DROP TABLE IF EXISTS `texts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `text` varchar(505) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `texts`
--

LOCK TABLES `texts` WRITE;
/*!40000 ALTER TABLE `texts` DISABLE KEYS */;
INSERT INTO `texts` VALUES (1,'american psycho','In 1987, wealthy New York investment banker Patrick Bateman\'s life revolves around dining at trendy restaurants while keeping up appearances for his fiancee Evelyn and for his circle of wealthy and shallow associates, most of whom he dislikes. Bateman describes the material accoutrements of his lifestyle, including his daily morning exercise and beautification routine. He also discusses his music collection, with performers such as Huey Lewis and the News, Phil Collins,');
INSERT INTO `texts` VALUES (2,'Skillful qualities',"Now, Kalamas, don\'t go by reports, by legends, by traditions, by scripture, by logical conjecture, by inference, by analogies, by agreement through pondering views, by probability, or by the thought, 'This contemplative is our teacher.' When you know for yourselves that, 'These qualities are skillful; these qualities are blameless; these qualities are praised by the wise; these qualities, when adopted & carried out, lead to welfare & to happiness' — then you should enter & remain in them");
INSERT INTO `texts` VALUES (3,'Hpylori',"After H. pylori enters your body, it attacks the lining of your stomach, which usually protects you from the acid your body uses to digest food. Once the bacteria have done enough damage, acid can get through the lining, which leads to ulcers. These may bleed, cause infections, or keep food from moving through your digestive tract.");
INSERT INTO `texts` VALUES (4,'Impermanence',"All is impermanent. And what is the all that is impermanent? The eye is impermanent, visual objects [ruupaa]... eye-consciousness... eye contact [cakku-samphassa]... whatever is felt [vedayita] as pleasant or unpleasant or neither-unpleasant-nor-pleasant, born of eye-contact is impermanent. [Likewise with the ear, nose, tongue, body, and mind]");
INSERT INTO `texts` VALUES (5,'Dreams',"During most dreams, the person dreaming is not aware that they are dreaming, no matter how absurd or eccentric the dream is. The reason for this may be that the prefrontal cortex, the region of the brain responsible for logic and planning, exhibits decreased activity during dreams. This allows the dreamer to more actively interact with the dream without thinking about what might happen, since things that would normally stand out in reality blend in with the dream scenery.");
/*!40000 ALTER TABLE `texts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `email` varchar(255) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `validated` int(11) DEFAULT NULL,
  `validation_code` varchar(255) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `userscol` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-31 17:28:57
