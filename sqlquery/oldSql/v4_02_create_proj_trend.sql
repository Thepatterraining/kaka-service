

-- 产品价格表
DROP TABLE IF EXISTS `proj_trend`;

CREATE TABLE `proj_trend` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `proj_no` varchar(30) DEFAULT NULL COMMENT '项目/代币编号',
  `proj_price` decimal(20,2) DEFAULT NULL COMMENT '价格',
  `proj_time` date DEFAULT NULL COMMENT '录入时间',
  `proj_pricetype` char(30) DEFAULT NULL COMMENT '来源 字典表proj_pricetyep  PROP01 人工录入 PROP02 链家爬虫',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;