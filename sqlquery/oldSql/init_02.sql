# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.17)
# Database: kkservice
# Generation Time: 2017-02-24 06:18:47 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table user
# ------------------------------------------------------------

-- 创建充值提现业务相关流程的表结构


-- 用户银行帐户表
DROP TABLE IF EXISTS `user_bank_account`;

CREATE TABLE `user_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_no` char(19) NOT NULL DEFAULT '' COMMENT '帐号',
  `account_name` varchar(255) NOT NULL DEFAULT '' COMMENT '户名',
  `account_bank` int(11) NOT NULL DEFAULT '0' COMMENT '开户行ID',
  `account_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `account_deal_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后交易时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;


-- 用户余额表
DROP TABLE IF EXISTS `user_cash_account`;

CREATE TABLE `user_cash_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id ',
  `account_cash` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '余额',
  `account_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途金额',
  `account_change_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后更新时间',
  `account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后对帐时间',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 资金池充值表
DROP TABLE IF EXISTS `cash_recharge`;

CREATE TABLE `cash_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cash_recharge_no` varchar(30) NOT NULL DEFAULT '' COMMENT '充值单据号 前缀 CR',
  `cash_recharge_phone` varchar(255) NOT NULL DEFAULT 0 COMMENT '充值手机号',
  `cash_recharge_amount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '充值金额',
  `cash_recharge_sysamount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '系统充值金额',
  `cash_recharge_useramount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '用户充值金额',
  `cash_recharge_status` varchar(10) NOT NULL DEFAULT '' COMMENT '充值状态 字典表 type=cash_rechage CR00 已经提交 CR01 成功 CR02 失败',
  `cash_recharge_userid` bigint NOT NULL DEFAULT 0 COMMENT ' 充值用户id',
  `cash_recharge_body` varchar(10) NOT NULL DEFAULT '' COMMENT '描述',
  `cash_recharge_chkuserid` bigint NOT NULL DEFAULT 0 COMMENT '审查管理员id',
  `cash_recharge_bankid` bigint NOT NULL DEFAULT 0 COMMENT '充值银行帐户id',
  `cash_recharge_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '提交时间',
  `cash_recharge_desbankid` bigint NOT NULL DEFAULT 0 COMMENT ' 入帐银行帐户id',
  `cash_recharge_chktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `cash_recharge_success` bit NOT NULL DEFAULT false COMMENT ' 是否有效记帐',
  `cash_recharge_type` varchar(10) NOT NULL DEFAULT '' COMMENT '充值类型 字典表 type=cash_rechage_tyep CRT01 普通用户充值',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 资金池提现表
DROP TABLE IF EXISTS `cash_withdrawal`;

CREATE TABLE `cash_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cash_withdrawal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '提现单据号 前缀 CW',
  `cash_withdrawal_amount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '提现金额',
  `cash_withdrawal_status` varchar(10) NOT NULL DEFAULT '' COMMENT '提现状态 字典表 type=cash_ withdrawaal CW00 已经提交 CW01 成功 CW02 失败',
  `cash_withdrawal_userid` bigint NOT NULL DEFAULT 0 COMMENT '提现用户id',
  `cash_withdrawal_chkuserid` bigint NOT NULL DEFAULT 0 COMMENT '审查管理员id',
  `cash_withdrawal_body` varchar(10) NOT NULL DEFAULT '' COMMENT '描述',
  `cash_withdrawal_bankid` bigint NOT NULL DEFAULT 0 COMMENT '入帐银行帐户id user_bank_acount',
  `cash_withdrawal_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '提交时间',
  `cash_withdrawal_srcbankid` bigint NOT NULL DEFAULT 0 COMMENT '出帐银行帐户id',
  `cash_withdrawal_chktime` datetime NOT NULl DEFAULT '1970-01-01' COMMENT '审核时间',
  `cash_withdrawal_success` bit NOT NULL DEFAULT false COMMENT '是否有效记帐',
  `cash_withdrawal_type` varchar(10) NOT NULL DEFAULT '' COMMENT '提现类型 字典表 type=cash_ withdrawal _type CWT01 普通用户充值',
  `cash_withdrawal_rate` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '提现费率',
  `cash_withdrawal_fee` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '提现手续费',
  `cash_withdrawal_out` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '实际提现金额',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 平台提现手续费表
DROP TABLE IF EXISTS `sys_cash_fee`;

