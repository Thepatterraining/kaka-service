CREATE TABLE `monitor_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `token` varchar(255) DEFAULT '' COMMENT 'token',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '请求地址',
  `dumpinfo` text,
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  `report_bug` int DEFAULT 1 COMMENT '是否已经报告bug',
  `workitem_id` varchar(255) DEFAULT '' COMMENT '效率云ID',
  `workitem_status` varchar(30) DEFAULT '' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;