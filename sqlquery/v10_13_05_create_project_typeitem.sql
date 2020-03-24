
CREATE TABLE `project_typeitem` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `projtype_id` bigint DEFAULT 0 COMMENT '类型id',
  `item_id` bigint DEFAULT 0 COMMENT 'project_infoitemdefine.id',
  `item_index` bigint DEFAULT 0 COMMENT '显示顺序',
  `item_group_id` bigint DEFAULT 0 COMMENT 'gourp.id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;