



alter table `sys_user` modify `user_currentrbtype` bigint NOT NULL DEFAULT 1 COMMENT '当前代理类型 sys_user_rbtype.id';
alter table `sys_user` modify `user_currenttype` bigint NOT NULL DEFAULT 1 COMMENT '当前用户类型 sys_user_type.id';
alter table `sys_user` modify `user_nexttype` bigint NOT NULL DEFAULT 2 COMMENT '下一级用户类型 sys_user_type.id';
alter table `sys_user` modify `user_nextrbtype` bigint NOT NULL DEFAULT 2 COMMENT '下一级代理类型 sys_user_rbtype.id';