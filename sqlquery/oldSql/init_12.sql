# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 112.126.71.91 (MySQL 5.5.53-0ubuntu0.14.04.1)
# Database: kkservice
# Generation Time: 2017-04-05 10:16:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table activity_info
# ------------------------------------------------------------
DROP TABLE IF EXISTS `activity_info`;
CREATE TABLE `activity_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `activity_no` varchar(20) NOT NULL DEFAULT '' COMMENT '活动编号 前缀SA',
  `activity_name` varchar(255) NOT NULL DEFAULT '' COMMENT '活动名称',
  `activity_start` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '开始时间',
  `activity_end` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '限制时间',
  `activity_limittype` char(10) NOT NULL DEFAULT '' COMMENT '活动限制类型 字典表 type=activity_limit AL01 限时 AL02 限量',
  `activity_event` varchar(255) NOT NULL DEFAULT '' COMMENT '绑定事件',
  `activity_limitcount` int(11) NOT NULL DEFAULT '0' COMMENT '数量',
  `activity_count` int(11) NOT NULL DEFAULT '0' COMMENT '实际发生数量',
  `activity_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '触发条件',
  `activity_code` char(10) NOT NULL DEFAULT '' COMMENT '活动邀请码',
  `activity_status` varchar(10) NOT NULL DEFAULT '' COMMENT '活动状态 字典表 type=activity_status AS00 未开始 AS01 进行中 AS02 已结束 AS03 已终止',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table activity_invitation
# ------------------------------------------------------------
DROP TABLE IF EXISTS `activity_invitation`;
CREATE TABLE `activity_invitation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `inviitation_no` varchar(30) NOT NULL DEFAULT '' COMMENT '邀请单号 前缀 INV',
  `inviitation_code` varchar(30) NOT NULL DEFAULT '' COMMENT '邀请码 目前同邀请人手机号',
  `inviitation_user` varchar(30) NOT NULL DEFAULT '' COMMENT '邀请用户(sys_user.user_id)',
  `inviitation_reguser` varchar(30) NOT NULL DEFAULT '' COMMENT '受邀用户 注册后的 sys_user.user_id',
  `inviitation_type` char(10) NOT NULL DEFAULT '' COMMENT '邀请类型 字典表invitation INV01= 注册',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table activity_item
# ------------------------------------------------------------
DROP TABLE IF EXISTS `activity_item`;
CREATE TABLE `activity_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `activity_no` varchar(30) NOT NULL DEFAULT '' COMMENT '活动编号 关联 activity.activity_no',
  `activity_itemtype` varchar(10) NOT NULL DEFAULT '' COMMENT '活动类型 字典表activity AT01 返券',
  `activity_itemno` varchar(255) NOT NULL DEFAULT '' COMMENT '券编码 voucher_info .voucher_no',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table auth_login_log
# ------------------------------------------------------------
DROP TABLE IF EXISTS `auth_login_log`;
CREATE TABLE `auth_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `auth_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `login_type` char(10) NOT NULL DEFAULT '' COMMENT '登陆类型-字典表',
  `login_time` datetime DEFAULT NULL COMMENT '登陆时间',
  `login_add` varchar(255) NOT NULL DEFAULT '' COMMENT '物理地点',
  `login_mac` varchar(255) NOT NULL DEFAULT '' COMMENT '地址／设备码',
  `login_ip` varchar(255) NOT NULL DEFAULT '' COMMENT '登陆ip',
  `login_token` varchar(255) NOT NULL DEFAULT '' COMMENT '登录时的accestken',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table auth_user
