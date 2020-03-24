

-- 创建 sys_auth_item 表 

DROP TABLE IF EXISTS `sys_auth_item`;

CREATE TABLE `sys_auth_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `auth_no` varchar(30) NOT NULL DEFAULT '' COMMENT '权限编号 每一级三位',
  `auth_name` varchar(255) NOT NULL DEFAULT '' COMMENT '权限名称',
  `auth_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'api 地址',
  `auth_type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限类型 dictype = auth_type ,AU01=菜单, AU02=视图，AU03=操作,AU04=字段,AU05=功能',
  `auth_notes` varchar(255) NOT NULL DEFAULT '' COMMENT '备注说明',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;