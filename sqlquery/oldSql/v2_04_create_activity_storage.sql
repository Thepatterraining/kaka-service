

-- 用户参加活动表
DROP TABLE IF EXISTS `activity_storage`;

CREATE TABLE `activity_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `activity_storage_no` varchar(255) NOT NULL DEFAULT '' COMMENT '前缀 ASN',
  `activity_no` varchar(255) NOT NULL DEFAULT '' COMMENT '活动编号',
  `activity_storage_status` char(10) NOT NULL DEFAULT '0' COMMENT 'ASS00 提交 ASS01 成功 ASS02 失败',
  `activity_storage_userid` bigint NOT NULL DEFAULT '0' COMMENT '用户id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;
