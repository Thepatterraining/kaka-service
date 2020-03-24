
CREATE TABLE `project_company` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_no` varchar(255) DEFAULT '' COMMENT '证件号',
  `company_name` varchar(255) DEFAULT '' COMMENT '公司名称',
  `company_address` varchar(255) DEFAULT '' COMMENT '注册地址',
  `company_representative` varchar(255) DEFAULT '' COMMENT '法人代表',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;