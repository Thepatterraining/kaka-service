

-- 配置表
DROP TABLE IF EXISTS `sys_config`;

CREATE TABLE `sys_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `config_key` varchar(255) NOT NULL DEFAULT '' COMMENT '设置的key值',
  `config_text` varchar(255) NOT NULL DEFAULT '' COMMENT '设置说明',
  `config_value` varchar(255) NOT NULL DEFAULT '' COMMENT '设置值',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `sys_config` (`id`, `config_key`, `config_text`, `config_value`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(1,'CASH_WITHDRAWALFEERATE','提现手续费','0.002',NULL,NULL,NULL,NULL,NULL,NULL),
	(2,'CASH_BUYFEERATE','买方手续费','0.0027',NULL,NULL,NULL,NULL,NULL,NULL),
	(3,'CASH_SELLFEERATE','卖方手续费','0.0027',NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'CASH_BUYFEEHIDDEN','手续费是否对外可见','1',NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'CASH_SELLFEEHIDDEN','手续费是否对外可见','1',NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'COIN_WITHDRAWALFEERATE','代币提现手续费率','0.002',NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'COIN_BUYFEERATE','买方代币费率','0',NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'COIN_SELLFEERATE','卖方代币费率','0',NULL,NULL,NULL,NULL,NULL,NULL),
	(9,'CASH_BUYFEETYPE','买方现金手续费类型','FR02',NULL,NULL,NULL,NULL,NULL,NULL),
	(10,'CASH_SELLFEETYPE','卖方现金手续费类型','FR01',NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'COIN_BUYFEETYPE','买方代币手续费类型','FR00',NULL,NULL,NULL,NULL,NULL,NULL),
	(12,'COIN_SELLFEETYPE','卖方代币手续费类型','FR00',NULL,NULL,NULL,NULL,NULL,NULL),
	(13,'COIN_SELLFEEHIDDEN','手续费是否对外可见','1',NULL,NULL,NULL,NULL,NULL,NULL),
	(14,'COIN_BUYFEEHIDDEN','手续费是否对外可见','1',NULL,NULL,NULL,NULL,NULL,NULL),
	(15,'PRODUCT_FREEZETIME','项目锁定期','7776000',NULL,NULL,NULL,NULL,NULL,NULL),
	(16,'REQ_REQUIRECODE','是否启用只用用邀请码注册','1',NULL,NULL,NULL,NULL,NULL,NULL),
	(17,'REQ_CODE_LENGTH','邀请码长度','8',NULL,NULL,NULL,NULL,NULL,NULL);