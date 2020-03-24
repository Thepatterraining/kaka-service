truncate table `kk_schecule_define`;
INSERT INTO `kk_schecule_define` (`id`, `sch_no`, `sch_name`, `sch_namestr`, `sch_type`, `sch_jobclass`, `sch_lastjob`, `created_at`,`updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,"report_user_rb_sub_day","ReportUserrbSubDay","ReportUserrbSubDay","SCH02","\\App\\Data\\Report\\ReportUserrbSubDayData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"report_user_coin_day","ReportUserCoinDay","ReportUserCoinDay","SCH02","\\App\\Data\\Report\\ReportUserCoinDayData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"report_user_cash_day","ReportUserCashDay","ReportUserCashDay","SCH02","\\App\\Data\\Report\\ReportUserCashDayData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"report_user_trade_day","ReportUserTradeDay","ReportUserTradeDay","SCH02","\\App\\Data\\Report\\ReportTradeDayData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(null,"report_user_sums_day","ReportUserSumsDay","ReportUserSumsDay","SCH02","\\App\\Data\\Report\\ReportSumsDayData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"report_user_withdrawal_day","ReportUseWithdrawalDay","ReportUserWithdrawalDay","SCH02","\\App\\Data\\Report\\ReportWithdrawalDayData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"user_cash_settlement_day","UserCashSettlementDay","UserCashSettlementDay","SCH02","\\App\\Data\\Settlement\\UserCashSettlementData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"third_party_recharge_income_doc","ThirdPartyRechargeIncomeDoc","ThirdPartyRechargeIncomeDoc","SCH02","\\App\\Data\\Cash\\UserRechargeData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"deal_timeout_third_recharge","DealTimeoutThirdRechargeData","DealTimeoutThirdRechargeData","SCH01","\\App\\Data\\Cash\\SysRechargeData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"clear_sys_error","ClearSysError","ClearSysError","SCH02","\\App\\Data\\Sys\\LogData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"clear_sys_log","ClearSysLog","ClearSysLog","SCH02","\\App\\Data\\Monitor\\DebugInfoData",NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(null,"user_cash_settlement_day","UserCashSettlementDay","UserCashSettlementDay","SCH01","\\App\\Data\\Settlement\\UserCashSettlementData",NULL,NULL,NULL,NULL,NULL,NULL,NULL);
