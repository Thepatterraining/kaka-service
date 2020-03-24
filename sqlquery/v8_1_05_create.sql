

DROP TABLE IF EXISTS `syscash_journaldoc`;

CREATE TABLE `syscash_journaldoc` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`syscash_journaldoc_no` varchar(60) NOT NULL DEFAULT '' COMMENT '单据号',
	`syscash_journaldoc_notes` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `syscash_journaldoc_frombankcard` varchar(255) NOT NULL DEFAULT '' COMMENT '出账银行卡',
  `syscash_journaldoc_tobankcard` varchar(255) NOT NULL DEFAULT '' COMMENT '入账银行卡',
  `syscash_journaldoc_frombankcardtype` varchar(255) NOT NULL DEFAULT '' COMMENT '出账银行卡类型',
  `syscash_journaldoc_tobankcardtype` varchar(255) NOT NULL DEFAULT '' COMMENT '入账银行卡类型',
  `syscash_journaldoc_amount` decimal(30,3) NOT NULL DEFAULT 0 COMMENT '金额',
  `syscash_journaldoc_checkuser` bigint NOT NULL DEFAULT 0 COMMENT '审核用户',
  `syscash_journaldoc_checktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `syscash_journaldoc_success` bit NOT NULL DEFAULT b'0' COMMENT '是否成功',
  `syscash_journaldoc_type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 平台内部，外部',
  `syscash_journaldoc_status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态，申请，审核，失败',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cash_journaldoc`;
CREATE TABLE `cash_journaldoc` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`cash_journaldoc_no` varchar(60) NOT NULL DEFAULT '' COMMENT '单据号',
	`cash_journaldoc_notes` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `cash_journaldoc_bankcard` varchar(255) NOT NULL DEFAULT '' COMMENT '银行卡',
  `cash_journaldoc_bankcardtype` varchar(255) NOT NULL DEFAULT '' COMMENT '出账银行卡类型',
  `cash_journaldoc_amount` decimal(30,3) NOT NULL DEFAULT 0 COMMENT '金额',
  `cash_journaldoc_checkuser` bigint NOT NULL DEFAULT 0 COMMENT '审核用户',
  `cash_journaldoc_checktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `cash_journaldoc_success` bit NOT NULL DEFAULT b'0' COMMENT '是否成功',
  `cash_journaldoc_type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 入账 出账',
  `cash_journaldoc_status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态，申请，审核，失败',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user_cashfreezondoc`;
CREATE TABLE `user_cashfreezondoc` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `usercash_freezondoc_no` varchar(60) NOT NULL DEFAULT '' COMMENT '单据号',
	`usercash_freezondoc_notes` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `usercash_freezondoc_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `usercash_freezondoc_accountid` bigint NOT NULL DEFAULT 0 COMMENT '账户id',
  `usercash_freezondoc_amount` decimal(30,3) NOT NULL DEFAULT 0 COMMENT '金额',
  `usercash_freezondoc_checkuser` bigint NOT NULL DEFAULT 0 COMMENT '审核用户',
  `usercash_freezondoc_checktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `usercash_freezondoc_success` bit NOT NULL DEFAULT b'0' COMMENT '是否成功',
  `usercash_freezondoc_type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 CNY',
  `usercash_freezondoc_status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态，冻结，解冻',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
