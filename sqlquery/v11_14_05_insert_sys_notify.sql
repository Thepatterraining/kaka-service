INSERT INTO `sys_notify` (`id`, `notify_type`, `notify_fmt`, `notify_user_filter`, `noiffy_event`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `notify_model`)
VALUES
	(null,'NT12','您好，您有项目到账。','','sysCoin_toUser_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Lending\\LendingDocInfo'),
	(null,'NT13','您好，您有项目被收回。','','sysCoin_UserReturn_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Lending\\LendingDocInfo'),
	(null,'NT06','系统向您账户中发放了{$item->voucher_val2}元理财金券，请及时使用。','','NewUser_Voucher_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Activity\\VoucherInfo'),
	(null,'NT09','您好，您本月的收益已到账','','NewUser_Bonus_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Bonus\\ProjBonusItem');