# ------------------------------------------------------------
DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE `auth_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `auth_id` varchar(255) NOT NULL DEFAULT '' COMMENT '登录名',
  `auth_nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `auth_name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `auth_idno` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证号',
  `auth_headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `auth_sex` varchar(255) NOT NULL DEFAULT '' COMMENT '性别',
  `auth_mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `auth_pwd` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `auth_status` varchar(255) NOT NULL DEFAULT '' COMMENT '用户状态',
  `auth_lastlogin` varchar(255) NOT NULL DEFAULT '' COMMENT '上次登陆时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table cash_bank_account
# ------------------------------------------------------------
DROP TABLE IF EXISTS `cash_bank_account`;
CREATE TABLE `cash_bank_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_no` char(19) NOT NULL DEFAULT '' COMMENT '帐号',
  `account_name` varchar(255) NOT NULL DEFAULT '0' COMMENT '户名',
  `account_bank` int(11) NOT NULL DEFAULT '0' COMMENT '开户行ID',
  `account_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '金额',
  `account_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '在途金额',
  `account_change_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后更新时间',
  `account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后对帐时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table cash_journal
# ------------------------------------------------------------
DROP TABLE IF EXISTS `cash_journal`;
CREATE TABLE `cash_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cash_journal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '流水单据号 前缀 CCJ ',
  `cash_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '记帐时间',
  `cash_result_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户在途',
  `cash_result_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户余额',
  `cash_journal_amount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '余额',
  `cash_journal_in` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '收入',
  `cash_journal_out` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '支出',
  `cash_journal_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '在途',
  `cash_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=cash_journal CJ01 提现 CJ02 充值',
  `cash_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联业务单据号',
  `cash_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=journal_type CJT01 初提 CJT02 审核 CJT03 失败 CJT04 撤回 CJT05 冲减',
  `cash_account_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '发生交易的银行帐户 sys_bank_account',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table cash_recharge
# ------------------------------------------------------------
DROP TABLE IF EXISTS `cash_recharge`;
CREATE TABLE `cash_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cash_recharge_no` varchar(30) NOT NULL DEFAULT '' COMMENT '充值单据号 前缀 CR',
  `cash_recharge_phone` varchar(255) NOT NULL DEFAULT '0' COMMENT '充值手机号',
  `cash_recharge_amount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '充值金额',
  `cash_recharge_sysamount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '系统充值金额',
  `cash_recharge_useramount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '用户充值金额',
  `cash_recharge_status` varchar(10) NOT NULL DEFAULT '' COMMENT '充值状态 字典表 type=cash_rechage CR00 已经提交 CR01 成功 CR02 失败',
  `cash_recharge_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT ' 充值用户id',
  `cash_recharge_body` varchar(10) NOT NULL DEFAULT '' COMMENT '描述',
  `cash_recharge_chkuserid` bigint(20) NOT NULL DEFAULT '0' COMMENT '审查管理员id',
  `cash_recharge_bankid` varchar(20) NOT NULL DEFAULT '0' COMMENT '充值银行帐户id',
  `cash_recharge_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '提交时间',
  `cash_recharge_desbankid` bigint(20) NOT NULL DEFAULT '0' COMMENT ' 入帐银行帐户id',
  `cash_recharge_chktime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '审核时间',
  `cash_recharge_success` bit(1) NOT NULL DEFAULT b'0' COMMENT ' 是否有效记帐',
  `cash_recharge_type` varchar(10) NOT NULL DEFAULT '' COMMENT '充值类型 字典表 type=cash_rechage_tyep CRT01 普通用户充值',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table cash_withdrawal
# ------------------------------------------------------------
DROP TABLE IF EXISTS `cash_withdrawal`;
CREATE TABLE `cash_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cash_withdrawal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '提现单据号 前缀 CW',
  `cash_withdrawal_amount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '提现金额',
  `cash_withdrawal_status` varchar(10) NOT NULL DEFAULT '' COMMENT '提现状态 字典表 type=cash_ withdrawaal CW00 已经提交 CW01 成功 CW02 失败',
  `cash_withdrawal_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '提现用户id',
  `cash_withdrawal_chkuserid` bigint(20) NOT NULL DEFAULT '0' COMMENT '审查管理员id',
  `cash_withdrawal_body` varchar(10) NOT NULL DEFAULT '' COMMENT '描述',
  `cash_withdrawal_bankid` bigint(20) NOT NULL DEFAULT '0' COMMENT '入帐银行帐户id user_bank_acount',
  `cash_withdrawal_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '提交时间',
  `cash_withdrawal_srcbankid` bigint(20) NOT NULL DEFAULT '0' COMMENT '出帐银行帐户id',
  `cash_withdrawal_chktime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '审核时间',
  `cash_withdrawal_success` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否有效记帐',
  `cash_withdrawal_type` varchar(10) NOT NULL DEFAULT '' COMMENT '提现类型 字典表 type=cash_ withdrawal _type CWT01 普通用户充值',
  `cash_withdrawal_rate` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '提现费率',
  `cash_withdrawal_fee` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '提现手续费',
  `cash_withdrawal_out` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '实际提现金额',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table coin_journal
