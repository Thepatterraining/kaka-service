
-- 活动详情
truncate table `activity_info`;
INSERT INTO `activity_info` (`id`, `activity_no`, `activity_name`, `activity_start`, `activity_end`, `activity_limittype`, `activity_event`, `activity_limitcount`, `activity_count`, `activity_filter`, `activity_code`, `activity_status`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'SA20170402193540897','','1970-01-01 00:00:00','1970-01-01 00:00:00','','',0,0,'AF02','','AS01',NULL,'2017-04-05 08:30:15',NULL,NULL,NULL,NULL),
	(2,'SA20170402193540898','','1970-01-01 00:00:00','1970-01-01 00:00:00','','',0,0,'AF01','345fg76k','AS01',NULL,'2017-04-05 07:34:20',NULL,NULL,NULL,NULL);

-- 活动子表
truncate table `activity_item`;
INSERT INTO `activity_item` (`id`, `activity_no`, `activity_itemtype`, `activity_itemno`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'SA20170402193540897','AT01','VCN2017031915460142476','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(2,'SA20170402193540898','AT01','VCN2017031915460142475','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(3,'SA20170402193540898','AT01','VCN2017031915460142475','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(4,'SA20170402193540898','AT01','VCN2017031915460142479','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(5,'SA20170402193540898','AT01','VCN2017031915460142477','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(6,'SA20170402193540898','AT01','VCN2017031915460142473','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(7,'SA20170402193540897','AT01','VCN2017031915460142475','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(8,'SA20170402193540898','AT01','VCN2017031915460142480','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(9,'SA20170402193540898','AT01','VCN2017031915460142478','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(10,'SA20170402193540898','AT01','VCN2017031915460142475','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(11,'SA20170402193540897','AT01','VCN2017031915460142475','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(12,'SA20170402193540898','AT01','VCN2017031915460142475','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(13,'SA20170402193540898','AT01','VCN2017031915460142476','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(14,'SA20170402193540898','AT01','VCN2017031915460142476','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(15,'SA20170402193540897','AT01','VCN2017031915460142475','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(16,'SA20170402193540898','AT01','VCN2017031915460142476','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL),
	(17,'SA20170402193540898','AT01','VCN2017031915460142473','2017-03-19 17:17:20','2017-03-19 17:17:20',NULL,NULL,NULL,NULL);


-- 管理员
truncate table `auth_user`;
INSERT INTO `auth_user` (`id`, `auth_id`, `auth_nickname`, `auth_name`, `auth_idno`, `auth_headimgurl`, `auth_sex`, `auth_mobile`, `auth_pwd`, `auth_status`, `auth_lastlogin`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(2,'kaka','kaka','name','','','','','c2d885b7053b69f0d93fd228bd97802a','','17-04-05 08:24:00','2017-04-02 14:42:53','2017-04-05 08:24:00',NULL,NULL,NULL,NULL);


-- 现金券
truncate table `voucher_info`;
INSERT INTO `voucher_info` (`id`, `vaucher_no`, `vaucher_name`, `vaucher_type`, `voucher_val1`, `voucher_val2`, `voucher_val3`, `voucher_val4`, `voucher_model`, `voucher_event`, `voucher_filter`, `voucher_timespan`, `voucher_count`, `voucher_usecount`, `voucher_timeoutcount`, `voucher_locktime`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'VCN2017031915460142476','现金券一号','VC01',2000.00,20.00,0.00,0.00,'','','',7776000,0,0,0,7776000,'2017-03-19 15:46:01','2017-04-05 08:06:45',NULL,NULL,NULL,NULL),
	(2,'VCN2017031915460142473','现金券二号','VC01',5000.00,50.00,0.00,0.00,'','','',7776000,0,0,0,7776000,'2017-03-19 15:46:01','2017-04-05 08:30:15',NULL,NULL,NULL,NULL),
	(3,'VCN2017031915460142475','现金券三号','VC01',1000.00,10.00,0.00,0.00,'','','',7776000,0,0,0,7776000,'2017-03-19 15:46:01','2017-04-05 07:34:20',NULL,NULL,NULL,NULL),
	(4,'VCN2017031915460142477','现金券四号','VC01',10000.00,100.00,0.00,0.00,'','','',7776000,0,0,0,7776000,'2017-03-19 15:46:01','2017-04-05 07:34:20',NULL,NULL,NULL,NULL),
	(5,'VCN2017031915460142478','现金券五号','VC01',20000.00,200.00,0.00,0.00,'','','',7776000,0,0,0,7776000,'2017-03-19 15:46:01','2017-04-05 07:34:20',NULL,NULL,NULL,NULL),
	(6,'VCN2017031915460142479','现金券六号','VC01',50000.00,500.00,0.00,0.00,'','','',7776000,0,0,0,7776000,'2017-03-19 15:46:01','2017-04-05 07:34:20',NULL,NULL,NULL,NULL),
	(7,'VCN2017031915460142480','现金券七号','VC01',100000.00,1000.00,0.00,0.00,'','','',7776000,0,0,0,7776000,'2017-03-19 15:46:01','2017-04-05 07:34:20',NULL,NULL,NULL,NULL);









truncate table `sys_bank`;
INSERT INTO `sys_bank` (`id`, `bank_type`, `bank_name`, `bank_add`, `bank_no`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'B05','太阳宫支行','','',NULL,NULL,NULL,NULL,NULL,NULL);

truncate table `sys_cash_account`;
INSERT INTO `sys_cash_account` (`id`, `account_cash`, `account_pending`, `account_change_time`, `account_settelment_time`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,0.0, 0.000, '2017-03-31 14:48:31', '1970-01-01 00:00:00', NULL, '2017-03-31 14:48:31', NULL, NULL, NULL, NULL);

truncate table `sys_cash`;
INSERT INTO `sys_cash` (`id`, `sys_account_cash`, `sys_account_pending`, `sys_account_change_time`, `sys_account_settelment_time`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1, 0.0, 0.000, '2017-03-31 12:09:01', '1970-01-01 00:00:00', NULL, '2017-03-31 12:09:01', NULL, NULL, NULL, NULL);

truncate table `cash_bank_account`;
INSERT INTO `cash_bank_account` (`id`, `account_no`, `account_name`, `account_bank`, `account_cash`, `account_pending`, `account_change_time`, `account_settelment_time`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'110925871910602','咔咔房链（北京）科技有限公司',1,0,0,'2017-04-05 08:42:33','1970-01-01 00:00:00',NULL,'2017-04-05 08:42:33',NULL,NULL,NULL,NULL);













truncate table `item_info`;
INSERT INTO `item_info` (`id`, `name`, `coin_type`, `kk_name`, `compound`, `layout`, `diqu`, `trade`, `number`, `age`, `space`, `rowards`, `renovation`, `school`, `metro`, `price`, `amount`, `term`, `exchange_time`, `school_district`, `sublet`, `rightDate`, `bonusDate`, `investment`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'双旗杆东里50.5㎡','KKC-BJ0001','咔咔北京数字一号房产','双旗杆东里','2室1厅1厨1卫','西城','德胜门','1/5','1979',50.50,'南','简装','西城区五路通小学','近8号线安华桥站',1477,5050,7,'2024-09-01 00:00:00','西城','IS01','1970-01-01 00:00:00','1970-01-01 00:00:00','<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;小区独立小院，有6栋板楼和3栋塔楼，小区有3栋板楼已经保温加固，其它几栋也将陆续施工，整个小区内的环境改造已经完成，重新铺了地砖，增加了健身的器材，小区内干净整洁，出小区南门有新鲜的蔬菜和水果供应，生活方便。</p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;步行距离人定湖公园500米，园林欧式风格、绿树成荫和清澈的湖水，是您休息的氧吧。\n配套银行中国银行、建设银行、招商银行、光大银行、北京银行等； 商场佰隆商厦、物美超市、美廉美、大润发定时定点班车接送，步行去华润万家800米购物方便。</p><p></p><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;交通南面是黄寺大街，北面是北三环中路，西面八达岭高速出行方便，东面中轴路。公交有123、运通104等，公交站黄寺站、阳光丽景站、安华桥西站、马甸桥东站，出行方便。</p><p><br></p>',NULL,NULL,NULL,NULL,NULL,NULL);

truncate table `item_formula`;
INSERT INTO `item_formula` (`id`, `coin_type`, `item_id`, `iamge`, `file`, `file_name`, `type`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'KKC-BJ0001',0,'/upload/KKC-BJ0001/huxingtu.jpg','','','IFT02',NULL,NULL,NULL,NULL,NULL,NULL),
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




-- 通知事件表的数据
truncate table `sys_notify`;
INSERT INTO `sys_notify` (`id`, `notify_type`, `notify_fmt`, `notify_user_filter`, `noiffy_event`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `notify_model`)
VALUES
	(5,'NT01','（充值成功）您尾号{$this->right($item->cash_recharge_bankid,4)}银行卡于{$item->cash_recharge_chktime}成功充值{$item->cash_recharge_amount}到您账户，请注意查收。','','Recharge_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Recharge'),
	(6,'NT02','（充值失败）未收到您尾号{$this->right($item->cash_recharge_bankid,4)}银行卡转账，充值申请已超期失效，如需要继续充值请重新发起充值申请。','','Recharge_Refuse',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Recharge'),
	(7,'NT03','（提现成功）您发起{$item->cash_withdrawal_amount}元提现申请于{$item->cash_withdrawal_chktime}已转交银行处理，请注意查收。','','Withdrawal_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Withdrawal'),
	(8,'NT04','（提现失败）您发起{$item->cash_withdrawal_amount}元提现申请已被拒绝，具体原因请咨询官方客服。','','Withdrawal_Refuse',NULL,NULL,NULL,NULL,NULL,NULL,'Cash\\Withdrawal'),
	(9,'NT05','您发起的{$item->order_coin_type}资产的委托于{$item->created_at->format(\'Y年m月d日\')}已部分成交。','','Order_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Trade\\TranactionOrder'),
	(10,'NT06','系统向您账户中发放了{$item->voucher_val2}元理财金券，请及时使用。','','Voucher_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Activity\\VoucherInfo');




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
	(110,'UCORDER01','usercashorder','买入',NULL,NULL,NULL,NULL,NULL,NULL),
	(111,'UCORDER02','usercashorder','卖出',NULL,NULL,NULL,NULL,NULL,NULL),
	(112,'UCORDER03','usercashorder','提现',NULL,NULL,NULL,NULL,NULL,NULL),
	(113,'UCORDER04','usercashorder','提现手续费',NULL,NULL,NULL,NULL,NULL,NULL),
	(114,'UCORDER05','usercashorder','充值',NULL,NULL,NULL,NULL,NULL,NULL),
	(115,'UCORDER06','usercashorder','交易手续费',NULL,NULL,NULL,NULL,NULL,NULL),
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
	(126,'IFT06','item_formula_type','合同',NULL,NULL,NULL,NULL,NULL,NULL),
	(127,'IFT07','item_formula_type','公式三',NULL,NULL,NULL,NULL,NULL,NULL),
	(128,'IFT08','item_formula_type','公式四',NULL,NULL,NULL,NULL,NULL,NULL),
	(129,'IFT09','item_formula_type','公式五',NULL,NULL,NULL,NULL,NULL,NULL),
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
	(176,'UOJ010','usercoin_journal','解除冻结',NULL,NULL,NULL,NULL,NULL,NULL);




truncate table `sys_error`;
INSERT INTO `sys_error` (`id`, `error_code`, `error_msg`, `error_level`, `error_requireauth`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,801001,'帐号未注册.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,801002,'用户没有登录.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(3,800001,'Token无效',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,800002,'Token超时.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(5,801003,'登录密码错误.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(6,802001,'没有输入字典类型',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(7,802002,'字典类型定义为空',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(8,802003,'较验规则设置错误',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(9,802004,'校验单据未定义.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(10,802005,'校验单据定义无效.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(11,802006,'未查到符合要求的单据.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(12,801004,'支付密码错误',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(13,801005,'没有输入支付密码.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(14,803001,'验证码发送失败',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(15,803002,'验证码不正确',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(16,803003,'邀请码不正确',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(17,804001,'现金验证设置错误,请输入关联参数',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(18,804002,'输入参数中没有关联参数',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(19,805001,'代币验证错误,请输入关联的代币类型参数',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(20,805002,'输入参数中没有代币类型参数',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(21,801006,'支付密码不能和登陆密码一样，请重新输入',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(22,806001,'余额不足！',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(23,806002,'一级市场不能挂买单',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(24,806003,'一级市场不能提币',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(26,801007,'修改失败',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(27,801008,'新手机号不能和原手机号一样，请重新输入',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(28,801009,'新支付密码不能和原支付密码一样，请重新输入',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(29,806004,'充值金额必须大于0',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(30,801010,'邀请码错误',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(31,801011,'新登陆密码不能和原来的一样',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(32,801012,'已存在该币，不能再次发币',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(33,806005,'交易数量必须大于0.01个',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(34,808001,'对帐单已经存在.',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(35,806006,'此卖单数量不足',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(36,809001,'此项目不存在',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(37,806007,'提现金额必须大于0并且有足够的可用金额',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(38,806008,'最小卖出数量必须大于0.01',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(39,806009,'委托剩余数量不能小于0.01 KKC',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(40,808002,'该银行卡已被绑定，如不是您本人操作，请尽快联系客服',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(41,801013,'该用户已注册',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(42,806010,'今日提现次数已达2次，请明日再试',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(43,801014,'用户在其他地方登录',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL),
	(44,806011,'卖出价格不得大于最近成交价或销售指导价3倍',0,b'0',NULL,NULL,NULL,NULL,NULL,NULL);