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
  `user_status` varchar(255) NOT NULL DEFAULT '' COMMENT '用户状态',
  `user_lastlogin` varchar(255) NOT NULL DEFAULT '' COMMENT '上次登陆时间',
  `user_with` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户提现次数',
  `user_with_date` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '提现时间',
  `user_type` char(10) NOT NULL DEFAULT '' COMMENT '用户类型  字典表 user_type UT00 普通用户 UT01 公司员工 UT02 公司高管 UT03 基金帐号',
  `user_invcode` varchar(255) NOT NULL DEFAULT '' COMMENT '邀请码',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_sms_log`;

CREATE TABLE `sys_sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `sms_type` char(10) NOT NULL DEFAULT '' COMMENT '类型-字典表',
  `sms_text` varchar(255) NOT NULL DEFAULT '' COMMENT '短信内容',
  `sms_status` char(10) NOT NULL DEFAULT '' COMMENT '短信类型-字典表',
  `sms_body` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_notify`;

CREATE TABLE `sys_notify` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `notify_type` char(10) NOT NULL DEFAULT '' COMMENT '通知类型',
  `notify_fmt` varchar(255) NOT NULL DEFAULT '' COMMENT '通知格式',
  `notify_user_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '通知的用户',
  `noiffy_event` varchar(255) NOT NULL DEFAULT '' COMMENT '通知的事件',
  `notify_model` varchar(255) DEFAULT NULL,
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_message`;

CREATE TABLE `sys_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `msg_type` char(10) DEFAULT '' COMMENT '消息类型',
  `msg_no` varchar(30) DEFAULT '' COMMENT '消息编号',
  `msg_to` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `msg_text` varchar(255) NOT NULL DEFAULT '' COMMENT '消息内容',
  `msg_url` varchar(255) NOT NULL DEFAULT '' COMMENT '消息跳转地址',
  `msg_status` char(10) NOT NULL DEFAULT '' COMMENT '消息状态-字典表 MSG01 未读 MSG02 推送 MSG03 已读',
  `notify_id` int(11) NOT NULL DEFAULT 0 COMMENT '通知的id',
  `msg_readtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '读取时间',
  `msg_model` varchar(255) DEFAULT '',
  `msg_docno` varchar(255) DEFAULT '' COMMENT '关联单据号',
  `msg_pushtime` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '推送时间',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_login_log`;

CREATE TABLE `sys_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `login_type` char(10) NOT NULL DEFAULT '' COMMENT '登陆类型-字典表',
  `login_time` datetime COMMENT '登陆时间',
  `login_add` varchar(255) NOT NULL DEFAULT '' COMMENT '物理地点',
  `login_mac` varchar(255) NOT NULL DEFAULT '' COMMENT '地址／设备码',
  `login_ip` varchar(255) NOT NULL DEFAULT '' COMMENT '登陆ip',
  `login_token` varchar(255) NOT NULL DEFAULT '' COMMENT '登录时的accestken',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_log`;

CREATE TABLE `sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `token` varchar(255) NOT NULL DEFAULT '' COMMENT 'token',
  `error_code` int(11) NOT NULL DEFAULT 0 COMMENT '错误码',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '请求地址',
  `dumpinfo` text NOT NULL DEFAULT '' COMMENT 'crash信息',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_error`;

CREATE TABLE `sys_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `error_code` int(11) NOT NULL DEFAULT 0 COMMENT '错误码',
  `error_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '错误信息',
  `error_level` int(11) NOT NULL DEFAULT 0 COMMENT '错误级别',
  `error_requireauth` BIT NOT NULL DEFAULT false COMMENT '要求重新登录',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_dictionary`;

CREATE TABLE `sys_dictionary` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `dic_no` char(10) NOT NULL DEFAULT '' COMMENT '字典数据编号',
  `dic_type` varchar(255) NOT NULL DEFAULT '' COMMENT '字典编码',
  `dic_name` varchar(255) NOT NULL DEFAULT '' COMMENT '字典值类型',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_coin_account`;

CREATE TABLE `sys_coin_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_type` char(10) NOT NULL DEFAULT '' COMMENT '账号类型',
  `account_address` varchar(255) NOT NULL DEFAULT '' COMMENT 'id',
  `account_cash` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '余额',
  `account_pending` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '在途金额',
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

DROP TABLE IF EXISTS `sys_cash_account`;

CREATE TABLE `sys_cash_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account_cash` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '余额',
  `account_pending` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '在途资金',
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

DROP TABLE IF EXISTS `sys_bank`;

CREATE TABLE `sys_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `bank_type` char(10) NOT NULL DEFAULT '' COMMENT '字典表',
  `bank_name` varchar(255) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_add` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `bank_no` varchar(255) NOT NULL DEFAULT '' COMMENT '行号',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_3rd_account`;

CREATE TABLE `sys_3rd_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sys_3rd_type` char(10) NOT NULL DEFAULT '' COMMENT '第三方账号类型-字典表',
  `sys_3rd_name` varchar(255) NOT NULL DEFAULT '' COMMENT '第三方账号名称',
  `sys_3rd_account` varchar(255) NOT NULL DEFAULT '' COMMENT 'id',
  `sys_3rd_key` varchar(255) NOT NULL DEFAULT '' COMMENT 'key',
  `sys_3rd_secrect` varchar(255) NOT NULL DEFAULT '' COMMENT '平台密钥',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `sys_mail`;

CREATE TABLE `sys_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mail_type` char(10) NOT NULL DEFAULT '' COMMENT '字典表',
  `mail_define` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件格式定义',
  `mail_url` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件请求类型',
  `mail_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件发送条件',
  `mail_user_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件用户条件',
  `mail_event` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件发送事件',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `sys_mail_log`;

CREATE TABLE `sys_mail_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mail_type` int(11) NOT NULL DEFAULT 0 COMMENT '邮件类型',
  `mail_text` varchar(255) NOT NULL DEFAULT '' COMMENT '邮件内容',
  `mail_uid` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `mail_sendtime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '邮件发送时间',
  `mail_status` char(10) NOT NULL DEFAULT '' COMMENT '邮件发送状态',
  `mail_to` varchar(255) NOT NULL DEFAULT '' COMMENT '用户邮件帐号',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `news_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '发布时间',
  `news_type` char(10) NOT NULL DEFAULT '' COMMENT '新闻类型 字典表news NEWS01 行业新闻 NEWS02 项目分析 NEWS03 系统公告',
  `news_pushtype` char(10) NOT NULL DEFAULT '' COMMENT '新闻推送类型 字典表newspush NP01 弹窗',
  `news_refmodel` varchar(255) NOT NULL DEFAULT '' COMMENT '指向业务',
  `news_refno` varchar(255) NOT NULL DEFAULT '' COMMENT '指向单据号',
  `news_refurl` varchar(255) NOT NULL DEFAULT '' COMMENT '指向URL (业务,单据)/URL输入一个即可',
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
