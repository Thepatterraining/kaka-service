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

-- 创建活动用卷的表结构


-- 活动表
DROP TABLE IF EXISTS `activity_info`;

CREATE TABLE `activity_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `activity_no` varchar(20) NOT NULL DEFAULT '' COMMENT '活动编号 前缀SA',
  `activity_name` varchar(255) NOT NULL DEFAULT '' COMMENT '活动名称',
  `activity_start` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '开始时间',
  `activity_end` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '限制时间',
  `activity_limittype` char(10) NOT NULL DEFAULT '' COMMENT '活动限制类型 字典表 type=activity_limit AL01 限时 AL02 限量',
  `activity_event` varchar(255) NOT NULL DEFAULT '' COMMENT '绑定事件',
  `activity_limitcount` int(11) NOT NULL DEFAULT 0 COMMENT '数量',
  `activity_count` int(11) NOT NULL DEFAULT 0 COMMENT '实际发生数量',
  `activity_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '触发条件',
  `activity_code` char(10) NOT NULL DEFAULT '' COMMENT '活动邀请码',
  `activity_status` varchar(10) NOT NULL DEFAULT '' COMMENT '活动状态 字典表 type=activity_status AS00 未开始 AS01 进行中 AS02 已结束 AS03 已终止',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 活动子表
DROP TABLE IF EXISTS `activity_item`;

CREATE TABLE `activity_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `activity_no` varchar(20) NOT NULL DEFAULT '' COMMENT '活动编号 关联 activity.activity_no',
  `activity_itemtype` varchar(10) NOT NULL DEFAULT '' COMMENT '活动类型 字典表activity AT01 返券',
  `activity_itemno` varchar(255) NOT NULL DEFAULT '' COMMENT '券编码 voucher_info .voucher_no',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 现金券定义表
DROP TABLE IF EXISTS `voucher_info`;

CREATE TABLE `voucher_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `vaucher_no` varchar(255) NOT NULL DEFAULT '' COMMENT '单据号 前缀VCN',
  `vaucher_name` varchar(255) NOT NULL DEFAULT '' COMMENT '现金券名称',
  `vaucher_type` varchar(255) NOT NULL DEFAULT '' COMMENT '券类型 voucher_type VC01 满减',
  `voucher_val1` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '满减 时，为满val1减val2',
  `voucher_val2` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '满减 时，为满val1减val2',
  `voucher_val3` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '满减 时，为满val1减val2',
  `voucher_val4` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '满减 时，为满val1减val2',
  `voucher_model` varchar(255) NOT NULL DEFAULT '' COMMENT '一期直接插入null',
  `voucher_event` varchar(255) NOT NULL DEFAULT '' COMMENT '一期直接插入null',
  `voucher_filter` varchar(255) NOT NULL DEFAULT '' COMMENT '一期直接插入null',
  `voucher_timespan` int(11) NOT NULL DEFAULT 0 COMMENT '超时时长 以秒为单位',
  `voucher_count` int(11) NOT NULL DEFAULT 0 COMMENT '发放数量',
  `voucher_usecount` int(11) NOT NULL DEFAULT 0 COMMENT '使用数量',
  `voucher_timeoutcount` int(11) NOT NULL DEFAULT 0 COMMENT '过期数量',
  `voucher_locktime` int(11) NOT NULL DEFAULT 0 COMMENT '锁定时间 使用后的资产锁定时长，以秒为单位',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 现金券发放记录表
DROP TABLE IF EXISTS `voucher_storage`;

