
CREATE TABLE `project_shareholder` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint DEFAULT 0 COMMENT '',
  `project_no` varchar(255) DEFAULT '' COMMENT '代币类型',
  `holder_id` bigint DEFAULT 0 COMMENT '',
  `holder_percent` decimal(20,3) DEFAULT 0 COMMENT '股比',
  `holder_capital` decimal(20,2) DEFAULT 0 COMMENT '认缴资本',
  `holder_type` int DEFAULT 0 COMMENT '股东类型',
  `holder_typename` varchar(255) DEFAULT '' COMMENT '名称',
  `holder_sharebonus` int DEFAULT 0 COMMENT '是否参加分红',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;