
-- sys_debug表
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

-- 资金池对帐
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
) ENGINE=InnoDB AUTO_INCREMENT=386 DEFAULT CHARSET=utf8;

-- 平台对帐
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
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8;

-- 用户现金对帐
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
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=utf8;