CREATE TABLE `voucher_storage` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `vaucherstorage_no` varchar(255) NOT NULL DEFAULT '' COMMENT '现金券编号 前缀VCS',
  `vaucherstorage_voucherno` varchar(255) NOT NULL DEFAULT '' COMMENT '现金卷编号  关联 voucher_info',
  `vaucherstorage_activity` varchar(255) NOT NULL DEFAULT '' COMMENT '活动编号',
  `voucherstorage_userid` bigint NOT NULL DEFAULT 0 COMMENT '所有者的用户id',
  `voucherstorage_storagetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '发放时间',
  `voucherstorage_status` char(10) NOT NULL DEFAULT '' COMMENT '状态 字典表voucher_status VOUS00 未用 VOUS01 已用 VOUS02 过期',
  `voucherstorage_jobno` varchar(255) NOT NULL DEFAULT '' COMMENT '关联单据号',
  `voucherstorage_usetime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '使用时间',
  `voucherstorage_outtime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '过期时间',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 临时项目表
DROP TABLE IF EXISTS `kk_item`;

CREATE TABLE `kk_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
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
  `exchange_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '交割日期',
  `school_district` varchar(255) NOT NULL COMMENT '教育属性',
  `sublet` varchar(255) NOT NULL COMMENT '分租方式  item_sublet  IS01 按季度分租  IS02  按年分租',
  `rightDate` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '确权日期',
  `bonusDate` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '分红日期',
  `investment` text NOT NULL COMMENT '投资分析',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
--
--
--   `plan_file` varchar(255) NOT NULL COMMENT '投资文件pdf',
--   `plan_file_name` varchar(255) NOT NULL COMMENT '投资文件pdf名字',
--   `cover_img1` varchar(255) DEFAULT '0' COMMENT '封面图',
--   `cover_img2` varchar(255) NOT NULL DEFAULT '0' COMMENT '户型图',
--   `cover_img3` varchar(255) NOT NULL COMMENT '趋势图',
--   `raising_money` decimal(11,2) DEFAULT '0.00' COMMENT '融资总额',
--
--   `sur_amount` int(11) NOT NULL COMMENT '剩余份数',
--   `lowest_money` decimal(11,2) DEFAULT '0.00' COMMENT '最低出资金额',
--   `start_time` int(11) DEFAULT '0' COMMENT '项目开始时间',
--   `end_time` int(11) DEFAULT '0' COMMENT '项目结束时间',
--
--   `complete_time` int(11) NOT NULL DEFAULT '0' COMMENT '众筹完成时间',
--   `quotation_time` int(11) NOT NULL DEFAULT '0' COMMENT '开盘时间',
--
--   `payend_time` int(11) DEFAULT '0' COMMENT '支付结束时间',
--   `content` text COMMENT '项目详情',
--   `sort` int(10) unsigned DEFAULT '0' COMMENT '排序号',
--   `view` int(10) unsigned DEFAULT '0' COMMENT '浏览数',
--   `progress` int(10) DEFAULT '0' COMMENT '进度',
--   `status` tinyint(1) DEFAULT '0' COMMENT '状态 -1 删除 0审核 1为正常',
--   `update_time` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
--   `time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
--
--   `rose` int(11) NOT NULL DEFAULT '0' COMMENT '历史涨幅',
--   `developers` varchar(255) NOT NULL COMMENT '开发商',
--
--   `property` varchar(255) NOT NULL COMMENT '物业公司',
--
--
--
--
--
--
--
--
--   `new_item` tinyint(1) NOT NULL COMMENT '最新项目',
--   `case_item` tinyint(1) NOT NULL COMMENT '成功案例',
--   `top_item` tinyint(1) NOT NULL COMMENT '置顶',
--
--   `investment` text NOT NULL COMMENT '投资分析',
--   `area` varchar(255) NOT NULL COMMENT '哪个区',
--   `reference1` int(11) NOT NULL COMMENT '参考价1',
--   `reference2` int(11) NOT NULL COMMENT '参考价2',
--   `reference3` int(11) NOT NULL COMMENT '参考价3',
--   `reference_bi` float(11,2) NOT NULL COMMENT '币的参考价',
--   `school_district` varchar(20) NOT NULL DEFAULT '' COMMENT '教育属性',
--   `order_price1` int(11) NOT NULL DEFAULT '0' COMMENT '同小区成交纪录1 成交单价',
--   `order_space1` int(11) NOT NULL DEFAULT '0' COMMENT '同小区成交纪录1 面积',
--   `order_date1` datetime DEFAULT NULL COMMENT '同小区成交纪录1 成交日期',
--   `order_layout1` varchar(20) DEFAULT NULL COMMENT '同小区成交纪录1 户型',
--   `order_total1` int(11) DEFAULT NULL COMMENT '同小区成交纪录1 成交价格',
--   `order_price2` int(11) NOT NULL DEFAULT '0' COMMENT '同小区成交纪录2 成交单价',
--   `order_price3` int(11) NOT NULL DEFAULT '0' COMMENT '同小区成交纪录3 成交单价',
--   `order_space2` int(11) NOT NULL DEFAULT '0' COMMENT '同小区成交纪录2 面积',
--   `order_space3` int(11) NOT NULL DEFAULT '0' COMMENT '同小区成交纪录3 面积',
--   `order_date2` datetime DEFAULT NULL COMMENT '同小区成交纪录2 成交日期',
--   `order_date3` datetime DEFAULT NULL COMMENT '同小区成交纪录3 成交日期',
--   `order_layout2` varchar(20) DEFAULT NULL COMMENT '同小区成交纪录2 户型',
--   `order_layout3` varchar(20) DEFAULT NULL COMMENT '同小区成交纪录3 户型',
--   `order_total2` int(11) DEFAULT NULL COMMENT '同小区成交纪录2 成交价格',
--   `order_total3` int(11) DEFAULT NULL COMMENT '同小区成交纪录3 成交价格',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='项目表';


