
-- 更新用户身份证号验证过的为 1
update `sys_user` set user_checkidno = 1 where user_idno != '';