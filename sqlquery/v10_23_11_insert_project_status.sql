truncate table `project_status`;
INSERT INTO `project_status` (`id`, `project_no`, `project_status`, `status_name`, `status_index`, `status_display`, `status_start`, `status_end`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'KKC-BJ0001','0','',0,0,'2017-10-23 15:00:00','2017-11-23 15:00:00','2017-10-23 16:03:55','2017-10-23 16:03:55',NULL,2,NULL,NULL),
	(2,'KKC-BJ0002','0','',0,0,'2017-10-23 16:16:00','2017-11-23 16:16:00','2017-10-23 16:16:59','2017-10-23 16:16:59',NULL,2,NULL,NULL),
	(3,'KKC-BJ0003','0','',0,0,'2017-10-23 16:30:00','2017-11-23 16:30:00','2017-10-23 16:26:46','2017-10-23 16:26:46',NULL,2,NULL,NULL),
	(4,'KKC-BJ0004','0','',0,0,'2017-10-23 16:32:00','2017-11-23 16:32:00','2017-10-23 16:31:44','2017-10-23 16:31:44',NULL,2,NULL,NULL),
	(5,'KKC-BJ0005','1','最新项目',1,1,'2017-10-23 16:37:00','2017-11-23 16:37:00','2017-10-23 16:37:21','2017-10-23 16:37:21',NULL,2,NULL,NULL);