-- 创建 region_city 表 

DROP TABLE IF EXISTS `region_city`;

CREATE TABLE `region_city` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) NOT NULL DEFAULT '' COMMENT '城市名称',
  `city_fullname` varchar(255) NOT NULL DEFAULT '' COMMENT '全名',
  `city_shortname` varchar(255) NOT NULL DEFAULT '' COMMENT '简称',
  `city_provinceid` bigint NOT NULL DEFAULT 0 COMMENT '省id',
  `city_provincename` varchar(255) NOT NULL DEFAULT '' COMMENT '省名称',
  `city_country` varchar(255) NOT NULL DEFAULT '' COMMENT '国家编码',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;