-- 临时项目表
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
  `exchange_time` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '交割日期',
  `school_district` varchar(255) NOT NULL COMMENT '教育属性',
  `sublet` varchar(255) NOT NULL COMMENT '分租方式  item_sublet  IS01 按季度分租  IS02  按年分租',
  `rightDate` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '确权日期',
  `bonusDate` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '分红日期',
  `investment` text NOT NULL COMMENT '投资分析',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 证照公式表
DROP TABLE IF EXISTS `item_formula`;

CREATE TABLE `item_formula` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_type` varchar(30) NOT NULL DEFAULT '' COMMENT '代币类型',
  `item_id` bigint NOT NULL DEFAULT 0 COMMENT '项目表id',
  `iamge` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `file` varchar(255) NOT NULL DEFAULT '' COMMENT '文件地址',
  `file_name` varchar(30) NOT NULL DEFAULT '' COMMENT '文件名称',
  `type` char(10) NOT NULL DEFAULT '' COMMENT 'item_formula_type    IFT01 购物证照',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 同小区成交记录表
DROP TABLE IF EXISTS `item_quarters`;

CREATE TABLE `item_quarters` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `coin_type` varchar(30) NOT NULL DEFAULT '' COMMENT '代币类型',
  `item_id` bigint NOT NULL DEFAULT 0 COMMENT '项目表id',
  `layout` varchar(30) NOT NULL DEFAULT '' COMMENT '房屋户型',
  `space` varchar(30) NOT NULL DEFAULT '' COMMENT '面积',
  `date` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '签约日期',
  `total` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '成交价格',
  `price` DECIMAL(20,3) NOT NULL DEFAULT 0 COMMENT '成交单价',
  `age` varchar(255) NOT NULL COMMENT '年代',
  `rowards` varchar(255) NOT NULL COMMENT '朝向',
  `number` char(10) DEFAULT NULL COMMENT '楼层',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- 邀请记录表
DROP TABLE IF EXISTS `activity_invitation`;

CREATE TABLE `activity_invitation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `inviitation_no` varchar(30) NOT NULL DEFAULT '' COMMENT '邀请单号 前缀 INV',
  `inviitation_code` varchar(30) NOT NULL DEFAULT '' COMMENT '邀请码 目前同邀请人手机号',
  `inviitation_user` varchar(30) NOT NULL DEFAULT '' COMMENT '邀请用户(sys_user.user_id)',
  `inviitation_reguser` varchar(30) NOT NULL DEFAULT '' COMMENT '受邀用户 注册后的 sys_user.user_id',
  `inviitation _type` char(10) NOT NULL DEFAULT '' COMMENT '邀请类型 字典表invitation INV01= 注册',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 用户现金交易记录表
DROP TABLE IF EXISTS `user_cash_order`;

CREATE TABLE `user_cash_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `usercashorder_no` varchar(30) NOT NULL DEFAULT '' COMMENT '单号 流水号UCO',
  `usercashorder_type` varchar(30) NOT NULL DEFAULT '' COMMENT '类型 字典表usercashorder UCORDER01 买入 UCORDER02 卖出 UCORDER03 提现 UCORDER04 提现手续费 UCORDER05 充值 UCORDER06 交易手续费',
  `usercashorder_jobno` varchar(30) NOT NULL DEFAULT '' COMMENT '关联的成交单',
  `usercashorder_price` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '金额',
  `usercashorder_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
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
