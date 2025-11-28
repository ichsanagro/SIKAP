/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kp_application_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `drive_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('PENDING','APPROVED','REVISION') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_kp_application_id_foreign` (`kp_application_id`),
  KEY `activity_logs_student_id_foreign` (`student_id`),
  CONSTRAINT `activity_logs_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `activity_logs_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
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
DROP TABLE IF EXISTS `companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batch` tinyint unsigned NOT NULL DEFAULT '1',
  `quota` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `company_field_supervisors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_field_supervisors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `field_supervisor_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_field_supervisors_company_id_field_supervisor_id_unique` (`company_id`,`field_supervisor_id`),
  KEY `company_field_supervisors_field_supervisor_id_foreign` (`field_supervisor_id`),
  CONSTRAINT `company_field_supervisors_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `company_field_supervisors_field_supervisor_id_foreign` FOREIGN KEY (`field_supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `company_quotas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_quotas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quota` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_quotas_company_id_period_unique` (`company_id`,`period`),
  CONSTRAINT `company_quotas_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `examiner_seminar_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `examiner_seminar_scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kp_application_id` bigint unsigned NOT NULL,
  `examiner_id` bigint unsigned NOT NULL,
  `laporan` tinyint unsigned NOT NULL DEFAULT '0',
  `presentasi` tinyint unsigned NOT NULL DEFAULT '0',
  `sikap` tinyint unsigned NOT NULL DEFAULT '0',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `total_skor` smallint unsigned NOT NULL DEFAULT '0',
  `rata_rata` decimal(5,2) NOT NULL DEFAULT '0.00',
  `nilai_huruf` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `examiner_seminar_scores_kp_application_id_examiner_id_unique` (`kp_application_id`,`examiner_id`),
  KEY `examiner_seminar_scores_examiner_id_foreign` (`examiner_id`),
  CONSTRAINT `examiner_seminar_scores_examiner_id_foreign` FOREIGN KEY (`examiner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `examiner_seminar_scores_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
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
DROP TABLE IF EXISTS `field_evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `field_evaluations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kp_application_id` bigint unsigned NOT NULL,
  `supervisor_id` bigint unsigned NOT NULL,
  `rating` tinyint unsigned NOT NULL DEFAULT '0',
  `evaluation` text COLLATE utf8mb4_unicode_ci,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_evaluations_supervisor_id_foreign` (`supervisor_id`),
  KEY `field_evaluations_kp_application_id_supervisor_id_index` (`kp_application_id`,`supervisor_id`),
  CONSTRAINT `field_evaluations_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `field_evaluations_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
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
DROP TABLE IF EXISTS `kp_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kp_applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `verification_status` enum('PENDING','APPROVED','REJECTED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `verification_notes` text COLLATE utf8mb4_unicode_ci,
  `verified_by` bigint unsigned DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `student_id` bigint unsigned NOT NULL,
  `supervisor_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placement_option` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned DEFAULT NULL,
  `custom_company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_company_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('DRAFT','SUBMITTED','VERIFIED_PRODI','ASSIGNED_SUPERVISOR','APPROVED','REJECTED','COMPLETED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `assigned_supervisor_id` bigint unsigned DEFAULT NULL,
  `field_supervisor_id` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `supervisor_period` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `krs_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `krs_drive_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proposal_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `proposal_drive_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kp_applications_student_id_foreign` (`student_id`),
  KEY `kp_applications_company_id_foreign` (`company_id`),
  KEY `kp_applications_assigned_supervisor_id_foreign` (`assigned_supervisor_id`),
  KEY `kp_applications_field_supervisor_id_foreign` (`field_supervisor_id`),
  KEY `kp_applications_verified_by_foreign` (`verified_by`),
  KEY `kp_applications_supervisor_id_index` (`supervisor_id`),
  CONSTRAINT `kp_applications_assigned_supervisor_id_foreign` FOREIGN KEY (`assigned_supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kp_applications_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kp_applications_field_supervisor_id_foreign` FOREIGN KEY (`field_supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kp_applications_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kp_applications_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kp_applications_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `kp_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kp_scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kp_application_id` bigint unsigned NOT NULL,
  `supervisor_id` bigint unsigned NOT NULL,
  `discipline` tinyint unsigned NOT NULL DEFAULT '0',
  `skill` tinyint unsigned NOT NULL DEFAULT '0',
  `attitude` tinyint unsigned NOT NULL DEFAULT '0',
  `report` tinyint unsigned NOT NULL DEFAULT '0',
  `mastery` tinyint unsigned NOT NULL DEFAULT '0',
  `final_score` decimal(5,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kp_scores_kp_application_id_supervisor_id_unique` (`kp_application_id`,`supervisor_id`),
  KEY `kp_scores_supervisor_id_foreign` (`supervisor_id`),
  CONSTRAINT `kp_scores_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kp_scores_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `mentoring_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mentoring_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kp_application_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `supervisor_id` bigint unsigned NOT NULL,
  `date` date NOT NULL,
  `topic` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `student_notes` text COLLATE utf8mb4_unicode_ci,
  `attachment_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('PENDING','APPROVED','REVISION') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mentoring_logs_kp_application_id_foreign` (`kp_application_id`),
  KEY `mentoring_logs_student_id_foreign` (`student_id`),
  KEY `mentoring_logs_supervisor_id_foreign` (`supervisor_id`),
  CONSTRAINT `mentoring_logs_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mentoring_logs_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mentoring_logs_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
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
DROP TABLE IF EXISTS `questionnaire_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questionnaire_questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `questionnaire_template_id` bigint unsigned NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` enum('text','textarea','radio','checkbox','select') COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` json DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnaire_questions_questionnaire_template_id_foreign` (`questionnaire_template_id`),
  CONSTRAINT `questionnaire_questions_questionnaire_template_id_foreign` FOREIGN KEY (`questionnaire_template_id`) REFERENCES `questionnaire_templates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `questionnaire_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questionnaire_responses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `questionnaire_template_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `kp_application_id` bigint unsigned DEFAULT NULL,
  `responses` json NOT NULL,
  `submitted_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnaire_responses_questionnaire_template_id_foreign` (`questionnaire_template_id`),
  KEY `questionnaire_responses_user_id_foreign` (`user_id`),
  KEY `questionnaire_responses_kp_application_id_foreign` (`kp_application_id`),
  CONSTRAINT `questionnaire_responses_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE SET NULL,
  CONSTRAINT `questionnaire_responses_questionnaire_template_id_foreign` FOREIGN KEY (`questionnaire_template_id`) REFERENCES `questionnaire_templates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questionnaire_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `questionnaire_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questionnaire_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kp_application_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `answers` json NOT NULL,
  `submitted_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnaire_submissions_kp_application_id_foreign` (`kp_application_id`),
  KEY `questionnaire_submissions_student_id_foreign` (`student_id`),
  CONSTRAINT `questionnaire_submissions_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questionnaire_submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `questionnaire_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questionnaire_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `target_role` enum('MAHASISWA','DOSEN_SUPERVISOR','PENGAWAS_LAPANGAN') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kp_application_id` bigint unsigned NOT NULL,
  `student_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `status` enum('SUBMITTED','VERIFIED_PRODI','REVISION','APPROVED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SUBMITTED',
  `grade` tinyint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_kp_application_id_foreign` (`kp_application_id`),
  KEY `reports_student_id_foreign` (`student_id`),
  CONSTRAINT `reports_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `seminar_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seminar_applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `kegiatan_harian_drive_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bimbingan_kp_drive_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('PENDING','APPROVED','REJECTED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `examiner_id` bigint unsigned DEFAULT NULL,
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seminar_date` date DEFAULT NULL,
  `seminar_time` time DEFAULT NULL,
  `seminar_location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `examiner_notes` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `seminar_applications_student_id_foreign` (`student_id`),
  KEY `seminar_applications_examiner_id_foreign` (`examiner_id`),
  CONSTRAINT `seminar_applications_examiner_id_foreign` FOREIGN KEY (`examiner_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `seminar_applications_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
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
DROP TABLE IF EXISTS `supervisor_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supervisor_scores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kp_application_id` bigint unsigned NOT NULL,
  `supervisor_id` bigint unsigned NOT NULL,
  `report` tinyint unsigned NOT NULL DEFAULT '0',
  `presentation` tinyint unsigned NOT NULL DEFAULT '0',
  `attitude` tinyint unsigned NOT NULL DEFAULT '0',
  `final_score` decimal(5,2) NOT NULL DEFAULT '0.00',
  `grade` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `supervisor_scores_kp_application_id_supervisor_id_unique` (`kp_application_id`,`supervisor_id`),
  KEY `supervisor_scores_supervisor_id_foreign` (`supervisor_id`),
  CONSTRAINT `supervisor_scores_kp_application_id_foreign` FOREIGN KEY (`kp_application_id`) REFERENCES `kp_applications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `supervisor_scores_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prodi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('MAHASISWA','ADMIN_PRODI','DOSEN_SUPERVISOR','PENGAWAS_LAPANGAN','SUPERADMIN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MAHASISWA',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `supervisor_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_supervisor_id_foreign` (`supervisor_id`),
  CONSTRAINT `users_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2025_01_01_000000_create_seminar_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2025_09_23_052513_add_role_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2025_09_23_052606_create_companies_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2025_09_23_052704_create_kp_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2025_09_23_052741_create_mentoring_logs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2025_09_23_052822_create_activity_logs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2025_09_23_052921_create_reports_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2025_09_23_053000_create_questionnaire_submissions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2025_09_24_144237_add_krs_path_to_kp_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2025_10_03_111415_add_verification_fields_to_kp_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2025_10_13_065153_create_kp_scores',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2025_10_13_065250_create_field_evaluations',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2025_10_13_070605_create_add_supervisor_period_to_kp_applications',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2025_10_13_070749_create_company_quotas_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2025_10_13_074528_create_add_supervisor_to_kp_applications',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2025_10_13_094518_add_is_active_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2025_10_13_120823_add_supervisor_id_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2025_10_13_191728_add_student_notes_to_mentoring_logs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2025_10_13_211758_create_company_field_supervisors_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2025_10_15_161144_add_proposal_and_approval_paths_to_kp_applications_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2025_11_05_085535_add_mastery_to_kp_scores_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2025_11_07_142008_create_supervisor_scores_table',2);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2025_11_08_161141_add_seminar_schedule_fields_to_seminar_applications_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2025_11_08_161157_add_seminar_schedule_fields_to_seminar_applications_table',3);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2025_11_09_165857_create_examiner_seminar_scores_table',4);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2025_11_09_042929_add_drive_links_to_kp_applications_table',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2025_11_09_175019_alter_examiner_seminar_scores_total_skor_column_type',5);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2025_11_10_064941_rename_photo_path_to_drive_link_in_activity_logs_table',6);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2025_11_10_070625_rename_seminar_paths_to_drive_links',7);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2025_11_11_000000_create_questionnaire_templates_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2025_11_11_000001_create_questionnaire_questions_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2025_11_11_000002_create_questionnaire_responses_table',8);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2025_11_28_211845_add_approval_drive_link_to_kp_applications_table',9);
