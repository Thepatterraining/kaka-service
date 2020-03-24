CREATE TABLE `project_bonustype` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bonus_name` varchar(255) DEFAULT NULL COMMENT '名称',
  `bonus_type` varchar(255) DEFAULT NULL COMMENT '分红方式',
  `bonus_cyc` varchar(255) DEFAULT NULL COMMENT '分红周期',
  `bonus_confirminfo` varchar(255) DEFAULT NULL COMMENT '确权说明',
  `bonus_confirmexp` varchar(255) DEFAULT NULL COMMENT '确权日表达式',
  `bonus_diviendinfo` varchar(255) DEFAULT NULL COMMENT '分红说明',
  `bonus_diviendexp` varchar(255) DEFAULT NULL COMMENT '分红日表达式',
  `bonus_rate` varchar(255) DEFAULT '' COMMENT '分红率',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;