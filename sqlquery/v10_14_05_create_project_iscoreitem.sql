
CREATE TABLE `project_iscoreitem` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint DEFAULT 0 COMMENT '名称',
  `project_no` varchar(255) DEFAULT '' COMMENT '代币类型',
  `scoreitem_id` bigint DEFAULT 0 COMMENT '分值项id',
  `scoreitem_value` DECIMAL(20,2) DEFAULT 0 COMMENT '分值',
  `scoreitem_name` varchar(255) DEFAULT '' COMMENT '名称 在新建时插入后不变，下同',
  `scoreitem_priority` int DEFAULT 0 COMMENT '',
  `scoreitem_index` int DEFAULT 0 COMMENT '',
  `scoreitem_scale` int DEFAULT 0 COMMENT '',
  `scoreitem_max` int DEFAULT 0 COMMENT '',
  `scoreitem_min` int DEFAULT 0 COMMENT '',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;