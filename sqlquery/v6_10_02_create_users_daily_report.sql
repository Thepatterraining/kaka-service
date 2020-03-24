CREATE TABLE `report_users_daily` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `report_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_intcount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_acscount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_currentcount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_lastlogin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_acslogin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_currentlogin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_start` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_end` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;