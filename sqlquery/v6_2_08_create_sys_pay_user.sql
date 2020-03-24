


DROP TABLE IF EXISTS `sys_pay_user`;

CREATE TABLE `sys_pay_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pay_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀 SPU',
  `pay_sysbankno` varchar(255) NOT NULL DEFAULT '' COMMENT '付款账号',
  `pay_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `pay_amount` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '金额',
  `pay_type` char(30) NOT NULL DEFAULT '' COMMENT '类型',
  `pay_status` char(30) NOT NULL DEFAULT '' COMMENT '状态',
  `pay_jobtype` char(30) NOT NULL DEFAULT '' COMMENT '关联单据类型',
  `pay_jobno` varchar(50) NOT NULL DEFAULT '' COMMENT '关联单据',
  `pay_note` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `pay_payuser` bigint NOT NULL DEFAULT 0 COMMENT '发起用户',
  `pay_paytime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '发起时间',
  `pay_ischeck` bit NOT NULL DEFAULT b'0' COMMENT '是否审核',
  `pay_checkuser` bigint NOT NULL DEFAULT 0 COMMENT '审核用户',
  `pay_checktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;