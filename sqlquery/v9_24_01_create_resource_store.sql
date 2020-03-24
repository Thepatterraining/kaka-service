CREATE TABLE `resource_store` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `filename` varchar(255) DEFAULT NULL COMMENT '文件名',
  `filetype` varchar(10) DEFAULT NULL COMMENT '文件类型',
  `storeid` varchar(255) DEFAULT NULL COMMENT '外部存储ID',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;