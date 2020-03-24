


-- 修改 sys_dictionary 表 更新数据

truncate table `sys_dictionary`;

INSERT INTO `sys_dictionary` (`id`, `dic_no`, `dic_type`, `dic_name`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'B01','bank','工商银行','2017-03-08 03:31:59','2017-03-08 03:31:59',NULL,NULL,NULL,NULL),
	(2,'B02','bank','农业银行','2017-03-08 03:32:49','2017-03-08 03:32:49',NULL,26,NULL,NULL),
	(3,'B03','bank','建设银行','2017-03-08 03:33:06','2017-03-08 03:33:06',NULL,26,NULL,NULL),
	(4,'B04','bank','中国银行','2017-03-08 03:33:17','2017-03-08 03:33:17',NULL,26,NULL,NULL),
	(5,'B05','bank','招商银行','2017-03-08 03:33:37','2017-03-08 03:33:37',NULL,26,NULL,NULL),
	(6,'B06','bank','北京农商银行','2017-03-08 05:37:26','2017-03-08 05:37:26',NULL,26,NULL,NULL),
	(7,'B07','bank','光大银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(8,'CR00','cash_rechage','已提交','2017-03-10 05:29:23','2017-03-10 05:29:23',NULL,NULL,NULL,NULL),
	(9,'CR01','cash_rechage','成功','2017-03-10 05:29:43','2017-03-10 05:29:43',NULL,NULL,NULL,NULL),
	(10,'CR02','cash_rechage','失败','2017-03-10 05:30:12','2017-03-10 05:30:12',NULL,NULL,NULL,NULL),
	(11,'CRT01','cash_rechage_type','普通','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(14,'TS00','trans_sell','挂单',NULL,NULL,NULL,NULL,NULL,NULL),
	(15,'TS01','trans_sell','部分成交',NULL,NULL,NULL,NULL,NULL,NULL),
	(16,'TS02','trans_sell','全部成交',NULL,NULL,NULL,NULL,NULL,NULL),
	(17,'TS03','trans_sell','部分撒单',NULL,NULL,NULL,NULL,NULL,NULL),
	(18,'TS04','trans_sell','全部撒单',NULL,NULL,NULL,NULL,NULL,NULL),
	(19,'TB00','trans_buy','挂单',NULL,NULL,NULL,NULL,NULL,NULL),
	(20,'TB01','trans_buy','部分成交',NULL,NULL,NULL,NULL,NULL,NULL),
	(21,'TB02','trans_buy','全部成交',NULL,NULL,NULL,NULL,NULL,NULL),
	(22,'TB03','trans_buy','部分撒单',NULL,NULL,NULL,NULL,NULL,NULL),
	(23,'TB04','trans_buy','全部撒单',NULL,NULL,NULL,NULL,NULL,NULL),
	(24,'CW00','cash_withdrawaal','提交',NULL,NULL,NULL,NULL,NULL,NULL),
	(25,'CW01','cash_withdrawaal','成功',NULL,NULL,NULL,NULL,NULL,NULL),
	(26,'CW02','cash_withdrawaal','失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(27,'CWT01','cash_withdrawal_type','普通',NULL,NULL,NULL,NULL,NULL,NULL),
	(28,'SLT01','sms_code','注册',NULL,NULL,NULL,NULL,NULL,NULL),
	(29,'SLT02','sms_code','修改手机号',NULL,NULL,NULL,NULL,NULL,NULL),
	(30,'SLT03','sms_code','修改支付密码',NULL,NULL,NULL,NULL,NULL,NULL),
	(31,'SLT04','sms_code','绑定银行卡',NULL,NULL,NULL,NULL,NULL,NULL),
	(32,'CJT01','journal_type','初提',NULL,NULL,NULL,NULL,NULL,NULL),
	(33,'CJT02','journal_type','成功',NULL,NULL,NULL,NULL,NULL,NULL),
	(34,'CJT03','journal_type','失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(35,'CJT04','journal_type','撤回',NULL,NULL,NULL,NULL,NULL,NULL),
	(36,'CJT05','journal_type','冲减',NULL,NULL,NULL,NULL,NULL,NULL),
	(37,'CJ01','usercash_journal','提现',NULL,NULL,NULL,NULL,NULL,NULL),
	(38,'CJ02','usercash_journal','充值',NULL,NULL,NULL,NULL,NULL,NULL),
	(39,'CJ03','usercash_journal','买单',NULL,NULL,NULL,NULL,NULL,NULL),
	(40,'CJ04','usercash_journal','卖单',NULL,NULL,NULL,NULL,NULL,NULL),
	(41,'CJ05','usercash_journal','提现手续费',NULL,NULL,NULL,NULL,NULL,NULL),
	(42,'CJ06','usercash_journal','成交手续费',NULL,NULL,NULL,NULL,NULL,NULL),
	(43,'CJ07','usercash_journal','返佣',NULL,NULL,NULL,NULL,NULL,NULL),
	(44,'CJ08','usercash_journal','用券',NULL,NULL,NULL,NULL,NULL,NULL),
	(45,'CJ09','usercash_journal','买入',NULL,NULL,NULL,NULL,NULL,NULL),
	(46,'CJ10','usercash_journal','一级市场放量',NULL,NULL,NULL,NULL,NULL,NULL),
	(47,'CJ11','usercash_journal','交易',NULL,NULL,NULL,NULL,NULL,NULL),
	(49,'CJT06','journal_type','交易',NULL,NULL,NULL,NULL,NULL,NULL),
	(50,'CRB00','cash_rechage_body','失败','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(51,'CWB00','cash_withdrawal_body','失败','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(52,'OR00','coin_rechage','已提交','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(53,'OR01','coin_rechage','已成功','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(54,'OR02','coin_rechage','已失败','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(55,'ORT01','coin_rechage_type','普通用户充值','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(56,'ORT02','coin_rechage_type','钱包直充','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(57,'ORT03','coin_rechage_type','一级市场充值','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(58,'UOJ01','usercoin_journal','充值','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(59,'UOJ02','usercoin_journal','提现','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(60,'UOJ03','usercoin_journal','提现代币手续费','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(61,'UOJ04','usercoin_journal','确认','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(62,'UOJ05','usercoin_journal','冲减','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(63,'UOJ06','usercoin_journal','交易手续费','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(64,'OWT01','coin_withdrawaal_type','普通用户提现','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(65,'OW00','coin_withdrawaal','已提交','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(66,'OW01','coin_withdrawaal','已成功','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(67,'OW02','coin_withdrawaal','已失败','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(68,'SLT05','sms_code','修改登录密码',NULL,NULL,NULL,NULL,NULL,NULL),
	(69,'COJ01','syscoin_journal','提币手续费',NULL,NULL,NULL,NULL,NULL,NULL),
	(70,'COJ02','syscoin_journal','交易手续费',NULL,NULL,NULL,NULL,NULL,NULL),
	(71,'AL01','activity_limit','限时',NULL,NULL,NULL,NULL,NULL,NULL),
	(72,'AL02','activity_limit','限量',NULL,NULL,NULL,NULL,NULL,NULL),
	(73,'AS00','activity_status','未开始',NULL,NULL,NULL,NULL,NULL,NULL),
	(74,'AS01','activity_status','进行中',NULL,NULL,NULL,NULL,NULL,NULL),
	(75,'AS02','activity_status','已结束',NULL,NULL,NULL,NULL,NULL,NULL),
	(76,'AS03','activity_status','已终止',NULL,NULL,NULL,NULL,NULL,NULL),
	(77,'VC01','voucher_type','满减',NULL,NULL,NULL,NULL,NULL,NULL),
	(78,'AT01','activity','返券',NULL,NULL,NULL,NULL,NULL,NULL),
	(79,'CWF00','cash_withdrawal_fee','已经提交',NULL,NULL,NULL,NULL,NULL,NULL),
	(80,'CWF01','cash_withdrawal_fee','成功',NULL,NULL,NULL,NULL,NULL,NULL),
	(81,'CWF02','cash_withdrawal_fee','失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(82,'CWFT01','cash_withdrawal_feetype','普通用户提现',NULL,NULL,NULL,NULL,NULL,NULL),
	(83,'VOUS01','voucher_status','已用',NULL,NULL,NULL,NULL,NULL,NULL),
	(84,'VOUS00','voucher_status','未用',NULL,NULL,NULL,NULL,NULL,NULL),
	(85,'VOUS02','voucher_status','过期',NULL,NULL,NULL,NULL,NULL,NULL),
	(86,'SL00','sell_level','普通',NULL,NULL,NULL,NULL,NULL,NULL),
	(87,'SL01','sell_level','理财金可用',NULL,NULL,NULL,NULL,NULL,NULL),
	(94,'UOJ08','usercoin_journal','成交',NULL,NULL,NULL,NULL,NULL,NULL),
	(95,'CJT01','cjournal_type','初提',NULL,NULL,NULL,NULL,NULL,NULL),
	(96,'CJT02','cjournal_type','成功',NULL,NULL,NULL,NULL,NULL,NULL),
	(97,'CJT03','cjournal_type','失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(98,'CJT04','cjournal_type','撤回',NULL,NULL,NULL,NULL,NULL,NULL),
	(99,'CJT05','cjournal_type','冲减',NULL,NULL,NULL,NULL,NULL,NULL),
	(100,'CJT06','cjournal_type','成交',NULL,NULL,NULL,NULL,NULL,NULL),
	(101,'US01','user_status','正常',NULL,NULL,NULL,NULL,NULL,NULL),
	(104,'UOJ07','usercoin_journal','交易','2017-03-10 05:30:46','2017-03-10 05:30:46',NULL,NULL,NULL,NULL),
	(105,'NEWS01','news','行业新闻',NULL,NULL,NULL,NULL,NULL,NULL),
	(106,'NP01','newspush','弹窗',NULL,NULL,NULL,NULL,NULL,NULL),
	(107,'MSG01','message_status','未读',NULL,NULL,NULL,NULL,NULL,NULL),
	(108,'UORDER01','userorder','买入',NULL,NULL,NULL,NULL,NULL,NULL),
	(109,'UORDER02','userorder','卖出',NULL,NULL,NULL,NULL,NULL,NULL),
	(110,'UCORDER01','usercashorder','项目购买',NULL,NULL,NULL,NULL,NULL,NULL),
	(111,'UCORDER02','usercashorder','项目转让',NULL,NULL,NULL,NULL,NULL,NULL),
	(112,'UCORDER03','usercashorder','提现',NULL,NULL,NULL,NULL,NULL,NULL),
	(114,'UCORDER05','usercashorder','充值',NULL,NULL,NULL,NULL,NULL,NULL),
	(116,'CYC01','settlementtype','小时自动对帐',NULL,NULL,NULL,NULL,NULL,NULL),
	(117,'CYC02','settlementtype','日对帐',NULL,NULL,NULL,NULL,NULL,NULL),
	(118,'CYC03','settlementtype','周对帐',NULL,NULL,NULL,NULL,NULL,NULL),
	(119,'IS01','item_sublet','按季度分租',NULL,NULL,NULL,NULL,NULL,NULL),
	(120,'IS02','item_sublet','按年分租',NULL,NULL,NULL,NULL,NULL,NULL),
	(121,'IFT01','item_formula_type','购物证照',NULL,NULL,NULL,NULL,NULL,NULL),
	(122,'IFT02','item_formula_type','户型图',NULL,NULL,NULL,NULL,NULL,NULL),
	(123,'IFT03','item_formula_type','项目图片',NULL,NULL,NULL,NULL,NULL,NULL),
	(124,'IFT04','item_formula_type','投资分析',NULL,NULL,NULL,NULL,NULL,NULL),
	(125,'IFT05','item_formula_type','房产证',NULL,NULL,NULL,NULL,NULL,NULL),
	(126,'IFT06','item_formula_type','购房合同',NULL,NULL,NULL,NULL,NULL,NULL),
	(127,'IFT07','item_formula_type','公证文件',NULL,NULL,NULL,NULL,NULL,NULL),
	(128,'IFT08','item_formula_type','外景图',NULL,NULL,NULL,NULL,NULL,NULL),
	(129,'IFT09','item_formula_type','内景图',NULL,NULL,NULL,NULL,NULL,NULL),
	(130,'IFT10','item_formula_type','公式6',NULL,NULL,NULL,NULL,NULL,NULL),
	(131,'IFT11','item_formula_type','公式7',NULL,NULL,NULL,NULL,NULL,NULL),
	(132,'IFT12','item_formula_type','公式8',NULL,NULL,NULL,NULL,NULL,NULL),
	(133,'IFT13','item_formula_type','公式9',NULL,NULL,NULL,NULL,NULL,NULL),
	(134,'IFT14','item_formula_type','公式十',NULL,NULL,NULL,NULL,NULL,NULL),
	(136,'AF01','activity_filter','邀请用户发券',NULL,NULL,NULL,NULL,NULL,NULL),
	(137,'AF02','activity_filter','未邀请用户发券',NULL,NULL,NULL,NULL,NULL,NULL),
	(138,'SCJ01','syscash_journal','提现手续费',NULL,NULL,NULL,NULL,NULL,NULL),
	(139,'SCJ02','syscash_journal','返券',NULL,NULL,NULL,NULL,NULL,NULL),
	(140,'SCJ03','syscash_journal','交易手续费',NULL,NULL,NULL,NULL,NULL,NULL),
	(141,'NEWS02','news','项目分析',NULL,NULL,NULL,NULL,NULL,NULL),
	(142,'NEWS03','news','官方公告',NULL,NULL,NULL,NULL,NULL,NULL),
	(143,'B08','bank','交通银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(144,'B09','bank','中国邮政储蓄银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(145,'B10','bank','中国民生银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(146,'B11','bank','平安银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(147,'B12','bank','浦发银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(148,'B13','bank','中信银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(149,'B14','bank','兴业银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(150,'B15','bank','华夏银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(151,'B16','bank','广发银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(152,'MSG02','message_status','推送',NULL,NULL,NULL,NULL,NULL,NULL),
	(153,'MSG03','message_status','已读',NULL,NULL,NULL,NULL,NULL,NULL),
	(154,'NT01','notify_type','充值成功提醒',NULL,NULL,NULL,NULL,NULL,NULL),
	(155,'NT02','notify_type','充值失败提醒',NULL,NULL,NULL,NULL,NULL,NULL),
	(156,'NT03','notify_type','提现成功提醒',NULL,NULL,NULL,NULL,NULL,NULL),
	(157,'NT04','notify_type','提现失败提醒',NULL,NULL,NULL,NULL,NULL,NULL),
	(158,'NT05','notify_type','交易成功提醒',NULL,NULL,NULL,NULL,NULL,NULL),
	(159,'NT06','notify_type','发券成功提醒',NULL,NULL,NULL,NULL,NULL,NULL),
	(160,'INV01','invitation','注册',NULL,NULL,NULL,NULL,NULL,NULL),
	(161,'CJ01','cash_journal','提现',NULL,NULL,NULL,NULL,NULL,NULL),
	(163,'CJ02','cash_journal','充值',NULL,NULL,NULL,NULL,NULL,NULL),
	(164,'CJ01','coin_journal','提现',NULL,NULL,NULL,NULL,NULL,NULL),
	(165,'CJ02','coin_journal','充值',NULL,NULL,NULL,NULL,NULL,NULL),
	(166,'CWF00','coin_withdrawal_fee','已经提交',NULL,NULL,NULL,NULL,NULL,NULL),
	(167,'CWF01','coin_withdrawal_fee','成功',NULL,NULL,NULL,NULL,NULL,NULL),
	(168,'CWF02','coin_withdrawal_fee','失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(169,'CWFT01','coin_withdrawal_feetype','普通用户提现',NULL,NULL,NULL,NULL,NULL,NULL),
	(170,'FT01','coin_frozen','用券交易',NULL,NULL,NULL,NULL,NULL,NULL),
	(171,'FS01','frozen_status','冻结',NULL,NULL,NULL,NULL,NULL,NULL),
	(172,'FS02','frozen_status','解冻',NULL,NULL,NULL,NULL,NULL,NULL),
	(173,'CJT07','cjournal_type','冻结',NULL,NULL,NULL,NULL,NULL,NULL),
	(174,'B17','bank','其他银行','2017-03-08 05:54:37','2017-03-08 05:54:37',NULL,26,NULL,NULL),
	(175,'UOJ09','usercoin_journal','用券冻结',NULL,NULL,NULL,NULL,NULL,NULL),
	(176,'UOJ10','usercoin_journal','解除冻结',NULL,NULL,NULL,NULL,NULL,NULL),
	(177,'ASS00','activity_storage_status','提交',NULL,NULL,NULL,NULL,NULL,NULL),
	(178,'ASS01','activity_storage_status','成功',NULL,NULL,NULL,NULL,NULL,NULL),
	(179,'ASS02','activity_storage_status','失败',NULL,NULL,NULL,NULL,NULL,NULL),
	(180,'UT00','user_type','普通用户',NULL,NULL,NULL,NULL,NULL,NULL),
	(181,'UT01','user_type','公司员工',NULL,NULL,NULL,NULL,NULL,NULL),
	(182,'UT02','user_type','公司高管',NULL,NULL,NULL,NULL,NULL,NULL),
	(183,'UT03','user_type','基金帐号',NULL,NULL,NULL,NULL,NULL,NULL),
	(184,'SLT06','sms_code','验证手机号',NULL,NULL,NULL,NULL,NULL,NULL),
	(185,'FR00','fee_rate_type','免收',NULL,NULL,NULL,NULL,NULL,NULL),
	(186,'FR01','fee_rate_type','价内',NULL,NULL,NULL,NULL,NULL,NULL),
	(187,'FR02','fee_rate_type','价外',NULL,NULL,NULL,NULL,NULL,NULL),
	(188,'NT07','notify_type','提现申请提醒',NULL,NULL,NULL,NULL,NULL,NULL),
	(190,'NT08','notify_type','买入成功提醒',NULL,NULL,NULL,NULL,NULL,NULL),
	(191,'PRS01','product_status','未开始',NULL,NULL,NULL,NULL,NULL,NULL),
	(192,'PRS02','product_status','发售中',NULL,NULL,NULL,NULL,NULL,NULL),
	(193,'PRS03','product_status','已售罄',NULL,NULL,NULL,NULL,NULL,NULL),
	(194,'PROP01','proj_pricetype','人工录入',NULL,NULL,NULL,NULL,NULL,NULL),
	(195,'PROP02','proj_pricetype','链家爬虫',NULL,NULL,NULL,NULL,NULL,NULL),
	(196,'FT02','coin_frozen','产品交易',NULL,NULL,NULL,NULL,NULL,NULL),
	(197,'BS01','bank_source','系统',NULL,NULL,NULL,NULL,NULL,NULL),
	(198,'BS02','bank_source','用戶添加',NULL,NULL,NULL,NULL,NULL,NULL),
	(199,'SLT07','sms_code','充值',NULL,NULL,NULL,NULL,NULL,NULL),
	(202,'UCORDER07','usercashorder','项目认购',NULL,NULL,NULL,NULL,NULL,NULL),
	(203,'SLT08','sms_code','登陆',NULL,NULL,NULL,NULL,NULL,NULL);