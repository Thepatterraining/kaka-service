

-- 修改 transaction_order 表 增加字段
alter table `transaction_order` add `order_cash_feetype` char(10) NOT NULL DEFAULT '' COMMENT '卖方手续费类型  字典表 FR00 免费 FR01 价内 FR02 价外',
add `order_coin_feetype` char(10) NOT NULL DEFAULT '' COMMENT '卖方代币手续费类型',
add `order_buycash_feetype` char(10) NOT NULL DEFAULT '' COMMENT '买方现金手续费类型',
add `order_buycoin_feetype` char(10) NOT NULL DEFAULT '' COMMENT '买方代币手续费类型',
add `order_buycash_feerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '买方现金手续费率',
add `order_buycash_fee` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '买方现金手续费',
add `order_sellcoin_feerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '卖方代币手续费率',
add `order_sellcoin_fee` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '卖方代币手续费';