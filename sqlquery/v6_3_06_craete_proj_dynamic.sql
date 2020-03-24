


DROP TABLE IF EXISTS `proj_dynamic`;

CREATE TABLE `proj_dynamic` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proj_no` varchar(30) NOT NULL DEFAULT '' COMMENT '项目编号',
  `proj_dynamictype` varchar(30) NOT NULL DEFAULT '' COMMENT '动态类型 字典表 prodynamic_type ,PDY05 = 确权,PDY06 = 分红,PDY07=其他公示',
  `proj_newsno` varchar(30) NOT NULL DEFAULT '' COMMENT '公告号',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;