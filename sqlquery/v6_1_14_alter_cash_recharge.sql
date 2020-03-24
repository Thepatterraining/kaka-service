
-- 增加充值通道id

alter table `cash_recharge` add `cash_recharge_channel` bigint NOT NULL DEFAULT 0 COMMENT '通道id';


