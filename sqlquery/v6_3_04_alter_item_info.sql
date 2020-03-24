


alter table `item_info` add `company_name` varchar(100) NOT NULL DEFAULT '' COMMENT '公司名',
add `company_sign` varchar(50) NOT NULL DEFAULT '' COMMENT '签章',
add `fourth_agent` varchar(20) NOT NULL DEFAULT '' COMMENT '法人',
add `fourth_no` varchar(20) NOT NULL DEFAULT '' COMMENT '注册号';