# ------------------------------------------------------------
DROP TABLE IF EXISTS `coin_journal`;
CREATE TABLE `coin_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_journal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀OCJ',
  `coin_journal_cointtype` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `coin_journal_in` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '收入',
  `coin_journal_out` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '支出',
  `coin_journal_pending` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '在途',
  `coin_journal_status` varchar(10) NOT NULL DEFAULT '' COMMENT '字典表 type=journal_type CJT01 已经提交 CJT02 成功 CJT03 失败 CJT04 撤回 CJT05 冲减 CJT06 交易',
  `coin_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单据号',
  `coin_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '记帐时间',
  `coin_account_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '发生交易的银行帐户',
  `coin_journal_type` varchar(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=coin_journal CJ01 提现 CJ02 充值',
  `coin_result_pending` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '流水发生后帐户在途',
  `coin_result_cash` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '流水发生后帐户余额',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table coin_rechage
# ------------------------------------------------------------
DROP TABLE IF EXISTS `coin_rechage`;
CREATE TABLE `coin_rechage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_recharge_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀OR',
  `coin_recharge_cointype` varchar(10) NOT NULL DEFAULT '' COMMENT '代币类型',
  `coin_recharge_amount` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '充值数量',
  `coin_recharge_status` varchar(10) NOT NULL DEFAULT '' COMMENT '字典表 type=coin_rechage OR00 已经提交 OR01 成功 OR02 失败',
  `coin_recharge_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '充值用户id',
  `coin_recharge_chkuserid` bigint(20) NOT NULL DEFAULT '0' COMMENT '审查管理员id',
  `coin_recharge_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '提交时间',
  `coin_recharge_chktime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '审核时间',
  `coin_recharge_address` varchar(255) NOT NULL DEFAULT '' COMMENT '入帐钱包地址 和user_coin_accoin中usercoin_address一致',
  `coin_recharge_success` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否有效记帐',
  `coin_recharge_type` varchar(10) NOT NULL DEFAULT '' COMMENT '充值类型 字典表 type=coin_rechage_type ORT01 普通用户充值 ORT02 钱包直充  ORT03 一级市场充值',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table coin_withdrawal
# ------------------------------------------------------------
DROP TABLE IF EXISTS `coin_withdrawal`;
CREATE TABLE `coin_withdrawal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_withdrawal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀OW',
  `coin_withdrawal_cointype` varchar(10) NOT NULL DEFAULT '' COMMENT '代币类型',
  `coin_withdrawal_amount` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '提现数量',
  `coin_withdrawal_status` varchar(10) NOT NULL DEFAULT '' COMMENT '字典表 type=coin_withdrawaal OW00 已经提交 OW01 成功 OW02 失败',
  `coin_withdrawal_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '提现用户id',
  `coin_withdrawal_chkuserid` bigint(20) NOT NULL DEFAULT '0' COMMENT '审查管理员id',
  `coin_withdrawal_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '提交时间',
  `coin_withdrawal_chktime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '审核时间',
  `coin_withdrawal_toaddress` varchar(255) NOT NULL DEFAULT '' COMMENT '提现钱包地址',
  `coin_withdrawal_fromaddress` varchar(255) NOT NULL DEFAULT '' COMMENT '提现钱包地址',
  `coin_withdrawal_success` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否有效记帐',
  `coin_withdrawal_type` varchar(10) NOT NULL DEFAULT '' COMMENT '提现类型 字典表 type=coin_withdrawaal_type OWT01 普通用户提现',
  `coin_withdrawal_rate` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '提现费率 百分比',
  `coin_withdrawal_fee` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '提现手续费',
  `coin_withdrawal_out` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '实际提币金额',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table item_formula
# ------------------------------------------------------------
DROP TABLE IF EXISTS `item_formula`;
CREATE TABLE `item_formula` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_type` varchar(30) NOT NULL DEFAULT '' COMMENT '代币类型',
  `item_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目表id',
  `iamge` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `file` varchar(255) NOT NULL DEFAULT '' COMMENT '文件地址',
  `file_name` varchar(30) NOT NULL DEFAULT '' COMMENT '文件名称',
  `type` char(10) NOT NULL DEFAULT '' COMMENT 'item_formula_type    IFT01 购物证照',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table item_info
# ------------------------------------------------------------
DROP TABLE IF EXISTS `item_info`;
CREATE TABLE `item_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(255) NOT NULL COMMENT '项目名称',
  `coin_type` varchar(50) NOT NULL COMMENT '代币类型',
  `kk_name` varchar(30) NOT NULL COMMENT '卡卡币名称 ',
  `compound` varchar(255) NOT NULL COMMENT '小区名称',
  `layout` varchar(255) NOT NULL COMMENT '户型',
  `diqu` varchar(255) NOT NULL COMMENT '地区',
  `trade` varchar(255) NOT NULL COMMENT '商圈',
  `number` char(10) DEFAULT NULL COMMENT '楼层',
  `age` varchar(255) NOT NULL COMMENT '年代',
  `space` decimal(10,2) DEFAULT NULL COMMENT '面积',
  `rowards` varchar(255) NOT NULL COMMENT '朝向',
  `renovation` varchar(255) NOT NULL COMMENT '装修',
  `school` varchar(255) NOT NULL COMMENT '教育配套',
  `metro` varchar(50) NOT NULL COMMENT '临近地铁',
  `price` int(11) NOT NULL COMMENT '市场参考价',
  `amount` int(11) DEFAULT '0' COMMENT '资产总量',
  `term` int(2) NOT NULL COMMENT '投资期限',
  `exchange_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '交割日期',
  `school_district` varchar(255) NOT NULL COMMENT '教育属性',
  `sublet` varchar(255) NOT NULL COMMENT '分租方式  item_sublet  IS01 按季度分租  IS02  按年分租',
  `rightDate` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '确权日期',
  `bonusDate` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '分红日期',
  `investment` text NOT NULL COMMENT '投资分析',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table item_quarters
# ------------------------------------------------------------
DROP TABLE IF EXISTS `item_quarters`;
CREATE TABLE `item_quarters` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_type` varchar(30) NOT NULL DEFAULT '' COMMENT '代币类型',
  `item_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '项目表id',
  `layout` varchar(30) NOT NULL DEFAULT '' COMMENT '房屋户型',
  `space` varchar(30) NOT NULL DEFAULT '' COMMENT '面积',
  `date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '签约日期',
  `total` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '成交价格',
  `price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '成交单价',
  `age` varchar(255) NOT NULL COMMENT '年代',
  `rowards` varchar(255) NOT NULL COMMENT '朝向',
  `number` char(10) DEFAULT NULL COMMENT '楼层',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table settlement_cash
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settlement_cash`;

CREATE TABLE `settlement_cash` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `settlement_no` varchar(30) DEFAULT NULL,
  `settlement_accountid` bigint(11) DEFAULT NULL,
  `settlement_begin_amount` decimal(20,3) DEFAULT NULL,
  `settlement_end_amount` decimal(20,3) DEFAULT NULL,
  `settlement_begin_pending` decimal(20,3) DEFAULT NULL,
  `settlement_end_pending` decimal(20,3) DEFAULT NULL,
  `settlement_begin_time` datetime DEFAULT NULL,
  `settlement_end_time` datetime DEFAULT NULL,
  `settlement_cyc` varchar(255) DEFAULT NULL,
  `settlement_amount_flat` tinyint(1) DEFAULT NULL,
  `settlement_amount_dvalue` decimal(20,3) DEFAULT NULL,
  `settlement_pending_flat` tinyint(1) DEFAULT NULL,
  `settlement_pending_dvalue` decimal(20,3) DEFAULT NULL,
  `settlement_user` int(11) DEFAULT NULL,
  `settlement_checkuser` int(11) DEFAULT NULL,
  `settlement_jounalcount` bigint(20) DEFAULT NULL,
  `settlement_in` decimal(20,3) DEFAULT NULL,
  `settlement_out` decimal(20,3) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- LOCK TABLES `settlement_cash` WRITE 
/*!40000 ALTER TABLE `settlement_cash` DISABLE KEYS */;

/*!40000 ALTER TABLE `settlement_cash` ENABLE KEYS */;
-- UNLOCK TABLES


# Dump of table settlement_sys_cash
# ------------------------------------------------------------
DROP TABLE IF EXISTS `settlement_sys_cash`;
CREATE TABLE `settlement_sys_cash` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `settlement_no` varchar(30) DEFAULT NULL,
  `settlement_accountid` bigint(11) DEFAULT NULL,
  `settlement_begin_amount` decimal(20,3) DEFAULT NULL,
  `settlement_end_amount` decimal(20,3) DEFAULT NULL,
  `settlement_begin_pending` decimal(20,3) DEFAULT NULL,
  `settlement_end_pending` decimal(20,3) DEFAULT NULL,
  `settlement_begin_time` datetime DEFAULT NULL,
  `settlement_end_time` datetime DEFAULT NULL,
  `settlement_cyc` varchar(255) DEFAULT NULL,
  `settlement_amount_flat` tinyint(1) DEFAULT NULL,
  `settlement_amount_dvalue` decimal(20,3) DEFAULT NULL,
  `settlement_pending_flat` tinyint(1) DEFAULT NULL,
  `settlement_pending_dvalue` decimal(20,3) DEFAULT NULL,
  `settlement_user` int(11) DEFAULT NULL,
  `settlement_checkuser` int(11) DEFAULT NULL,
  `settlement_jounalcount` bigint(20) DEFAULT NULL,
  `settlement_in` decimal(20,3) DEFAULT NULL,
  `settlement_out` decimal(20,3) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table settlement_user_cash
# ------------------------------------------------------------
DROP TABLE IF EXISTS `settlement_user_cash`;
CREATE TABLE `settlement_user_cash` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `settlement_no` varchar(30) DEFAULT NULL,
  `settlement_accountid` bigint(11) DEFAULT NULL,
  `settlement_begin_amount` decimal(20,3) DEFAULT NULL,
  `settlement_end_amount` decimal(20,3) DEFAULT NULL,
  `settlement_begin_pending` decimal(20,3) DEFAULT NULL,
  `settlement_end_pending` decimal(20,3) DEFAULT NULL,
  `settlement_begin_time` datetime DEFAULT NULL,
  `settlement_end_time` datetime DEFAULT NULL,
  `settlement_cyc` varchar(255) DEFAULT NULL,
  `settlement_amount_flat` tinyint(1) DEFAULT NULL,
  `settlement_amount_dvalue` decimal(20,3) DEFAULT NULL,
  `settlement_pending_flat` tinyint(1) DEFAULT NULL,
  `settlement_pending_dvalue` decimal(20,3) DEFAULT NULL,
  `settlement_user` int(11) DEFAULT NULL,
  `settlement_in` decimal(20,3) DEFAULT NULL,
  `settlement_out` decimal(20,3) DEFAULT NULL,
  `settlement_checkuser` int(11) DEFAULT NULL,
  `settlement_jounalcount` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_3rd_account
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_3rd_account`;
CREATE TABLE `sys_3rd_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sys_3rd_type` char(10) NOT NULL DEFAULT '' COMMENT '第三方账号类型-字典表',
  `sys_3rd_name` varchar(255) NOT NULL DEFAULT '' COMMENT '第三方账号名称',
  `sys_3rd_account` varchar(255) NOT NULL DEFAULT '' COMMENT 'id',
  `sys_3rd_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'key',
  `sys_3rd_secrect` varchar(255) NOT NULL DEFAULT '' COMMENT '平台密钥',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_bank
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_bank`;
CREATE TABLE `sys_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `bank_type` char(10) NOT NULL DEFAULT '' COMMENT '字典表',
  `bank_name` varchar(255) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_add` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `bank_no` varchar(255) NOT NULL DEFAULT '' COMMENT '行号',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_cash
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_cash`;
CREATE TABLE `sys_cash` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sys_account_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '金额',
  `sys_account_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '在途金额',
  `sys_account_change_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后更新时间',
  `sys_account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后对帐时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_cash_account
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_cash_account`;
CREATE TABLE `sys_cash_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '余额',
  `account_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '在途资金',
  `account_change_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后更新时间',
  `account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后对帐时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_cash_fee
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_cash_fee`;
CREATE TABLE `sys_cash_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cash_withdrawal_feeno` varchar(30) NOT NULL DEFAULT '' COMMENT '手续费单据号 前缀 WF',
  `cash_withdrawal_feeamount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '手续提现金额',
  `cash_withdrawal_feestatus` varchar(10) NOT NULL DEFAULT '' COMMENT '提现状态 字典表 type=cash_ withdrawal_fee CWF00 已经提交 CWF01 成功 CWF02 失败',
  `cash_withdrawal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '提现单号',
  `cash_withdrawal_feetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '提交时间',
  `cash_withdrawal_feechktime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '审核时间',
  `cash_withdrawal_feesuccess` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否有效记帐',
  `cash_withdrawal_feetype` varchar(10) NOT NULL DEFAULT '' COMMENT '手续费类型 字典表 type=cash_ withdrawal _feetype CWFT01 普通用户提现',
  `cash_withdrawal_rate` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '提现费率',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_cash_journal
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_cash_journal`;
CREATE TABLE `sys_cash_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `syscash_journal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '流水单据号 前缀 SCJ ',
  `syscash_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '记帐时间',
  `syscash_journal_amount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '余额',
  `syscash_journal_in` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '收入',
  `syscash_journal_out` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '支出',
  `syscash_journal_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '在途',
  `syscash_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=syscash_journal SCJ01 提现手续费 SCJ02 返券 SCJ03 交易手续费',
  `syscash_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联业务单据号',
  `syscash_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=cjournal_type CJT01 初提 CJT02 审核 CJT03 失败 CJT04 撤回 CJT05 冲减 CJT06 交易',
  `syscash_result_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户在途',
  `syscash_result_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户余额',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_coin
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_coin`;
CREATE TABLE `sys_coin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `syscoin_account_type` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `syscoin_account_address` varchar(255) NOT NULL DEFAULT '' COMMENT '钱包地址',
  `syscoin_account_cash` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '余额',
  `syscoin_account_pending` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '在途余额',
  `syscoin_account_change_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后更新时间',
  `syscoint_account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后对帐时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_coin_account
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_coin_account`;
CREATE TABLE `sys_coin_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_type` char(10) NOT NULL DEFAULT '' COMMENT '账号类型',
  `account_address` varchar(255) NOT NULL DEFAULT '' COMMENT 'id',
  `account_cash` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '余额',
  `account_pending` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '在途金额',
  `account_change_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后更新时间',
  `account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后对帐时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_coin_fee
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_coin_fee`;
CREATE TABLE `sys_coin_fee` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_withdrawal_feeno` varchar(30) NOT NULL DEFAULT '' COMMENT '单据号 前缀WF',
  `coin_withdrawal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '提现单据号',
  `coin_withdrawal_cointype` varchar(10) NOT NULL DEFAULT '' COMMENT '代币类型',
  `coin_withdrawal_feeamount` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '提现手续费',
  `coin_withdrawal_feestatus` varchar(10) NOT NULL DEFAULT '' COMMENT '字典表 type=coin_ withdrawal_fee CWF00 已经提交 CWF01 成功 CWF02 失败',
  `coin_withdrawal_feetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '提交时间',
  `coin_withdrawal_feechktime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '审核时间',
  `coin_withdrawal_feesuccess` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否有效记帐',
  `coin_withdrawal_feetype` varchar(10) NOT NULL DEFAULT '' COMMENT '提现类型 字典表 type=coin_withdrawal_feetype CWFT01 普通用户提现',
  `coin_withdrawal_rate` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '提现费率 百分比',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_coin_journal
# ------------------------------------------------------------
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_debug
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_debug`;
CREATE TABLE `sys_debug` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) DEFAULT NULL,
  `req` text,
  `res` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_dictionary
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_dictionary`;
CREATE TABLE `sys_dictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `dic_no` char(10) NOT NULL DEFAULT '' COMMENT '字典数据编号',
  `dic_type` varchar(255) NOT NULL DEFAULT '' COMMENT '字典编码',
  `dic_name` varchar(255) NOT NULL DEFAULT '' COMMENT '字典值类型',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_error
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_error`;
CREATE TABLE `sys_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `error_code` int(11) NOT NULL DEFAULT '0' COMMENT '错误码',
  `error_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '错误信息',
  `error_level` int(11) NOT NULL DEFAULT '0' COMMENT '错误级别',
  `error_requireauth` bit(1) NOT NULL DEFAULT b'0' COMMENT '要求重新登录',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_log
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_log`;
CREATE TABLE `sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `token` varchar(255) DEFAULT '' COMMENT 'token',
  `error_code` int(11) NOT NULL DEFAULT '0' COMMENT '错误码',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '请求地址',
  `dumpinfo` text COMMENT 'crash信息',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_login_log
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_login_log`;
CREATE TABLE `sys_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `login_type` char(10) NOT NULL DEFAULT '' COMMENT '登陆类型-字典表',
  `login_time` datetime DEFAULT NULL COMMENT '登陆时间',
  `login_add` varchar(255) NOT NULL DEFAULT '' COMMENT '物理地点',
  `login_mac` varchar(255) NOT NULL DEFAULT '' COMMENT '地址／设备码',
  `login_ip` varchar(255) NOT NULL DEFAULT '' COMMENT '登陆ip',
  `login_token` varchar(255) NOT NULL DEFAULT '' COMMENT '登录时的accestken',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_mail
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_mail`;
CREATE TABLE `sys_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mail_type` char(10) NOT NULL DEFAULT '' COMMENT '字典表',
  `mail_define` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件格式定义',
  `mail_url` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件请求类型',
  `mail_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件发送条件',
  `mail_user_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件用户条件',
  `mail_event` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件发送事件',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_mail_log
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_mail_log`;
CREATE TABLE `sys_mail_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mail_type` int(11) NOT NULL DEFAULT '0' COMMENT '邮件类型',
  `mail_text` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件内容',
  `mail_uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `mail_sendtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '邮件发送时间',
  `mail_status` char(10) NOT NULL DEFAULT '' COMMENT '邮件发送状态',
  `mail_to` varchar(255) NOT NULL DEFAULT '' COMMENT '用户邮件帐号',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_message
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_message`;
CREATE TABLE `sys_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `msg_to` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `msg_text` varchar(255) NOT NULL DEFAULT '' COMMENT '消息内容',
  `msg_url` varchar(255) NOT NULL DEFAULT '' COMMENT '消息跳转地址',
  `msg_status` char(10) NOT NULL DEFAULT '' COMMENT '消息状态-字典表 MSG01 未读 MSG02 推送 MSG03 已读',
  `notify_id` int(11) NOT NULL DEFAULT '0' COMMENT '通知的id',
  `msg_readtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '读取时间',
  `msg_model` varchar(255) DEFAULT NULL,
  `msg_docno` varchar(255) DEFAULT NULL COMMENT '关联单据号',
  `msg_pushtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  `msg_type` char(10) DEFAULT NULL COMMENT '消息类型',
  `msg_no` varchar(30) DEFAULT NULL COMMENT '消息编号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_news
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_news`;
CREATE TABLE `sys_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `news_no` varchar(30) NOT NULL DEFAULT '' COMMENT '编号 SN',
  `news_title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `news_subtitle` varchar(255) NOT NULL DEFAULT '' COMMENT '副标题',
  `news_intro` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `news_writer` varchar(255) NOT NULL DEFAULT '' COMMENT '发布人',
  `news_source` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `news_content` text NOT NULL COMMENT '内容',
  `news_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '发布时间',
  `news_type` char(10) NOT NULL DEFAULT '' COMMENT '新闻类型 字典表news NEWS01 行业新闻 NEWS02 项目分析 NEWS03 系统公告',
  `news_pushtype` char(10) NOT NULL DEFAULT '' COMMENT '新闻推送类型 字典表newspush NP01 弹窗',
  `news_refmodel` varchar(255) NOT NULL DEFAULT '' COMMENT '指向业务',
  `news_refno` varchar(255) NOT NULL DEFAULT '' COMMENT '指向单据号',
  `news_refurl` varchar(255) NOT NULL DEFAULT '' COMMENT '指向URL (业务,单据)/URL输入一个即可',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_notify
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_notify`;
CREATE TABLE `sys_notify` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `notify_type` char(10) NOT NULL DEFAULT '' COMMENT '通知类型 notify_type   NT01充值成功 NT02 充值失败 NT03 提现成功 NT04 提现失败 NT05 交易 NT06 发券',
  `notify_fmt` text NOT NULL COMMENT '通知格式',
  `notify_user_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '通知的用户',
  `noiffy_event` varchar(255) NOT NULL DEFAULT '' COMMENT '通知的事件',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  `notify_model` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_sms_log
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_sms_log`;
CREATE TABLE `sys_sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `sms_type` char(10) NOT NULL DEFAULT '' COMMENT '类型-字典表 sms_code SLT01 注册 SLT02 修改手机号 SLT03 修改支付密码 SLT05 修改登陆密码 SLT04 绑定银行卡 ',
  `sms_text` varchar(255) NOT NULL DEFAULT '' COMMENT '短信内容',
  `sms_status` char(10) NOT NULL DEFAULT '' COMMENT '短信类型-字典表',
  `sms_body` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sys_user
# ------------------------------------------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` varchar(255) NOT NULL DEFAULT '' COMMENT '登录名',
  `user_nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `user_idno` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证号',
  `user_headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `user_sex` varchar(255) NOT NULL DEFAULT '' COMMENT '性别',
  `user_mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `user_pwd` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `user_paypwd` varchar(255) NOT NULL DEFAULT '' COMMENT '支付密码',
  `user_status` varchar(255) NOT NULL DEFAULT '' COMMENT '用户状态 user_status',
  `user_lastlogin` datetime DEFAULT NULL COMMENT '上次登陆时间',
  `user_with` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户提现次数',
  `user_with_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '提现时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table testtable
