


alter table `proj_bonus` add `bonus_starttime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '开始时间',
add `bonus_endtime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '结束时间';