
alter table `project_annualrate` modify `annualrate_value` varchar(30) DEFAULT '' COMMENT '收益';
alter table `project_annualrate` modify `annualrate_year` varchar(255) DEFAULT '' COMMENT '年份';

alter table `project_annualrate` add `annualrate_primary` int DEFAULT 0 COMMENT '是否是平均年化';