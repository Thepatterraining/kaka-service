INSERT INTO `event_define` (`id`, `event_name`, `event_key`, `event_model`, `event_type`, `event_filter`,`event_level`,`event_queue_type`,`event_observer`,`created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,"挂买单","saved","App\\Model\\Trade\\TranactionBuy","NY00",null,1,"transaction","App\\Observers\\TransactionBuyObserver",NULL,NULL,null,NULL,NULL,NULL),
	(null,"挂卖单","saved","App\\Model\\Trade\\TranactionSell","NY00",null,1,"transaction","App\\Observers\\TransactionSellObserver",NULL,NULL,null,NULL,NULL,NULL),
	(null,"交易","saved","App\\Model\\Trade\\TranactionOrder","NY00",null,1,"transaction","App\\Observers\\TransactionOrderObserver",NULL,NULL,null,NULL,NULL,NULL);