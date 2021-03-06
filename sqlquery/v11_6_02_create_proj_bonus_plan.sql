CREATE TABLE `proj_bonus_plan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bonusplan_no` varchar(255) NOT NULL DEFAULT '' COMMENT '编号',
  `bonusplan_coin` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `bonusplan_fee` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '管理费',
  `bonusplan_cash` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '总金额',
  `bonusplan_dealfee` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '总金额',
  `bonusplan_dealcash` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '总金额',
  `bonusplan_unit` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '总金额',
  `bonusplan_status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态',
  `bonusplan_checkuserid` bigint NOT NULL DEFAULT 0 COMMENT '审核人',
  `bonusplan_checktime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '审核时间',
  `bonusplan_autocheck` int NOT NULL DEFAULT 0 COMMENT '是否自动审核',
  `bonusplan_typeid` bigint NOT NULL DEFAULT 0 COMMENT '类型',
  `bonusplan_starttime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '开始时间',
  `bonusplan_endtime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '结束时间',
  `bonsuplan_counts` int NOT NULL DEFAULT 0 COMMENT '分红期数',
  `bonsuplan_startindex` int NOT NULL DEFAULT 0 COMMENT '分红开始期数',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;