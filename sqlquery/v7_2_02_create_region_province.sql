-- 创建 region_province 表 

DROP TABLE IF EXISTS `region_province`;

CREATE TABLE `region_province` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `province_name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `province_country` char(2) NOT NULL DEFAULT '' COMMENT '国家编码',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;