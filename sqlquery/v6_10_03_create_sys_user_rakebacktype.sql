CREATE TABLE `sys_user_rakebacktype` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_rbtype_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户类型',
  `user_rbtype_enable` bit(1) NOT NULL DEFAULT b'1' COMMENT '是否允许返佣',
  `user_rbtype_rechargerate` decimal(20,5) NOT NULL DEFAULT '0.00000' COMMENT '充值返佣比例 (万分之几)',
  `user_rbtype_buyrate` decimal(20,5) NOT NULL DEFAULT '0.00000' COMMENT '消费返佣比例 (万分)',
  `user_rbtype_lrecharge` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '充值下限',
  `user_rbtype_trecharge` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '充值上限',
  `user_rbtype_lbuy` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '消费下限',
  `user_rbtype_tbuy` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '消费上限',
  `user_rbtype_index` int(11) NOT NULL DEFAULT '0' COMMENT '级别排序',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;