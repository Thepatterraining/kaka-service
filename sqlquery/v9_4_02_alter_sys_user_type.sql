

alter table `sys_user_type` add `user_buy_market_cashfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '二级买方现金手续费率',
add `user_buy_market_cashfeetype` varchar(30) NOT NULL DEFAULT '' COMMENT '二级买方现金手续费类型',
add `user_buy_market_coinfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '二级买方代币手续费率',
add `user_buy_market_coinfeetype` varchar(30) NOT NULL DEFAULT '' COMMENT '二级买方代币手续费类型',
add `user_sell_market_cashfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '二级卖方现金手续费率',
add `user_sell_market_cashfeetype` varchar(30) NOT NULL DEFAULT '' COMMENT '二级卖方现金手续费类型',
add `user_sell_market_coinfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '二级卖方代币手续费率',
add `user_sell_market_coinfeetype` varchar(30) NOT NULL DEFAULT '' COMMENT '二级卖方代币手续费类型',
add `user_sell_least_market_cashfee` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '最小的二级卖方现金手续费',
add `user_buy_least_market_cashfee` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '最小的二级买方现金手续费';