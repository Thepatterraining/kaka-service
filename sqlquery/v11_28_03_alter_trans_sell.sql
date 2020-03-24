alter table `transaction_sell` modify `sell_count` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '挂单数量';
alter table `transaction_sell` modify `sell_transcount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '成交数量';
alter table `transaction_sell` modify `sell_showcoincount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '显示数量';
alter table `transaction_sell` modify `sell_coinfee` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '代币手续费';