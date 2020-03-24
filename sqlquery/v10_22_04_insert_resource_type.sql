truncate table `resource_type`; 
INSERT INTO `resource_type` (`id`, `resource_type_name`, `resource_filetype`, `resource_pre_logic`, `resource_post_logic`, `resource_model_id`, `resource_model_name`, `resource_pre_param`, `resource_post_param`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
    (null,"户型图","jpeg",null,null,1,"项目管理",null,null,NULL,NULL,null,NULL,NULL,NULL),
	  (null,"内景图","jpg",null,null,1,"项目管理",null,null,NULL,NULL,null,NULL,NULL,NULL),
    (null,"外景图","jpg",null,null,1,"项目管理",null,null,NULL,NULL,null,NULL,NULL,NULL),
    (null,"购房合同","jpg",null,null,1,"项目管理",null,null,NULL,NULL,null,NULL,NULL,NULL),
    (null,"房产证","jpg",null,null,1,"项目管理",null,null,NULL,NULL,null,NULL,NULL,NULL),
    (null,"公证文件","jpg",null,null,1,"项目管理",null,null,NULL,NULL,null,NULL,NULL,NULL),
    (null,"总览图","png",null,null,1,"项目管理",null,null,NULL,NULL,null,NULL,NULL,NULL),
    (null,"公章","png",null,null,1,"项目管理",null,null,NULL,NULL,null,NULL,NULL,NULL);           