# ------------------------------------------------------------
DROP TABLE IF EXISTS `testtable`;
CREATE TABLE `testtable` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `counter` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table transaction_buy
# ------------------------------------------------------------
DROP TABLE IF EXISTS `transaction_buy`;
CREATE TABLE `transaction_buy` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `buy_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀TS',
  `buy_count` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '挂单数量',
  `buy_limit` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '挂单价格',
  `buy_feerate` decimal(20,5) NOT NULL DEFAULT '0.00000' COMMENT '手续费率',
  `buy_ammount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '挂单总价',
  `buy_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '挂单用户id',
  `buy_usercointaccount` bigint(20) NOT NULL DEFAULT '0' COMMENT '挂单用户帐户',
  `buy_transcount` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '成交数量',
  `buy_transammount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '成交价格',
  `buy_status` char(10) NOT NULL DEFAULT '' COMMENT '买单状态 字典表type = trans_buy; TB00  挂单 TB01 部分成交 TB02 全部成交 TB03 部分撒单 TB04 全部撒单 ',
  `buy_lasttranstime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后成交时间',
  `buy_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '币种',
  `buy_region` varchar(30) NOT NULL DEFAULT '' COMMENT '地区',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table transaction_order
# ------------------------------------------------------------
DROP TABLE IF EXISTS `transaction_order`;
CREATE TABLE `transaction_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `order_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀TO',
  `order_count` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '成交数量',
  `order_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '成交价格',
  `order_cash_rate` decimal(20,5) NOT NULL DEFAULT '0.00000' COMMENT '人民币手续费率',
  `order_coin_rate` decimal(20,5) NOT NULL DEFAULT '0.00000' COMMENT '代币手续费率',
  `order_cash_fee` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '人民币手续费',
  `order_coin_fee` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '代币手续费',
  `order_buy_no` varchar(255) NOT NULL DEFAULT '' COMMENT '买单号',
  `order_sell_no` varchar(255) NOT NULL DEFAULT '' COMMENT '卖单号',
  `order_sell_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '卖方用户',
  `order_buy_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '买方用户',
  `order_sell_coinaccount` bigint(20) NOT NULL DEFAULT '0' COMMENT '卖方代币帐户',
  `order_sell_cashacount` bigint(20) NOT NULL DEFAULT '0' COMMENT '卖方现金帐户',
  `order_buy_coinaccount` bigint(20) NOT NULL DEFAULT '0' COMMENT '买方代币帐户',
  `order_buy_cashaccount` bigint(20) NOT NULL DEFAULT '0' COMMENT '买方现金帐户',
  `order_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '入帐现金',
  `order_coin` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '入帐代币',
  `order_amount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '成交金额',
  `order_coin_type` varchar(255) NOT NULL DEFAULT '0' COMMENT '成交币种',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table transaction_sell
# ------------------------------------------------------------
DROP TABLE IF EXISTS `transaction_sell`;
CREATE TABLE `transaction_sell` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sell_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀TB',
  `sell_count` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '挂单数量',
  `sell_limit` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '挂单价格',
  `sell_feerate` decimal(20,5) NOT NULL DEFAULT '0.00000' COMMENT '手续费率',
  `sell_ammount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '挂单总价',
  `sell_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '挂单用户id',
  `sell_usercointaccount` bigint(20) NOT NULL DEFAULT '0' COMMENT '挂单用户帐户',
  `sell_transcount` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '成交数量',
  `sell_transammount` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '成交价格',
  `sell_status` char(10) NOT NULL DEFAULT '' COMMENT '卖单状态 字典表type = trans_sell; TS00  挂单 TS01 部分成交 TS02 全部成交 TS03 部分撒单 TS04 全部撒单 ',
  `sell_lasttranstime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后成交时间',
  `sell_leveltype` char(10) NOT NULL DEFAULT '' COMMENT '卖单类型 字典表type = sell_level SL00 普通 SL01 一级市场',
  `sell_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '币种',
  `sell_region` varchar(30) NOT NULL DEFAULT '' COMMENT '地区',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_bank_account
# ------------------------------------------------------------
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_cash_account
# ------------------------------------------------------------
DROP TABLE IF EXISTS `user_cash_account`;
CREATE TABLE `user_cash_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id ',
  `account_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '余额',
  `account_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '在途金额',
  `account_change_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后更新时间',
  `account_settelment_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后对帐时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_cash_journal
# ------------------------------------------------------------
DROP TABLE IF EXISTS `user_cash_journal`;
CREATE TABLE `user_cash_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usercash_journal_userid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `usercash_result_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户在途',
  `usercash_result_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户余额',
  `usercash_journal_no` varchar(30) NOT NULL DEFAULT '' COMMENT '流水单据号 前缀 UCJ ',
  `usercash_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '记帐时间',
  `usercash_journal_amout` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '余额',
  `usercash_journal_in` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '收入',
  `usercash_journal_out` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '支出',
  `usercash_journal_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '在途',
  `usercash_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=usercash_journal CJ01 提现 CJ02 充值 CJ03 买单 CJ04 卖单 CJ05 提现手续费 CJ06 成交手续费 CJ07 返佣 CJ08 用券 CJ09 买入 CJ10 一级市场放量 CJ11 卖出',
  `usercash_journal_jobno` varchar(30) NOT NULL DEFAULT '0' COMMENT '关联业务单据号',
  `usercash_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=journal_type CJT01 初提 CJT02 审核 CJT03 失败 CJT04 撤回 CJT05 冲减 CJT06 成交',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_cash_order
# ------------------------------------------------------------
DROP TABLE IF EXISTS `user_cash_order`;
CREATE TABLE `user_cash_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usercashorder_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单号 流水号UCO',
  `usercashorder_type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 字典表usercashorder UCORDER01 买入 UCORDER02 卖出 UCORDER03 提现 UCORDER04 提现手续费 UCORDER05 充值 UCORDER06 交易手续费 UCORDER07 返券',
  `usercashorder_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联的成交单',
  `usercashorder_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '金额',
  `usercashorder_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_coin_account
