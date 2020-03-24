DROP TABLE IF EXISTS `realty_district_schooldistrict_item`;

CREATE TABLE `realty_district_schooldistrict_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `district_id` bigint NOT NULL DEFAULT 0 COMMENT '小区名称',
  `school_districtid` bigint NOT NULL DEFAULT 0 COMMENT '学区信息',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;