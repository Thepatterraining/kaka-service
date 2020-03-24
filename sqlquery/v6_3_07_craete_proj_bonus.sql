


DROP TABLE IF EXISTS `proj_bonus`;

CREATE TABLE `proj_bonus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bonus_no` varchar(30) NOT NULL DEFAULT '' COMMENT '分红单号 前缀CBN',
  `bonus_proj` varchar(30) NOT NULL DEFAULT '' COMMENT '项目编号',
  `bonus_authdate` datetime NOT NULL DEFAULT '1971-01-01' COMMENT '确权日期',
  `bonus_plancash` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '总金额',
  `bonus_planfee` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '管理费用',
  `bonus_dealcash` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '实际分红金额',
  `bonus_dealfee` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '实际管理费用',
  `bonus_cash` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '分红金额 = 总金额-管理费用',
  `bonus_unit` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '总小单位 当前为 0.01',
  `bonus_holdings` int NOT NULL DEFAULT 0 COMMENT '持币总用户',
  `bonus_distributecount` int NOT NULL DEFAULT 0 COMMENT '达到分红条件的用户',
  `bonus_status` varchar(30) NOT NULL DEFAULT '' COMMENT '分红状态 PBS01 申请 PBS02 成功 PBS03 失败',
  `bonus_chkuserid` bigint NOT NULL DEFAULT 0 COMMENT '审核人',
  `bonus_chktime`  datetime NOT NULL DEFAULT '1971-01-01' COMMENT '审核日期',
  `bonus_time`  datetime NOT NULL DEFAULT '1971-01-01' COMMENT '发起日期',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;