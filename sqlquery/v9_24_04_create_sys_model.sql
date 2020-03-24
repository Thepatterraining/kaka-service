CREATE TABLE `sys_model` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `model_name` varchar(255) DEFAULT NULL COMMENT '模型名称',
  `model_class` varchar(255) DEFAULT NULL COMMENT '类名',
  `model_filename` varchar(255) DEFAULT NULL COMMENT '文件名',
  `model_table` varchar(255) DEFAULT NULL COMMENT '表名',
  `model_version` varchar(255) DEFAULT NULL COMMENT '版本号',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;