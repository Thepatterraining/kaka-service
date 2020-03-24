
alter table `sys_login_log` add `ip_area` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip地区',
add `ip_city` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip城市',
add `ip_country` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip国家',
add `ip_isp` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip供应商',
add `ip_region` varchar(50) NOT NULL DEFAULT '' COMMENT 'ip区域';
