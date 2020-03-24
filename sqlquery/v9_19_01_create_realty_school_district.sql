DROP TABLE IF EXISTS `realty_school_district`;

CREATE TABLE `realty_school_district` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `rsd_name` varchar(255) NOT NULL DEFAULT '' COMMENT '学区名称',
  `rsd_shortname` varchar(255) NOT NULL DEFAULT '' COMMENT '学区简称',
  `rsd_district_id` bigint NOT NULL DEFAULT 0 COMMENT '市区id',
  `rsd_district_name` varchar(255) NOT NULL DEFAULT '' COMMENT '市区名称',
  `rsd_startyear` int NOT NULL DEFAULT 0 COMMENT '设立年份',
  `rsd_endyear` int NOT NULL DEFAULT 0 COMMENT '取消年份',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;