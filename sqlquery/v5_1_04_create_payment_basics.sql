


-- 创建 sys_company 表 

DROP TABLE IF EXISTS `sys_company`;

CREATE TABLE `sys_company` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_no` varchar(30) NOT NULL DEFAULT '' COMMENT '五证合一号码',
  `company_name` varchar(255) NOT NULL DEFAULT '' COMMENT '公司名称',
  `company_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `company_type` char(20) NOT NULL DEFAULT '' COMMENT '字典表 company_type COM01 代持公司 COM02 基金公司  COM03 支付公司',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- 创建 sys_3rd_pay 表 

DROP TABLE IF EXISTS `sys_3rd_pay`;

CREATE TABLE `sys_3rd_pay` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
  `pay_accessid` varchar(255) NOT NULL DEFAULT '' COMMENT 'Id',
  `pay_accesskey` varchar(255) NOT NULL DEFAULT '' COMMENT '加密用KEY',
  `pay_cusno` varchar(255) NOT NULL DEFAULT '' COMMENT '商户号',
  `pay_remark1` varchar(255) NOT NULL DEFAULT '' COMMENT '备用一',
  `pay_remark2` varchar(255) NOT NULL DEFAULT '' COMMENT '备用二',
  `pay_remark3` varchar(255) NOT NULL DEFAULT '' COMMENT '备用三',
  `pay_assuserid` bigint NOT NULL DEFAULT 0 COMMENT '负责人 sys_admin.id',
  `pay_chkuserid` bigint NOT NULL DEFAULT 0 COMMENT '审核人 sys_admin.id',
  `pay_settelmentuserid` bigint NOT NULL DEFAULT 0 COMMENT '对帐人 sys_admin.id',
  `pay_withdrawalintype` char(20) NOT NULL DEFAULT '' COMMENT '到帐方式 字典表 3rd_incometype 3RDIN01 单独 3RDIN02 整体',
  `pay_withdrawalbankno` char(20) NOT NULL DEFAULT '' COMMENT '提现银行帐号',
  `pay_feebankno` char(20) NOT NULL DEFAULT '' COMMENT '手续费银行帐号',
  `pay_ammount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '可用',
  `pay_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途',
  `pay_provisions` char(20) NOT NULL DEFAULT '' COMMENT '备付金帐户',
  `pay_trusteeship` char(20) NOT NULL DEFAULT '' COMMENT '托管帐户',
  `company_type` char(20) NOT NULL DEFAULT '' COMMENT '字典表 company_type COM01 代持公司 COM02 基金公司  COM03 支付公司',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 创建 sys_3rd_pay_journal 表 

DROP TABLE IF EXISTS `sys_3rd_pay_journal`;

CREATE TABLE `sys_3rd_pay_journal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pay3rd_journal_no` varchar(255) NOT NULL DEFAULT '' COMMENT '流水号 前缀 PAY',
  `pay3rd_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '记帐时间',
  `pay3rd_journal_payid` bigint NOT NULL DEFAULT 0 COMMENT '支付平台',
  `pay3rd_journal_channelid` bigint NOT NULL DEFAULT 0 COMMENT '支付通道',
  `pay3rd_journal_in` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '收入',
  `pay3rd_journal_out` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '支出',
  `pay3rd_journal_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途',
  `pay3rd_journal_type` char(20) NOT NULL DEFAULT '' COMMENT '记帐类型',
  `pay3rd_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联的业务单据号',
  `pay3rd_journal_status` char(20) NOT NULL DEFAULT '' COMMENT '	单据类型',
  `pay3rd_journal_resultpending` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '帐后在途',
  `pay3rd_jounral_resultcash` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '帐后可用',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 创建 sys_3rd_pay_channel 表 

DROP TABLE IF EXISTS `sys_3rd_pay_channel`;

CREATE TABLE `sys_3rd_pay_channel` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `channel_name` varchar(255) NOT NULL DEFAULT '' COMMENT '通道名称',
  `channel_payplatform` bigint NOT NULL DEFAULT 0 COMMENT '所属支付平台',
  `channel_infeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '入帐费率',
  `channel_infeetype` char(20) NOT NULL DEFAULT '' COMMENT '入帐费率类型',
  `channel_outfeerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '提现费率',
  `channel_outfeetype` char(20) NOT NULL DEFAULT '' COMMENT '提现费率类型',
  `channel_withdrawtype` char(20) NOT NULL DEFAULT '' COMMENT '提现类型 字典表 3rd_withdrawal 3RD01 人工 3RD02 自动日结 3RD03 自动周结 4RD04 自动月结',
  `channel_withdrawset` varchar(255) NOT NULL DEFAULT '' COMMENT '提现周期设定',
  `channel_withdralbankno` char(20) NOT NULL DEFAULT '' COMMENT '提现帐号',
  `channel_dealclass` varchar(255) NOT NULL DEFAULT '' COMMENT '处理类',
  `channel_ammout` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '可用',
  `chnnnel_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 创建 sys_3rd_pay_channelmethod 表 

DROP TABLE IF EXISTS `sys_3rd_pay_channelmethod`;

CREATE TABLE `sys_3rd_pay_channelmethod` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` bigint NOT NULL DEFAULT 0 COMMENT '通道名称',
  `method_id` bigint NOT NULL DEFAULT 0 COMMENT '方式名称',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 创建 sys_3rd_pay_methods 表 

DROP TABLE IF EXISTS `sys_3rd_pay_methods`;

CREATE TABLE `sys_3rd_pay_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `method_name` varchar(255) NOT NULL DEFAULT '' COMMENT '支付名称',
  `method_inputrequireclass` varchar(255) NOT NULL DEFAULT '' COMMENT '输入接口获取类',
  `method_inputclass` varchar(255) NOT NULL DEFAULT '' COMMENT '输入接口处理类',
  `method_invokeclass` varchar(255) NOT NULL DEFAULT '' COMMENT '支付回调类',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 创建 sys_3rd_pay_incomedocs 表 

DROP TABLE IF EXISTS `sys_3rd_pay_incomedocs`;

CREATE TABLE `sys_3rd_pay_incomedocs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `income_no` char(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀 IN',
  `income_3rdpay` bigint NOT NULL DEFAULT 0 COMMENT '入帐平台',
  `income_3rdchannel` bigint NOT NULL DEFAULT 0 COMMENT '入帐通道',
  `income_account` char(30) NOT NULL DEFAULT '' COMMENT '入帐帐号',
  `income_provisions` char(30) NOT NULL DEFAULT '' COMMENT '备付金帐号',
  `income_cash` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '入帐金额',
  `income_feerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '入帐手续费率',
  `income_fee` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '手续费',
  `income_type` char(20) NOT NULL DEFAULT '' COMMENT '入帐类型',
  `income_checkuser` bigint NOT NULL DEFAULT 0 COMMENT '审核人',
  `income_checktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `income_status` char(20) NOT NULL DEFAULT '' COMMENT '状态',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- 修改 cash_bank_account 表 

alter table `cash_bank_account` add `account_remark` varchar(255) NOT NULL default '' COMMENT "备注",
add `account_type` char(20) NOT NULL default '' COMMENT "字典表 account_type AC01 普通 AC02 资金池 AC03 第三方支付 AC04 备付金 AC05 平台";


ALTER TABLE `cash_bank_account` MODIFY `account_no` VARCHAR(30) NOT NULL DEFAULT '' COMMENT "账号";
