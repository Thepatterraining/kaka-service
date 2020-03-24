

-- 修改 item_info 表 增加字段
alter table `item_info` add `bonus_rate` decimal(10,5) NOT NULL DEFAULT 0 COMMENT '分红率',
add `bonus_cycle` varchar(20) NOT NULL DEFAULT '' COMMENT '分红周期',
add `bonus_periods` int NOT NULL DEFAULT 0 COMMENT '分红期数',
add `bonus_right_date` varchar(255) NOT NULL DEFAULT '' COMMENT '确权日',
add `bonus_date` varchar(255) NOT NULL DEFAULT '' COMMENT '分红日';