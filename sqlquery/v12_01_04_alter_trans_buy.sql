alter table `transaction_buy` modify `buy_count` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '挂单数量';
alter table `transaction_buy` modify `buy_transcount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '成交数量';
alter table `transaction_buy` modify `buy_showcount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '显示数量';