INSERT INTO `event_notifydefine` (`id`, `notify_name`, `notify_event`, `notify_filter`, `notify_type`, `notify_specialclass`, `notify_level`, `notify_fmt`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'新手标回收发券',19,NULL,'NT01','App\\Data\\Activity\\VoucherStorageData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'首次绑定',20,NULL,'NT01','App\\Data\\App\\UserInfoData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'分红短信',21,NULL,'NT02','App\\Data\\Bonus\\ProjBonusItemData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL);