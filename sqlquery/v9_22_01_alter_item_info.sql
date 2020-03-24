
alter table `item_info` add `house_type` varchar(50) NOT NULL DEFAULT '' COMMENT '房屋署权 商品房',
add `lease_type` varchar(50) NOT NULL DEFAULT '' COMMENT '租凭状态 待出租',
add `house_purpose` varchar(50) NOT NULL DEFAULT '' COMMENT '房屋用途 普通住宅',
add `region` varchar(255) NOT NULL DEFAULT '' COMMENT '区域介绍 临近第3中学',
add `traffic` varchar(255) NOT NULL DEFAULT '' COMMENT '交通位置 距离1号线地铁站100米';
