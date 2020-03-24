

INSERT INTO `sys_dictionary` (`id`, `dic_no`, `dic_type`, `dic_name`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'SCJ10','syscash_journal','内部转账','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(null,'CJT11','cjournal_type','内部转账',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJT12','cjournal_type','外部转账',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJDT01','cash_journaldoc_type','转入',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJDT02','cash_journaldoc_type','转出',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJ16','usercash_journal','冻结',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJ17','usercash_journal','解冻',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJT10','journal_type','冻结',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJT11','journal_type','解冻',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJDS01','cash_journaldoc_status','申请',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJDS02','cash_journaldoc_status','审核',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CJDS03','cash_journaldoc_status','拒绝',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'SCJDS01','syscash_journaldoc_status','申请',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'SCJDS02','syscash_journaldoc_status','审核',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'SCJDS03','syscash_journaldoc_status','拒绝',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'SCJDT01','syscash_journaldoc_type','内部',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'UCFDS01','usercash_freezondoc_status','申请',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'UCFDS02','usercash_freezondoc_status','审核',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'UCFDS03','usercash_freezondoc_status','拒绝',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'UCFDT01','usercash_freezondoc_type','冻结',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'UCFDT02','usercash_freezondoc_type','解冻',NULL,NULL,NULL,NULL,NULL,NULL);