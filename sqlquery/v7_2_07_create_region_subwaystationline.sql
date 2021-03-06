-- 创建 region_subwaystationline 表 

DROP TABLE IF EXISTS `region_subwaystationline`;

CREATE TABLE `region_subwaystationline` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subwayline_id` bigint NOT NULL DEFAULT 0 COMMENT '线路id',
  `subwayline_name` varchar(255) NOT NULL DEFAULT '' COMMENT '线路名称',
  `subwaystation_index` int NOT NULL DEFAULT 0 COMMENT '顺序',
  `subwaystation_id` bigint NOT NULL DEFAULT 0 COMMENT '地铁站id',
  `subwaystation_name` varchar(255) NOT NULL DEFAULT '' COMMENT '地铁站名称',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;