CREATE TABLE `sys_cash_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cash_withdrawal_feeno` varchar(30) NOT NULL DEFAULT '' COMMENT '手续费单据号 前缀 WF',
  `cash_withdrawal_feeamount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '手续提现金额',
  `cash_withdrawal_feestatus` varchar(10) NOT NULL DEFAULT '' COMMENT '提现状态 字典表 type=cash_ withdrawal_fee CWF00 已经提交 CWF01 成功 CWF02 失败',
  `cash_withdrawal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '提现单号',
  `cash_withdrawal_feetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '提交时间',
  `cash_withdrawal_feechktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `cash_withdrawal_feesuccess` bit NOT NULL DEFAULT false COMMENT '是否有效记帐',
  `cash_withdrawal_feetype` varchar(10) NOT NULL DEFAULT '' COMMENT '手续费类型 字典表 type=cash_ withdrawal _feetype CWFT01 普通用户提现',
  `cash_withdrawal_rate` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '提现费率',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 平台现金银行账户表
DROP TABLE IF EXISTS `cash_bank_account`;

CREATE TABLE `cash_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_no` char(18) NOT NULL DEFAULT '' COMMENT '帐号',
  `account_name` varchar(255) NOT NULL DEFAULT 0 COMMENT '户名',
  `account_bank` int(11) NOT NULL DEFAULT 0 COMMENT '开户行ID',
  `account_cash` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '金额',
  `account_pending` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '在途金额',
  `account_change_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后更新时间',
  `account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后对帐时间',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 平台资金池表
DROP TABLE IF EXISTS `sys_cash`;

CREATE TABLE `sys_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sys_account_cash` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '金额',
  `sys_account_pending` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '在途金额',
  `sys_account_change_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后更新时间',
  `sys_account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后对帐时间',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 资金池流水表
DROP TABLE IF EXISTS `cash_journal`;

CREATE TABLE `cash_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cash_journal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '流水单据号 前缀 CCJ ',
  `cash_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '记帐时间',
  `cash_result_pending` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户在途',
  `cash_result_cash` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户余额',
  `cash_journal_amount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '余额',
  `cash_journal_in` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '收入',
  `cash_journal_out` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '支出',
  `cash_journal_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途',
  `cash_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=cash_journal CJ01 提现 CJ02 充值',
  `cash_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联业务单据号',
  `cash_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=journal_type CJT01 初提 CJT02 审核 CJT03 失败 CJT04 撤回 CJT05 冲减',
  `cash_account_id` bigint NOT NULL DEFAULT 0 COMMENT '发生交易的银行帐户 sys_bank_account',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 用户流水表
DROP TABLE IF EXISTS `user_cash_journal`;

CREATE TABLE `user_cash_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usercash_journal_userid` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `usercash_result_pending` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户在途',
  `usercash_result_cash` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户余额',
  `usercash_journal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '流水单据号 前缀 CCJ ',
  `usercash_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '记帐时间',
  `usercash_journal_amout` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '余额',
  `usercash_journal_in` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '收入',
  `usercash_journal_out` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '支出',
  `usercash_journal_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途',
  `usercash_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=usercash_journal CJ01 提现 CJ02 充值 CJ03 买单 CJ04 卖单 CJ05 提现手续费 CJ06 成交手续费 CJ07 返佣 CJ08 用券 CJ09 买入 CJ10 一级市场放量',
  `usercash_journal_jobno` varchar(30) NOT NULL DEFAULT 0 COMMENT '关联业务单据号',
  `usercash_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=cjournal_type CJT01 初提 CJT02 审核 CJT03 失败 CJT04 撤回 CJT05 冲减',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 平台流水表
DROP TABLE IF EXISTS `sys_cash_journal`;

CREATE TABLE `sys_cash_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `syscash_journal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '流水单据号 前缀 SCJ ',
  `syscash_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '记帐时间',
  `syscash_journal_amount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '余额',
  `syscash_journal_in` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '收入',
  `syscash_journal_out` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '支出',
  `syscash_journal_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途',
  `syscash_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=syscash_journal SCJ01 手续费 SCJ02 返券',
  `syscash_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联业务单据号',
  `syscash_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=cjournal_type CJT01 初提 CJT02 审核 CJT03 失败 CJT04 撤回 CJT05 冲减',
  `syscash_result_pending` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户在途',
  `syscash_result_cash` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户余额',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
