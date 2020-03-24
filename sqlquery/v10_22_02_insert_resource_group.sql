truncate table `resource_group`; 
INSERT INTO `resource_group` (`id`, `resource_model_id`, `resource_group`, `resource_group_include`, `resource_group_level`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,1,"房产图片","外景图 内景图",2,NULL,NULL,null,NULL,NULL,NULL),
	(null,1,"房产权证","购房合同 房产证 公证文件",1,NULL,NULL,null,NULL,NULL,NULL);