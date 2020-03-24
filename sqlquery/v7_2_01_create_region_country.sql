-- 创建 region_country 表 

DROP TABLE IF EXISTS `region_country`;

CREATE TABLE `region_country` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_code` char(2) NOT NULL DEFAULT '' COMMENT '国家编码 CN',
  `country_telcode` char(3) NOT NULL DEFAULT '' COMMENT '国家电话号 86',
  `country_name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `country_fullname` varchar(255) NOT NULL DEFAULT '' COMMENT '全称',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;