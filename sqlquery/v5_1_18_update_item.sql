
-- 项目详细
DROP TABLE IF EXISTS `item_info`;

CREATE TABLE `item_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '项目名称',
  `coin_type` varchar(50) NOT NULL DEFAULT '' COMMENT '代币类型',
  `kk_name` varchar(30) NOT NULL DEFAULT '' COMMENT '卡卡币名称 ',
  `compound` varchar(255) NOT NULL DEFAULT '' COMMENT '小区名称',
  `layout` varchar(255) NOT NULL DEFAULT '' COMMENT '户型',
  `diqu` varchar(255) NOT NULL DEFAULT '' COMMENT '地区',
  `trade` varchar(255) NOT NULL DEFAULT '' COMMENT '商圈',
  `number` char(10) DEFAULT '' COMMENT '楼层',
  `age` varchar(255) NOT NULL DEFAULT '' COMMENT '年代',
  `space` decimal(10,2) DEFAULT NULL COMMENT '面积',
  `rowards` varchar(255) NOT NULL DEFAULT '' COMMENT '朝向',
  `renovation` varchar(255) NOT NULL DEFAULT '' COMMENT '装修',
  `school` varchar(255) NOT NULL DEFAULT '' COMMENT '教育配套',
  `metro` varchar(50) NOT NULL DEFAULT '' COMMENT '临近地铁',
  `price` int(11) NOT NULL COMMENT '市场参考价',
  `amount` int(11) DEFAULT '0' COMMENT '资产总量',
  `term` int(2) NOT NULL COMMENT '投资期限',
  `exchange_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '交割日期',
  `school_district` varchar(255) NOT NULL DEFAULT '' COMMENT '教育属性',
  `sublet` varchar(255) NOT NULL DEFAULT '' COMMENT '分租方式  item_sublet  IS01 按季度分租  IS02  按年分租',
  `rightDate` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '确权日期',
  `bonusDate` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '分红日期',
  `investment` text NOT NULL COMMENT '投资分析',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  `bonus_rate` varchar(255) NOT NULL DEFAULT '0.00000' COMMENT '分红率',
  `bonus_cycle` varchar(20) NOT NULL DEFAULT '' COMMENT '分红周期',
  `bonus_periods` int(11) NOT NULL DEFAULT '0' COMMENT '分红期数',
  `bonus_right_date` varchar(255) NOT NULL DEFAULT '' COMMENT '确权日',
  `bonus_date` varchar(255) NOT NULL DEFAULT '' COMMENT '分红日',
  `rose` decimal(20,5) NOT NULL DEFAULT '0.00000' COMMENT '涨幅',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `item_info` (`id`, `name`, `coin_type`, `kk_name`, `compound`, `layout`, `diqu`, `trade`, `number`, `age`, `space`, `rowards`, `renovation`, `school`, `metro`, `price`, `amount`, `term`, `exchange_time`, `school_district`, `sublet`, `rightDate`, `bonusDate`, `investment`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `bonus_rate`, `bonus_cycle`, `bonus_periods`, `bonus_right_date`, `bonus_date`, `rose`)
VALUES
	(null,'德胜房产系列001号','KKC-BJ0001','咔咔北京数字一号房产','双旗杆东里','2室1厅1厨1卫','西城','德胜门','1/5','1979',50.55,'南','简装','西城区五路通小学','近8号线安华桥站',1455,5050,7,'2024-09-01 00:00:00','西城','IS01','1970-01-01 00:00:00','1970-01-01 00:00:00','小区位于三环里，西边是八达岭高速，东边是中轴路，北二环，北三环，德胜门，马甸桥，让您自驾畅通无堵，坐地铁8号线安华桥站也可以到家，门口多条公交线路，距离8号线安华桥站620米，交通便利；周边毗邻北京西城区五路通小学、北京三帆中学、北京师范大学第二附属中学西城实验学校、三帆中学裕中校区、北京第四中学、北京第八中学、北京第十三中学、北京第七中学等优质教育资源，教育实力雄厚；周边临近华联商厦、翠微百货、新华百货、北京积水潭医院、北京安贞医院、火箭军总医院、工商银行、北京银行、华夏银行等公共场所， 配套设施完善，生活十分便利。',NULL,NULL,NULL,NULL,NULL,NULL,'待定','季度',28,'季度结束的最后一天','季度开始的第一天',339.00000),
	(null,'德胜房产系列002号','KKC-BJ0002','','文联宿舍','','西城','德胜门','','',36.80,'','','','',1530,0,8,'1970-01-01 00:00:00','','','1970-01-01 00:00:00','1970-01-01 00:00:00','小区位于三环里，西边是八达岭高速，东边是中轴路，北二环，北三环，德胜门，马甸桥，让您自驾畅通无堵，坐地铁8号线安华桥站也可以到家，门口多条公交线路，距离8号线安华桥站620米，交通便利；周边毗邻北京西城区五路通小学、北京三帆中学、北京师范大学第二附属中学西城实验学校、三帆中学裕中校区、北京第四中学、北京第八中学、北京第十三中学、北京第七中学等优质教育资源，教育实力雄厚；周边临近华联商厦、翠微百货、新华百货、北京积水潭医院、北京安贞医院、火箭军总医院、工商银行、北京银行、华夏银行等公共场所， 配套设施完善，生活十分便利。',NULL,NULL,NULL,NULL,NULL,NULL,'待定','季度',32,'季度结束的最后一天','季度开始的第一天',301.00000);


