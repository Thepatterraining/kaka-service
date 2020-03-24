


DROP TABLE IF EXISTS `sys_3rd_pay_channel`;

CREATE TABLE `sys_3rd_pay_channel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `channel_name` varchar(255) NOT NULL DEFAULT '' COMMENT '通道名称',
  `channel_payplatform` bigint NOT NULL DEFAULT 0 COMMENT '所属支付平台',
  `channel_infeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '入帐费率',
  `channel_infeetype` char(20) NOT NULL DEFAULT '' COMMENT '入帐费率类型',
  `channel_outfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '提现费率',
  `channel_outfeetype` char(20) NOT NULL DEFAULT '' COMMENT '提现费率类型',
  `channel_withdrawtype` char(20) NOT NULL DEFAULT '' COMMENT '提现类型 字典表 3rd_withdrawal 3RD01 人工 3RD02 自动日结 3RD03 自动周结 4RD04 自动月结',
  `channel_withdrawset` varchar(255) NOT NULL DEFAULT '' COMMENT '提现周期设定',
  `channel_withdralbankno` char(20) NOT NULL DEFAULT '' COMMENT '提现帐号',
  `channel_dealclass` varchar(255) NOT NULL DEFAULT '' COMMENT '处理类',
  `channel_ammout` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '可用',
  `channel_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途',
  `channel_icon` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sys_3rd_pay_channel` (`id`, `channel_name`, `channel_payplatform`, `channel_infeerate`, `channel_infeetype`, `channel_outfeerate`, `channel_outfeetype`, `channel_withdrawtype`, `channel_withdrawset`, `channel_withdralbankno`, `channel_dealclass`, `channel_ammout`, `channel_pending`, `channel_icon`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'支付宝-扫码支付(光大银行)',1,0.00350,'FR01',0.00000,'FR00','3RD02','','110925871910801','',0.000,0.000,'/upload/pay/zhifubaosaoma.png',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'线下扫码支付(光大深圳)-微信',1,0.00350,'FR01',0.00000,'FR00','3RD02','','110925871910801','',0.000,0.000,'/upload/pay/weixinsaoma.png',NULL,NULL,NULL,NULL,NULL,NULL);


