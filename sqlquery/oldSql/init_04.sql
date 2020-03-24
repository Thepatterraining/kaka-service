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

-- 创建代币业务相关的表结构


-- 代币充值表
DROP TABLE IF EXISTS `coin_rechage`;

CREATE TABLE `coin_rechage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_recharge_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀OR',
  `coin_recharge_cointype` varchar(10) NOT NULL DEFAULT '' COMMENT '代币类型',
  `coin_recharge_amount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '充值数量',
  `coin_recharge_status` varchar(10) NOT NULL DEFAULT '' COMMENT '字典表 type=coin_rechage OR00 已经提交 OR01 成功 OR02 失败',
  `coin_recharge_userid` bigint NOT NULL DEFAULT 0 COMMENT '充值用户id',
  `coin_recharge_chkuserid` bigint NOT NULL DEFAULT 0 COMMENT '审查管理员id',
  `coin_recharge_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '提交时间',
  `coin_recharge_chktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `coin_recharge_address` varchar(255) NOT NULL DEFAULT '' COMMENT '入帐钱包地址 和user_coin_accoin中usercoin_address一致',
  `coin_recharge_success` bit NOT NULL DEFAULT false COMMENT '是否有效记帐',
  `coin_recharge_type` varchar(10) NOT NULL DEFAULT '' COMMENT '充值类型 字典表 type=coin_rechage_type ORT01 普通用户充值 ORT02 钱包直充  ORT03 一级市场充值',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 代币提现表
DROP TABLE IF EXISTS `coin_withdrawal`;

CREATE TABLE `coin_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_withdrawal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀OW',
  `coin_withdrawal_cointype` varchar(10) NOT NULL DEFAULT '' COMMENT '代币类型',
  `coin_withdrawal_amount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '提现数量',
  `coin_withdrawal_status` varchar(10) NOT NULL DEFAULT '' COMMENT '字典表 type=coin_withdrawaal OW00 已经提交 OW01 成功 OW02 失败',
  `coin_withdrawal_userid` bigint NOT NULL DEFAULT 0 COMMENT '提现用户id',
  `coin_withdrawal_chkuserid` bigint NOT NULL DEFAULT 0 COMMENT '审查管理员id',
  `coin_withdrawal_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '提交时间',
  `coin_withdrawal_chktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `coin_withdrawal_toaddress` varchar(255) NOT NULL DEFAULT '' COMMENT '提现钱包地址',
  `coin_withdrawal_fromaddress` varchar(255) NOT NULL DEFAULT '' COMMENT '提现钱包地址',
  `coin_withdrawal_success` bit NOT NULL DEFAULT false COMMENT '是否有效记帐',
  `coin_withdrawal_type` varchar(10) NOT NULL DEFAULT '' COMMENT '提现类型 字典表 type=coin_withdrawaal_type OWT01 普通用户提现',
  `coin_withdrawal_rate` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '提现费率 百分比',
  `coin_withdrawal_fee` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '提现手续费',
  `coin_withdrawal_out` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '实际提币金额',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 代币转出手续费表
DROP TABLE IF EXISTS `sys_coin_fee`;

CREATE TABLE `sys_coin_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_withdrawal_feeno` varchar(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀WF',
  `coin_withdrawal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '提现单据号',
  `coin_withdrawal_cointype` varchar(10) NOT NULL DEFAULT '' COMMENT '代币类型',
  `coin_withdrawal_feeamount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '提现手续费',
  `coin_withdrawal_feestatus` varchar(10) NOT NULL DEFAULT '' COMMENT '字典表 type=coin_ withdrawal_fee CWF00 已经提交 CWF01 成功 CWF02 失败',
  `coin_withdrawal_feetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '提交时间',
  `coin_withdrawal_feechktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `coin_withdrawal_feesuccess` bit NOT NULL DEFAULT false COMMENT '是否有效记帐',
  `coin_withdrawal_feetype` varchar(10) NOT NULL DEFAULT '' COMMENT '提现类型 字典表 type=coin_withdrawal_feetype CWFT01 普通用户提现',
  `coin_withdrawal_rate` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '提现费率 百分比',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 代币池流水表
DROP TABLE IF EXISTS `coin_journal`;

CREATE TABLE `coin_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_journal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀OCJ',
  `coin_journal_cointtype` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `coin_journal_in` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '收入',
  `coin_journal_out` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '支出',
  `coin_journal_pending` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '在途',
  `coin_journal_status` varchar(10) NOT NULL DEFAULT '' COMMENT '字典表 type=journal_type CJT01 已经提交 CJT02 成功 CJT03 失败 CJT04 撤回 CJT05 冲减',
  `coin_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据号',
  `coin_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '记帐时间',
  `coin_account_id` bigint NOT NULL DEFAULT 0 COMMENT '发生交易的银行帐户',
  `coin_journal_type` varchar(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=coin_journal CJ01 提现 CJ02 充值',
  `coin_result_pending` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户在途',
  `coin_result_cash` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户余额',
  `hash` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 平台代币池表
DROP TABLE IF EXISTS `sys_coin`;

CREATE TABLE `sys_coin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `syscoin_account_type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `syscoin_account_address` varchar(255) NOT NULL DEFAULT '' COMMENT '钱包地址',
  `syscoin_account_cash` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '余额',
  `syscoin_account_pending` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '在途余额',
  `syscoin_account_change_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后更新时间',
  `syscoint_account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后对帐时间',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 用户代币冻结表
DROP TABLE IF EXISTS `user_coin_frozen`;

CREATE TABLE `user_coin_frozen` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `frozen_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单号 前缀 FZ',
  `frozen_cointtype` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `frozen_coinaccoint` bigint NOT NULL DEFAULT 0 COMMENT '冻结代币帐户 user_cointaccoint.id',
  `frozen_userid` varchar(30) NOT NULL DEFAULT '' COMMENT '冻结用户id sys_user.user_id',
  `frozen_type` varchar(10) NOT NULL DEFAULT '' COMMENT '冻结类型 字典表type=coin_frozen FT01 用券交易',
  `frozen_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单号',
  `frozen_deadline` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '解冻日期',
  `frozen_status` varchar(10) NOT NULL DEFAULT '' COMMENT '冻结状态 字典表type=frozen_status FS01=冻结 FS02=解冻',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 用户代币交易记录表
DROP TABLE IF EXISTS `user_order`;

CREATE TABLE `user_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `userorder_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单号 流水号UO',
  `userorder_type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 字典表userorder UORDER01 买入 UORDER02 卖出',
  `userorder_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联的买单或卖单',
  `userorder_orderno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联的交易单',
  `userorder_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '代币种类',
  `userorder_price` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '单价',
  `userorder_coin` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '代币数量',
  `userorder_discounttype` varchar(30) NOT NULL DEFAULT '' COMMENT '优惠类型',
  `userorder_discountno` varchar(30) NOT NULL DEFAULT '' COMMENT '优惠券号',
  `userorder_fee` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '手续费',
  `userorder_ammount` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '最终成交金额',
  `userorder_userid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户id',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
