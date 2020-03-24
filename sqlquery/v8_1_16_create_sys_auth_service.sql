

DROP TABLE IF EXISTS `sys_auth_service`;

CREATE TABLE `sys_auth_service` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`auth_note` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `auth_api` varchar(255) NOT NULL DEFAULT '' COMMENT 'api url',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

alter table `sys_auth_item` add `auth_api_id` bigint NOT NULL DEFAULT 0 COMMENT 'api id';
