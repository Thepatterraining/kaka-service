

-- 修改 cash_journal 表 银行卡字段类型
alter table `cash_journal` modify column `cash_account_id` varchar(20) NOT NULL DEFAULT '' COMMENT '发生交易的银行帐户 sys_bank_account';

-- 修改 cash_recharge 表 银行卡字段类型
alter table `cash_recharge` modify column `cash_recharge_desbankid` varchar(20) NOT NULL DEFAULT '' COMMENT '入帐银行帐户id',
modify column `cash_recharge_bankid` varchar(20) NOT NULL DEFAULT '' COMMENT '充值银行帐户id';

-- 修改 cash_withdrawal 表 银行卡字段类型
alter table `cash_withdrawal` modify column `cash_withdrawal_srcbankid` varchar(20) NOT NULL DEFAULT '' COMMENT '出帐银行帐户id',
modify column `cash_withdrawal_bankid` varchar(20) NOT NULL DEFAULT '' COMMENT '入帐银行帐户id user_bank_acount';

-- 修改 user_bank_account 表 银行卡字段类型
alter table `user_bank_account` modify column `account_no` varchar(20) NOT NULL DEFAULT '' COMMENT '帐号';

-- 修改 cash_bank_account 表 银行卡字段类型
alter table `cash_bank_account` modify column `account_no` varchar(20) NOT NULL DEFAULT '' COMMENT '帐号';