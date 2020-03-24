DROP TABLE IF EXISTS `realty_school_district_items`;

CREATE TABLE `realty_school_district_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_district_id` bigint NOT NULL DEFAULT 0 COMMENT '学区ID',
  `school_id` bigint NOT NULL DEFAULT 0 COMMENT '学校id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;