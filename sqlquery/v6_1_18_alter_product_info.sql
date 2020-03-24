
-- 增加产品 秒杀完成时间字段 和类型字段
alter table `product_info` add `product_completiontime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '秒杀完成时间';
alter table `product_info` add `product_type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 product_type PRT01 普通 PRT02 秒杀';