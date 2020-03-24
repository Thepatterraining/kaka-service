alter table `sys_login_log` add `login_appid` varchar(255) DEFAULT '' COMMENT 'appid';
alter table `sys_login_log` add `login_appname` varchar(255) DEFAULT '' COMMENT 'app name';
alter table `sys_login_log` add `login_appguid` bigint DEFAULT 0 COMMENT 'appguid';