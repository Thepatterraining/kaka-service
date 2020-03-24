

-- 修改 sys_user 表 增加字段
alter table `sys_user` add `user_dream1` varchar(255) NOT NULL DEFAULT '' COMMENT '我的梦想1',
add `user_dream2` varchar(255) NOT NULL DEFAULT '' COMMENT '我的梦想2';