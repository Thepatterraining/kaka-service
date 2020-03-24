
CREATE TABLE `project_infoitemdefine` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) DEFAULT '' COMMENT '名称',
  `item_datatype` int DEFAULT 0 COMMENT '数据类型',
  `item_prenote` varchar(255) DEFAULT '' COMMENT '前置说明',
  `item_lastnote` varchar(255) DEFAULT '' COMMENT '后置说明',
  `item_datafmt` varchar(255) DEFAULT '' COMMENT '格式',
  `item_displayfmt` varchar(255) DEFAULT '' COMMENT '显示格式',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;