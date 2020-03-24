


-- 修改 finance_bank 表 更新数据

truncate table `finance_bank`;

INSERT INTO `finance_bank` (`id`, `bank_no`, `bank_name`, `bank_short`, `bank_fullname`, `bank_source`, `bank_icon`, `bank_ischeck`, `bank_checkser`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'1','招商银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'2','中国银行','','','BS01',NULL,b'1','262','2017-05-04 17:14:27','2017-05-04 17:40:48',NULL,262,NULL,NULL),
	(3,'3','建设银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'4','交通银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'5','农业银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'6','工商银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'7','中国邮政储蓄银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'8','中国光大银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(9,'9','中国民生银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(10,'10','平安银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'11','浦发银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(12,'12','中信银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(13,'13','兴业银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(14,'14','华夏银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(15,'15','广发银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(20,'16','北京农商银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL),
	(21,'17','其他银行','','','BS01',NULL,b'1','',NULL,NULL,NULL,NULL,NULL,NULL);