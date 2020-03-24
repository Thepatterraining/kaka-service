
CREATE TABLE `project_infoitem` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint DEFAULT 0 COMMENT 'projectinfo.id',
  `project_no` varchar(255) DEFAULT '' COMMENT '编号 KKC-BJ0001',
  `proj_itemid` bigint DEFAULT 0 COMMENT 'item.id',
  `proj_itemvalue` varchar(255) DEFAULT '' COMMENT '详情值',
  `proj_itemname` varchar(255) DEFAULT '' COMMENT '名称',
  `proj_itemgroupname` varchar(255) DEFAULT '' COMMENT '分组',
  `proj_itemgroupindex` bigint DEFAULT 0 COMMENT '',
  `proj_itemindex` bigint DEFAULT 0 COMMENT '',
  `proj_itemprenote` varchar(255) DEFAULT '' COMMENT '',
  `proj_itemlastnote` varchar(255) DEFAULT '' COMMENT '',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;