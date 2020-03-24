CREATE TABLE `event_notifyuserlog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notify_logno` varchar(30) DEFAULT NULL COMMENT '日志编号',
  `notify_no` varchar(30) DEFAULT NULL COMMENT '通知编号',
  `notify_evt` varchar(30) DEFAULT NULL COMMENT '事件编号',
  `notify_user` varchar(30) DEFAULT NULL COMMENT '通知用户',
  `notify_text` varchar(30) DEFAULT NULL COMMENT '通知数据',
  `notify_level` char(30) DEFAULT NULL COMMENT '通知级别',
  `notify_type` varchar(20) DEFAULT NULL COMMENT '通知类型',
  `notify_address` varchar(20) DEFAULT NULL COMMENT '通知地址',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;