# ------------------------------------------------------------
DROP TABLE IF EXISTS `user_coin_account`;
CREATE TABLE `user_coin_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usercoin_account_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `usercoin_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '代币编号',
  `usercoin_address` varchar(255) NOT NULL DEFAULT '' COMMENT '充值钱包地址',
  `usercoin_cash` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '余额',
  `usercoin_pending` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '在途金额',
  `usercoin_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '平均持币成本',
  `usercoin_value` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '持币总成本',
  `usercoin_netprice` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT '平均持币净成本 扣费的成本',
  `usercoin_netvalue` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '持币净成本 扣费后成本',
  `usercoin_change_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后更新时间',
  `usercoin_settelment_time` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '最后对帐时间',
  `usercoint_primarycash` decimal(20,8) NOT NULL DEFAULT '0.00000000' COMMENT '一级市场首发余额',
  `usercoint_isprimary` bit(1) NOT NULL DEFAULT b'0' COMMENT '是否为一级市场',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  `usercoin_locktime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '锁定时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_coin_frozen
# ------------------------------------------------------------
DROP TABLE IF EXISTS `user_coin_frozen`;
CREATE TABLE `user_coin_frozen` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `frozen_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单号 前缀 FZ',
  `frozen_cointtype` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `frozen_coinaccoint` bigint(20) NOT NULL DEFAULT '0' COMMENT '冻结代币帐户 user_cointaccoint.id',
  `frozen_userid` varchar(30) NOT NULL DEFAULT '' COMMENT '冻结用户id sys_user.user_id',
  `frozen_type` varchar(10) NOT NULL DEFAULT '' COMMENT '冻结类型 字典表type=coin_frozen FT01 用券交易',
  `frozen_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联单号',
  `frozen_deadline` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '解冻日期',
  `frozen_status` varchar(10) NOT NULL DEFAULT '' COMMENT '冻结状态 字典表type=frozen_status FS01=冻结 FS02=解冻',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_coin_journal
# ------------------------------------------------------------
DROP TABLE IF EXISTS `user_coin_journal`;
CREATE TABLE `user_coin_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usercoin_journal_no` varchar(30) NOT NULL DEFAULT '0' COMMENT '流水单据号 前缀 UOJ',
  `usercoin_journal_datetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '记帐时间',
  `usercoin_journal_in` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '收入',
  `usercoin_journal_out` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '支出',
  `usercoin_journal_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '在途',
  `usercoin_journal_type` char(10) NOT NULL DEFAULT '' COMMENT '记帐类型 字典表type=usercoin_journal UOJ01 充值 UOJ02 提现 UOJ03 现币手续费 UOJ04 确认 UOJ05 冲减 UOJ06 交易手续费 UOJ07交易 UOJ08 成交 UOJ09 用券冻结 UOJ10 解除冻结',
  `usercoin_journal_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联业务单据号',
  `usercoin_journal_status` char(10) NOT NULL DEFAULT '' COMMENT '单据类型 字典表 type=cjournal_type CJT01 初提 CJT02 审核 CJT03 失败 CJT04 撤回 CJT05 冲减 CJT06 成交 CJT07 冻结',
  `usercoin_journal_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户id',
  `usercoin_journal_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '币类型',
  `usercoin_journal_account` bigint(20) NOT NULL DEFAULT '0' COMMENT '帐户id',
  `usercoin_result_pending` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户在途',
  `usercoin_result_cash` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '流水发生后帐户余额 ',
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '校验值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_order
# ------------------------------------------------------------
DROP TABLE IF EXISTS `user_order`;
CREATE TABLE `user_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `userorder_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单号 流水号UO',
  `userorder_type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 字典表userorder UORDER01 买入 UORDER02 卖出 UORDER03 返券',
  `userorder_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联的买单或卖单',
  `userorder_orderno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联的交易单',
  `userorder_cointype` varchar(255) NOT NULL DEFAULT '' COMMENT '代币种类',
  `userorder_price` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '单价',
  `userorder_coin` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '代币数量',
  `userorder_discounttype` varchar(30) NOT NULL DEFAULT '' COMMENT '优惠类型',
  `userorder_discountno` varchar(30) NOT NULL DEFAULT '' COMMENT '优惠券号',
  `userorder_fee` decimal(20,3) NOT NULL DEFAULT '0.000' COMMENT '手续费',
  `userorder_ammount` decimal(20,9) NOT NULL DEFAULT '0.000000000' COMMENT '最终成交金额',
  `userorder_userid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户id',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table voucher_info
