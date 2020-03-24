

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
	(1,'1','招商银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'2','中国银行','','','BS01',NULL,b'1','262','2017-05-04 17:14:27','2017-05-04 17:40:48',NULL,262,NULL,NULL),
	(3,'3','建设银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'3','交通银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'3','农业银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'3','招商银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'3','中国邮政储蓄银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'3','中国光大银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(9,'3','中国民生银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(10,'3','平安银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'3','浦发银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(12,'3','中信银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(13,'3','兴业银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(14,'3','华夏银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(15,'3','广发银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL);