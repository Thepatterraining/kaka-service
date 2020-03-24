CREATE TABLE `kk_schecule_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sch_itemno` varchar(30) DEFAULT '',
  `sch_defno` varchar(30) DEFAULT 'JS01',
  `sch_itemname` varchar(255) DEFAULT NULL,
  `sch_jobno` varchar(255) DEFAULT NULL,
  `sch_status` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;