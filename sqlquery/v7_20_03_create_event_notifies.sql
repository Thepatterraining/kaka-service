CREATE TABLE `event_notifies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notify_no` varchar(30) DEFAULT NULL COMMENT '通知编号',
  `notify_evt` varchar(30) DEFAULT NULL COMMENT '事件编号',
  `notify_id` varchar(255) DEFAULT NULL COMMENT '通知定义id',
  `notify_name` varchar(255) DEFAULT NULL COMMENT '通知名称',
  `notify_level` char(30) DEFAULT NULL COMMENT '通知级别',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;