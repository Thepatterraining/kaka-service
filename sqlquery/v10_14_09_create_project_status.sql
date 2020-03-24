
CREATE TABLE `project_status` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_no` varchar(255) DEFAULT '' COMMENT '编号 KKC-BJ0001',
  `project_status` varchar(255) DEFAULT '' COMMENT '项目状态',
  `status_name` varchar(255) DEFAULT '' COMMENT '名称',
  `status_index` int DEFAULT 0 COMMENT '显示顺序',
  `status_display` int DEFAULT 0 COMMENT '是否显示',
  `status_start` datetime DEFAULT '1970-01-01' COMMENT '开始时间',
  `status_end` datetime DEFAULT '1970-01-01' COMMENT '结束时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;