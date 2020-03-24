

DROP TABLE IF EXISTS `index_coin_hour`;

CREATE TABLE `index_coin_hour` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`coin_type` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `price_open` bigint NOT NULL DEFAULT 0 COMMENT '开 价格',
  `price_close` bigint NOT NULL DEFAULT 0 COMMENT '收 价格',
  `price_high` bigint NOT NULL DEFAULT 0 COMMENT '高 价格',
  `price_low` bigint NOT NULL DEFAULT 0 COMMENT '低 价格',
  `price_scale` bigint NOT NULL DEFAULT 100 COMMENT '价格因子 默认100 实际价格 = 价格／价格因子',
  `volume_val` bigint NOT NULL DEFAULT 0 COMMENT '成交量',
  `volume_scale` bigint NOT NULL DEFAULT 10000 COMMENT '成交量因子 默认10000 实际成交 = 成交量／成交量因子',
  `turnover_val` int NOT NULL DEFAULT 0 COMMENT '换手率',
  `turnover_scale` int NOT NULL DEFAULT 100 COMMENT '换手率因子 默认100 实际换手率 = 换手率／换手率因子',
  `coin_scale` decimal(20,9) NOT NULL DEFAULT 0.01 COMMENT '报价格因子 默认0.01',
  `time_open` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '开始时间',
  `time_close` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '结束时间 和下一个开始时间相同 查询使用 between',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_coin_hour_id_unique_index` (`coin_type`,`time_open`,`time_close`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `index_coin_day`;

CREATE TABLE `index_coin_day` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`coin_type` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `price_open` bigint NOT NULL DEFAULT 0 COMMENT '开 价格',
  `price_close` bigint NOT NULL DEFAULT 0 COMMENT '收 价格',
  `price_high` bigint NOT NULL DEFAULT 0 COMMENT '高 价格',
  `price_low` bigint NOT NULL DEFAULT 0 COMMENT '低 价格',
  `price_scale` bigint NOT NULL DEFAULT 100 COMMENT '价格因子 默认100 实际价格 = 价格／价格因子',
  `volume_val` bigint NOT NULL DEFAULT 0 COMMENT '成交量',
  `volume_scale` bigint NOT NULL DEFAULT 10000 COMMENT '成交量因子 默认10000 实际成交 = 成交量／成交量因子',
  `turnover_val` int NOT NULL DEFAULT 0 COMMENT '换手率',
  `turnover_scale` int NOT NULL DEFAULT 100 COMMENT '换手率因子 默认100 实际换手率 = 换手率／换手率因子',
  `coin_scale` decimal(20,9) NOT NULL DEFAULT 0.01 COMMENT '报价格因子 默认0.01',
  `time_open` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '开始时间',
  `time_close` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '结束时间 和下一个开始时间相同 查询使用 between',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_coin_day_id_unique_index` (`coin_type`,`time_open`,`time_close`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `index_coin_week`;

CREATE TABLE `index_coin_week` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`coin_type` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `price_open` bigint NOT NULL DEFAULT 0 COMMENT '开 价格',
  `price_close` bigint NOT NULL DEFAULT 0 COMMENT '收 价格',
  `price_high` bigint NOT NULL DEFAULT 0 COMMENT '高 价格',
  `price_low` bigint NOT NULL DEFAULT 0 COMMENT '低 价格',
  `price_scale` bigint NOT NULL DEFAULT 100 COMMENT '价格因子 默认100 实际价格 = 价格／价格因子',
  `volume_val` bigint NOT NULL DEFAULT 0 COMMENT '成交量',
  `volume_scale` bigint NOT NULL DEFAULT 10000 COMMENT '成交量因子 默认10000 实际成交 = 成交量／成交量因子',
  `turnover_val` int NOT NULL DEFAULT 0 COMMENT '换手率',
  `turnover_scale` int NOT NULL DEFAULT 100 COMMENT '换手率因子 默认100 实际换手率 = 换手率／换手率因子',
  `coin_scale` decimal(20,9) NOT NULL DEFAULT 0.01 COMMENT '报价格因子 默认0.01',
  `time_open` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '开始时间',
  `time_close` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '结束时间 和下一个开始时间相同 查询使用 between',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_coin_week_id_unique_index` (`coin_type`,`time_open`,`time_close`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `index_coin_month`;

CREATE TABLE `index_coin_month` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
	`coin_type` varchar(255) NOT NULL DEFAULT '' COMMENT '代币类型',
  `price_open` bigint NOT NULL DEFAULT 0 COMMENT '开 价格',
  `price_close` bigint NOT NULL DEFAULT 0 COMMENT '收 价格',
  `price_high` bigint NOT NULL DEFAULT 0 COMMENT '高 价格',
  `price_low` bigint NOT NULL DEFAULT 0 COMMENT '低 价格',
  `price_scale` bigint NOT NULL DEFAULT 100 COMMENT '价格因子 默认100 实际价格 = 价格／价格因子',
  `volume_val` bigint NOT NULL DEFAULT 0 COMMENT '成交量',
  `volume_scale` bigint NOT NULL DEFAULT 10000 COMMENT '成交量因子 默认10000 实际成交 = 成交量／成交量因子',
  `turnover_val` int NOT NULL DEFAULT 0 COMMENT '换手率',
  `turnover_scale` int NOT NULL DEFAULT 100 COMMENT '换手率因子 默认100 实际换手率 = 换手率／换手率因子',
  `coin_scale` decimal(20,9) NOT NULL DEFAULT 0.01 COMMENT '报价格因子 默认0.01',
  `time_open` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '开始时间',
  `time_close` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '结束时间 和下一个开始时间相同 查询使用 between',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_coin_month_id_unique_index` (`coin_type`,`time_open`,`time_close`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

