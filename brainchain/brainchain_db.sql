-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: brainchain_db
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `relations`
--

DROP TABLE IF EXISTS `relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `relations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `from_word_id` int NOT NULL,
  `to_word_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_from_word` (`from_word_id`),
  KEY `fk_to_word` (`to_word_id`),
  CONSTRAINT `fk_from_word` FOREIGN KEY (`from_word_id`) REFERENCES `words` (`id`),
  CONSTRAINT `fk_to_word` FOREIGN KEY (`to_word_id`) REFERENCES `words` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relations`
--

LOCK TABLES `relations` WRITE;
/*!40000 ALTER TABLE `relations` DISABLE KEYS */;
INSERT INTO `relations` VALUES (1,1,2),(2,1,3),(3,1,9),(4,1,20),(5,2,13),(6,13,12),(7,12,11),(8,11,14),(9,13,2),(10,4,1),(11,4,2),(12,5,2),(13,5,20),(14,3,4),(15,3,5),(16,6,7),(17,7,6),(18,6,8),(19,8,15),(20,8,20),(21,6,20),(22,7,20),(23,9,20),(24,10,9),(25,10,11),(26,10,6),(27,9,6),(28,9,7),(29,11,19),(30,19,12),(31,19,18),(32,12,13),(33,14,15),(34,15,20),(35,16,20),(36,16,17),(37,17,18),(38,18,16),(39,14,6),(40,14,8),(41,15,8),(42,20,6),(43,20,9),(44,2,20),(45,13,16),(46,5,9),(47,4,9),(48,2,1),(49,12,11),(50,11,10),(51,18,14),(52,3,20);
/*!40000 ALTER TABLE `relations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rounds`
--

DROP TABLE IF EXISTS `rounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rounds` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `score` int NOT NULL,
  `chain_length` int NOT NULL,
  `creativity_percent` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_round_user` (`user_id`),
  CONSTRAINT `fk_round_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rounds`
--

LOCK TABLES `rounds` WRITE;
/*!40000 ALTER TABLE `rounds` DISABLE KEYS */;
INSERT INTO `rounds` VALUES (1,1,0,1,20,'2025-11-16 09:28:38'),(2,1,36,4,49,'2025-11-16 09:30:15'),(3,1,26,3,40,'2025-11-16 10:14:08'),(4,1,12,2,30,'2025-11-16 11:29:53'),(5,1,14,2,36,'2025-11-16 11:30:32'),(6,1,12,2,32,'2025-11-18 05:50:34'),(7,1,26,2,36,'2025-11-18 05:51:04'),(8,1,38,2,32,'2025-11-18 05:51:42'),(9,2,42,4,51,'2025-12-03 06:28:36'),(10,3,0,1,24,'2025-12-03 06:32:12'),(11,3,28,3,44,'2025-12-03 06:34:11'),(12,3,14,2,42,'2025-12-03 06:34:52'),(13,5,0,1,32,'2025-12-04 21:45:50'),(14,5,78,3,44,'2025-12-04 21:48:49'),(15,5,106,3,44,'2025-12-04 21:50:47'),(16,5,168,5,62,'2025-12-04 21:51:41'),(17,5,72,4,53,'2025-12-04 21:53:10'),(18,5,122,5,60,'2025-12-04 21:53:53'),(19,6,16,2,36,'2026-01-03 13:10:00'),(20,7,12,2,32,'2026-01-04 13:53:23'),(21,7,46,4,48,'2026-01-04 13:55:12'),(22,8,0,1,24,'2026-01-05 04:06:04'),(23,8,38,4,48,'2026-01-05 04:06:55'),(24,9,0,1,24,'2026-01-05 06:33:26'),(25,9,28,3,44,'2026-01-05 06:34:37'),(26,9,40,2,34,'2026-01-05 06:35:11'),(27,10,36,4,48,'2026-01-05 07:24:32'),(28,11,0,1,28,'2026-01-05 09:08:08');
/*!40000 ALTER TABLE `rounds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Chaitu4206','$2y$10$Ah2RCzEH5p3JqxNTWb.L0uQiATGnhw87sZMoRursjPjAMWUrXtLIW','2025-11-16 09:27:09'),(2,'chaitu','$2y$10$uSh64Z.criZQ0eRzsnl3Qe7NJr.sOIUuk7uw4swWbNeA9g.dXQHd.','2025-12-03 06:27:54'),(3,'chaitu1235','$2y$10$ZVdQ9aWiqeqGDLOG0sni0ebPYQq6Rr5FZh6m4BTeqS/niQAQHNU/6','2025-12-03 06:31:29'),(4,'chaitu42','$2y$10$GmUo9oFIGL1eSrzDANKpSecDS.qh4jKXGtmLp5bpCpxrmiYDiuHaO','2025-12-04 13:35:02'),(5,'Uma0826','$2y$10$60ZjEfBxzDsgWupZ/nmZ/.DI6fpclRF8iTiaELr2ZWXj3b3OlE5z6','2025-12-04 21:44:01'),(6,'chaitu1234','$2y$10$MbolsXMcLBSCsDtSoC.ltudJoWtQzAVzE5tNgHxC/lkqwZwmsrf2K','2026-01-03 13:09:24'),(7,'pratyush1234','$2y$10$VHN7OkyT5FYRtGjshiktZONgIfVjRc8vONi.9GTywf.oPjCnMK9xC','2026-01-04 13:52:48'),(8,'ooo','$2y$10$f/W64lF6vcb.5GBAJLS9mOmnCSwNz7.EKqLCn9jxhV3tqQkJxscz6','2026-01-05 04:05:23'),(9,'qwertuy','$2y$10$jMg/7JHK0sKSdZL3gjgbrOdppUDS2x7NKw/6MJ0QSPzd0OlPnQXUG','2026-01-05 06:32:43'),(10,'rajeev','$2y$10$pGxzT6FFzZMNtcBq.8bXlOrdebrzebDJhLqOutv8.hTeL36xQqfbC','2026-01-05 07:23:13'),(11,'raj','$2y$10$llGu/pw4vIMyAV9tB7LToe/D4O7CbTQleP3Lc4yaaqqMuWLVLdakq','2026-01-05 09:07:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `words`
--

DROP TABLE IF EXISTS `words`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `words` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `text` (`text`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `words`
--

LOCK TABLES `words` WRITE;
/*!40000 ALTER TABLE `words` DISABLE KEYS */;
INSERT INTO `words` VALUES (9,'animal'),(10,'bird'),(12,'cloud'),(16,'earth'),(3,'fish'),(7,'forest'),(5,'lake'),(8,'leaf'),(20,'life'),(15,'light'),(18,'mountain'),(1,'ocean'),(13,'rain'),(4,'river'),(17,'rock'),(11,'sky'),(14,'sun'),(6,'tree'),(2,'water'),(19,'wind');
/*!40000 ALTER TABLE `words` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-17 21:42:10
