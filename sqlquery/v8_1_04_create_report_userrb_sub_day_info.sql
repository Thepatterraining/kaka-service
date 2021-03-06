CREATE TABLE `report_userrb_sub_day_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `report_user` bigint(20) DEFAULT NULL COMMENT '邀请人id',
  `report_user_name` varchar(255) DEFAULT NULL COMMENT '邀请人姓名',
  `report_user_mobile` varchar(20) DEFAULT NULL COMMENT '邀请人手机号',
  `report_invuser_id` bigint(20) DEFAULT NULL COMMENT '受邀人id',
  `report_invuser_name` varchar(255) DEFAULT NULL COMMENT '受邀人性命',
  `report_invuser_mobile` varchar(20) DEFAULT NULL COMMENT '受邀人手机号',
  `report_invuser_rbbuy_count` bigint(20) DEFAULT NULL COMMENT '受邀人消费笔数',
  `report_invuser_rbbuy_cash` decimal(20,3) DEFAULT NULL COMMENT '受邀人消费金额',
  `report_invuser_rbbuy_return_cash` decimal(20,3) DEFAULT NULL COMMENT '受邀人返佣给邀请人金额',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  `report_start` datetime DEFAULT NULL,
  `report_end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;