
CREATE TABLE `project_holder` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `holder_name` varchar(255) DEFAULT '' COMMENT '姓名',
  `holder_id` varchar(255) DEFAULT '' COMMENT 'id',
  `holder_type` int DEFAULT 0 COMMENT '类型 0 自然人 1 公司',
  `holder_user_id` int DEFAULT 0 COMMENT '前台用户id',
  `holder_mobile` char(11) DEFAULT '' COMMENT '电话',
  `holder_mail` varchar(255) DEFAULT '' COMMENT '邮件',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;