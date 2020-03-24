

-- 产品表
DROP TABLE IF EXISTS `product_info`;

CREATE TABLE `product_info` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'id',
  `product_no` varchar(255) NOT NULL DEFAULT '' COMMENT '产品编号 前缀pro',
	`product_name` varchar(255) NOT NULL DEFAULT '' COMMENT '产品名称',
	`product_coin` varchar(255) NOT NULL DEFAULT '' COMMENT '产品的关联代币',
	`product_starttime` datetime DEFAULT '1970-01-01 00:00:00' COMMENT '产品起售时间',
	`product_status` varchar(10) DEFAULT '' COMMENT '字典表product_status PRS01 未开始 PRS02 发售中 PRS03 已售罄',
	`product_owner` bigint DEFAULT 0 COMMENT '产品创建人',
	`product_feetype` varchar(255) DEFAULT '' COMMENT '费率类型',
	`product_feerate` decimal(20,3) DEFAULT 0 COMMENT '费率',
	`product_voucherenable` bit DEFAULT 1 COMMENT '是否可用代金券',
	`product_price` decimal(20,3) DEFAULT 0 COMMENT '单价',
	`product_count` decimal(20,9) DEFAULT 0 COMMENT '数量',
	`product_amount` decimal(20,3) DEFAULT 0 COMMENT '总金额',
	`product_sellno` varchar(30) DEFAULT '' COMMENT '卖单号',
	`created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
