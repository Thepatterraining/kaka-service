

-- 创建 sys_auth_group 表 

DROP TABLE IF EXISTS `sys_auth_group`;

CREATE TABLE `sys_auth_group` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `authgroup_name` varchar(30) NOT NULL DEFAULT '' COMMENT '管理组名称',
  `authgroup_note` varchar(255) NOT NULL DEFAULT '' COMMENT '管理组备注',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;