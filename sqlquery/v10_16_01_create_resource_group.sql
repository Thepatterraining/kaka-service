CREATE TABLE `resource_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `resource_model_id` bigint(20) DEFAULT NULL COMMENT '项目id',
  `resource_group` varchar(255) DEFAULT NULL COMMENT '组别名称',
  `resource_group_include` varchar(255) DEFAULT NULL COMMENT '组别包含资源',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` datetime DEFAULT NULL,
  `updated_id` datetime DEFAULT NULL,
  `deleted_id` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;