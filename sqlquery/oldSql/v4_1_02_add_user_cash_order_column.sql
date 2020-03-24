

-- 修改 user_cash_order 表 增加字段
alter table `user_cash_order` add `usercashorder_balance` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '账户余额';