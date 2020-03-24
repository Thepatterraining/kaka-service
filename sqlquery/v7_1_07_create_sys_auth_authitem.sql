

-- 创建 sys_auth_authitem 表 

DROP TABLE IF EXISTS `sys_auth_authitem`;

CREATE TABLE `sys_auth_authitem` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `auth_id` bigint NOT NULL DEFAULT 0 COMMENT '权限信息',
  `group_id` bigint NOT NULL DEFAULT 0 COMMENT '组信息',
  `filter` text NOT NULL COMMENT '筛选信息',
  `display` text NOT NULL COMMENT '显示信息',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;