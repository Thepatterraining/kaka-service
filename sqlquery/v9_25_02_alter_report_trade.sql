

alter table `report_user_trade_day` add `report_initcount_top` bigint(20) DEFAULT NULL COMMENT '一级市场初始交易笔数',
  add `report_tradecount_top` bigint(20) DEFAULT NULL COMMENT '一级市场交易笔数',
  add `report_resultcount_top` bigint(20) DEFAULT NULL COMMENT '一级市场期末交易笔数',
  add `report_initcash_top` decimal(20,3) DEFAULT NULL COMMENT '一级市场初始交易金额',
  add `report_tradecash_top` decimal(20,3) DEFAULT NULL COMMENT '一级市场交易金额',
  add `report_resultcash_top` decimal(20,3) DEFAULT NULL COMMENT '一级市场期末交易金额',
  add `report_initcount_second` bigint(20) DEFAULT NULL COMMENT '二级市场初始交易笔数',
  add `report_tradecount_second` bigint(20) DEFAULT NULL COMMENT '二级市场交易笔数',
  add `report_resultcount_second` bigint(20) DEFAULT NULL COMMENT '二级市场期末交易笔数',
  add `report_initcash_second` decimal(20,3) DEFAULT NULL COMMENT '二级市场初始交易金额',
  add `report_tradecash_second` decimal(20,3) DEFAULT NULL COMMENT '二级市场交易金额',
  add `report_resultcash_second` decimal(20,3) DEFAULT NULL COMMENT '二级市场期末交易金额';