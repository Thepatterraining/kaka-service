-- vp表
DROP TABLE IF EXISTS `sys_user_vp`;

CREATE TABLE `sys_user_vp` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `coin_type` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `enable` bit NOT NULL DEFAULT b'1' COMMENT '是否有效',
  `enable_buyback` bit NOT NULL DEFAULT b'0' COMMENT '是否允许回购',
  `enable_product` bit NOT NULL DEFAULT b'1' COMMENT '是否允许发售产品',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 用户类型对照表
DROP TABLE IF EXISTS `sys_user_types`;

CREATE TABLE `sys_user_types` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `usertype_id` bigint NOT NULL DEFAULT 0 COMMENT '用户类型id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- vp表
DROP TABLE IF EXISTS `sys_user_type`;

CREATE TABLE `sys_user_type` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_type_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户类型',
  `user_buy_cashfeetype` varchar(30) NOT NULL DEFAULT '' COMMENT '买入手续费类型',
  `user_buy_cashfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '买入现金手续费率',
  `user_buy_coinfeetype` varchar(30) NOT NULL DEFAULT '' COMMENT '买入代币手续费类型',
  `user_buy_coinfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '买入代币手续费率',
  `user_sell_cashfeetype` varchar(30) NOT NULL DEFAULT '' COMMENT '卖出现金手续费类型',
  `user_sell_cashfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '卖出现金手续费率',
  `user_sell_coinfeetype` varchar(30) NOT NULL DEFAULT '' COMMENT '卖出代币手续费类型',
  `user_sell_coinfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '卖出代币手续费率',
  `user_income_level` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '充值金额',
  `user_cost_level` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '消费金额',
  `user_next_income` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '到下一级的充值',
  `user_next_cost` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '下一消费级别',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;