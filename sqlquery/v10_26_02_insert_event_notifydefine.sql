INSERT INTO `event_notifydefine` (`id`, `notify_name`, `notify_event`, `notify_filter`, `notify_type`, `notify_specialclass`, `notify_level`, `notify_fmt`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'充值短信提醒',17,NULL,'NT02','App\\Data\\Cash\\RechargeData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'提现短信提醒',18,NULL,'NT02','App\\Data\\Cash\\WithdrawalData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL);