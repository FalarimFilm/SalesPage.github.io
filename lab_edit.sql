-- MySQL dump 10.13  Distrib 8.0.36, for macos14 (arm64)
--
-- Host: 127.0.0.1    Database: lab_edit
-- ------------------------------------------------------
-- Server version	5.7.38

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
-- Table structure for table `cart_product`
--

DROP TABLE IF EXISTS `cart_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `amont` int(11) NOT NULL DEFAULT '1',
  `price` decimal(15,2) NOT NULL,
  `cart_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_has_carts_products1_idx` (`product_id`),
  KEY `fk_products_has_carts_cart1_idx` (`cart_id`),
  CONSTRAINT `fk_products_has_carts_cart1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_products_has_carts_products1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_product`
--

LOCK TABLES `cart_product` WRITE;
/*!40000 ALTER TABLE `cart_product` DISABLE KEYS */;
INSERT INTO `cart_product` VALUES (17,14,1,555.00,2);
/*!40000 ALTER TABLE `cart_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `total_price` bigint(50) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_cart_shop_id_idx` (`user_id`),
  CONSTRAINT `fk_cart_shop_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,0,1,'2022-10-21 18:18:44','2024-02-07 08:23:04'),(2,0,2,'2022-10-21 18:18:44','2024-02-07 05:18:54'),(3,0,5,'2022-10-21 18:18:44','2022-10-21 18:18:44');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_code_unique` (`code`),
  KEY `categories_created_at_index` (`created_at`),
  KEY `categories_updated_at_index` (`updated_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'2022-10-18 07:38:25','2022-10-18 07:38:25','CT001','PHP','PHP category'),(2,'2022-10-18 07:38:25','2022-10-18 07:38:25','CT002','JavaScript','JavaScript category'),(3,'2022-10-18 07:38:25','2022-10-18 07:38:25','CT003','Python','Python category');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_code_unique` (`code`),
  KEY `products_created_at_index` (`created_at`),
  KEY `products_updated_at_index` (`updated_at`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `fk_products_shops1_idx` (`shop_id`),
  CONSTRAINT `fk_products_shops1` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (2,'2021-01-31 18:35:51','2021-01-31 18:35:52','PD002','JavaScript: The Definitive Guide',2,250.00,'JavaScript is the programming language of the web and is used by more\r\nsoftware developers today than any other programming language.\r\nFor nearly 25 years this best seller has been the go-to guide for\r\nJavaScript programmers. The seventh edition is fully updated to cover\r\nthe 2020 version of JavaScript, and new chapters cover:\r\nclasses\r\nmodules\r\niterators\r\ngenerators\r\nPromises\r\nasync/await\r\nand metaprogramming.\r\nYou’ll find illuminating and engaging example code throughout.',2),(3,'2021-01-31 18:37:17','2021-01-31 18:37:18','PD003','Learning PHP, MySQL & JavaScript',2,450.00,'Build interactive, data driven websites with the potent combination\r\nof open source technologies and web standards, even if you have only\r\nbasic HTML knowledge. In this update to this popular hands on guide,\r\nyou’ll tackle dynamic web programming with the latest versions of\r\ntoday’s core technologies:\r\nPHP\r\nMySQL\r\nJavaScript\r\nCSS\r\nHTML5\r\nand key jQuery libraries.',3),(4,'2021-01-31 18:38:27','2021-01-31 18:38:28','PD004','Python Crash Course, 2nd Edition',3,560.00,'In the first half of the book, you\'ll learn basic programming concepts,\r\nsuch as variables, lists, classes, and loops, and practice writing\r\nclean code with exercises for each topic. You\'ll also learn how to make\r\nyour programs interactive and test your code safely before adding it to\r\na project. In the second half, you\'ll put your new knowledge into\r\npractice with three substantial projects:\r\na Space Invaders-inspired arcade game\r\na set of data visualizations with Python\'s handy libraries\r\nand a simple web app you can deploy online.',2),(5,'2022-10-18 07:35:54','2022-10-18 07:35:54','PD101','Web Security for Developers',1,758.55,'You will learn how to:\r\n	Protect against SQL injection attacks, malicious JavaScript, and cross-site request forgery\r\n	Add authentication and shape access control to protect accounts\r\n	Lock down user accounts to prevent attacks that rely on guessing passwords, stealing sessions,\r\n	or escalating privileges\r\n	Implement encryption\r\n	Manage vulnerabilities in legacy code\r\n	Prevent information leaks that disclose vulnerabilities\r\n	Mitigate advanced attacks like malvertising and denial-of-service',2),(6,'2022-10-18 07:35:54','2022-10-18 07:35:54','PD102','How To Be A Web Developer In 90 Days',1,1369.18,'You are going to enjoy this book because I have made coding fun by doing\r\nsomething that has never been done before. I’ve included animations that\r\nexplain daily lessons. You will also receive a free 15 minute live chat\r\nwith a Certified Web Developer. Plus, you can learn at your own pace.\r\nIf you need additional help, there’s an option to attend live online classes.\r\nAt the end of this book, for your final project,you will build your own website.',3),(7,'2022-10-18 07:35:54','2022-10-18 07:35:54','PD103','Web Developer',1,892.72,'A web developer is a highly skilled professional who is trained to design and\r\nmanage websites for companies and individuals. A career in this field is a perfect\r\nchoice for those who are interested in computer science and the marketing of\r\nproducts and services. In this book, you will learn about the job duties of a web\r\ndeveloper, how to prepare for a career in the field, key skills for success,\r\nmethods of exploring this interesting occupation, and much more. Web Developer\r\nis just one of many exciting titles in the Careers with Earning Potential series.\r\nReaders will discover a range of careers that typically do not require a\r\nbachelor\'s degree but provide a good middle-class income. There is also a title\r\nin the series, Become Invaluable in the Workplace: Set Yourself Apart, that teaches\r\nthem how to present themselves professionally in their job application materials.',3),(10,'2022-10-21 13:16:49','2022-10-21 13:16:49','oopo8','ytfuyghuijkop',2,888.00,'tdryftuyghijok[lploimygvtrtc',10),(14,'2022-10-27 06:13:31','2022-10-27 06:13:31','5555','55',1,555.00,'5555',2);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shops`
