DROP TABLE IF EXISTS `realty_house_type`;

CREATE TABLE `realty_house_type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `housetype_name` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `housetype_bedroom` int NOT NULL DEFAULT 0 COMMENT '卧室数量',
  `housetype_parlor` int NOT NULL DEFAULT 0 COMMENT '厅',
  `housetype_bathroom` int NOT NULL DEFAULT 0 COMMENT '卫',
  `housetype_floor` int NOT NULL DEFAULT 0 COMMENT '层',
  `housetype_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;