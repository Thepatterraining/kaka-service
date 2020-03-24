

-- 邀请注册设置表
DROP TABLE IF EXISTS `activity_regcofig`;

CREATE TABLE `activity_regcofig` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `invite_usertype` char(10) NOT NULL DEFAULT '' COMMENT '用户类型',
  `invite_activitycode` varchar(255) NOT NULL DEFAULT '' COMMENT '活动编号',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




-- 活动邀请码表
DROP TABLE IF EXISTS `activity_invitationcode`;

CREATE TABLE `activity_invitationcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `invite_code` char(10) NOT NULL DEFAULT '' COMMENT '6-10位随机字符串',
  `invite_activity` varchar(255) NOT NULL DEFAULT '' COMMENT '活动编号',
  `invite_user` bigint NOT NULL DEFAULT 0 COMMENT '所属用户',
  `invite_count` int NOT NULL DEFAULT 0 COMMENT '已经邀请的数量',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;