


-- 修改 transaction_buy 表 增加字段
alter table `transaction_buy` add `buy_scale` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '比例因子',
add `buy_touser_showprice` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '显示价格',
add `buy_touser_showcount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '显示数量';

alter table `transaction_buy` add `buy_touser_feeprice` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '显示价格 带手续费',
add `buy_touser_feecount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '显示数量 带手续费';