truncate table `item_formula`;

INSERT INTO `item_formula` (`id`, `coin_type`, `item_id`, `iamge`, `file`, `file_name`, `type`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'KKC-BJ0001',0,'/upload/KKC-BJ0001/huxingtu.jpg','','','IFT02',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/touzifenxi.pdf','调查分析报告-双旗杆东里20170331','IFT04',NULL,NULL,NULL,NULL,NULL,NULL),
	(3,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/fangchanzheng.pdf','房产证-双旗杆东里','IFT05',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'KKC-BJ0001',0,'/upload/KKC-BJ0001/fangchanzheng1.jpg','','','IFT05',NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'KKC-BJ0001',0,'/upload/KKC-BJ0001/hetong1.jpg','','','IFT06',NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'KKC-BJ0001',0,'','/upload/KKC-BJ0001/hetong.pdf','西城双旗杆东里-20170401','IFT06',NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img1.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img2.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(9,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img3.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(10,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img4.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(11,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img5.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(12,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img6.jpg','','','IFT03',NULL,NULL,'2017-05-09 00:00:00',NULL,NULL,NULL),
	(13,'KKC-BJ0001',0,'/upload/KKC-BJ0001/img1.jpg','','','IFT01',NULL,NULL,NULL,NULL,NULL,NULL),
	(14,'KKC-BJ0001',0,'/upload/KKC-BJ0001/waijing.jpg','','','IFT08',NULL,NULL,NULL,NULL,NULL,NULL),
	(15,'KKC-BJ0001',0,'/upload/KKC-BJ0001/neijing.jpg','','','IFT09',NULL,NULL,NULL,NULL,NULL,NULL),
	(16,'KKC-BJ0001',0,'/upload/KKC-BJ0001/gongzhengwenjian.jpg','','','IFT07',NULL,NULL,NULL,NULL,NULL,NULL),
	(17,'KKC-BJ0002',0,'/upload/KKC-BJ0002/hetong.jpg','','','IFT06',NULL,NULL,NULL,NULL,NULL,NULL),
	(18,'KKC-BJ0002',0,'/upload/KKC-BJ0002/waijing.jpg','','','IFT08',NULL,NULL,NULL,NULL,NULL,NULL),
	(19,'KKC-BJ0002',0,'/upload/KKC-BJ0002/neijing.jpg','','','IFT09',NULL,NULL,NULL,NULL,NULL,NULL),
	(20,'KKC-BJ0002',0,'/upload/KKC-BJ0002/huxingtu.jpg','','','IFT02',NULL,NULL,NULL,NULL,NULL,NULL),
	(21,'KKC-BJ0002',0,'/upload/KKC-BJ0002/img1.jpg','','','IFT03',NULL,NULL,NULL,NULL,NULL,NULL),
	(22,'KKC-BJ0002',0,'','/upload/KKC-BJ0002/touzifenxi.pdf','调查分析报告-文联宿舍20170510','IFT04',NULL,NULL,NULL,NULL,NULL,NULL),
	(23,'KKC-BJ0002',0,'/upload/KKC-BJ0002/fangchanzheng.jpg','','','IFT05',NULL,NULL,NULL,NULL,NULL,NULL);




update `transaction_order` set `order_price` = `order_price` * 100;
