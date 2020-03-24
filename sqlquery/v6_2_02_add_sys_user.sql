



alter table `sys_user` add `user_currenttype` bigint NOT NULL DEFAULT 0 COMMENT '当前用户类型 sys_user_type.id',
add `user_nexttype` bigint NOT NULL DEFAULT 0 COMMENT '下一级用户类型 sys_user_type.id',
add `user_currentrbtype` bigint NOT NULL DEFAULT 0 COMMENT '当前代理类型 sys_user_rbtype.id',
add `user_nextrbtype` bigint NOT NULL DEFAULT 0 COMMENT '下一级代理类型 sys_user_rbtype.id';
