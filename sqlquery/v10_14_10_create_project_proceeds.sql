
CREATE TABLE `project_proceeds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_no` varchar(255) DEFAULT '' COMMENT '编号 KKC-BJ0001',
  `project_proceeds_id` bigint DEFAULT 0 COMMENT '',
  `project_proceeds_name` varchar(255) DEFAULT '' COMMENT '收益名称',
  `project_proceeds_note` varchar(255) DEFAULT '' COMMENT '收益说明',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;