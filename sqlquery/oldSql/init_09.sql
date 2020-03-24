truncate table `item_info`;
INSERT INTO `item_info` (`id`, `name`, `coin_type`, `kk_name`, `compound`, `layout`, `diqu`, `trade`, `number`, `age`, `space`, `rowards`, `renovation`, `school`, `metro`, `price`, `amount`, `term`, `exchange_time`, `school_district`, `sublet`, `rightDate`, `bonusDate`, `investment`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'双旗杆东里50.5㎡','KKC-BJ0001','咔咔北京数字一号房产','双旗杆东里','2室1厅1厨1卫','西城','德胜门','1/5','1979',50.50,'南','简装','西城区五路通小学','近8号线安华桥站',1477,5050,7,'2024-09-01 00:00:00','西城学区','IS01','1970-01-01 00:00:00','1970-01-01 00:00:00','<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;小区独立小院，有6栋板楼和3栋塔楼，小区有3栋板楼已经保温加固，其它几栋也将陆续施工，整个小区内的环境改造已经完成，重新铺了地砖，增加了健身的器材，小区内干净整洁，出小区南门有新鲜的蔬菜和水果供应，生活方便。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;步行距离人定湖公园500米，园林欧式风格、绿树成荫和清澈的湖水，是您休息的氧吧。\n配套银行中国银行、建设银行、招商银行、光大银行、北京银行等； 商场佰隆商厦、物美超市、美廉美、大润发定时定点班车接送，步行去华润万家800米购物方便。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交通南面是黄寺大街，北面是北三环中路，西面八达岭高速出行方便，东面中轴路。公交有123、运通104等，公交站黄寺站、阳光丽景站、安华桥西站、马甸桥东站，出行方便。</p><p><br></p>',NULL,NULL,NULL,NULL,NULL,NULL);

truncate table `item_formula`;
INSERT INTO `item_formula` (`id`, `coin_type`, `item_id`, `iamge`, `file`, `file_name`, `type`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'KKC-BJ0001',0,'/upload/KKC-BJ0001/huxingtu.jpg','null','null','IFT02',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/touzifenxi.pdf','调查分析报告-双旗杆东里20170331','IFT04',NULL,NULL,NULL,NULL,NULL,NULL),
	(3,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/fangchanzheng.pdf','房产证-双旗杆东里','IFT05',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'KKC-BJ0001',0,'/upload/KKC-BJ0001/fangchanzheng1.jpg,/upload/KKC-BJ0001/fangchanzheng2.jpg,/upload/KKC-BJ0001/fangchanzheng3.jpg','','','IFT05',NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'KKC-BJ0001',0,'/upload/KKC-BJ0001/hetong1.jpg,/upload/KKC-BJ0001/hetong2.jpg,/upload/KKC-BJ0001/hetong3.jpg','','','IFT06',NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/hetong.pdf','西城双旗杆东里-20170401','IFT06',NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img1.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img2.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(9,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img3.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(10,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img4.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img5.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(12,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img6.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(13,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img1.jpg','','','IFT01',NULL,NULL,NULL,NULL,NULL,NULL);

truncate table `item_quarters`;
INSERT INTO `item_quarters` (`id`, `coin_type`, `item_id`, `layout`, `space`, `date`, `total`, `price`, `age`, `rowards`, `number`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'KKC-BJ0001',0,'两室一厅','57.7','2017-03-15 00:00:00',858.000,148701.000,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'KKC-BJ0001',0,'两室一厅','57.7','2017-02-27 00:00:00',783.000,135702.000,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(3,'KKC-BJ0001',0,'两室一厅','50','2017-02-26 00:00:00',740.000,148000.000,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL);