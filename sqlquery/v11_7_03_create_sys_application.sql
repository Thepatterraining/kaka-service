CREATE TABLE `sys_application` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) NOT NULL DEFAULT '' COMMENT '应用id',
  `app_name` varchar(255) NOT NULL DEFAULT '' COMMENT '应用名称',
  `app_key` varchar(255) NOT NULL DEFAULT '' COMMENT '应用key',
  `app_version` varchar(255) NOT NULL DEFAULT '' COMMENT '版本号',
  `app_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;