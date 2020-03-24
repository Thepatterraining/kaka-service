

DROP TABLE IF EXISTS `sys_3rd_pay_channelmethod`;

CREATE TABLE `sys_3rd_pay_channelmethod` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '通道名称',
  `method_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '方式名称',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `sys_3rd_pay_channelmethod` (`id`, `channel_id`, `method_id`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,1,1,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,2,1,NULL,NULL,NULL,NULL,NULL,NULL);
