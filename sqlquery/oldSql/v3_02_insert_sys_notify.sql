
-- 插入 sys_notify 表默认值

truncate table `sys_notify`;
INSERT INTO `sys_notify` (`id`, `notify_type`, `notify_fmt`, `notify_user_filter`, `noiffy_event`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `notify_model`)
VALUES
	(5,'NT01','（充值成功）您尾号{$this->right($item->cash_recharge_bankid,4)}银行卡于{$item->cash_recharge_chktime}成功充值{$item->cash_recharge_amount}到您账户，请注意查收。','','Recharge_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Recharge'),
	(6,'NT02','（充值失败）未收到您尾号{$this->right($item->cash_recharge_bankid,4)}银行卡转账，充值申请已超期失效，如需要继续充值请重新发起充值申请。','','Recharge_Refuse',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Recharge'),
	(7,'NT03','（提现成功）您发起{$item->cash_withdrawal_amount}元提现申请于{$item->cash_withdrawal_chktime}已转交银行处理，请注意查收。','','Withdrawal_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Withdrawal'),
	(8,'NT04','（提现失败）您发起{$item->cash_withdrawal_amount}元提现申请已被拒绝，具体原因请咨询官方客服。','','Withdrawal_Refuse',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Withdrawal'),
	(9,'NT05','您发起的{$item->order_coin_type}资产的委托于{$item->created_at->format(\'Y年m月d日\')}已部分成交。','','Order_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Trade\\TranactionOrder'),
	(10,'NT06','系统向您账户中发放了{$item->voucher_val2}元理财金券，请及时使用。','','Voucher_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Activity\\VoucherInfo'),
	(11,'NT07','（提现提醒） 您于{$item->cash_withdrawal_time}发起{$item->cash_withdrawal_amount}元提现申请，请耐心等待。','','Withdrawal_Apply',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Withdrawal'),
	(12,'NT08','（买入成功）您于 {$item->created_at->format(\'Y年m月d日\')} 成功买入{$item-> order_coin_type}资产，请确认为本人操作。','','Order_Buy',NULL,NULL,NULL,NULL,NULL,NULL,'Trade\\TranactionOrder');