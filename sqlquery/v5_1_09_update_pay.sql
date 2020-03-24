
-- 增加通道信息

truncate table `sys_3rd_pay_channel`;
INSERT INTO `sys_3rd_pay_channel` (`id`, `channel_name`, `channel_payplatform`, `channel_infeerate`, `channel_infeetype`, `channel_outfeerate`, `channel_outfeetype`, `channel_withdrawtype`, `channel_withdrawset`, `channel_withdralbankno`, `channel_dealclass`, `channel_ammout`, `chnnnel_pending`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'支付宝-扫码支付(光大银行)',1,0.00350,'FR01',0.00000,'FR00','3RD02','','110925871910801','',0.000,0.000,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'线下扫码支付(光大深圳)-微信',1,0.00350,'FR01',0.00000,'FR00','3RD02','','110925871910801','',0.000,0.000,NULL,NULL,NULL,NULL,NULL,NULL);




-- 增加pay

truncate table `sys_3rd_pay`;
INSERT INTO `sys_3rd_pay` (`id`, `pay_name`, `pay_accessid`, `pay_accesskey`, `pay_cusno`, `pay_remark1`, `pay_remark2`, `pay_remark3`, `pay_assuserid`, `pay_chkuserid`, `pay_settelmentuserid`, `pay_withdrawalintype`, `pay_withdrawalbankno`, `pay_feebankno`, `pay_ammount`, `pay_pending`, `pay_provisions`, `pay_trusteeship`, `company_type`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'全码付','105580006455','98955ba5c937c6f4c51c93d4eb347d17','105580006455','','','',0,0,0,'3RDIN02','110925871910801','110925871910801',0.000,0.000,'110925871910801','110925871910801','',NULL,NULL,NULL,NULL,NULL,NULL);


-- 增加sys_3rd_pay_channelmethod
truncate table `sys_3rd_pay_channelmethod`;

INSERT INTO `sys_3rd_pay_channelmethod` (`id`, `channel_id`, `method_id`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,1,1,NULL,NULL,NULL,NULL,NULL,NULL);

-- 增加sys_3rd_pay_methods
truncate table `sys_3rd_pay_methods`;

INSERT INTO `sys_3rd_pay_methods` (`id`, `method_name`, `method_inputrequireclass`, `method_inputclass`, `method_invokeclass`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'','','','',NULL,NULL,NULL,NULL,NULL,NULL);