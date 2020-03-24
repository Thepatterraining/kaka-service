

-- 产品预购表
DROP TABLE IF EXISTS `product_preorder`;

CREATE TABLE `product_preorder` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `preorder_no` varchar(255) NOT NULL DEFAULT '' COMMENT '预购单号 PREO',
  `preorder_product` varchar(255) NOT NULL DEFAULT '' COMMENT '产品编号',
  `preorder_count` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '数量',
  `preorder_voucherinfo` varchar(255) NOT NULL DEFAULT '' COMMENT '将要用的代金券号',
  `preorder_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `preorder_amount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '金额',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;