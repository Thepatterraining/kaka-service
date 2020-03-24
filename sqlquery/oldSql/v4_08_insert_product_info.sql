
-- 字典表
DROP TABLE IF EXISTS `product_info`;

CREATE TABLE `product_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `product_no` varchar(255) NOT NULL DEFAULT '' COMMENT '产品编号 前缀pro',
  `product_name` varchar(255) NOT NULL DEFAULT '' COMMENT '产品名称',
  `product_coin` varchar(255) NOT NULL DEFAULT '' COMMENT '产品的关联代币',
  `product_starttime` datetime DEFAULT '1970-01-01 00:00:00' COMMENT '产品起售时间',
  `product_status` varchar(10) DEFAULT '' COMMENT '字典表product_status PRS01 未开始 PRS02 发售中 PRS03 已售罄',
  `product_owner` bigint(20) DEFAULT '0' COMMENT '产品创建人',
  `product_feetype` varchar(255) DEFAULT '' COMMENT '费率类型',
  `product_feerate` decimal(20,5) DEFAULT '0.000' COMMENT '费率',
  `product_voucherenable` bit(1) DEFAULT b'1' COMMENT '是否可用代金券',
  `product_price` decimal(20,3) DEFAULT '0.000' COMMENT '单价',
  `product_count` decimal(20,9) DEFAULT '0.000000000' COMMENT '数量',
  `product_amount` decimal(20,3) DEFAULT '0.000' COMMENT '总金额',
  `product_sellno` varchar(30) DEFAULT '' COMMENT '卖单号',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  `product_frozentime` bigint(20) NOT NULL DEFAULT '0' COMMENT '冻结期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `product_info` (`id`, `product_no`, `product_name`, `product_coin`, `product_starttime`, `product_status`, `product_owner`, `product_feetype`, `product_feerate`, `product_voucherenable`, `product_price`, `product_count`, `product_amount`, `product_sellno`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `product_frozentime`)
VALUES
	(null,'PRO2017042719481748801','双旗杆东里一期','KKC-BJ0001','2017-04-27 19:48:17','PRS02',1,'FR01',0.00027,b'1',1400.000,10.000000000,14000.000,'TS2017042719481708848','2017-04-27 19:48:17','2017-04-27 19:48:17',NULL,1,NULL,NULL,0);


-- 插入卖单表

INSERT INTO `transaction_sell` (`id`, `sell_no`, `sell_count`, `sell_limit`, `sell_feerate`, `sell_ammount`, `sell_userid`, `sell_usercointaccount`, `sell_transcount`, `sell_transammount`, `sell_status`, `sell_lasttranstime`, `sell_leveltype`, `sell_cointype`, `sell_region`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `sell_feetype`, `sell_coinfeerate`, `sell_coinfeetype`, `sell_cashfeehidden`, `sell_coinfeehidden`, `sell_showcoinprice`, `sell_showcoincount`, `sell_coinfee`)
VALUES
(null,'TS2017042719481708848',10.00000000,1400.000,0.00270,14000.000,1,1,0.00000000,0.000,'TS00','1970-01-01 00:00:00','SL01','KKC-BJ0001','西城','2017-04-27 21:01:44','2017-04-27 21:01:44',NULL,1,NULL,NULL,'FR01',0.000,'FR00',1,1,1396.230,10.00000000,0.00000000);


-- 插入趋势

INSERT INTO `proj_trend` (`id`, `proj_no`, `proj_price`, `proj_time`, `proj_pricetype`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'KKC-BJ0001',1400.00,'2017-04-30','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',1500.00,'2017-05-30','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',1600.00,'2017-06-30','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',1700.00,'2017-07-30','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',1800.00,'2017-08-30','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',1400.00,'2017-09-30','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL);