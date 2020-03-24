

INSERT INTO `sys_config` (`id`, `config_key`, `config_text`, `config_value`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,'MARKET_CASH_BUYFEETYPE','二级买方现金手续费类型','FR02',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'MARKET_CASH_SELLFEETYPE','二级卖方现金手续费类型','FR02',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'MARKET_COIN_BUYFEETYPE','二级买方代币手续费类型','FR00',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'MARKET_COIN_SELLFEETYPE','二级卖方代币手续费类型','FR00',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'MARKET_COIN_BUYFEERATE','二级买方代币费率','0',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'MARKET_COIN_SELLFEERATE','二级卖方代币费率','0',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'MARKET_CASH_BUYFEERATE','二级买方手续费','0.0027',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'MARKET_CASH_SELLFEERATE','二级卖方手续费','0.0027',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'LEAST_MARKET_CASH_BUYFEE','最小的二级买方手续费','0.01',NULL,NULL,NULL,NULL,NULL,NULL),
	(null,'LEAST_MARKET_CASH_SELLFEE','最小的二级卖方手续费','0.01',NULL,NULL,NULL,NULL,NULL,NULL);