INSERT INTO `event_define` (`id`, `event_name`, `event_key`, `event_model`, `event_type`, `event_filter`, `event_level`, `event_queue_type`, `event_observer`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'充值','saved','App\\Model\\Cash\\Recharge','NY00',NULL,'1','','App\\Observers\\RechargeObserver',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'提现','saved','App\\Model\\Cash\\Withdrawal','NY00',NULL,'1','','App\\Observers\\WithdrawalObserver',NULL,NULL,NULL,NULL,NULL,NULL);