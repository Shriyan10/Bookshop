-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: handicraft_db
-- ------------------------------------------------------
-- Server version	8.0.41

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
DROP DATABASE IF EXISTS handicraft;
CREATE DATABASE handicraft;
USE book_shop;
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_details`
--

LOCK TABLES `payment_details` WRITE;
/*!40000 ALTER TABLE `payment_details` DISABLE KEYS */;
INSERT INTO `payment_details` VALUES (2,6,5),(3,11,5),(4,9,6),(5,10,7),(6,12,8),(7,3,9),(8,4,9),(9,22,10),(10,16,13),(11,17,14),(12,18,19),(13,19,20),(14,110,20),(15,111,20),(16,112,20),(17,20,21),(18,21,21);
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,20000,NULL,2),(2,54000,NULL,2),(3,54000,NULL,2),(4,54000,NULL,2),(5,40000,NULL,2),(6,32000,NULL,2),(7,32000,NULL,2),(8,20000,NULL,2),(9,40000,NULL,2),(10,18000,NULL,2),(11,0,NULL,2),(12,0,NULL,2),(13,20000,NULL,2),(14,20000,NULL,2),(15,0,NULL,2),(16,0,NULL,2),(17,0,NULL,2),(18,0,NULL,2),(19,20000,NULL,2),(20,80000,NULL,2),(21,60000,NULL,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_details`
--

