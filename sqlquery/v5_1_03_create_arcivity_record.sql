


-- 创建 activity_record 表 

DROP TABLE IF EXISTS `activity_record`;

CREATE TABLE `activity_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `record_no` varchar(30) NOT NULL DEFAULT '' COMMENT '编号',
  `record_group` varchar(30) NOT NULL DEFAULT '' COMMENT '分组编号',
  `record_activity` varchar(30) NOT NULL DEFAULT '' COMMENT '活动编号',
  `record_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

