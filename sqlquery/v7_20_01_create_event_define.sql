CREATE TABLE `event_define` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_name` varchar(255) DEFAULT NULL COMMENT '事件名称',
  `event_key` varchar(255) DEFAULT NULL COMMENT '事件key',
  `event_model` varchar(255) DEFAULT NULL COMMENT '定义类',
  `event_type` char(30) DEFAULT NULL COMMENT '定义事件',
  `event_filter` varchar(255) DEFAULT NULL COMMENT '条件',
  `event_level` char(30) DEFAULT NULL COMMENT '优先级',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;