LOCK TABLES `product_details` WRITE;
/*!40000 ALTER TABLE `product_details` DISABLE KEYS */;
INSERT INTO `product_details` VALUES (1,'Shakyamuni Buddha','Bodhi Raj','<h2><strong style=\"background-color: rgb(255, 255, 255); color: var(--heading-color);\">Handmade Master Buddha Guru Rinpoche Statue | 24K Gold Gilded Sculpture</strong></h2><p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\">This Master Buddha Guru Rinpoche Sculpture symbolizes the </strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\">founder of Tibetan Buddhism and a master of spiritual transformation. This statue measures 15”/38 cm (Height) x 9.3”/23.5 cm (Base) Weight: 4.93 kg. This work of art has a copper body and is gilded in a triple layer of 24K gold, which is further enhanced with acrylic and gold paints. We can see Silver Plated to and adorned with gemstones. This item, Crafted by expert Nepalese artisans, this sacred item embodies the rich traditions of Himalayan Buddhism, making it an important addition to altars, meditation areas, or sacred collections.</span></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\">Guru Rinpoche is represented sitting in a royal posture, presenting confidence and spiritual mastery. His right hand holds a vajra, which represents indestructible power while his left hand holds a skull cup (kapala) filled with the nectar of wisdom. The khatvanga, a trident ornamented with symbolic components reflecting his tantric attainment and the union of wisdom and compassion, rests on his left shoulder.</span></p><p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\">Size:</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\"> 15”/38 cm (Height) x 9.3”/23.5 cm (Base)</span></p><p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\">Weight:</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\"> 4.93 kg</span></p><p><strong style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\">Material:</strong><span style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\"> 24K Gold Gilded, Gold &amp; Acrylic Paintings, Copper </span><em style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\">Body, Silver Plated, Hand Carved Gemstones </em></p><p><em style=\"background-color: rgb(255, 255, 255); color: rgb(103, 114, 121);\">In Tibetan Buddhism, Guru Rinpoche, also called Padmasambhava, is a highly esteemed figure who is frequently referred to as the \"Second Buddha\" due to his pivotal role in bringing Buddhism to Tibet. Samye Monastery, the first Buddhist monastery in Tibet, was able to be built because he is credited with driving out local spirits and impediments. The core teachings of Tibetan Buddhism are those of Guru Rinpoche, who brought Vajrayana (Tantric) Buddhism to Tibet and blended it with the native Bon tradition. He is revered for his mastery of spiritual practices and his significant influence on the development of Tibetan Buddhism. His legacy comprises a multitude of teachings and books.</em></p><p><br></p>','123123',20000,'https://www.termatree.com/cdn/shop/files/ShakyamuniBuddhaStatue_cb953922-0122-4ae3-844e-ab7f37c7cbc7_800x.jpg?v=1732619561'),(2,'Chenrezig','Bodhi Raj','RajHandi','123123',20000,'https://www.termatree.com/cdn/shop/files/ChenrezigStatue_9ab064f3-9c3e-4d1b-988c-9a3365f58f8b_800x.jpg?v=1709720153'),(3,'Guru Urgen Norlaa','Bodhi Raj','RajHandi','123123',18000,'https://www.termatree.com/cdn/shop/files/GuruOrgenNorlaStatue_800x.jpg?v=1693135000'),(4,' Amitabha Buddha','Bodhi Raj','RajHandi','123123',32000,'https://www.termatree.com/cdn/shop/files/10854_14of16_600x.jpg?v=1736332123'),(5,'Kshitigarbha Bodhisattva','Bodhi Raj','RajHandi','123123',24000,'https://www.termatree.com/cdn/shop/files/9424-18_600x.jpg?v=1727177322'),(6,'Amitayus','Bodhi Raj','RajHandi','123123',20000,'https://www.termatree.com/cdn/shop/files/AmitayusStatue_d6a9f415-8c15-453c-add5-f88a6bd857a4.jpg?v=1721025489'),(8,'Ganesh ','bodhiraj','lord shiva son','parbati',20000,'https://luckythanka.com/cdn/shop/products/il_fullxfull.4193920832_jgqy.jpg?v=1664193629'),(9,'shiva','bodhiraj','lord bhramha son','bhramhas wife',10000,'https://i0.wp.com/sakshizion.com/wp-content/uploads/2017/06/20218_3988514079074_1523371036_n.jpg'),(10,'Pariatur Recusandae','Amet labore dolore ','Ducimus incididunt ','Excepteur distinctio',685,'Mollit reprehenderit'),(11,'Ut nemo voluptas est','Magnam sapiente maxi','Expedita quo dolorem','Voluptatem reiciendi',856,'Recusandae Voluptat'),(12,'Facere autem culpa ','Lorem voluptate ad n','Sit aliqua Nihil si','Blanditiis qui sunt ',348,'Labore aute laborios'),(13,'Facere autem culpa2','Lorem voluptate ad n','Sit aliqua Nihil si','Blanditiis qui sunt ',348,'Labore aute laborios');
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
) ENGINE=InnoDB AUTO_INCREMENT=140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (3,'SOLD',1,'2025-02-26 08:11:14','2025-02-28 03:31:01'),(4,'SOLD',1,'2025-02-26 08:11:14','2025-02-28 03:31:01'),(5,'SOLD',2,'2025-02-26 08:11:28','2025-02-26 08:50:44'),(6,'SOLD',2,'2025-02-26 08:11:28','2025-02-26 08:55:34'),(7,'SOLD',3,'2025-02-26 08:11:32','2025-02-26 08:52:07'),(8,'SOLD',3,'2025-02-26 08:11:32','2025-02-26 08:52:07'),(9,'SOLD',4,'2025-02-26 08:11:38','2025-02-26 16:13:48'),(10,'SOLD',4,'2025-02-26 08:11:38','2025-02-27 02:22:51'),(11,'SOLD',2,'2025-02-26 08:11:41','2025-02-26 08:55:34'),(12,'SOLD',2,'2025-02-26 08:11:41','2025-02-27 02:29:36'),(13,'SOLD',3,'2025-02-26 08:11:44','2025-02-26 08:52:07'),(14,'SOLD',3,'2025-02-26 08:11:44','2025-02-26 08:53:52'),(15,'AVAILABLE',6,'2025-02-26 08:12:34',NULL),(16,'SOLD',2,'2025-02-27 15:45:15','2025-03-11 10:44:30'),(17,'SOLD',2,'2025-02-27 15:45:15','2025-03-11 10:45:35'),(18,'SOLD',1,'2025-02-28 09:29:17','2025-03-11 10:52:44'),(19,'SOLD',1,'2025-02-28 09:29:17','2025-03-12 01:02:03'),(20,'SOLD',2,'2025-02-28 09:29:24','2025-03-21 03:27:22'),(21,'SOLD',2,'2025-02-28 09:29:24','2025-03-21 03:27:22'),(22,'SOLD',3,'2025-02-28 09:29:30','2025-03-11 10:43:33'),(23,'AVAILABLE',3,'2025-02-28 09:29:30',NULL),(24,'AVAILABLE',4,'2025-02-28 09:29:37',NULL),(25,'AVAILABLE',4,'2025-02-28 09:29:37',NULL),(26,'AVAILABLE',5,'2025-02-28 09:29:47',NULL),(27,'AVAILABLE',5,'2025-02-28 09:29:47',NULL),(28,'AVAILABLE',6,'2025-02-28 09:29:52',NULL),(29,'AVAILABLE',6,'2025-02-28 09:29:52',NULL),(30,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(31,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(32,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(33,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(34,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(35,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(36,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(37,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(38,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(39,'AVAILABLE',11,'2025-02-28 09:46:47',NULL),(50,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(51,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(52,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(53,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(54,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(55,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(56,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(57,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(58,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(59,'AVAILABLE',13,'2025-02-28 10:41:00',NULL),(60,'AVAILABLE',12,'2025-02-28 10:41:08',NULL),(61,'AVAILABLE',12,'2025-02-28 10:41:08',NULL),(62,'AVAILABLE',12,'2025-02-28 10:41:08',NULL),(63,'AVAILABLE',12,'2025-02-28 10:41:08',NULL),(64,'AVAILABLE',12,'2025-02-28 10:41:09',NULL),(65,'AVAILABLE',12,'2025-02-28 10:41:09',NULL),(66,'AVAILABLE',12,'2025-02-28 10:41:09',NULL),(67,'AVAILABLE',12,'2025-02-28 10:41:09',NULL),(68,'AVAILABLE',12,'2025-02-28 10:41:09',NULL),(69,'AVAILABLE',12,'2025-02-28 10:41:09',NULL),(70,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(71,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(72,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(73,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(74,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(75,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(76,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(77,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(78,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(79,'AVAILABLE',11,'2025-02-28 10:41:18',NULL),(80,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(81,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(82,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(83,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(84,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(85,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(86,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(87,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(88,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(89,'AVAILABLE',10,'2025-02-28 10:41:26',NULL),(90,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(91,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(92,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(93,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(94,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(95,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(96,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(97,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(98,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(99,'AVAILABLE',9,'2025-02-28 10:41:39',NULL),(100,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(101,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(102,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(103,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(104,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(105,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(106,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(107,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(108,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(109,'AVAILABLE',8,'2025-02-28 10:41:45',NULL),(110,'SOLD',1,'2025-03-12 01:01:34','2025-03-12 01:02:03'),(111,'SOLD',1,'2025-03-12 01:01:34','2025-03-12 01:02:03'),(112,'SOLD',1,'2025-03-12 01:01:34','2025-03-12 01:02:03'),(113,'AVAILABLE',1,'2025-03-12 01:01:34',NULL),(114,'AVAILABLE',1,'2025-03-12 01:01:34',NULL),(115,'AVAILABLE',1,'2025-03-12 01:01:34',NULL),(116,'AVAILABLE',1,'2025-03-12 01:01:34',NULL),(117,'AVAILABLE',1,'2025-03-12 01:01:35',NULL),(118,'AVAILABLE',1,'2025-03-12 01:01:35',NULL),(119,'AVAILABLE',1,'2025-03-12 01:01:35',NULL),(120,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(121,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(122,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(123,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(124,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(125,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(126,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(127,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(128,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(129,'AVAILABLE',1,'2025-03-20 01:21:01',NULL),(130,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(131,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(132,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(133,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(134,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(135,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(136,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(137,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(138,'AVAILABLE',3,'2025-03-21 03:28:25',NULL),(139,'AVAILABLE',3,'2025-03-21 03:28:25',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `contact_no` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Sushant','admin','admin@admin.com','$2y$10$0fYZt1LKeCgu/AfzrMeflu7EQXRhqae9EMRbk46aEJ4U8Hy/9KAfy',1,'KTM',123123),(2,'Sushant','Shakya','sushantshakya191@gmail.com','$2y$10$0fYZt1LKeCgu/AfzrMeflu7EQXRhqae9EMRbk46aEJ4U8Hy/9KAfy',2,'Chyasal,Lalitpur',123123),(4,'Sushant','Shakya','sushantshakya191@gmail.com','$2y$10$zINpYreERyBK/Vp7DlHWS.DIvk7XUBbHXdr.x3Re0nPMrfZquzClK',2,'Chyasal,Lalitpur',23432534),(6,'Sushant','Shakya','sushantshakya191@gmail.com','$2y$10$ozESHkacTKQ/sEic54WqCOI384.DRGJrV.RtUN6pmACECnI.eDjMy',2,'Chyasal,Lalitpur',999999),(7,'Sushant','Shakya','sushantshakya1@gmail.com','$2y$10$4MA1hIFw.H58MHzHDP2HJe628yESD8B.p2KycixwT6YfjCckHZKb2',2,'Chyasal,Lalitpur',9818760451),(8,'Sushant','Shakya','sushantshakya1@gmail.com','$2y$10$hbW1N8NI8Bbq6tz680P7iewpniBiZ.pWO.quUzlyeKcSCzzO4N4UW',2,'Chyasal,Lalitpur',9818760451),(9,'','Shakya','sushantshakya191@gmail.com','$2y$10$5tdELEGZQRn0JQ.bfor3ieLkUYb0RWaeW/QcnXbkLWmjr.HJ2taym',2,'Chyasal,Lalitpur',9818760451),(10,'Mallory','Best','hicydofuf@mailinator.com','$2y$10$tblskrR7boSc7aYfsP1ag..D/4LeXneBlEMAQMDZou9luzpQcGIYe',2,'Quidem id id recus',28),(11,'Shakya','Shakya','sushantshakya00@gmail.com','$2y$10$dw1qDMf6oI2Rs4GPeVhYBuGLTOnBYkoUZT2V/Q0EPgsvi9YzQCo8i',2,'Chyasal,Lalitpur',0),(12,'Padam','Shakya','padamshakya191@gmail.com','$2y$10$IxU.AA9Z1hFUhxWxk7rYfevJ3WEWwigQyohao6vdhkMLHA7VRNp6C',2,'Chyasal,Lalitpur',981876045),(13,'Padam','Shakya','padamshakya191@gmail.com','$2y$10$7tBfIWaiUxj5aGe9aAda8O3XvSclRzWT3Mt6JXvMEkT9YuWYg.h8a',2,'Chyasal,Lalitpur',981876045),(14,'shriyan','Shakya','shriyanshakya191@gmail.com','$2y$10$c4ZQs8XdlsSd6q5rDxMWCO47ByczjeBHiB1cUCAegnR1mX9Ie.2vC',2,'Chyasal,Lalitpur',981876),(15,'shriyan','Shakya','shriyanshakya191@gmail.com','$2y$10$Vd9cZythUvGzZd7tVaav3O4zcL3zItEqL8HWi700OUNI/8JwYJsbK',2,'Chyasal,Lalitpur',98187604),(16,'Sushant','Shakya','sushantshakya33@gmail.com','$2y$10$BltnEZvOY3p9g/VdMwOLXO2gpMLRDmwPW1QvfqHOvMl/f5.zFeGeO',2,'Chyasal,Lalitpur',981876045),(17,'Sushant','Shakya','sushantshakya10@gmail.com','$2y$10$ZaYf1v9XJbXU99Vaor/ZyumPJEQzQi/HONilD5vSza/JNEt/CQZ0G',2,'Chyasal,Lalitpur',98187604516);
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

-- Dump completed on 2025-03-21 14:26:21
