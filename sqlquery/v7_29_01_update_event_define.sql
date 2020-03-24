truncate table `event_define`;
INSERT INTO `event_define` (`id`, `event_name`, `event_key`, `event_model`, `event_type`, `event_filter`,`event_level`,`created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,"每日汇总",null,'\\App\\Data\\Notify\\INotifyData','NY01',null,1,NULL,NULL,null,NULL,NULL,NULL);