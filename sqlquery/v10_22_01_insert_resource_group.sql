drop table `resource_group`; 
CREATE TABLE `resource_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `resource_model_id` bigint(20) DEFAULT NULL COMMENT '项目id',
  `resource_group` varchar(255) DEFAULT NULL COMMENT '组别名称',
  `resource_group_include` varchar(255) DEFAULT NULL COMMENT '组别包含资源',
  `resource_group_level` bigint(20) DEFAULT NULL COMMENT '组别展示优先级',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` datetime DEFAULT NULL,
  `updated_id` datetime DEFAULT NULL,
  `deleted_id` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `resource_group` (`id`, `resource_model_id`, `resource_group`, `resource_group_include`, `resource_group_level`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,1,"房产图片","外景图 内景图",2,NULL,NULL,null,NULL,NULL,NULL),
	(null,1,"房产权证","购房合同 房产证 公证文件",1,NULL,NULL,null,NULL,NULL,NULL);