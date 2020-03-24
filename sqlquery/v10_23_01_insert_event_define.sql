INSERT INTO `event_define` (`id`, `event_name`, `event_key`, `event_model`, `event_type`, `event_filter`,`event_level`,`event_queue_type`,`event_observer`,`created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,"代币对账错误",null,null,'NY05','\\App\\Data\\Notify\\INotifyData',1,null,null,NULL,NULL,null,NULL,NULL,NULL),
	(null,"现金对账错误",null,null,'NY06','\\App\\Data\\Notify\\INotifyData',1,null,null,NULL,NULL,null,NULL,NULL,NULL),
	(null,"DB错误","created",'\\App\\Model\\Sys\\Log','NY07','\\App\\Data\\Notify\\INotifyData',1,"","App\\Observers\\DBErrorObserver",null,NULL,null,NULL,NULL,NULL);