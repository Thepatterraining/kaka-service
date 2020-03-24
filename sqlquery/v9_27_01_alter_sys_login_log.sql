
alter table `sys_login_log` add `login_latitude` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '纬度',
add `login_longitude` decimal(20,9) NOT NULL DEFAULT 0 COMMENT ' 经度',
add `login_device_type` varchar(255) NOT NULL DEFAULT "" COMMENT '设备型号',
add `login_device_system` varchar(255) NOT NULL DEFAULT "" COMMENT '设备操作系统 (版本)',
add `login_device_brand` varchar(255) NOT NULL DEFAULT "" COMMENT '设备品牌';

alter table `sys_login_log` add index login_token (`login_token`);