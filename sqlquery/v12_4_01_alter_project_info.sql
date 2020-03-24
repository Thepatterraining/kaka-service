
update `project_info` set `project_hold_last` = null;

alter table `project_info` modify `project_hold_last` datetime DEFAULT '1970-01-01' COMMENT '到期时间';

update `project_info` set `project_hold_last` = '2024-09-30' where `project_no` = 'KKC-BJ0001';
update `project_info` set `project_hold_last` = '2024-09-30' where `project_no` = 'KKC-BJ0002';
update `project_info` set `project_hold_last` = '2019-08-31' where `project_no` = 'KKC-BJ0003';
update `project_info` set `project_hold_last` = '2024-09-30' where `project_no` = 'KKC-BJ0004';
update `project_info` set `project_hold_last` = '2024-09-30' where `project_no` = 'KKC-BJ0005';
update `project_info` set `project_hold_last` = '2024-09-30' where `project_no` = 'KKC-BJ0006';