
alter table `resource_index` add `resource_modelname` varchar(255) NOT NULL DEFAULT 0 COMMENT '项目名称',
                             add `resource_name` varchar(255) NOT NULL DEFAULT 0 COMMENT '项目名称';