

-- 修改 transaction_buy 表 增加字段
alter table `transaction_buy` add `buy_feetype` char(10) NOT NULL DEFAULT '' COMMENT '代币手续费类型  字典表 FR00 免费 FR01 价内 FR02 价外',
add `buy_cashfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '现金费率',
add `buy_cashfeetype` char(10) NOT NULL DEFAULT '' COMMENT '现金手续费类型',
add `buy_cashfeehidden` int(1) NOT NULL DEFAULT 1 COMMENT '现金手续费是否可见',
add `buy_coinfeehidden` int(1) NOT NULL DEFAULT 1 COMMENT '代币手续费是否可见',
add `buy_showprice` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '显示价格',
add `buy_showcount` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '显示数量';


alter table `transaction_buy` add `buy_cashfee` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '现金手续费';