CREATE TABLE `coin_addressinfo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `coin_address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `coin_user_name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `coin_user_idno` varchar(18) DEFAULT NULL COMMENT '身份证',
  `coin_user_mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机',
  `coin_user_email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `coin_status` varchar(30) NOT NULL DEFAULT '' COMMENT '字典 coin_address_status CAS00 已提交 CAS01 已认证 CAS02 已过期 CAS03 已迁移',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;