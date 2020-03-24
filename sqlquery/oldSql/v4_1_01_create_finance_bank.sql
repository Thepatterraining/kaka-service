
-- 字典表
DROP TABLE IF EXISTS `finance_bank`;

CREATE TABLE `finance_bank` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `bank_no` varchar(30) NOT NULL DEFAULT '' COMMENT '银行编号 | 目前默认 "" ',
  `bank_name` varchar(255) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_short` varchar(255) NOT NULL DEFAULT '' COMMENT '银行简称',
  `bank_fullname` varchar(255) NOT NULL DEFAULT '' COMMENT '银行全称',
  `bank_source` varchar(20) DEFAULT '' COMMENT '添加来源 字典表`bank_source` `BS01` = 系统 `BS02` 用戶添加',
  `bank_icon` text  COMMENT '银行的图标 base 64字符串  目前留空 ',
  `bank_ischeck` bit DEFAULT b'0' COMMENT '是否已经审核',
  `bank_checkser` varchar(255) DEFAULT '' COMMENT '审核人',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;