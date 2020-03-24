CREATE TABLE `resource_index` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `resource_id` bigint(20) DEFAULT NULL COMMENT '存储id',
  `resource_typeid` bigint(20) DEFAULT NULL COMMENT '资源类型',
  `resource_modelid` varchar(255) DEFAULT NULL COMMENT '项目id',
  `resource_itemno` int(11) DEFAULT NULL COMMENT '索引',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;