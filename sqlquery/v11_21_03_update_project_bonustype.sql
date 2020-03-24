update `project_bonustype` set `bonus_confirminfo` = '周一下午5点' where `bonus_cyc` = '按周分红';
update `project_bonustype` set `bonus_confirminfo` = '当日23:59:59' where `bonus_cyc` = '按天分红';

update `project_bonustype` set `bonus_diviendinfo` = '周三下午5点' where `bonus_cyc` = '按周分红';
update `project_bonustype` set `bonus_diviendinfo` = '次日13:30:00' where `bonus_cyc` = '按天分红';

update `project_bonustype` set `bonus_name` = '房屋租金';