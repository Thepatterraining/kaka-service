


alter table `user_coin_journal` modify `usercoin_journal_in` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '收入',
modify `usercoin_journal_out` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '支出',
modify `usercoin_journal_pending` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '在途',
modify `usercoin_result_pending` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户在途',
modify `usercoin_result_cash` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户余额';


alter table `sys_coin_journal` modify `syscoin_result_pending` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户在途',
modify `syscoin_result_cash` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户余额 ';