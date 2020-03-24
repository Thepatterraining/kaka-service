

-- 修改 transaction_sell 表 增加字段
alter table `transaction_sell` add `sell_feetype` char(10) NOT NULL DEFAULT '' COMMENT '现金手续费类型  字典表 FR00 免费 FR01 价内 FR02 价外',
add `sell_coinfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '代币费率',
add `sell_coinfeetype` char(10) NOT NULL DEFAULT '' COMMENT '代币手续费类型',
add `sell_cashfeehidden` int(1) NOT NULL DEFAULT 1 COMMENT '现金手续费是否可见',
add `sell_coinfeehidden` int(1) NOT NULL DEFAULT 1 COMMENT '代币手续费是否可见',
add `sell_showcoinprice` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '显示价格',
add `sell_showcoincount` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '显示数量';


alter table `transaction_sell` add `sell_coinfee` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '代币手续费';