


-- 修改 activity_group 表 更新数据

DROP TABLE IF EXISTS `activity_group`;

CREATE TABLE `activity_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `group_no` varchar(30) NOT NULL DEFAULT '' COMMENT '分组编号',
  `group_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分组名称',
  `group_type` char(20)  NOT NULL DEFAULT '' COMMENT '分组类型',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

