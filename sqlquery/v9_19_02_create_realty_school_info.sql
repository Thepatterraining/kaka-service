DROP TABLE IF EXISTS `realty_school_info`;

CREATE TABLE `realty_school_info` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) NOT NULL DEFAULT '' COMMENT '学校名称',
  `school_shortname` varchar(255) NOT NULL DEFAULT '' COMMENT '学校简称',
  `school_running_type` varchar(255) NOT NULL DEFAULT '' COMMENT '办学类型 字典表schoolrunningtype SCHRT01 公立 SCHRT02 民办 SCHRT03 联合',
  `school_type` varchar(255) NOT NULL DEFAULT '' COMMENT '学校类型 SCHT01 小学 SCHT02 初中 SCHT03 高中 SCHT04 九年一贯',
  `shool_intro` text NOT NULL COMMENT '学校介绍 ',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;