-- 创建 region_subwayline 表 

DROP TABLE IF EXISTS `region_subwayline`;

CREATE TABLE `region_subwayline` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subwayline_name` varchar(255) NOT NULL DEFAULT '' COMMENT '线路名称',
  `subwayline_cityid` bigint NOT NULL DEFAULT 0 COMMENT '城市id',
  `subwayline_cityname` varchar(255) NOT NULL DEFAULT '' COMMENT '城市名称',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;