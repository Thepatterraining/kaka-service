CREATE TABLE `resource_bannerpic` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `banner_name` varchar(255) DEFAULT NULL COMMENT '名称',
  `banner_resourceid` bigint(20) DEFAULT NULL COMMENT '资源id',
  `banner_index` bigint(20) DEFAULT NULL COMMENT '索引',
  `banner_model_define_id` bigint(20) DEFAULT NULL COMMENT '模型定义id',
  `banner_model_define_name` varchar(255) DEFAULT NULL COMMENT '模型名称',
  `banner_model_define_data_id` bigint(20) DEFAULT NULL COMMENT '模型数据id',
  `banner_res_model_define_id` bigint(20) DEFAULT NULL COMMENT '关联模型定义id',
  `banner_res_model_define_name` varchar(255) DEFAULT NULL COMMENT '关联模型定义名称',
  `banner_res_model_data_id` bigint(20) DEFAULT NULL COMMENT '关联模型id',
  `banner_res_url` varchar(255) DEFAULT NULL COMMENT '关联链接',
  `banner_show_level` int(11) NOT NULL DEFAULT '1' COMMENT '展示优先级，1最小',
  `banner_note` varchar(255) DEFAULT NULL COMMENT '说明',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;