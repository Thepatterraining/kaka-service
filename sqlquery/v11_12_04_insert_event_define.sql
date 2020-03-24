INSERT INTO `event_define` (`id`, `event_name`, `event_key`, `event_model`, `event_type`, `event_filter`, `event_level`, `event_queue_type`, `event_observer`, `event_param`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'新手标','saved','App\\Model\\Lending\\LendingDocInfo','NY00',NULL,'1','','App\\Observers\\LendingDocInfoObserver','{"voucherNo":"VCN2017111115042590278"}',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'提现','saved','App\\Model\\App\\UserInfo','NY00',NULL,'1','','App\\Observers\\UserInfoObserver','{"price":0,"coinType":"KKC-BJ0006","count":1}',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'分红','saved','App\\Model\\Bonus\\ProjBonusItem','NY00',NULL,'1','','App\\Observers\\ProjBonusItemObserver',NULL,NULL,NULL,NULL,NULL,NULL,NULL);