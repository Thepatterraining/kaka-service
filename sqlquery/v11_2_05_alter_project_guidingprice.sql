
alter table `project_guidingprice` add `project_pricedate` datetime DEFAULT '1970-01-01' COMMENT '显示时间';
alter table `project_guidingprice` add `project_price_ischeck` int DEFAULT 0 COMMENT '是否审核';
alter table `project_guidingprice` add `project_prick_checkuser` bigint DEFAULT 0 COMMENT '审核管理员id ';