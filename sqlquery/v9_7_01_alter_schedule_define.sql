alter table `kk_schecule_define` add `sch_comment` text DEFAULT null COMMENT '事务备注';

update `kk_schecule_define` set `sch_comment`='返佣日报' where `id`=1;
update `kk_schecule_define` set `sch_comment`='代币日报' where `id`=2;
update `kk_schecule_define` set `sch_comment`='现金日报' where `id`=3;
update `kk_schecule_define` set `sch_comment`='人员日报' where `id`=4;
update `kk_schecule_define` set `sch_comment`='充值日报' where `id`=5;
update `kk_schecule_define` set `sch_comment`='提现日报' where `id`=6;
update `kk_schecule_define` set `sch_comment`='每日用户查帐' where `id`=7;
update `kk_schecule_define` set `sch_comment`='每小时清理超时三方充值' where `id`=8;
update `kk_schecule_define` set `sch_comment`='每日清理系统错误' where `id`=9;
update `kk_schecule_define` set `sch_comment`='每日清理系统日志' where `id`=10;
update `kk_schecule_define` set `sch_comment`='每小时用户查账' where `id`=11;
update `kk_schecule_define` set `sch_comment`='每小时处理k线' where `sch_name`='CreateBarGragh' and `sch_type`='SCH01';
update `kk_schecule_define` set `sch_comment`='每日处理k线' where `sch_name`='CreateBarGragh' and `sch_type`='SCH02';
update `kk_schecule_define` set `sch_comment`='每周处理k线' where `sch_name`='CreateBarGragh' and `sch_type`='SCH03';
update `kk_schecule_define` set `sch_comment`='每月处理k线' where `sch_name`='CreateBarGragh' and `sch_type`='SCH04';
