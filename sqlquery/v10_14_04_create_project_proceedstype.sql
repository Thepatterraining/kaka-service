
CREATE TABLE `project_proceedstype` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proceedstype_name` varchar(255) DEFAULT '' COMMENT '名称',
  `proceedstype_note` varchar(255) DEFAULT '' COMMENT '说明',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;