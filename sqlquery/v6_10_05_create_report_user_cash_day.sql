CREATE TABLE `report_user_cash_day` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `report_no` varchar(255) DEFAULT NULL COMMENT '报表编号',
  `report_name` varchar(255) DEFAULT NULL COMMENT '报表名称',
  `report_cyc` char(30) DEFAULT NULL COMMENT '报表周期',
  `report_user` bigint(20) DEFAULT NULL COMMENT '报表用户',
  `report_usermobile` char(11) DEFAULT NULL COMMENT '用户电话',
  `report_username` varchar(255) DEFAULT NULL COMMENT '用户姓名',
  `report_invuser` bigint(20) DEFAULT NULL COMMENT '邀请用户',
  `report_invcode` char(30) DEFAULT NULL COMMENT '进入的邀请码',
  `report_rechargecash` decimal(20,2) DEFAULT NULL COMMENT '充值金额',
  `report_rechargecount` int(11) DEFAULT NULL COMMENT '充值笔数',
  `report_withdrawalcash` decimal(20,2) DEFAULT NULL COMMENT '提现金额',
  `report_withdrawalcount` int(11) DEFAULT NULL COMMENT '提现笔数',
  `report_buycount` int(11) DEFAULT NULL COMMENT '买入笔数',
  `report_buycash` decimal(20,2) DEFAULT NULL COMMENT '消费现金',
  `report_sellcount` int(11) DEFAULT NULL COMMENT '卖出笔数',
  `report_sellcash` decimal(20,2) DEFAULT NULL COMMENT '收入现金',
  `report_cashfee` decimal(20,2) DEFAULT NULL COMMENT '充值／提现手续费',
  `report_trade` decimal(20,2) DEFAULT NULL COMMENT '交易手续费',
  `report_voucherusecount` int(11) DEFAULT NULL COMMENT '使用的代金券数量',
  `report_voucherusecash` decimal(20,2) DEFAULT NULL COMMENT '使用的券的金额',
  `report_vouchercount` int(11) DEFAULT NULL COMMENT '剩余的券的数量',
  `report_vouchercash` decimal(20,2) DEFAULT NULL COMMENT '剩余的券的金额',
  `report_otherincome` decimal(20,2) DEFAULT NULL COMMENT '其他收入',
  `report_otheroutcome` decimal(20,2) DEFAULT NULL COMMENT '其他支出',
  `report_initcash` decimal(20,2) DEFAULT NULL COMMENT '期初可用',
  `report_initpending` decimal(20,2) DEFAULT NULL COMMENT '期初在途',
  `report_resultcash` decimal(20,2) DEFAULT NULL COMMENT '期末可用',
  `report_resultpending` decimal(20,2) DEFAULT NULL COMMENT '期末在途',
  `report_income` decimal(20,2) DEFAULT NULL COMMENT '总收入',
  `report_outcome` decimal(20,2) unsigned DEFAULT NULL COMMENT '总支出',
  `report_start` datetime DEFAULT NULL COMMENT '开始时间',
  `report_end` datetime DEFAULT NULL COMMENT '结束时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;