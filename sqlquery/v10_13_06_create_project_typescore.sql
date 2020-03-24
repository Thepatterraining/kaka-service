
CREATE TABLE `project_typescore` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `score_id` bigint DEFAULT 0 COMMENT 'score.id',
  `projtype_id` bigint DEFAULT 0 COMMENT 'project_infoitemdefine.id',
  `score_index` int DEFAULT 0 COMMENT '顺序',
  `score_priority` int DEFAULT 100 COMMENT '权重 默认100',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;