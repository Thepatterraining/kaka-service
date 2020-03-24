


DROP TABLE IF EXISTS `proj_bonusitem`;

CREATE TABLE `proj_bonusitem` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bonus_no` varchar(30) NOT NULL DEFAULT '' COMMENT '分红单号 前缀CBN',
  `bonus_proj` varchar(30) NOT NULL DEFAULT '' COMMENT '项目编号',
  `bonus_authdate` datetime NOT NULL DEFAULT '1971-01-01' COMMENT '确权日期',
  `bonus_userid` bigint NOT NULL DEFAULT 0 COMMENT '用户id',
  `bonus_count` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '代币数量',
  `bonus_cash` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '分红金额',
  `bonus_success` bit NOT NULL DEFAULT b'0' COMMENT '是否已经成功入帐',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;