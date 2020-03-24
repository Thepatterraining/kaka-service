
CREATE TABLE `project_annualrate` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proj_id` bigint DEFAULT 0 COMMENT '项目id',
  `project_no` varchar(255) DEFAULT '' COMMENT '代币类型',
  `annualrate_value` decimal(20,2) DEFAULT 0 COMMENT '收益',
  `annualrate_year` int DEFAULT 0 COMMENT '年份',
  `annualrate_ishistory` int DEFAULT 0 COMMENT '是否为历史 0 否，为预期 1 是历史',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;