--

DROP TABLE IF EXISTS `shops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shops` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shops_code_unique` (`code`),
  KEY `shops_created_at_index` (`created_at`),
  KEY `shops_updated_at_index` (`updated_at`),
  KEY `fk_shops_users1_idx` (`user_id`),
  CONSTRAINT `fk_shops_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shops`
--

LOCK TABLES `shops` WRITE;
/*!40000 ALTER TABLE `shops` DISABLE KEYS */;
INSERT INTO `shops` VALUES (2,'2022-10-18 07:36:09','2022-10-18 07:36:09','SH102','Bob Shop',22.41123,-90.5768,'Address 1\r\nAddress 2',1),(3,'2022-10-18 07:36:09','2022-10-18 07:36:09','SH104','Cindy Shop',-24.99135,80.35458,'Address 1\r\nAddress 2',5),(10,'2022-10-21 12:47:06','2022-10-21 13:32:55','oopo','popopopopop',787,878,'rtyuiopohgfghjkl',2);
/*!40000 ALTER TABLE `shops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `home` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `addition_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` int(11) DEFAULT NULL,
  `order_time` timestamp NULL DEFAULT NULL,
  `payment_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `user_user_id_unique` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@my-db.com','2022-10-18 08:25:12','$2y$10$RGuRSLsfJUdaELnY9ZUER.w4pqSyoHeiluriZRahtJB1nWBNYUuwW',NULL,'ADMIN','2022-10-18 08:25:12','2022-10-18 08:25:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'User','user@my-db.com','2022-10-18 08:25:12','$2y$10$ggNGqa1vmznIwhTFcSRkoeBEI5ZN/EDYTwQAfBeIHYogpxGCNzfJG',NULL,'USER','2022-10-18 08:25:12','2022-10-18 08:25:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'ddd','film@my-db.com',NULL,'$2y$10$m72TEQglRYecOMBnBCtIWOBInVU9WpBRpKwwizzpnt6AoheyBxOcq',NULL,'ADMIN','2022-10-18 01:33:00','2022-10-18 01:55:25',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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

-- Dump completed on 2024-02-08  2:08:12
