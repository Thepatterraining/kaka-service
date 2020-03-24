CREATE TABLE `report_user_hourly` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `report_name` varchar(255) NOT NULL DEFAULT '0' COMMENT '报表名称',
  `report_runtype` char(30) NOT NULL DEFAULT '0' COMMENT '运行周期',
  `report_intcount` bigint(20) NOT NULL DEFAULT '0' COMMENT '上期用户基数',
  `report_acscount` bigint(20) NOT NULL DEFAULT '0' COMMENT '增长数',
  `report_currentcount` bigint(20) NOT NULL DEFAULT '0' COMMENT '到周期结束数量',
  `report_lastlogin` bigint(20) NOT NULL DEFAULT '0' COMMENT '上期用户活跃基数',
  `report_acslogin` bigint(20) NOT NULL DEFAULT '0' COMMENT '增长活跃',
  `report_currentlogin` bigint(20) NOT NULL DEFAULT '0' COMMENT '当前活跃',
  `report_start` datetime NOT NULL DEFAULT '2017-04-06 00:00:00' COMMENT '开始时间',
  `report_end` datetime NOT NULL DEFAULT '2017-04-07 00:00:00' COMMENT '结束时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;