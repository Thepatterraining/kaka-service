truncate table `project_shareholder`;
INSERT INTO `project_shareholder` (`id`, `project_id`, `project_no`, `holder_id`, `holder_percent`, `holder_capital`, `holder_type`, `holder_typename`, `holder_sharebonus`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,1,'KKC-BJ0001',1,3.960,200.00,1,'分红',1,'2017-10-23 16:03:55','2017-10-23 16:03:55',NULL,2,NULL,NULL),
	(2,2,'KKC-BJ0002',1,5.435,200.00,1,'分红',1,'2017-10-23 16:16:59','2017-10-23 16:16:59',NULL,2,NULL,NULL),
	(3,3,'KKC-BJ0003',1,3.136,200.00,1,'分红',1,'2017-10-23 16:26:47','2017-10-23 16:26:47',NULL,2,NULL,NULL),
	(4,4,'KKC-BJ0004',1,4.124,200.00,1,'分红',1,'2017-10-23 16:31:44','2017-10-23 16:31:44',NULL,2,NULL,NULL);