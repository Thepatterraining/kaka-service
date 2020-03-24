CREATE TABLE `event_notifydefine` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notify_name` varchar(255) DEFAULT NULL COMMENT '通知名称',
  `notify_event` bigint(20) DEFAULT NULL COMMENT '通知事件',
  `notify_filter` varchar(255) DEFAULT NULL COMMENT '通知条件',
  `notify_type` varchar(255) DEFAULT NULL COMMENT '通知类型',
  `notify_specialclass` varchar(255) DEFAULT NULL COMMENT '通知特殊处理类',
  `notify_level` char(30) DEFAULT NULL COMMENT '通知级别',
  `notify_fmt` text COMMENT '格式',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;