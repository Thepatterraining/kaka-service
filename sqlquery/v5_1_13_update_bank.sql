

-- 银行表
DROP TABLE IF EXISTS `finance_bank`;

CREATE TABLE `finance_bank` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `bank_no` varchar(30) NOT NULL DEFAULT '' COMMENT '银行编号 | 目前默认 "" ',
  `bank_name` varchar(255) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_short` varchar(255) NOT NULL DEFAULT '' COMMENT '银行简称',
  `bank_fullname` varchar(255) NOT NULL DEFAULT '' COMMENT '银行全称',
  `bank_source` varchar(20) DEFAULT '' COMMENT '添加来源 字典表`bank_source` `BS01` = 系统 `BS02` 用戶添加',
  `bank_icon` text COMMENT '银行的图标 base 64字符串  目前留空 ',
  `bank_ischeck` bit(1) DEFAULT b'0' COMMENT '是否已经审核',
  `bank_checkser` varchar(255) DEFAULT '' COMMENT '审核人',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `finance_bank` (`id`, `bank_no`, `bank_name`, `bank_short`, `bank_fullname`, `bank_source`, `bank_icon`, `bank_ischeck`, `bank_checkser`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'1','招商银行','','','BS01','/upload/bankLogo/banklogo-05.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'2','中国银行','','','BS01','/upload/bankLogo/banklogo-03.svg',b'1','262','2017-05-04 17:14:27','2017-05-04 17:40:48',NULL,262,NULL,NULL),
	(3,'3','建设银行','','','BS01','/upload/bankLogo/banklogo-02.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'4','交通银行','','','BS01','/upload/bankLogo/banklogo-04.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'5','农业银行','','','BS01','/upload/bankLogo/banklogo-06.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'6','工商银行','','','BS01','/upload/bankLogo/banklogo-01.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'7','中国邮政储蓄银行','','','BS01','/upload/bankLogo/banklogo-07.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'8','中国光大银行','','','BS01','/upload/bankLogo/banklogo-08.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(9,'9','中国民生银行','','','BS01','/upload/bankLogo/banklogo-09.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(10,'10','平安银行','','','BS01','/upload/bankLogo/banklogo-12.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'11','浦发银行','','','BS01','/upload/bankLogo/banklogo-10.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(12,'12','中信银行','','','BS01','/upload/bankLogo/banklogo-11.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(13,'13','兴业银行','','','BS01','/upload/bankLogo/banklogo-13.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(14,'14','华夏银行','','','BS01','/upload/bankLogo/banklogo-14.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(15,'15','广发银行','','','BS01','/upload/bankLogo/banklogo-15.svg',b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(21,'17','其他银行','','','BS01','/upload/bankLogo/qitayinhang.png',b'1','',NULL,NULL,NULL,NULL,NULL,NULL);


-- 支行表

INSERT INTO `sys_bank` (`id`, `bank_type`, `bank_name`, `bank_add`, `bank_no`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(366,'','北京三元桥支行','','9',NULL,NULL,NULL,NULL,NULL,NULL);


-- 系统银行卡

truncate table `cash_bank_account`;

INSERT INTO `cash_bank_account` (`id`, `account_no`, `account_name`, `account_bank`, `account_cash`, `account_pending`, `account_change_time`, `account_settelment_time`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `account_remark`, `account_type`)
VALUES
	(null,'110925871910602','咔咔房链（北京）科技有限公司',1,0.000,0.000,'2017-05-19 18:32:48','1970-01-01 00:00:00',NULL,'2017-05-19 18:32:48','2017-05-19 00:00:00',NULL,NULL,NULL,'','AC05'),
	(null,'110925871910801','咔咔房链（北京）科技有限公司',1,0.000,0.000,'2017-05-19 22:04:17','1970-01-01 00:00:00','2017-05-13 18:31:03','2017-05-19 22:04:17',NULL,262,NULL,NULL,'','AC06'),
	(null,'110925871910801','咔咔房链（北京）科技有限公司',1,0.000,0.000,'2017-05-19 22:04:17','1970-01-01 00:00:00','2017-05-13 18:31:03','2017-05-19 22:04:17',NULL,262,NULL,NULL,'','AC04'),
	(null,'152501671','咔咔房链（北京）科技有限公司',366,0.000,0.000,'1970-01-01 00:00:00','1970-01-01 00:00:00',NULL,NULL,NULL,NULL,NULL,NULL,'','AC05');