CREATE TABLE `kk_schecule_define` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sch_no` varchar(30) DEFAULT NULL,
  `sch_name` varchar(255) DEFAULT NULL,
  `sch_namestr` varchar(255) DEFAULT NULL,
  `sch_type` char(255) DEFAULT NULL,
  `sch_jobclass` varchar(255) DEFAULT NULL,
  `sch_lastjob` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;