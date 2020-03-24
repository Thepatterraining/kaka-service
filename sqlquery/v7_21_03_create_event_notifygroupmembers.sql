CREATE TABLE `event_notifygroupmembers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) DEFAULT NULL COMMENT '组id',
  `authuser_id` bigint(20) DEFAULT NULL COMMENT '管理员id',
  `authuser_name` varchar(255) DEFAULT NULL COMMENT '管理员姓名',
  `authuser_email` varchar(255) DEFAULT NULL COMMENT '管理员邮箱',
  `authuser_mobile` char(11) DEFAULT NULL COMMENT '管理员手机号',
  `authuser_openid` varchar(255) DEFAULT NULL COMMENT '管理员openid',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;