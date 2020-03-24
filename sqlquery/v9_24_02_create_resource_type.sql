CREATE TABLE `resource_type` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `resource_type_name` varchar(255) DEFAULT NULL COMMENT '类型名称',
  `resource_filetype` varchar(10) DEFAULT NULL COMMENT '文件类型',
  `resource_pre_logic` varchar(255) DEFAULT NULL COMMENT '前置处理类',
  `resource_post_logic` varchar(255) DEFAULT NULL COMMENT '后置处理类',
  `resource_model_id` bigint(20) DEFAULT NULL COMMENT '关联model id',
  `resource_model_name` varchar(255) DEFAULT NULL COMMENT '关联modelname',
  `resource_pre_param` varchar(255) DEFAULT NULL COMMENT '前置处理参数',
  `resource_post_param` varchar(255) DEFAULT NULL COMMENT '后置处理参数',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `udpated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;