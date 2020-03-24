

alter table `sys_user_type` add `user_cash_withdrawalfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '现金提现手续费',
add `user_coin_withdrawalfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '代币提现手续费',
add `user_coin_sellfeehidden` bit NOT NULL DEFAULT b'1' COMMENT '代币手续费是否可见',
add `user_coin_buyfeehidden` bit NOT NULL DEFAULT b'1' COMMENT '代币手续费是否可见',
add `user_cash_buyfeehidden` bit NOT NULL DEFAULT b'1' COMMENT '现金手续费是否可见',
add `user_cash_sellfeehidden` bit NOT NULL DEFAULT b'1' COMMENT '现金手续费是否可见';