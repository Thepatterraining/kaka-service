alter table `transaction_order` modify `order_count` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '成交数量';
alter table `transaction_order` modify `order_coin_fee` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '代币手续费';
alter table `transaction_order` modify `order_coin` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '入帐代币';