INSERT INTO `event_notifydefine` (`id`, `notify_name`, `notify_event`, `notify_filter`, `notify_type`, `notify_specialclass`,`notify_level`,`notify_fmt`,`created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,"获知买单撤销",6,null,'NT01',"App\\Data\\Trade\\TranactionBuyData",1,NULL,NULL,null,NULL,NULL,NULL,null),
    (null,"获知卖单撤销",7,null,'NT01',"App\\Data\\Trade\\TranactionSellData",1,NULL,NULL,null,NULL,NULL,NULL,null),
    (null,"获知交易撤销",8,null,'NT01',"App\\Data\\Trade\\TranactionOrderData",1,NULL,NULL,null,NULL,NULL,NULL,null);