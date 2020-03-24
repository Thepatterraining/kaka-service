
DROP TABLE IF EXISTS `activity_filter`;

CREATE TABLE `activity_filter` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `activity_no` varchar(50) NOT NULL DEFAULT '' COMMENT '活动号',
  `filter_exp` varchar(255) NOT NULL DEFAULT '' COMMENT '表达式',
  `filter_name` varchar(255) NOT NULL DEFAULT '' COMMENT '向用户显示的内容',
  `filter_itemno` int NOT NULL DEFAULT 0 COMMENT '序号',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;