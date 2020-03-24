-- 创建 sys_3rd_pay_banklimit 表 

DROP TABLE IF EXISTS `sys_3rd_pay_banklimit`;

CREATE TABLE `sys_3rd_pay_banklimit` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bank_typeno` varchar(255) NOT NULL DEFAULT '' COMMENT '银行编号',
  `bank_daytop` bigint NOT NULL DEFAULT 0 COMMENT '日限额',
  `bank_pertop` bigint NOT NULL DEFAULT 0 COMMENT '单笔限额',
  `bank_perbottom` decimal(30,3) NOT NULL DEFAULT 0 COMMENT '单笔最底',
  `bank_cardtype` varchar(50) NOT NULL DEFAULT '' COMMENT '卡类型 dictype = bank_cardtype ,BC01 贷记卡，BC02 借记卡',
  `channel_id` bigint NOT NULL DEFAULT 0 COMMENT '通道id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;