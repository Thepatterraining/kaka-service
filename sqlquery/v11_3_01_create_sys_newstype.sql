CREATE TABLE `sys_newstype` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `newstype_name` varchar(255) NOT NULL DEFAULT '' COMMENT '类别名称',
  `newstype_no` varchar(255) NOT NULL DEFAULT '' COMMENT '人为编号',
  `newstype_content` text NOT NULL COMMENT '类别说明',
  `newstype_pubdate` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '发布时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;