
DROP TABLE IF EXISTS `activity_recordsteps`;

CREATE TABLE `activity_recordsteps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `record_no` varchar(50) NOT NULL DEFAULT '' COMMENT '纪录号',
  `activity_no` varchar(50) NOT NULL DEFAULT '' COMMENT '活动号',
  `step_status` bit NOT NULL DEFAULT b'0' COMMENT '是否成功达成',
  `activity_item` int NOT NULL DEFAULT 0 COMMENT '活动条件',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;