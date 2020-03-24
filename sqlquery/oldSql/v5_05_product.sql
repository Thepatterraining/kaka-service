


-- 修改 proj_trend 表 更新数据

truncate table `proj_trend`;

INSERT INTO `proj_trend` (`id`, `proj_no`, `proj_price`, `proj_time`, `proj_pricetype`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'KKC-BJ0001',292.89,'2011-09-27','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',316.75,'2012-04-09','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',419.17,'2012-10-06','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',607.99,'2013-03-20','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',566.98,'2013-10-23','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',610.00,'2014-03-1','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',552.83,'2014-10-02','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',694.62,'2015-03-21','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',802.31,'2015-09-29','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',1057.42,'2016-03-01','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',1082.27,'2016-09-12','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
	(null,'KKC-BJ0001',1487.01,'2017-03-15','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',342.14,'2011-10-25','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',353.39,'2012-04-06','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',491.73,'2012-10-15','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',692.94,'2013-06-21','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',700,'2013-11-23','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',736.42,'2014-03-06','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',706.53,'2014-10-26','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',688.73,'2015-03-23','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',921.20,'2015-11-15','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',1065.22,'2016-08-18','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL),
    (null,'KKC-BJ0002',1416.24,'2017-03-03','PROP01','2017-04-30 16:39:28','2017-04-30 16:39:28',NULL,1,NULL,NULL);



truncate table `item_info`;
INSERT INTO `item_info` (`id`, `name`, `coin_type`, `kk_name`, `compound`, `layout`, `diqu`, `trade`, `number`, `age`, `space`, `rowards`, `renovation`, `school`, `metro`, `price`, `amount`, `term`, `exchange_time`, `school_district`, `sublet`, `rightDate`, `bonusDate`, `investment`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `bonus_rate`, `bonus_cycle`, `bonus_periods`, `bonus_right_date`, `bonus_date`, `rose`)
VALUES
	(null,'德胜房产系列001号','KKC-BJ0001','咔咔北京数字一号房产','双旗杆东里','2室1厅1厨1卫','西城','德胜门','1/5','1979',50.55,'南','简装','西城区五路通小学','近8号线安华桥站',147000,5050,7,'2024-09-01 00:00:00','西城','IS01','1970-01-01 00:00:00','1970-01-01 00:00:00','小区位于三环里，西边是八达岭高速，东边是中轴路，北二环，北三环，德胜门，马甸桥，让您自驾畅通无堵，坐地铁8号线安华桥站也可以到家，门口多条公交线路，距离8号线安华桥站620米，交通便利，周边毗邻西城区五路通小学、三帆中学、师范大学第二附属中学西城实验学校、三帆中学裕中校区。',NULL,NULL,NULL,NULL,NULL,NULL,3.00000,'季度',28,'季度结束的最后一天','季度开始的第一天',339.00000),
	(null,'德胜房产系列002号','KKC-BJ0002','','文联宿舍','','西城','德胜门','','',36.80,'','','','',155000,0,8,'1970-01-01 00:00:00','','','1970-01-01 00:00:00','1970-01-01 00:00:00','小区位于三环里，西边是八达岭高速，东边是中轴路，北二环，北三环，德胜门，马甸桥，让您自驾畅通无堵，坐地铁8号线安华桥站也可以到家，门口多条公交线路，距离8号线安华桥站620米，交通便利，周边毗邻西城区五路通小学、三帆中学、师范大学第二附属中学西城实验学校、三帆中学裕中校区。',NULL,NULL,NULL,NULL,NULL,NULL,3.00000,'季度',32,'季度结束的最后一天','季度开始的第一天',301.00000);

truncate table `item_formula`;
INSERT INTO `item_formula` (`id`, `coin_type`, `item_id`, `iamge`, `file`, `file_name`, `type`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/huxingtu.jpg','','','IFT02',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/touzifenxi.pdf','调查分析报告-双旗杆东里20170331','IFT04',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/fangchanzheng.pdf','房产证-双旗杆东里','IFT05',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/fangchanzheng1.jpg','','','IFT05',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/hetong1.jpg','','','IFT06',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/hetong.pdf','西城双旗杆东里-20170401','IFT06',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img1.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img2.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img3.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img4.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img5.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img6.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img1.jpg','','','IFT01',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/waijing.jpg','','','IFT08',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/neijing.jpg','','','IFT09',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0001',0,'/upload/KKC-BJ0001/gongzhengwenjian.jpg','','','IFT07',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0002',0,'/upload/KKC-BJ0002/hetong.jpg','','','IFT06',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0002',0,'/upload/KKC-BJ0002/waijing.jpg','','','IFT08',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0002',0,'/upload/KKC-BJ0002/neijing.jpg','','','IFT09',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0002',0,'/upload/KKC-BJ0002/huxingtu.jpg','','','IFT02',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'KKC-BJ0002',0,'/upload/KKC-BJ0002/img1.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL);

