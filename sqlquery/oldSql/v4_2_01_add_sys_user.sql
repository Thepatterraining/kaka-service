

-- 修改 sys_user 表 增加字段
alter table `sys_user` add `user_checkidno` varchar(10) NOT NULL DEFAULT '0' COMMENT '是否设置身份证号';