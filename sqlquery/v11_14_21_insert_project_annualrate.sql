INSERT INTO `project_annualrate` (`id`, `proj_id`, `project_no`, `annualrate_value`, `annualrate_year`, `annualrate_ishistory`, `annualrate_primary`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,8,'KKC-BJ0006','70.75','2012',1,0,'2017-11-13 00:33:33','2017-11-13 00:33:33',NULL,2,NULL,NULL),
	(null,8,'KKC-BJ0006','18.9','2013',1,0,'2017-11-13 00:33:33','2017-11-13 00:33:33',NULL,2,NULL,NULL),
	(null,8,'KKC-BJ0006','1.26','2014',1,0,'2017-11-13 00:33:33','2017-11-13 00:33:33',NULL,2,NULL,NULL),
	(null,8,'KKC-BJ0006','29.58','2015',1,0,'2017-11-13 00:33:33','2017-11-13 00:33:33',NULL,2,NULL,NULL),
	(null,8,'KKC-BJ0006','43.9','2016',1,0,'2017-11-13 00:33:33','2017-11-13 00:33:33',NULL,2,NULL,NULL),
	(null,8,'KKC-BJ0006','32.9','2017',1,1,'2017-11-13 00:33:33','2017-11-13 00:33:33',NULL,2,NULL,NULL);


update `project_annualrate` set `annualrate_year` = "预期租金收益" where `project_no` = 'KKC-BJ0005' and `annualrate_value` = "5.00";
update `project_annualrate` set `annualrate_year` = "预期房价波动" where `project_no` = 'KKC-BJ0005' and `annualrate_value` = "15.00";
update `project_annualrate` set `annualrate_value` = "0 - 10" where `project_no` = 'KKC-BJ0005' and `annualrate_value` = "15.00";