
alter table `sys_user` add `mobile_province` varchar(50) NOT NULL DEFAULT "" COMMENT '手机卡省份',
add `mobile_city` varchar(50) NOT NULL DEFAULT "" COMMENT '手机卡城市',
add `mobile_company` varchar(50) NOT NULL DEFAULT "" COMMENT '手机卡公司',
add `mobile_cardtype` varchar(50) NOT NULL DEFAULT "" COMMENT '手机卡类型',
add `id_province` varchar(50) NOT NULL DEFAULT "" COMMENT '身份证省份',
add `id_city` varchar(50) NOT NULL DEFAULT "" COMMENT '身份证城市',
add `id_town` varchar(50) NOT NULL DEFAULT "" COMMENT '身份证镇',
add `id_area` varchar(255) NOT NULL DEFAULT "" COMMENT '身份证地区',
add `id_birth` date NOT NULL DEFAULT "1970-01-01" COMMENT '身份证生日';
