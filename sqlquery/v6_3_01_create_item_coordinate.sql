


DROP TABLE IF EXISTS `item_coordinate`;

CREATE TABLE `item_coordinate` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `coordinate_x` decimal(20,5) NOT NULL DEFAULT 0 COMMENT 'x 坐标',
  `coordinate_y` decimal(20,5) NOT NULL DEFAULT 0 COMMENT 'y 坐标',
  `school_name` varchar(50) NOT NULL DEFAULT '' COMMENT '学校名称',
  `coin_type` varchar(50) NOT NULL DEFAULT '' COMMENT '代币类型',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 ic01 房子 ic02 学校',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;