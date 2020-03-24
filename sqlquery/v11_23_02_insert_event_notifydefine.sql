drop table `event_notifydefine`;
CREATE TABLE `event_notifydefine` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `notify_name` varchar(255) DEFAULT NULL COMMENT '通知名称',
  `notify_event` bigint(20) DEFAULT NULL COMMENT '通知事件',
  `notify_filter` varchar(255) DEFAULT NULL COMMENT '通知条件',
  `notify_type` varchar(255) DEFAULT NULL COMMENT '通知类型',
  `notify_specialclass` varchar(255) DEFAULT NULL COMMENT '通知特殊处理类',
  `notify_level` char(30) DEFAULT NULL COMMENT '通知级别',
  `notify_fmt` text COMMENT '格式',
  `notify_param` text COMMENT '通知参数',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `event_notifydefine` (`id`, `notify_name`, `notify_event`, `notify_filter`, `notify_type`, `notify_specialclass`,`notify_level`,`notify_fmt`,`notify_param`,`created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,"开发组获知大额充值",1,null,'NT01',null,1,NULL,NULL,null,NULL,NULL,NULL,null,NULL),
	(null,"运营组获知大额充值",2,null,'NT02',null,2,NULL,NULL,null,NULL,NULL,NULL,null,NULL),
    (null,"运营获知每日汇总",2,null,'NT01',null,1,NULL,NULL,null,NULL,NULL,NULL,null,NULL),
    (null,"运营组获知大额充值",2,"select created_at from cash_recharge where cash_recharge_amount>=50000 and id= ?",'NT01',"App\\Data\\Cash\\RechargeData",2,NULL,NULL,NULL,null,NULL,NULL,NULL,null),
    (null,"获知买单",3,null,'NT01',"App\\Data\\NotifyRun\\Trade\\TransactionBuyData",1,NULL,NULL,null,NULL,NULL,NULL,null,NULL),
    (null,"获知卖单",4,null,'NT01',"App\\Data\\NotifyRun\\Trade\\TransactionSellData",1,NULL,NULL,null,NULL,NULL,NULL,null,NULL),
    (null,"获知交易",5,null,'NT01',"App\\Data\\NotifyRun\\Trade\\TransactionOrderData",1,NULL,NULL,null,NULL,NULL,NULL,null,NULL),
    (null,"后端获知代币对账错误",13,null,"NT01",null,1,NULL,null,NULL,NULL,NULL,null,null,NULL),
	(null,"后端获知现金对账错误",14,null,"NT01",NULL,1,null,NULL,null,NULL,NULL,NULL,null,NULL),
	(null,"后端获知DB错误",15,null,"NT01","App\\Data\\NotifyRun\\Sys\\LogData",1,null,null,null,NULL,NULL,NULL,null,NULL),
    (null,'分红到账',16,NULL,'NT03','App\\Data\\NotifyRun\\Bonus\\ProjBonusData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
    (null,'充值短信提醒',17,NULL,'NT02','App\\Data\\NotifyRun\\Cash\\RechargeData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'提现短信提醒',18,NULL,'NT02','App\\Data\\NotifyRun\\Cash\\WithdrawalData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
    (null,'新手标回收发券',19,NULL,'NT01','App\\Data\\NotifyRun\\Voucher\\VoucherStorageData','1',NULL,'{"voucherNo":"VCN2017111115042590278"}',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'首次绑定',20,NULL,'NT01','App\\Data\\NotifyRun\\App\\BindingData','1',NULL,'{"price":0,"coinType":"KKC-BJ0006","count":0.5}',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'分红短信',21,NULL,'NT02','App\\Data\\NotifyRun\\Bonus\\ProjBonusItemData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
    (null,'调查手机号判断',22,NULL,'NT01','App\\Data\\NotifyRun\\Survey\\RegSurveyData','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);