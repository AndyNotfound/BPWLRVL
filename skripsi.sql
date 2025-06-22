-- MySQL dump 10.13  Distrib 9.2.0, for macos15.2 (arm64)
--
-- Host: localhost    Database: batd6732_skripsi
-- ------------------------------------------------------
-- Server version	9.2.0

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `itineraries`
--

DROP TABLE IF EXISTS `itineraries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `itineraries` (
  `Oid` char(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateBy` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Role` bigint unsigned NOT NULL,
  `Code` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Name` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`Oid`),
  KEY `itineraries_createby_foreign` (`CreateBy`),
  KEY `itineraries_role_foreign` (`Role`),
  CONSTRAINT `itineraries_createby_foreign` FOREIGN KEY (`CreateBy`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `itineraries_role_foreign` FOREIGN KEY (`Role`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `itineraries`
--

LOCK TABLES `itineraries` WRITE;
/*!40000 ALTER TABLE `itineraries` DISABLE KEYS */;
INSERT INTO `itineraries` VALUES ('0446bb3a-40fb-46f2-b16e-9dd41fab9e65',1,'2025-06-11 16:18:56',1,'penang-hill-malaysia','Penang Hill Malaysia',0),('19a396b3-e6bd-4242-a941-35a071e57fa5',1,'2025-06-11 16:18:56',1,'universal-studios-singapore','Universal Studios Singapore',0),('1ac0d7ff-35a9-4a17-abf0-3a17cd07649f',1,'2025-06-11 16:18:56',1,'vihara-duta-maitreya-batam','Vihara Duta Maitreya Batam',0),('1c5d13ef-c4d6-4604-bd73-aef50aab9ccb',1,'2025-06-11 16:18:56',1,'marina-bay-sands-skypark','Marina Bay Sands SkyPark',0),('1f82af5d-7928-48ac-88bc-56d7b867f3ce',1,'2025-06-11 16:18:56',1,'desa-wisata-sebong-pereh','Desa Wisata Sebong Pereh',0),('21d6518c-ea68-4876-941a-211fc0e86f3a',1,'2025-06-11 16:18:56',1,'orchard-road-shopping-district','Orchard Road Shopping District',0),('24aa41fc-c5c8-4741-9e53-9548453001f3',1,'2025-06-11 16:18:56',1,'genting-highlands-resort','Genting Highlands Resort',0),('2cd4f18c-21ea-4469-9501-60a384c4f1e4',1,'2025-06-11 16:18:56',1,'treasure-bay-crystal-lagoon','Treasure Bay Crystal Lagoon',0),('3446f1f9-c652-4e25-a8bf-0bd10b26a88e',1,'2025-06-11 16:18:56',1,'singapore-flyer-observation-wheel','Singapore Flyer Observation Wheel',0),('37a5d752-d5ef-43f6-b4dd-2622546ce319',1,'2025-06-11 16:18:56',1,'merlion-park-singapore','Merlion Park Singapore',0),('3f80dd09-d518-40fa-ad58-0daf4b9b57c4',1,'2025-06-11 16:18:56',1,'pantai-marina-waterfront-city','Pantai Marina Waterfront City',0),('53253e26-ca22-4874-9645-98204084cf35',1,'2025-06-11 16:18:56',1,'helix-bridge-singapore','Helix Bridge Singapore',0),('5443b053-38ac-4e9c-9335-b7fc76f0456b',1,'2025-06-11 16:18:56',1,'kuala-lumpur-tower','Kuala Lumpur Tower',0),('55234d8d-3ff8-4757-ad02-0e988f6d5f7d',1,'2025-06-11 16:18:56',1,'cameron-highlands-tea-plantation','Cameron Highlands Tea Plantation',0),('571c6a94-b788-4bba-994f-ce9f4b517501',1,'2025-06-11 16:18:56',1,'mangrove-tour-sebung-river','Mangrove Tour Sebung River',0),('5a01f71f-f1b2-43ef-892c-f54384d43c1d',1,'2025-06-11 16:18:56',1,'gurun-pasir-dan-telaga-biru-bintan','Gurun pasir dan Telaga Biru Bintan',0),('5f4019f6-ba2f-42f3-8fae-e704fe8983a9',1,'2025-06-11 16:18:56',1,'vihara-1000-wajah-bintan','Vihara 1000 Wajah Bintan',0),('632109fa-e8a8-4b53-adb6-9f4b9058f92f',1,'2025-06-11 16:18:56',1,'pantai-trikora-bintan','Pantai Trikora Bintan',0),('6ee89acd-803d-436d-8d1b-65259232f30d',1,'2025-06-11 16:18:56',1,'danau-biru-batam','Danau Biru Batam',0),('76756152-1962-4992-bcb7-ef85dbe5c660',1,'2025-06-11 16:18:56',1,'esplanade-singapore','Esplanade Singapore',0),('7d380777-c4da-47bf-b8b6-9d9aad415b20',1,'2025-06-11 16:18:56',1,'white-sands-island-bintan','White Sands Island Bintan',0),('8096cb60-b97b-4751-8302-4af864b39c7b',1,'2025-06-11 16:18:56',1,'singapore-zoo-mandai','Singapore Zoo Mandai',0),('828924f9-986a-4366-bbd7-23af56c35ad7',1,'2025-06-11 16:18:56',1,'bukit-panglong-bintan','Bukit Panglong Bintan',0),('8a9c27a8-6a4c-4cfc-b9c9-effaaf5a2779',1,'2025-06-11 16:18:56',1,'jonker-street-melaka','Jonker Street Melaka',0),('8f615da0-2038-4cf1-bdf6-52a0aa6c85d2',1,'2025-06-11 16:18:56',1,'bukit-senyum-viewpoint-batam','Bukit Senyum Viewpoint Batam',0),('9d6f382c-3643-4660-aba4-8ede196f28b0',1,'2025-06-11 16:18:56',1,'masjid-kristal-terengganu','Masjid Kristal Terengganu',0),('a696e802-ed09-40f0-a6c8-617ea518f1fc',1,'2025-06-11 16:18:56',1,'gardens-by-the-bay-singapore','Gardens by the Bay Singapore',0),('b19f5a6b-d41b-4800-af98-b0c3a86f1c47',1,'2025-06-11 16:18:56',1,'menara-kembar-petronas-kuala-lumpur','Menara Kembar Petronas Kuala Lumpur',0),('b7abea48-b369-4466-8696-04d856f21ade',1,'2025-06-11 16:18:56',1,'george-town-street-art-penang','George Town Street Art Penang',0),('b9fd8967-149d-401d-8e9d-9b31a3c457ea',1,'2025-06-11 16:18:56',1,'lagoi-bay-lantern-park','Lagoi Bay Lantern Park',0),('bb006962-82f6-446b-bdba-202fe0b8c47d',1,'2025-06-11 16:18:56',1,'aquaria-klcc-malaysia','Aquaria KLCC Malaysia',0),('c0dde79d-e49b-4afb-876f-8d7aabe297ef',1,'2025-06-11 16:18:56',1,'taman-mini-indonesia-batam','Taman Mini Indonesia Batam',0),('c31efe21-3857-4215-8611-3e2bb0175802',1,'2025-06-11 16:18:56',1,'safari-lagoi-dan-eco-farm','Safari Lagoi dan Eco Farm',0),('c59ae712-1023-4906-ac81-e48d9072f77d',1,'2025-06-11 16:18:56',1,'jembatan-barelang-batam','Jembatan Barelang Batam',0),('c607c7a5-372c-4f80-b2d0-8e77c441fee6',1,'2025-06-11 16:18:56',1,'batam-miniature-house-park','Batam Miniature House Park',0),('cafe8356-89d4-4a7a-8c3d-ca0edd74af14',1,'2025-06-11 16:18:56',1,'batu-caves-selangor','Batu Caves Selangor',0),('cf15d176-1c0d-4c0c-88c6-eff4754b5b17',1,'2025-06-11 16:18:56',1,'sentosa-island-singapore','Sentosa Island Singapore',0),('d292d3f0-8532-4c87-9177-f73dafc9eae7',1,'2025-06-11 16:18:56',1,'hutan-mangrove-tanjung-uban','Hutan Mangrove Tanjung Uban',0),('dc12bc98-7c7e-4b70-a58f-88162ed4e7b8',1,'2025-06-11 16:18:56',1,'ocarina-theme-park-batam','Ocarina Theme Park Batam',0),('dd014209-eb35-43b5-a2bd-5b32db9238a6',1,'2025-06-11 16:18:56',1,'welcome-to-batam-monument','Welcome to Batam Monument',0),('df36d0a8-50f9-4065-a02c-a50dc5c2b178',1,'2025-06-11 16:18:56',1,'langkawi-sky-bridge','Langkawi Sky Bridge',0);
/*!40000 ALTER TABLE `itineraries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_03_15_082048_create_personal_access_tokens_table',1),(5,'2025_03_22_154925_create_permission_tables',1),(6,'2025_05_10_061134_create_packages_table',1),(7,'2025_05_10_063518_add_role_id_to_users_table',1),(8,'2025_05_10_131759_create_travel_transactions_table',1),(9,'2025_05_10_140951_create_travel_transaction_details_table',1),(10,'2025_05_10_225336_create_settings_table',1),(11,'2025_05_10_233106_create_add_more_field_to_travel_transactions_detail_table',1),(12,'2025_05_11_051713_create_itineraries_table',1),(13,'2025_05_11_054100_create_add_more_field_to_travel_transactions_detail_2_table',1),(14,'2025_05_11_060303_create_more_field_itineraries_table',1),(15,'2025_05_12_082518_create_package_new_field_table',1),(16,'2025_05_30_085525_create_reviews_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `packages` (
  `Oid` char(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateBy` bigint unsigned NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Description` longtext COLLATE utf8mb4_unicode_ci,
  `Location` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HeadImage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SubImage1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SubImage2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ValidDateStart` datetime DEFAULT NULL,
  `ValidDateEnd` datetime DEFAULT NULL,
  `Price` double NOT NULL DEFAULT '0',
  `MaxCapacity` int NOT NULL DEFAULT '0',
  `isCustomItineraries` tinyint(1) NOT NULL DEFAULT '0',
  `isFavorites` tinyint(1) NOT NULL DEFAULT '0',
  `isSeasonal` tinyint(1) NOT NULL DEFAULT '0',
  `isMustsee` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Oid`),
  KEY `packages_createby_foreign` (`CreateBy`),
  CONSTRAINT `packages_createby_foreign` FOREIGN KEY (`CreateBy`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES ('039ecf65-1dfb-4171-875a-21bf92ccbcde',1,'2025-06-11 17:02:04','City Tour Batam Custom','Eksplorasi Kota Batam Sesuai Keinginanmu','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Batam, Kepulauan Riau','http://127.0.0.1:8000/images/1749748004_catppuccin-mocha-asian-town.png','http://127.0.0.1:8000/images/1749747402_Rectangle 140 (1).png','http://127.0.0.1:8000/images/1749747402_WhatsApp Image 2025-05-03 at 19.10.53.jpeg',NULL,NULL,0,250,1,0,1,1),('03c657b7-c271-48f7-b269-5f21fee027e6',1,'2025-06-11 17:02:04','One Day Trip to Trikora Beach','Pantai Pasir Putih dan Santai Seharian','<ul><li><a>Penjemputan dari pelabuhan/hotel Tanjung Pinang</a></li><li><a>Kunjungan ke Pantai Trikora, bermain air & relaksasi</a></li><li><a>Makan siang di restoran seafood lokal</a></li><li><a>Kunjungan ke Vihara Patung Seribu Wajah</a></li><li><a>Belanja kerajinan lokal</a></li><li><a>Kembali ke hotel/pelabuhan (16:00)</a></li></ul>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,341335,250,0,1,1,0),('058af2d4-645d-4030-bdba-3e392c2b280c',1,'2025-06-11 17:02:04','Two Days One Night Trip to Bintan','Liburan Santai 2 Hari 1 Malam di Bintan','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,0,0,0),('098de4aa-bd97-47b8-85ed-e5bfb103135a',1,'2025-06-11 17:02:04','Two Days One Night Trip to Bintan','Liburan Santai 2 Hari 1 Malam di Bintan','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,1,0,1),('0a6629a2-f774-45da-8dcf-e5b0570ae3b8',1,'2025-06-11 17:02:04','Snorkeling at Ranoh Island','Paket Sehari Snorkeling di Ranoh Island','<ul><li><a>Meeting point di Marina Waterfront Batam pukul 08:00</a></li><li><a>Speedboat ke Pulau Ranoh (±1 jam)</a></li><li><a>Snorkeling di laut jernih & bermain banana boat</a></li><li><a>Free akses: hammock, bean bag, volleyball</a></li><li><a>Lunch buffet di tepi pantai</a></li><li><a>Free time sebelum kembali ke Batam (16:00)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,861963,250,0,0,1,0),('0f357129-c543-4adc-ad13-14c245aa9c1a',1,'2025-06-11 17:02:04','Snorkeling at Ranoh Island','Paket Sehari Snorkeling di Ranoh Island','<ul><li><a>Meeting point di Marina Waterfront Batam pukul 08:00</a></li><li><a>Speedboat ke Pulau Ranoh (±1 jam)</a></li><li><a>Snorkeling di laut jernih & bermain banana boat</a></li><li><a>Free akses: hammock, bean bag, volleyball</a></li><li><a>Lunch buffet di tepi pantai</a></li><li><a>Free time sebelum kembali ke Batam (16:00)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,1050487,250,0,1,1,0),('10bebad0-64d3-450a-9688-d9a9c55f1fb0',1,'2025-06-11 17:02:04','Snorkeling at Kepri Coral','Paket Seru Snorkeling di Kepri Coral','<ul><li><a>Penjemputan pukul 08:00 di hotel atau pelabuhan</a></li><li><a>Naik boat dari dermaga ke Kepri Coral (±1 jam perjalanan)</a></li><li><a>Snorkeling di area karang dengan pemandu profesional</a></li><li><a>Akses ke kolam renang, restoran, dan akuarium bawah laut</a></li><li><a>Makan siang di floating restaurant</a></li><li><a>Waktu bebas di pantai dan area foto</a></li><li><a>Pulang ke Batam pada pukul 16:30</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,903779,250,0,1,1,1),('14893183-ee57-4bf5-8592-78eeb03a736a',1,'2025-06-11 17:02:04','One Day Trip to Trikora Beach','Pantai Pasir Putih dan Santai Seharian','<ul><li><a>Penjemputan dari pelabuhan/hotel Tanjung Pinang</a></li><li><a>Kunjungan ke Pantai Trikora, bermain air & relaksasi</a></li><li><a>Makan siang di restoran seafood lokal</a></li><li><a>Kunjungan ke Vihara Patung Seribu Wajah</a></li><li><a>Belanja kerajinan lokal</a></li><li><a>Kembali ke hotel/pelabuhan (16:00)</a></li></ul>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,554536,250,0,1,0,1),('1dfc2519-01e7-42ee-a4af-2e0ad7c997c9',1,'2025-06-11 17:02:04','One Day Trip to Nipah Island','Sehari Penuh Menjelajahi Pulau Nipah','<ul><li><a>Penjemputan dari hotel/pelabuhan pada pukul 07:30 WIB</a></li><li><a>Perjalanan menuju Pelabuhan Telaga Punggur</a></li><li><a>Naik speedboat menuju Pulau Nipah (±45 menit)</a></li><li><a>Aktivitas: Snorkeling, beach games, dan foto-foto di spot ikonik</a></li><li><a>Makan siang BBQ seafood di tepi pantai</a></li><li><a>Waktu bebas untuk eksplorasi dan berenang</a></li><li><a>Kembali ke Batam dan diantar kembali ke hotel (pukul 17:00 WIB)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,364048,250,0,0,1,1),('2f4a5c07-f838-47fa-9ed5-3f07534fc4e3',1,'2025-06-11 17:02:04','One Day Trip to Trikora Beach','Pantai Pasir Putih dan Santai Seharian','<ul><li><a>Penjemputan dari pelabuhan/hotel Tanjung Pinang</a></li><li><a>Kunjungan ke Pantai Trikora, bermain air & relaksasi</a></li><li><a>Makan siang di restoran seafood lokal</a></li><li><a>Kunjungan ke Vihara Patung Seribu Wajah</a></li><li><a>Belanja kerajinan lokal</a></li><li><a>Kembali ke hotel/pelabuhan (16:00)</a></li></ul>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,1116058,250,0,0,0,1),('2ff54707-6a2f-416a-a194-caf59412cfc0',1,'2025-06-11 17:02:04','Snorkeling at Ranoh Island','Paket Sehari Snorkeling di Ranoh Island','<ul><li><a>Meeting point di Marina Waterfront Batam pukul 08:00</a></li><li><a>Speedboat ke Pulau Ranoh (±1 jam)</a></li><li><a>Snorkeling di laut jernih & bermain banana boat</a></li><li><a>Free akses: hammock, bean bag, volleyball</a></li><li><a>Lunch buffet di tepi pantai</a></li><li><a>Free time sebelum kembali ke Batam (16:00)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,815274,250,0,1,0,1),('31fd2021-6694-40aa-9fba-d50007b1ddee',1,'2025-06-11 17:48:59','Test custom','Hai',NULL,'Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,1000,0,0,0,0,0),('4703ad28-d107-4352-a133-868ab013b678',1,'2025-06-11 17:02:04','Snorkeling at Ranoh Island','Paket Sehari Snorkeling di Ranoh Island','<ul><li><a>Meeting point di Marina Waterfront Batam pukul 08:00</a></li><li><a>Speedboat ke Pulau Ranoh (±1 jam)</a></li><li><a>Snorkeling di laut jernih & bermain banana boat</a></li><li><a>Free akses: hammock, bean bag, volleyball</a></li><li><a>Lunch buffet di tepi pantai</a></li><li><a>Free time sebelum kembali ke Batam (16:00)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,419273,250,0,0,1,0),('4b05dc61-e0ae-42f4-80db-117c4f6e7da3',1,'2025-06-11 17:02:04','Two Days One Night Trip to Bintan','Liburan Santai 2 Hari 1 Malam di Bintan','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,1,1,0),('4d58dc37-ad57-4216-ba5b-ec2e14af1ab9',1,'2025-06-11 17:02:04','One Day Trip to Trikora Beach','Pantai Pasir Putih dan Santai Seharian','<ul><li><a>Penjemputan dari pelabuhan/hotel Tanjung Pinang</a></li><li><a>Kunjungan ke Pantai Trikora, bermain air & relaksasi</a></li><li><a>Makan siang di restoran seafood lokal</a></li><li><a>Kunjungan ke Vihara Patung Seribu Wajah</a></li><li><a>Belanja kerajinan lokal</a></li><li><a>Kembali ke hotel/pelabuhan (16:00)</a></li></ul>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,1088415,250,0,1,0,1),('51cbac12-a33a-45f4-bd73-9d3bdc6cdd53',1,'2025-06-11 17:02:04','Two Days One Night Trip to Bintan','Liburan Santai 2 Hari 1 Malam di Bintan','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,1,0,0),('57af0450-188a-439a-aa8b-d8dc23c63994',1,'2025-06-11 17:43:12','Custom Package Two','Testing','<p>Testing aja</p>','Batam, Indonesi','http://127.0.0.1:8000/images/1749663792_alur_sistem_tour_and_travel_updated.png','http://127.0.0.1:8000/images/1749663792_catppuccin-mocha-asian-town.png','http://127.0.0.1:8000/images/1749663792_anime-girl-countryside-scenery-4k-wallpaper-uhdpaper.com-187@3@a.jpg',NULL,NULL,100,0,1,0,0,0),('62b67623-8868-461a-b26e-5c387bc4f0d7',1,'2025-06-11 17:02:04','City Tour Batam Custom','Eksplorasi Kota Batam Sesuai Keinginanmu','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,1,0,0),('63bdc2e1-055b-4f70-ac7e-268eabbad085',1,'2025-06-11 17:02:04','One Day Trip to Nipah Island','Sehari Penuh Menjelajahi Pulau Nipah','<ul><li><a>Penjemputan dari hotel/pelabuhan pada pukul 07:30 WIB</a></li><li><a>Perjalanan menuju Pelabuhan Telaga Punggur</a></li><li><a>Naik speedboat menuju Pulau Nipah (±45 menit)</a></li><li><a>Aktivitas: Snorkeling, beach games, dan foto-foto di spot ikonik</a></li><li><a>Makan siang BBQ seafood di tepi pantai</a></li><li><a>Waktu bebas untuk eksplorasi dan berenang</a></li><li><a>Kembali ke Batam dan diantar kembali ke hotel (pukul 17:00 WIB)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,832078,250,0,1,0,1),('64f2bb3e-5e04-405e-ab24-30865b170d77',1,'2025-06-11 17:02:04','Snorkeling at Kepri Coral','Paket Seru Snorkeling di Kepri Coral','<ul><li><a>Penjemputan pukul 08:00 di hotel atau pelabuhan</a></li><li><a>Naik boat dari dermaga ke Kepri Coral (±1 jam perjalanan)</a></li><li><a>Snorkeling di area karang dengan pemandu profesional</a></li><li><a>Akses ke kolam renang, restoran, dan akuarium bawah laut</a></li><li><a>Makan siang di floating restaurant</a></li><li><a>Waktu bebas di pantai dan area foto</a></li><li><a>Pulang ke Batam pada pukul 16:30</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,1035622,250,0,1,1,1),('6772f835-f23e-4b53-8de8-211d0947146a',1,'2025-06-12 16:36:37','Test Fix','Test aja 1 edit','<p>testing fix 1 udah di edit</p>','Batam, Kepulauan Riau','http://127.0.0.1:8000/images/1749746257_Rectangle 140 (1).png','http://127.0.0.1:8000/images/1749746197_alur_sistem_tour_and_travel_updated.png',NULL,NULL,NULL,10,0,0,0,0,0),('67b8dc7f-9215-4766-a45a-153f4b78d2d7',1,'2025-06-11 17:02:04','One Day Trip to Nipah Island','Sehari Penuh Menjelajahi Pulau Nipah','<ul><li><a>Penjemputan dari hotel/pelabuhan pada pukul 07:30 WIB</a></li><li><a>Perjalanan menuju Pelabuhan Telaga Punggur</a></li><li><a>Naik speedboat menuju Pulau Nipah (±45 menit)</a></li><li><a>Aktivitas: Snorkeling, beach games, dan foto-foto di spot ikonik</a></li><li><a>Makan siang BBQ seafood di tepi pantai</a></li><li><a>Waktu bebas untuk eksplorasi dan berenang</a></li><li><a>Kembali ke Batam dan diantar kembali ke hotel (pukul 17:00 WIB)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,812830,250,0,0,0,0),('791a4edf-7555-4718-9da2-9c3bd63709d9',1,'2025-06-11 17:02:04','Snorkeling at Ranoh Island','Paket Sehari Snorkeling di Ranoh Island','<ul><li><a>Meeting point di Marina Waterfront Batam pukul 08:00</a></li><li><a>Speedboat ke Pulau Ranoh (±1 jam)</a></li><li><a>Snorkeling di laut jernih & bermain banana boat</a></li><li><a>Free akses: hammock, bean bag, volleyball</a></li><li><a>Lunch buffet di tepi pantai</a></li><li><a>Free time sebelum kembali ke Batam (16:00)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,401001,250,0,1,0,1),('7ed4d3ca-2986-4cd3-a21c-1c3d71e14008',1,'2025-06-12 13:33:04','Test create travel package one','Testing after bugs','<p>Kenapa ya manusia itu aneh banget</p>','Batam, Indonesia','http://127.0.0.1:8000/images/1749735184_Screenshot 2025-05-22 at 9.12.36 AM.png','http://127.0.0.1:8000/images/1749735184_samurai.jpg','http://127.0.0.1:8000/images/1749735184_albedo-overlord-anime-girl-4k-wallpaper-uhdpaper.com-268@5@b.jpg',NULL,NULL,10,0,0,0,0,0),('7fe7a26d-5ad0-4403-a352-d56a0e88f3c6',1,'2025-06-11 17:02:04','City Tour Batam Custom','Eksplorasi Kota Batam Sesuai Keinginanmu','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,1,0,1),('9cdbef85-6065-43d5-9108-1ceeffcc637f',1,'2025-06-11 17:02:04','One Day Trip to Nipah Island','Sehari Penuh Menjelajahi Pulau Nipah','<ul><li><a>Penjemputan dari hotel/pelabuhan pada pukul 07:30 WIB</a></li><li><a>Perjalanan menuju Pelabuhan Telaga Punggur</a></li><li><a>Naik speedboat menuju Pulau Nipah (±45 menit)</a></li><li><a>Aktivitas: Snorkeling, beach games, dan foto-foto di spot ikonik</a></li><li><a>Makan siang BBQ seafood di tepi pantai</a></li><li><a>Waktu bebas untuk eksplorasi dan berenang</a></li><li><a>Kembali ke Batam dan diantar kembali ke hotel (pukul 17:00 WIB)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,493442,250,0,0,0,1),('ab9d68c8-e53c-4a03-a9ac-32eb4df5f861',1,'2025-06-11 17:02:04','One Day Trip to Nipah Island','Sehari Penuh Menjelajahi Pulau Nipah','<ul><li><a>Penjemputan dari hotel/pelabuhan pada pukul 07:30 WIB</a></li><li><a>Perjalanan menuju Pelabuhan Telaga Punggur</a></li><li><a>Naik speedboat menuju Pulau Nipah (±45 menit)</a></li><li><a>Aktivitas: Snorkeling, beach games, dan foto-foto di spot ikonik</a></li><li><a>Makan siang BBQ seafood di tepi pantai</a></li><li><a>Waktu bebas untuk eksplorasi dan berenang</a></li><li><a>Kembali ke Batam dan diantar kembali ke hotel (pukul 17:00 WIB)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,598641,250,0,0,0,0),('b5bb6c6d-be3f-4c71-b42e-c6928a047f37',1,'2025-06-11 17:51:05','Kenapa`','Test Aneh','<p>Aneh sih</p>','Batam, Indonesia','http://127.0.0.1:8000/images/1749664265_alur_sistem_tour_and_travel_updated.png',NULL,NULL,NULL,NULL,1000,0,0,0,0,0),('b8ccb95c-b2c1-4052-bee3-b2496bdea4c4',1,'2025-06-11 17:02:04','One Day Trip to Nipah Island','Sehari Penuh Menjelajahi Pulau Nipah','<ul><li><a>Penjemputan dari hotel/pelabuhan pada pukul 07:30 WIB</a></li><li><a>Perjalanan menuju Pelabuhan Telaga Punggur</a></li><li><a>Naik speedboat menuju Pulau Nipah (±45 menit)</a></li><li><a>Aktivitas: Snorkeling, beach games, dan foto-foto di spot ikonik</a></li><li><a>Makan siang BBQ seafood di tepi pantai</a></li><li><a>Waktu bebas untuk eksplorasi dan berenang</a></li><li><a>Kembali ke Batam dan diantar kembali ke hotel (pukul 17:00 WIB)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,826122,250,0,0,0,1),('c170c076-5939-430e-8d39-281010be03dc',1,'2025-06-11 17:02:04','Two Days One Night Trip to Bintan','Liburan Santai 2 Hari 1 Malam di Bintan','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,0,0,0),('c1d9befd-29f2-4348-b63d-4cb7c306979c',1,'2025-06-11 17:02:04','Snorkeling at Kepri Coral','Paket Seru Snorkeling di Kepri Coral','<ul><li><a>Penjemputan pukul 08:00 di hotel atau pelabuhan</a></li><li><a>Naik boat dari dermaga ke Kepri Coral (±1 jam perjalanan)</a></li><li><a>Snorkeling di area karang dengan pemandu profesional</a></li><li><a>Akses ke kolam renang, restoran, dan akuarium bawah laut</a></li><li><a>Makan siang di floating restaurant</a></li><li><a>Waktu bebas di pantai dan area foto</a></li><li><a>Pulang ke Batam pada pukul 16:30</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,626933,250,0,0,1,1),('c7d79085-76b7-447d-8564-2000b8ac571e',1,'2025-06-11 17:02:04','Snorkeling at Kepri Coral','Paket Seru Snorkeling di Kepri Coral','<ul><li><a>Penjemputan pukul 08:00 di hotel atau pelabuhan</a></li><li><a>Naik boat dari dermaga ke Kepri Coral (±1 jam perjalanan)</a></li><li><a>Snorkeling di area karang dengan pemandu profesional</a></li><li><a>Akses ke kolam renang, restoran, dan akuarium bawah laut</a></li><li><a>Makan siang di floating restaurant</a></li><li><a>Waktu bebas di pantai dan area foto</a></li><li><a>Pulang ke Batam pada pukul 16:30</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,632022,250,0,1,0,1),('cfb5a125-0fae-45ce-9a1f-cd572c2a0983',1,'2025-06-11 17:02:04','One Day Trip to Trikora Beach','Pantai Pasir Putih dan Santai Seharian','<ul><li><a>Penjemputan dari pelabuhan/hotel Tanjung Pinang</a></li><li><a>Kunjungan ke Pantai Trikora, bermain air & relaksasi</a></li><li><a>Makan siang di restoran seafood lokal</a></li><li><a>Kunjungan ke Vihara Patung Seribu Wajah</a></li><li><a>Belanja kerajinan lokal</a></li><li><a>Kembali ke hotel/pelabuhan (16:00)</a></li></ul>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,1132403,250,0,0,1,0),('d1e4d54e-b01b-44a6-820f-67fc324c6858',1,'2025-06-11 17:02:04','Two Days One Night Trip to Bintan','Liburan Santai 2 Hari 1 Malam di Bintan','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,1,0,0),('d769b0dc-80dd-4f84-90b8-5a055a147599',1,'2025-06-11 17:02:04','City Tour Batam Custom','Eksplorasi Kota Batam Sesuai Keinginanmu','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,1,1,0),('da0df0da-9733-44d5-95de-91a8d68833f8',1,'2025-06-11 17:02:04','Snorkeling at Kepri Coral','Paket Seru Snorkeling di Kepri Coral','<ul><li><a>Penjemputan pukul 08:00 di hotel atau pelabuhan</a></li><li><a>Naik boat dari dermaga ke Kepri Coral (±1 jam perjalanan)</a></li><li><a>Snorkeling di area karang dengan pemandu profesional</a></li><li><a>Akses ke kolam renang, restoran, dan akuarium bawah laut</a></li><li><a>Makan siang di floating restaurant</a></li><li><a>Waktu bebas di pantai dan area foto</a></li><li><a>Pulang ke Batam pada pukul 16:30</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,686990,250,0,0,0,1),('da8f195d-2ce4-43d6-91b6-144306f7b755',1,'2025-06-11 17:02:04','Snorkeling at Ranoh Island','Paket Sehari Snorkeling di Ranoh Island','<ul><li><a>Meeting point di Marina Waterfront Batam pukul 08:00</a></li><li><a>Speedboat ke Pulau Ranoh (±1 jam)</a></li><li><a>Snorkeling di laut jernih & bermain banana boat</a></li><li><a>Free akses: hammock, bean bag, volleyball</a></li><li><a>Lunch buffet di tepi pantai</a></li><li><a>Free time sebelum kembali ke Batam (16:00)</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,417402,250,0,0,1,0),('e6b667c8-f16d-4f67-b94c-1edca89e8bbe',1,'2025-06-11 17:02:04','Snorkeling at Kepri Coral','Paket Seru Snorkeling di Kepri Coral','<ul><li><a>Penjemputan pukul 08:00 di hotel atau pelabuhan</a></li><li><a>Naik boat dari dermaga ke Kepri Coral (±1 jam perjalanan)</a></li><li><a>Snorkeling di area karang dengan pemandu profesional</a></li><li><a>Akses ke kolam renang, restoran, dan akuarium bawah laut</a></li><li><a>Makan siang di floating restaurant</a></li><li><a>Waktu bebas di pantai dan area foto</a></li><li><a>Pulang ke Batam pada pukul 16:30</a></li></ul>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,778060,250,0,1,0,0),('f1f3b77d-8895-4af1-9eed-a177d6b33f3e',1,'2025-06-11 17:02:04','One Day Trip to Trikora Beach','Pantai Pasir Putih dan Santai Seharian','<ul><li><a>Penjemputan dari pelabuhan/hotel Tanjung Pinang</a></li><li><a>Kunjungan ke Pantai Trikora, bermain air & relaksasi</a></li><li><a>Makan siang di restoran seafood lokal</a></li><li><a>Kunjungan ke Vihara Patung Seribu Wajah</a></li><li><a>Belanja kerajinan lokal</a></li><li><a>Kembali ke hotel/pelabuhan (16:00)</a></li></ul>','Bintan, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,716186,250,0,1,1,0),('f49dcaf6-46a9-460a-93c0-202e588e9b1e',1,'2025-06-11 17:02:04','City Tour Batam Custom','Eksplorasi Kota Batam Sesuai Keinginanmu','<p>Explore Batam dan Bintan sesuai keinginan Anda. Tim kami siap menyesuaikan destinasi, waktu, dan aktivitas agar sesuai dengan kebutuhan Anda.</p>','Batam, Kepulauan Riau',NULL,NULL,NULL,NULL,NULL,0,250,1,1,1,1);
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `Oid` char(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateBy` bigint unsigned DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Packages` char(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Review` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`Oid`),
  KEY `fk_reviews_createby` (`CreateBy`),
  KEY `fk_reviews_packages` (`Packages`),
  CONSTRAINT `fk_reviews_createby` FOREIGN KEY (`CreateBy`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reviews_packages` FOREIGN KEY (`Packages`) REFERENCES `packages` (`Oid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2025-06-02 06:19:12','2025-06-02 06:19:12'),(2,'owner','web','2025-06-02 06:19:12','2025-06-02 06:19:12'),(3,'client','web','2025-06-02 06:19:12','2025-06-02 06:19:12');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `Oid` char(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SecretKey` longtext COLLATE utf8mb4_unicode_ci,
  `Password` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('6c08485c-6d52-4d1a-beef-52788d8b495d','xnd_development_cuLsW78TsykciQcivQf32aSCVnACCj6WY6c6tes8SBr7yp5gzHkpgfgu8gQ3uGg',''),('8692960d-39ce-4e3f-9558-3cd59a207b40','xnd_development_62YxANBgUFrEwDR4SQsmKjw9gafR15PWEvcfT3FcfdI2WUJ8tNPumlzEruDOl',''),('dd2458f3-0a61-458f-8e73-5c5b1d172709','xnd_development_62YxANBgUFrEwDR4SQsmKjw9gafR15PWEvcfT3FcfdI2WUJ8tNPumlzEruDOl','');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travel_transaction_details`
--

DROP TABLE IF EXISTS `travel_transaction_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `travel_transaction_details` (
  `Oid` char(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateBy` bigint unsigned DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TravelTransaction` char(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Code` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Description` longtext COLLATE utf8mb4_unicode_ci,
  `TotalPax` int NOT NULL DEFAULT '0',
  `Name` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PhoneNumber` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EnterDate` date DEFAULT NULL,
  `ExitDate` date DEFAULT NULL,
  `isCustomItineraries` tinyint(1) NOT NULL DEFAULT '0',
  `Type` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PaymentID` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Status` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ExpiresAt` timestamp NULL DEFAULT NULL,
  `Itineraries` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`Oid`),
  KEY `travel_transaction_details_createby_foreign` (`CreateBy`),
  KEY `travel_transaction_details_traveltransaction_foreign` (`TravelTransaction`),
  CONSTRAINT `travel_transaction_details_createby_foreign` FOREIGN KEY (`CreateBy`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `travel_transaction_details_traveltransaction_foreign` FOREIGN KEY (`TravelTransaction`) REFERENCES `travel_transactions` (`Oid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travel_transaction_details`
--

LOCK TABLES `travel_transaction_details` WRITE;
/*!40000 ALTER TABLE `travel_transaction_details` DISABLE KEYS */;
INSERT INTO `travel_transaction_details` VALUES ('19847b2f-0a1b-4b43-830b-416397fa9b0a',NULL,'2025-06-16 13:28:12','3e67fa98-c638-46fc-b149-efae5f6ba4b9',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-16','2025-06-16',0,'QR','68501bef5bf0833976110701','Process','2025-06-17 06:28:15',NULL),('21c4b643-234c-4aa6-8d69-5ab1fa2481b7',NULL,'2025-06-11 17:13:36','e1a977a6-ce5a-47ef-ad2b-31b9c3f4a7c7',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-11','2025-06-11',0,NULL,NULL,'Entry',NULL,NULL),('2d05b59a-7a39-4112-9868-79e79bfc430e',NULL,'2025-06-11 17:13:05','8f0b9570-5435-407a-ae54-9dea1c8726d1',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-11','2025-06-11',0,NULL,NULL,'Entry',NULL,NULL),('6ee1bd46-6b6c-4309-83b6-fd3438ace28d',NULL,'2025-06-16 13:26:28','c33a8de0-4365-4b2b-93e4-40db8ecfcc34',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-16','2025-06-16',0,'QR','68501b885bf08339761106b7','Process','2025-06-17 06:26:33',NULL),('7be35fb5-dffd-414b-b099-ff97d5c5a80b',NULL,'2025-06-11 17:13:56','0146a2a6-44cc-4f85-8e9d-bc24f6a36ad7',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-11','2025-06-11',0,'QR','6849b9643dc26f84339a905d','Process','2025-06-12 10:14:13',NULL),('98504833-8eb4-41c7-bfe8-69ece917c0df',1,'2025-06-16 13:33:01','58980c6b-ce8d-49f1-a2b2-3e5402cbe211',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-16','2025-06-16',0,NULL,NULL,'Entry',NULL,NULL),('e2af6a2d-2a16-4aba-9852-80cdf66bbaad',1,'2025-06-16 13:50:05','282330e0-2127-4b64-ba88-d27b6d02cd2d',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-16','2025-06-16',0,NULL,NULL,'Entry',NULL,NULL),('e2c4179c-92a6-4c02-b979-99822291faea',NULL,'2025-06-16 13:38:34','611549b9-6b45-4c4c-9fb7-6bb988af0f59',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-16','2025-06-16',0,NULL,NULL,'Entry',NULL,NULL),('e470fd6b-4eda-462b-bdcb-0b5145ff3305',NULL,'2025-06-16 13:37:30','b475fd1f-9849-43e4-a2a8-b214dce40201',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-16','2025-06-16',0,'QR','68501e20ad9f484a8b5f46e2','Process','2025-06-17 06:37:36',NULL),('eb6d1738-9c48-4571-b6e6-5336a0663a81',NULL,'2025-06-16 13:50:00','ba0474b4-f188-4b4e-92a7-1ca552179984',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-16','2025-06-16',0,NULL,NULL,'Entry',NULL,NULL),('f12433d5-da35-4252-a8bd-6c9221d477d9',NULL,'2025-06-16 13:37:57','3e72e6c2-d445-4df5-bcf0-df3462e486b6',NULL,'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',1,'Gohand Test Fix 1','andy.notfound@gmail.com','081223423423','2025-06-16','2025-06-16',0,'QR','68501e385bf0833976110925','Process','2025-06-17 06:38:00',NULL);
/*!40000 ALTER TABLE `travel_transaction_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `travel_transactions`
--

DROP TABLE IF EXISTS `travel_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `travel_transactions` (
  `Oid` char(38) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreateBy` bigint unsigned DEFAULT NULL,
  `Packages` char(38) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Code` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Price` double NOT NULL DEFAULT '0',
  `Description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`Oid`),
  KEY `fk_travel_transactions_createby` (`CreateBy`),
  KEY `fk_travel_transactions_packages` (`Packages`),
  CONSTRAINT `fk_travel_transactions_createby` FOREIGN KEY (`CreateBy`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_travel_transactions_packages` FOREIGN KEY (`Packages`) REFERENCES `packages` (`Oid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `travel_transactions`
--

LOCK TABLES `travel_transactions` WRITE;
/*!40000 ALTER TABLE `travel_transactions` DISABLE KEYS */;
INSERT INTO `travel_transactions` VALUES ('0146a2a6-44cc-4f85-8e9d-bc24f6a36ad7',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-11 17:13:56','PKG - CWISBXZ',341335,NULL),('282330e0-2127-4b64-ba88-d27b6d02cd2d',1,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-16 13:50:05','PKG - CL0VG28',341335,NULL),('3e67fa98-c638-46fc-b149-efae5f6ba4b9',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-16 13:28:12','PKG - HZXWZEE',341335,NULL),('3e72e6c2-d445-4df5-bcf0-df3462e486b6',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-16 13:37:57','PKG - WCRPKCY',341335,NULL),('58980c6b-ce8d-49f1-a2b2-3e5402cbe211',1,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-16 13:33:01','PKG - MT5BGDA',341335,NULL),('611549b9-6b45-4c4c-9fb7-6bb988af0f59',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-16 13:38:34','PKG - 23JBP0Z',341335,NULL),('8f0b9570-5435-407a-ae54-9dea1c8726d1',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-11 17:13:05','PKG - UK2GCKB',341335,NULL),('b475fd1f-9849-43e4-a2a8-b214dce40201',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-16 13:37:30','PKG - OTVZYCL',341335,NULL),('ba0474b4-f188-4b4e-92a7-1ca552179984',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-16 13:50:00','PKG - 585EZYM',341335,NULL),('c33a8de0-4365-4b2b-93e4-40db8ecfcc34',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-16 13:26:28','PKG - 6QANEPI',341335,NULL),('e1a977a6-ce5a-47ef-ad2b-31b9c3f4a7c7',NULL,'03c657b7-c271-48f7-b269-5f21fee027e6','2025-06-11 17:13:36','PKG - EPS3RQ5',341335,NULL);
/*!40000 ALTER TABLE `travel_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role` bigint unsigned DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_phone_number_unique` (`phone_number`),
  KEY `users_role_foreign` (`role`),
  CONSTRAINT `users_role_foreign` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'admin@example.com','1234567890','Admin','Admin','User','$2y$12$l1IZ8mVXPm9jEscmUwQx2uhB4gTlih4DzktRCviugK6C6G6HMi6Lq',1,'2025-06-02 06:19:12','2025-06-07 03:19:28'),(2,2,'owner@example.com','0987654321','Owner','Owner','User','$2y$12$Fq9JnBmraeftI64JZR2mhunTcV3mWd/U4fxqiv8ri.QbbizhUsIrC',1,'2025-06-02 06:19:13','2025-06-02 06:19:13'),(3,3,'client@example.com','1234567891','Client','Client','User','$2y$12$EPFTKuCLTMOEJNbrMOGJf.mxctqZQEgrVX7tvUtUd4NYFxtQDVdbu',1,'2025-06-02 06:19:13','2025-06-02 06:19:13'),(4,3,'testing@example.com',NULL,'testing','testing','aja','$2y$12$a2EjlqM1Y6o0x8OUGHysReN4Kpb0b16QmJMf6UW0JJnqL9fmlHgaS',1,'2025-06-15 07:48:53','2025-06-15 07:48:53'),(5,3,'testing1@gmail.com',NULL,'testing1','testing','one','$2y$12$dFRatYCZWVr/lmvu.Qgfjus6HxXvO1G6FxFY5h0zcaTZW4nHzlOum',1,'2025-06-15 07:49:27','2025-06-15 07:49:27');
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

-- Dump completed on 2025-06-21 23:25:53