# ------------------------------------------------------------
DROP TABLE IF EXISTS `voucher_info`;
CREATE TABLE `voucher_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `vaucher_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀VCN',
  `vaucher_name` varchar(255) NOT NULL DEFAULT '' COMMENT '现金券名称',
  `vaucher_type` varchar(255) NOT NULL DEFAULT '' COMMENT '券类型 voucher_type VC01 满减',
  `voucher_val1` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '活动值 满减 时，为满val1减val2',
  `voucher_val2` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '满减 时，为满val1减val2',
  `voucher_val3` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '满减 时，为满val1减val2',
  `voucher_val4` decimal(20,2) NOT NULL DEFAULT '0.00' COMMENT '满减 时，为满val1减val2',
  `voucher_model` varchar(255) NOT NULL DEFAULT '' COMMENT '绑定模型 一期直接插入null',
  `voucher_event` varchar(255) NOT NULL DEFAULT '' COMMENT '绑定事件 一期直接插入null',
  `voucher_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '使用条件 一期直接插入null',
  `voucher_timespan` int(11) NOT NULL DEFAULT '0' COMMENT '超时时长 以秒为单位',
  `voucher_count` int(11) NOT NULL DEFAULT '0' COMMENT '发放数量',
  `voucher_usecount` int(11) NOT NULL DEFAULT '0' COMMENT '使用数量',
  `voucher_timeoutcount` int(11) NOT NULL DEFAULT '0' COMMENT '过期数量',
  `voucher_locktime` int(11) NOT NULL DEFAULT '0' COMMENT '锁定时间 使用后的资产锁定时长，以秒为单位',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table voucher_storage
# ------------------------------------------------------------
DROP TABLE IF EXISTS `voucher_storage`;
CREATE TABLE `voucher_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `vaucherstorage_no` varchar(255) NOT NULL DEFAULT '' COMMENT '现金券编号 前缀VCS',
  `vaucherstorage_voucherno` varchar(255) NOT NULL DEFAULT '' COMMENT '现金卷编号  关联 voucher_info',
  `vaucherstorage_activity` varchar(255) NOT NULL DEFAULT '' COMMENT '活动编号',
  `voucherstorage_userid` bigint(20) NOT NULL DEFAULT '0' COMMENT '所有者的用户id',
  `voucherstorage_storagetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '发放时间',
  `voucherstorage_status` char(10) NOT NULL DEFAULT '' COMMENT '状态 字典表voucher_status VOUS00 未用 VOUS01 已用 VOUS02 过期',
  `voucherstorage_jobno` varchar(255) NOT NULL DEFAULT '' COMMENT '关联单据号',
  `voucherstorage_usetime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '使用时间',
  `voucherstorage_outtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '过期时间',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
