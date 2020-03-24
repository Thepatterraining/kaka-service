
-- 加入买单和成交类型
alter table `transaction_buy` add `buy_leveltype` char(10) NOT NULL DEFAULT 'BL01' COMMENT '买单类型 BL00 普通 BL01 一级产品';
alter table `transaction_order` add `order_buy_leveltype` char(10) NOT NULL DEFAULT '' COMMENT '买单类型';
alter table `transaction_order` add `order_sell_leveltype` char(10) NOT NULL DEFAULT '' COMMENT '卖单类型';

-- 更新之前的买单为产品买单
update `transaction_buy` set `buy_leveltype` = 'BL01';