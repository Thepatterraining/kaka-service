


-- 修改 transaction_sell 表 增加字段
alter table `transaction_sell` add `sell_scale` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '比例因子',
add `sell_touser_showprice` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '显示价格',
add `sell_touser_showcount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '显示数量',
add `sell_touser_feeprice` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '显示价格 带手续费',
add `sell_touser_feecount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '显示数量 带手续费';

