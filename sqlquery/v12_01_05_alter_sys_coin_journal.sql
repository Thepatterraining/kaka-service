alter table `sys_coin_journal` modify `syscoin_journal_in` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '收入';
alter table `sys_coin_journal` modify `syscoin_journal_out` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '支出';
alter table `sys_coin_journal` modify `syscoin_journal_pending` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '在途';