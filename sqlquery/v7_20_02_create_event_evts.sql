CREATE TABLE `event_evts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_no` varchar(255) DEFAULT NULL COMMENT '事件编号',
  `event_id` bigint(20) DEFAULT NULL COMMENT '事件id',
  `event_model` varchar(255) DEFAULT NULL COMMENT '事件类',
  `event_name` varchar(255) DEFAULT NULL COMMENT '事件名称',
  `event_data` text COMMENT '事件数据',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;