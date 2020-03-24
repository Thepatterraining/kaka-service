


-- 修改 transaction_order 表 增加字段
alter table `transaction_order` add `order_scale` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '比例因子',
add `order_touser_showprice` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '显示价格',
add `order_touser_showcount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '显示数量';

