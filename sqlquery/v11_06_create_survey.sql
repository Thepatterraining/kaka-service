CREATE TABLE `activity_survey_info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `survey_invcode` varchar(30) NOT NULL DEFAULT '',
  `survey_name` varchar(30) NOT NULL DEFAULT '',
  `survey_mobile` char(11) NOT NULL DEFAULT '',
  `survey_city` varchar(30) NOT NULL DEFAULT '',
  `survey_idno` char(18) NOT NULL DEFAULT '',
  `survey_reg` int(11) NOT NULL DEFAULT '0',
  `survey_regid` bigint(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `survey_birth` date DEFAULT NULL,
  `survey_idpre` char(6) DEFAULT NULL,
  `survey_income` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;