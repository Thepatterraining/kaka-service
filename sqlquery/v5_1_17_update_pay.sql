

-- 加入支付宝

truncate table `sys_3rd_pay_channel`;

INSERT INTO `sys_3rd_pay_channel` (`id`, `channel_name`, `channel_payplatform`, `channel_infeerate`, `channel_infeetype`, `channel_outfeerate`, `channel_outfeetype`, `channel_withdrawtype`, `channel_withdrawset`, `channel_withdralbankno`, `channel_dealclass`, `channel_ammout`, `channel_pending`, `channel_icon`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'支付宝-扫码支付(光大银行)',1,0.00350,'FR01',0.00000,'FR00','3RD02','','110925871910801','swift.alipay',0.000,0.000,'/upload/pay/zhifubaosaoma.png',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'线下扫码支付(光大深圳)-微信',1,0.00350,'FR01',0.00000,'FR00','3RD02','','110925871910801','swift.wechat',0.000,0.000,'/upload/pay/weixinsaoma.png',NULL,NULL,NULL,NULL,NULL,NULL);

