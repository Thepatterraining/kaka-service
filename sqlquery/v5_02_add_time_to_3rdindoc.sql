alter table `sys_3rd_pay_incomedocs` add `income_endtime` DATETIME not null DEFAULT '1970-1-1 00:00:00' COMMENT '汇总结束时间';
alter table `sys_3rd_pay_incomedocs` add `income_starttime` DATETIME not null  DEFAULT '1970-1-1 00:00:00'  COMMENT  '汇总开始时间';
