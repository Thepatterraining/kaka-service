

-- 修改 sys_user 表 增加字段
alter table `sys_user` add `user_type` char(10) NOT NULL DEFAULT '' COMMENT '用户类型  字典表 user_type UT00 普通用户 UT01 公司员工 UT02 公司高管 UT03 基金帐号',
add `user_invcode` varchar(255) NOT NULL DEFAULT '' COMMENT '邀请码';