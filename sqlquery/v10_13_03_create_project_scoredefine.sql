
CREATE TABLE `project_scoredefine` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `score_name` varchar(255) DEFAULT '' COMMENT '名称',
  `score_scale` int DEFAULT 5 COMMENT '比例因子',
  `score_priority` int DEFAULT 1 COMMENT '权值',
  `score_min` int DEFAULT 0 COMMENT '最小',
  `score_max` int DEFAULT 0 COMMENT '最大',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;