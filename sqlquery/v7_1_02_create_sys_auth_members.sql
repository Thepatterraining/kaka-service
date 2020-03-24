

-- 创建 sys_auth_members 表 

DROP TABLE IF EXISTS `sys_auth_members`;

CREATE TABLE `sys_auth_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint NOT NULL DEFAULT 0 COMMENT '组id',
  `authuser_id` bigint NOT NULL DEFAULT 0 COMMENT '管理员id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;