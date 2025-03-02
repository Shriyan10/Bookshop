-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: book_shop
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `payment_details`
--

DROP TABLE IF EXISTS `payment_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `payment_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `book_id` (`product_id`),
  KEY `payment_id` (`payment_id`),
  CONSTRAINT `payment_details_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`),
  CONSTRAINT `payment_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_details`
--

LOCK TABLES `payment_details` WRITE;
/*!40000 ALTER TABLE `payment_details` DISABLE KEYS */;
INSERT INTO `payment_details` VALUES (1,13042,1),(2,13055,1),(3,13056,1),(4,13008,1),(5,13302,1),(6,13303,1),(7,13043,2),(8,13057,2),(9,13058,2),(10,13009,2),(11,13304,2),(12,13305,2),(13,13031,3),(14,13012,4),(15,13014,4),(16,13032,5),(17,13015,5),(18,13059,6),(19,13060,6),(20,13061,6),(21,13062,6),(22,13044,7),(23,13045,7),(24,13046,8),(25,13047,8),(26,13048,8),(27,13049,8),(28,13050,8),(29,13051,8),(30,13052,8),(31,13165,8),(32,13166,8),(33,13167,8),(34,13168,8),(35,13169,8),(36,13170,8),(37,13171,8),(38,13172,8),(39,13173,8),(40,13174,8),(41,13175,8),(42,13176,8),(43,13177,8),(44,13178,8),(45,13179,8),(46,13180,8),(47,13181,8),(48,13182,8),(49,13183,8),(50,13184,8),(51,13185,8),(52,13186,8),(53,13187,8),(54,13188,8),(55,13189,8),(56,13190,8),(57,13191,8),(58,13192,8),(59,13193,8),(60,13194,8),(61,13195,8),(62,13196,8),(63,13197,8),(64,13198,8),(65,13199,8),(66,13200,8),(67,13201,8),(68,13202,8),(69,13203,8),(70,13204,8),(71,13205,8),(72,13206,8),(73,13207,8),(74,13208,8),(75,13209,8),(76,13210,8),(77,13211,8),(78,13212,8),(79,13213,8),(80,13214,8),(81,13215,8),(82,13216,8),(83,13217,8),(84,13218,8),(85,13219,8),(86,13220,8),(87,13221,8),(88,13222,8),(89,13223,8),(90,13224,8),(91,13225,8),(92,13226,8),(93,13227,8),(94,13228,8),(95,13229,8),(96,13230,8),(97,13231,8),(98,13232,8),(99,13233,8),(100,13234,8),(101,13235,8),(102,13236,8),(103,13237,8),(104,13238,8),(105,13239,8),(106,13240,8),(107,13241,8),(108,13242,8),(109,13243,8),(110,13244,8),(111,13245,8),(112,13246,8),(113,13247,8),(114,13248,8),(115,13249,8),(116,13250,8),(117,13251,8),(118,13252,8),(119,13253,8),(120,13254,8),(121,13255,8),(122,13256,8),(123,13257,8),(124,13258,8),(125,13259,8),(126,13260,8),(127,13261,8),(128,13262,8),(129,13263,8),(130,13264,8),(131,13265,8),(132,13266,8),(133,13267,8),(134,13268,8),(135,13269,8),(136,13270,8),(137,13271,8),(138,13272,8),(139,13273,8),(140,13274,8),(141,13275,8),(142,13276,8),(143,13277,8),(144,13278,8),(145,13279,8),(146,13280,8),(147,13281,8),(148,13282,8),(149,13283,8),(150,13284,8),(151,13285,8),(152,13286,8),(153,13287,8),(154,13016,9),(155,13033,10),(156,13500,11),(157,13017,12),(158,13034,12);
/*!40000 ALTER TABLE `payment_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total_cost` int NOT NULL,
  `delivery_charge` int DEFAULT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_user_id_user_id_fk` (`user_id`),
  CONSTRAINT `payment_user_id_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,5533,NULL,42),(2,5533,NULL,42),(3,811,NULL,42),(4,2000,NULL,42),(5,2622,NULL,42),(6,3244,NULL,42),(7,1622,NULL,42),(8,105430,NULL,42),(9,1000,NULL,42),(10,811,NULL,43),(11,811,NULL,43),(12,1900,NULL,43);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_details`
--

DROP TABLE IF EXISTS `product_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(200) DEFAULT NULL,
  `description` text,
  `distributor` varchar(20) DEFAULT NULL,
  `price` int DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_details`
--

LOCK TABLES `product_details` WRITE;
/*!40000 ALTER TABLE `product_details` DISABLE KEYS */;
INSERT INTO `product_details` VALUES (4,'Harry Potter','Omnis non ipsam non ','Tenetur fugiat sit q','Similique nostrum qu',1000,'https://res.cloudinary.com/bloomsbury-atlas/image/upload/w_360,c_scale,dpr_1.5/jackets/9781408855652.jpg'),(5,'Narnia','asdf','Tenetur fugiat sit q','Similique nostrum qu',900,'https://m.media-amazon.com/images/I/91jlAlsTYzL._SL1500_.jpg'),(7,'Karnali Blues','Buddhisagar\n','Tenetur fugiat sit q','Similique nostrum qu',811,'https://media.thuprai.com/front_covers/Karnali_Blues_-_english_-_Buddhisagar.jpeg'),(8,'Atomic Habits','Omnis non ipsam non ','Tenetur fugiat sit q','Similique nostrum qu',811,'https://media.thuprai.com/front_covers/atomic-habits-f.jpg'),(9,'A Little Life','Omnis non ipsam non ','Tenetur fugiat sit q','Similique nostrum qu',811,'https://i5.walmartimages.com/seo/A-Little-Life-Paperback-9780804172707_439b6aba-8aae-4a38-a546-ac12005ffa5d.b60cf8ff89be31dca23dadaab0215353.jpeg'),(10,'Ijoriya','asdf','Tenetur fugiat sit q','ttyh',811,'https://media.thuprai.com/front_covers/Ijoriya_by_subin_bhattarai_-f.jpg'),(11,'Before the Coffee Gets Cold','sacf','vfre','rth',1050,'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1704153539i/44421460.jpg'),(12,'Nexus','dssdvs','sdvfv','svfwef',900,'https://books.bizmandala.com/media/books/9781911717096/9781911717096-5770.webp'),(13,'Rich Dad Poor Dad','tynndn','erjvgiu','oeruighiu',850,'https://media.thuprai.com/front_covers/rich-dad-poor-dad-ezspgvh2.jpg'),(14,'Think and Grow Rich','fghg','uyk','tyjy',500,'https://m.media-amazon.com/images/I/61IxJuRI39L._AC_UF1000,1000_QL80_.jpg'),(15,'Rewind','Shriyan','the description','Shriyan',999,'https://m.media-amazon.com/images/I/71lxpZEFVpL._AC_UF1000,1000_QL80_.jpg'),(16,'Daredevil','Paul Crilley','A guilt-ridden father. A harsh mentor. A passionate lover.','Amazon',800,'https://m.media-amazon.com/images/I/51IIqbv2uEL._SY445_SX342_.jpg');
/*!40000 ALTER TABLE `product_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status` enum('SOLD','AVAILABLE','DAMAGED') DEFAULT 'AVAILABLE',
  `product_detail_id` int NOT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `book_detail_id` (`product_detail_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_detail_id`) REFERENCES `product_details` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13611 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (13577,'AVAILABLE',4,'2025-03-02 16:17:54',NULL),(13578,'AVAILABLE',4,'2025-03-02 16:17:54',NULL),(13579,'AVAILABLE',4,'2025-03-02 16:17:54',NULL),(13580,'AVAILABLE',5,'2025-03-02 16:18:03',NULL),(13581,'AVAILABLE',5,'2025-03-02 16:18:03',NULL),(13582,'AVAILABLE',5,'2025-03-02 16:18:03',NULL),(13583,'AVAILABLE',7,'2025-03-02 16:18:28',NULL),(13584,'AVAILABLE',7,'2025-03-02 16:18:28',NULL),(13585,'AVAILABLE',7,'2025-03-02 16:18:28',NULL),(13586,'AVAILABLE',8,'2025-03-02 16:18:44',NULL),(13587,'AVAILABLE',8,'2025-03-02 16:18:44',NULL),(13588,'AVAILABLE',8,'2025-03-02 16:18:44',NULL),(13589,'AVAILABLE',9,'2025-03-02 16:18:57',NULL),(13590,'AVAILABLE',9,'2025-03-02 16:18:57',NULL),(13591,'AVAILABLE',9,'2025-03-02 16:18:57',NULL),(13592,'AVAILABLE',10,'2025-03-02 16:19:12',NULL),(13593,'AVAILABLE',10,'2025-03-02 16:19:12',NULL),(13594,'AVAILABLE',10,'2025-03-02 16:19:12',NULL),(13595,'AVAILABLE',11,'2025-03-02 16:19:24',NULL),(13596,'AVAILABLE',11,'2025-03-02 16:19:24',NULL),(13597,'AVAILABLE',11,'2025-03-02 16:19:24',NULL),(13598,'AVAILABLE',12,'2025-03-02 16:19:58',NULL),(13599,'AVAILABLE',12,'2025-03-02 16:19:58',NULL),(13600,'AVAILABLE',12,'2025-03-02 16:19:58',NULL),(13601,'AVAILABLE',13,'2025-03-02 16:20:10',NULL),(13602,'AVAILABLE',13,'2025-03-02 16:20:10',NULL),(13603,'AVAILABLE',13,'2025-03-02 16:20:10',NULL),(13604,'AVAILABLE',14,'2025-03-02 16:20:18',NULL),(13605,'AVAILABLE',14,'2025-03-02 16:20:18',NULL),(13606,'AVAILABLE',14,'2025-03-02 16:20:18',NULL),(13607,'AVAILABLE',15,'2025-03-02 16:20:25',NULL),(13608,'AVAILABLE',15,'2025-03-02 16:20:25',NULL),(13609,'AVAILABLE',15,'2025-03-02 16:20:25',NULL),(13610,'AVAILABLE',16,'2025-03-02 16:24:48',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'ADMIN'),(2,'CUSTOMER');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int DEFAULT NULL,
  `address` varchar(50) NOT NULL,
  `contact_no` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jenette','Walls','myfeqamyh@mailinator.com','$2y$10$HVW258KCSqopaW9gU6vMFOx.aImhka1vF57E2fiY4/vKhDLAuHkjq',2,'Labore quibusdam exp',43543),(4,'Veronica','Bauer','hisohinava@mailinator.com','$2y$10$HVW258KCSqopaW9gU6vMFOx.aImhka1vF57E2fiY4/vKhDLAuHkjq',2,'Laudantium temporib',123),(8,'Inez','Valdez','ryduqylu@mailinator.com','$2y$10$HVW258KCSqopaW9gU6vMFOx.aImhka1vF57E2fiY4/vKhDLAuHkjq',2,'Veniam voluptas lab',2536),(9,'Freya','Guerra','caqok@mailinator.com','$2y$10$HVW258KCSqopaW9gU6vMFOx.aImhka1vF57E2fiY4/vKhDLAuHkjq',2,'Totam ex elit commo',8989),(11,'Shriyan','Bajracharya','shriyan123@gmail.com','$2y$10$HVW258KCSqopaW9gU6vMFOx.aImhka1vF57E2fiY4/vKhDLAuHkjq',1,'Patan',987),(13,'Calvin','Wilkerson','humojovy@mailinator.com','$2y$10$HVW258KCSqopaW9gU6vMFOx.aImhka1vF57E2fiY4/vKhDLAuHkjq',1,'Dolor culpa veritat',9855),(15,'Samson','Graves','admin@admin.com','$2y$10$HVW258KCSqopaW9gU6vMFOx.aImhka1vF57E2fiY4/vKhDLAuHkjq',1,'Illum vero inventor',123123123),(17,'Shriyan','Bajracharya','shri@baj.com','$2y$10$HVW258KCSqopaW9gU6vMFOx.aImhka1vF57E2fiY4/vKhDLAuHkjq',1,'Rem iure et soluta a',123456),(31,'Robert','Rivers','periwa@mailinator.com','$2y$10$ODKXrPXstIUelGKZxvYQ6exn7o.5XF.Kg6XdQ1s/v8jVqP.bcnuQu',NULL,'Nulla tempora deleni',1231),(32,'Amal','Dyer','xodoxijyj@mailinator.com','$2y$10$QcmFFWrhHAULHwM8iJJMXujZDntNN6E2o4yN/mNpLg.0SWvSVNEtG',NULL,'Mollitia sed tempori',4564),(33,'Edward','Lott','kyfime@mailinator.com','$2y$10$EGnF3GQZrcR2eEUHW27Q1ukJJFyYficuG/uFalHo5F2ICFmQqdgfu',NULL,'Omnis a obcaecati se',878978),(34,'Drake','Larson','quva@mailinator.com','$2y$10$b227bJtBdIgRa0HpGg7WZO7C2FhJr03dAChMQcN5TTb1CMfs2WeZS',NULL,'Ducimus ullam dolor',456465),(35,'Sushant','Shakya','sus@cus.com','$2y$10$Dzc2uNFh7w39J6s1p35JQOWLKUSQn7IWpyV1HRi4BbTIxYCmWSII6',NULL,'KTM',123123),(36,'sayub','asd','sayub@pus.com','$2y$10$KFd7RLIRVo/pZqnIWvx3luVySh8axuoEoX8hJ79kmBi/LszF/8zIS',NULL,'KTM',12345),(37,'aarash','shakya','aarsh@thick.com','$2y$10$w7395GCZU/HMO0F.B4t2L.UK4gTz0AZxEJj2mKYP49M/jg6gKG3hi',NULL,'KTM',12345),(41,'April','Nieves','dajety@mailinator.com','$2y$10$YFnXwK4B5com1prMyE35J.0IN.02uL7ZmMsUO8tAzZtWnarxPluzm',2,'Occaecat sequi ipsam',32151),(42,'Customer','Flores','customer@customer.com','$2y$10$zH5kuxccsRy1SwIv3Vu2/.n1zrv4MsZMGSL/89sYR6YYI.jCgeikO',2,'Adipisci cumque culp',33332),(43,'Shriyan','Bajracharya','shriyan@bajra.com','$2y$10$AjBDEJR9vT2AHdJZjxEcXuQvHb/UDdbvrtUbfb1cdkGwZj5im./p.',2,'Patan',980010001),(44,'Shriyan','Bajracharya','shriyan@bajra.com','$2y$10$0RzjhUywO0ceQ6j.fr3JKeMYTBIZkcmmOCjlR9AA61s0ZZbdVVN9K',2,'Patan',980010001),(46,'Admin','Shriyan','admin@shriyan.com','$2y$10$TXb/4/0ureYnKZ5tQ0sUVeFF/Ze/UcG0hbPXPgR5Pg1NN51ztjyyK',1,'Patan',980012012),(47,'a','b','a@b.com','$2y$10$RsuBR.eVNq.H/sbFICGwjO.UyLADblT6RmHlaMV0R3SpzF8ySRp4.',2,'ktm',1234567890);
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

-- Dump completed on 2025-03-02 22:15:06
