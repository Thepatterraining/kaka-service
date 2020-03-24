CREATE TABLE `proj_bonus_planitem` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bonusplan_no` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `bonusplan_index` int(11) NOT NULL DEFAULT '0' COMMENT '第几期',
  `bonusplan_status` varchar(30) NOT NULL DEFAULT '' COMMENT '计划/执行/取消',
  `bonus_no` varchar(255) NOT NULL DEFAULT '' COMMENT '分红单号',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  `bonusplan_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;