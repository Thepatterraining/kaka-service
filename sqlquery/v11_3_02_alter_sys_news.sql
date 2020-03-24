
alter table `sys_news` add `news_outime` datetime DEFAULT '1970-01-01' COMMENT '下架时间';
alter table `sys_news` add `news_pushbanner` int DEFAULT 0 COMMENT '是否轮播';
alter table `sys_news` add `news_type_id` bigint DEFAULT 0 COMMENT 'type.id';
alter table `sys_news` add `news_type_name` varchar(255) DEFAULT '' COMMENT 'type.name';
alter table `sys_news` add `news_pushtotop` int DEFAULT 0 COMMENT '推送到首页的排序';