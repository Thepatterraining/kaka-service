CREATE TABLE `proj_bonus_plantype` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bonusplan_typename` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `bonusplan_typenote` varchar(255) DEFAULT NULL COMMENT '说明',
  `bonusplan_typestatus` varchar(255) DEFAULT NULL COMMENT '类型',
  `bonusplan_exp` varchar(255) NOT NULL DEFAULT '' COMMENT '周期设定表达式',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;