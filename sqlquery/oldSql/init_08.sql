truncate table `sys_bank`;
INSERT INTO `sys_bank` (`id`, `bank_type`, `bank_name`, `bank_add`, `bank_no`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'B07','西坝河支行','null','null',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'B03','三元桥','null','null','2017-04-05 15:59:31','2017-04-05 15:59:31',NULL,227,NULL,NULL),
	(3,'B04','qwertgyh','null','null','2017-04-05 16:13:42','2017-04-05 16:13:42',NULL,228,NULL,NULL);

truncate table `sys_cash_account`;
INSERT INTO `sys_cash_account` (`id`, `account_cash`, `account_pending`, `account_change_time`, `account_settelment_time`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,0.0, 0.000, '2017-03-31 14:48:31', '1970-01-01 00:00:00', NULL, '2017-03-31 14:48:31', NULL, NULL, NULL, NULL);

truncate table `sys_cash`;
INSERT INTO `sys_cash` (`id`, `sys_account_cash`, `sys_account_pending`, `sys_account_change_time`, `sys_account_settelment_time`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1, 0.0, 0.000, '2017-03-31 12:09:01', '1970-01-01 00:00:00', NULL, '2017-03-31 12:09:01', NULL, NULL, NULL, NULL);

truncate table `cash_bank_account`;
INSERT INTO `cash_bank_account` (`id`, `account_no`, `account_name`, `account_bank`, `account_cash`, `account_pending`, `account_change_time`, `account_settelment_time`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'6231560201139467','谭博超',1,0,0,'2017-04-05 08:42:33','1970-01-01 00:00:00',NULL,'2017-04-05 08:42:33',NULL,NULL,NULL,NULL);
