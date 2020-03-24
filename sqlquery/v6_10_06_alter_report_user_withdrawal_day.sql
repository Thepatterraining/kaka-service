alter table `report_user_withdrawal_day` add `report_inituncheckcount` bigint(20) DEFAULT NULL COMMENT '过往未审核返现笔数',
add `report_withdrawaluncheckcount` bigint(20) DEFAULT NULL COMMENT '本期未审核返现笔数',
add `report_resultuncheckcount` bigint(20) DEFAULT NULL COMMENT '截止当前未审核返现总笔数';