INSERT INTO `event_notifydefine` (`id`, `notify_name`, `notify_event`, `notify_filter`, `notify_type`, `notify_specialclass`,`notify_level`,`notify_fmt`,`created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,"后端获知代币对账错误",13,null,"NT01",null,1,NULL,null,NULL,NULL,NULL,null,null),
	(null,"后端获知现金对账错误",14,null,"NT01",NULL,1,null,NULL,null,NULL,NULL,NULL,null),
	(null,"后端获知DB错误",15,null,"NT01","App\\Data\\Sys\\LogData",1,null,null,null,NULL,NULL,NULL,null);