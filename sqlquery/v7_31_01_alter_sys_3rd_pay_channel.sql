
alter table `sys_3rd_pay_channel` add `channel_infeeroutetype` char(20) NOT NULL DEFAULT '' COMMENT '手续费舍入类型 FRR01 四舍五入 FRR02 恒入 FRR03 恒舍';
alter table `sys_3rd_pay_channel` add `channel_infeemincount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '手续费最小金额';
