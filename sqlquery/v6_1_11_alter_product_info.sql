
-- 增加售罄时间和撤销时间

alter table `product_info` add `product_endtime` DATETIME NOT NULL DEFAULT '1970-01-01' COMMENT '售罄时间';
alter table `product_info` add `product_revoketime` DATETIME NOT NULL DEFAULT '1970-01-01' COMMENT '撤销时间';


