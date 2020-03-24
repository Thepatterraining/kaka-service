
alter table `project_bonustype` add `bonus_index` int DEFAULT 0 COMMENT '显示顺序';

update `project_bonustype` set `bonus_cyc` = '按周分红' where `bonus_cyc` = '按年分红';

update `project_bonustype` set `bonus_index` = 2 where `bonus_cyc` = '按周分红';
update `project_bonustype` set `bonus_index` = 1 where `bonus_cyc` = '按月分红';