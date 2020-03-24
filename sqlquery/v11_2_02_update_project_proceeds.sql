
update `project_proceeds` set `project_proceeds_name` = '房租分红' where `project_proceeds_name` = '固定分红';
update `project_proceeds` set `project_proceeds_note` = '房产升值收益' where `project_proceeds_note` = '房产价值上浮交易收益';
update `project_proceeds` set `project_proceeds_note` = '房租收益' where `project_proceeds_note` = '固定比例租金收益';