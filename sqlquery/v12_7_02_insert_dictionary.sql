INSERT INTO `sys_dictionary` (`id`, `dic_no`, `dic_type`, `dic_name`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'CAS00','coin_address_status','已提交',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CAS01','coin_address_status','实名已认证',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CAS02','coin_address_status','实名认证失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CAS03','coin_address_status','地址已认证',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'CAS03','coin_address_status','地址认证失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'TLT01','coin_trans_type','地址认证失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'TLS01','coin_trans_status','已提交',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'TLS02','coin_trans_status','成功',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'TLS03','coin_trans_status','拒绝',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'SLT21','sms_code','kyc验证',NULL,NULL,NULL,NULL,NULL,NULL);