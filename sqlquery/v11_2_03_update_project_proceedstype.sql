
update `project_proceedstype` set `proceedstype_name` = '房租分红' where `proceedstype_name` = '固定分红';
update `project_proceedstype` set `proceedstype_note` = '房产升值收益' where `proceedstype_note` = '房产价值上浮交易收益';
update `project_proceedstype` set `proceedstype_note` = '房租收益' where `proceedstype_note` = '固定比例租金收益';