-- 创建 region_subwaystation 表 

DROP TABLE IF EXISTS `region_subwaystation`;

CREATE TABLE `region_subwaystation` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subwaystation_name` varchar(255) NOT NULL DEFAULT '' COMMENT '站名',
  `subwaystation_cityid` bigint NOT NULL DEFAULT 0 COMMENT '城市id',
  `subwaystation_cityname` varchar(255) NOT NULL DEFAULT '' COMMENT '城市名称',
  `subwaystation_districtid` bigint NOT NULL DEFAULT 0 COMMENT '区id',
  `subwaystation_districtname` varchar(255) NOT NULL DEFAULT '' COMMENT '区名',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;