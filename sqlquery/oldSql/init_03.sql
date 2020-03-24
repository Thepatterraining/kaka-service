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

-- 创建交易代币业务相关流程的表结构


-- 买单表
DROP TABLE IF EXISTS `transaction_buy`;

CREATE TABLE `transaction_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `buy_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀TS',
  `buy_count` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '挂单数量',
  `buy_limit` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '挂单价格',
  `buy_feerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '手续费率',
  `buy_ammount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '挂单总价',
  `buy_userid` bigint NOT NULL DEFAULT 0 COMMENT '挂单用户id',
  `buy_usercointaccount` bigint NOT NULL DEFAULT 0 COMMENT '挂单用户帐户',
  `buy_transcount` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '成交数量',
  `buy_transammount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '成交价格',
  `buy_status` char(10) NOT NULL DEFAULT '' COMMENT '买单状态 字典表type = trans_buy; TB00  挂单 TB01 部分成交 TB02 全部成交 TB03 部分撒单 TB04 全部撒单 ',
  `buy_lasttranstime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后成交时间',
  `buy_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '币种',
  `buy_region` varchar(30) NOT NULL DEFAULT '' COMMENT '地区',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 卖单表
DROP TABLE IF EXISTS `transaction_sell`;

CREATE TABLE `transaction_sell` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sell_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀TB',
  `sell_count` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '挂单数量',
  `sell_limit` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '挂单价格',
  `sell_feerate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '手续费率',
  `sell_ammount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '挂单总价',
  `sell_userid` bigint NOT NULL DEFAULT 0 COMMENT '挂单用户id',
  `sell_usercointaccount` bigint NOT NULL DEFAULT 0 COMMENT '挂单用户帐户',
  `sell_transcount` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '成交数量',
  `sell_transammount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '成交价格',
  `sell_status` char(10) NOT NULL DEFAULT '' COMMENT '卖单状态 字典表type = trans_sell; TS00  挂单 TS01 部分成交 TS02 全部成交 TS03 部分撒单 TS04 全部撒单 ',
  `sell_lasttranstime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后成交时间',
  `sell_leveltype` char(10) NOT NULL DEFAULT '' COMMENT '卖单类型 字典表type = sell_level SL00 普通 SL01 一级市场',
  `sell_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '币种',
  `sell_region` varchar(30) NOT NULL DEFAULT '' COMMENT '地区',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 成交表
DROP TABLE IF EXISTS `transaction_order`;

CREATE TABLE `transaction_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀TO',
  `order_count` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '成交数量',
  `order_price` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '成交价格',
  `order_cash_rate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '人民币手续费率',
  `order_coin_rate` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '代币手续费率',
  `order_cash_fee` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '人民币手续费',
  `order_coin_fee` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '代币手续费',
  `order_buy_no` varchar(255) NOT NULL DEFAULT '' COMMENT '买单号',
  `order_sell_no` varchar(255) NOT NULL DEFAULT '' COMMENT '卖单号',
  `order_sell_userid` bigint NOT NULL DEFAULT 0 COMMENT '卖方用户',
  `order_buy_userid` bigint NOT NULL DEFAULT 0 COMMENT '买方用户',
  `order_sell_coinaccount` bigint NOT NULL DEFAULT 0 COMMENT '卖方代币帐户',
  `order_sell_cashacount` bigint NOT NULL DEFAULT 0 COMMENT '卖方现金帐户',
  `order_buy_coinaccount` bigint NOT NULL DEFAULT 0 COMMENT '买方代币帐户',
  `order_buy_cashaccount` bigint NOT NULL DEFAULT 0 COMMENT '买方现金帐户',
  `order_cash` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '入帐现金',
  `order_coin` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '入帐代币',
  `order_amount` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '成交金额',
  `order_coin_type` varchar(255) NOT NULL DEFAULT 0 COMMENT '成交币种',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 用户代币余额表
DROP TABLE IF EXISTS `user_coin_account`;

CREATE TABLE `user_coin_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usercoin_account_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `usercoin_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '代币编号',
  `usercoin_address` varchar(255) NOT NULL DEFAULT '' COMMENT '充值钱包地址',
  `usercoin_cash` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '余额',
  `usercoin_pending` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '在途金额',
  `usercoin_price` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '平均持币成本',
  `usercoin_value` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '持币总成本',
  `usercoin_netprice` decimal(20,4) NOT NULL DEFAULT 0 COMMENT '平均持币净成本 扣费的成本',
  `usercoin_netvalue` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '持币净成本 扣费后成本',
  `usercoin_change_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后更新时间',
  `usercoin_settelment_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '最后对帐时间',
  `usercoin_locktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '锁定时间',
  `usercoint_primarycash` decimal(20,8) NOT NULL DEFAULT 0 COMMENT '一级市场首发余额',
  `usercoint_isprimary` bit NOT NULL DEFAULT false COMMENT '是否为一级市场',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 用户代币流水表
DROP TABLE IF EXISTS `user_coin_journal`;

CREATE TABLE `user_coin_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usercoin_journal_no` varchar(30) NOT NULL DEFAULT 0 COMMENT '流水单据号 前缀 UOJ',
  `usercoin_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '记帐时间',
  `usercoin_journal_in` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '收入',
  `usercoin_journal_out` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '支出',
  `usercoin_journal_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途',
  `usercoin_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=usercoin_journal UOJ01 充值 UOJ02 提现 UOJ03 现币手续费 UOJ04 确认 UOJ05 冲减 UOJ06 交易手续费',
  `usercoin_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联业务单据号',
  `usercoin_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=cjournal_type CJT01 初提 CJT02 审核 CJT03 失败 CJT04 撤回 CJT05 冲减',
  `usercoin_journal_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `usercoin_journal_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '币类型',
  `usercoin_journal_account` bigint NOT NULL DEFAULT 0 COMMENT '帐户id',
  `usercoin_result_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户在途',
  `usercoin_result_cash` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '流水发生后帐户余额 ',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 平台代币流水表
DROP TABLE IF EXISTS `sys_coin_journal`;

CREATE TABLE `sys_coin_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `syscoin_journal_no` varchar(30) NOT NULL DEFAULT '0' COMMENT '流水单据号 前缀 SOJ',
  `syscoin_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '记帐时间',
  `syscoin_journal_in` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '收入',
  `syscoin_journal_out` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '支出',
  `syscoin_journal_pending` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '在途',
  `syscoin_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=syscoin_journal COJ01 提币手续费 COJ02交易手续费',
  `syscoin_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联业务单据号',
  `syscoin_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=cjournal_type OJT01 初提 OJT02 审核 OJT03 失败 OJT04 撤回 OJT05 冲减 OJT06 交易手续费',
  `syscoin_result_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户在途',
  `syscoin_result_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户余额 ',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  `syscoin_coin_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
