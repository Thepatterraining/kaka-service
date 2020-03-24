
truncate table `sys_user_type`;

INSERT INTO `sys_user_type` (`id`, `user_type_name`, `user_buy_cashfeetype`, `user_buy_cashfeerate`, `user_buy_coinfeetype`, `user_buy_coinfeerate`, `user_sell_cashfeetype`, `user_sell_cashfeerate`, `user_sell_coinfeetype`, `user_sell_coinfeerate`, `user_income_level`, `user_cost_level`, `user_next_income`, `user_next_cost`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `user_cash_withdrawalfeerate`, `user_coin_withdrawalfeerate`, `user_coin_sellfeehidden`, `user_coin_buyfeehidden`, `user_cash_buyfeehidden`, `user_cash_sellfeehidden`)
VALUES
	(null,'普通用户','FR02',0.00270,'FR00',0.00000,'FR00',0.00270,'FR00',0.00000,0.000,0.000,0.000,0.000,NULL,NULL,NULL,NULL,NULL,NULL,0.00200,0.00200,b'1',b'1',b'1',b'1'),
	(null,'vp用户','FR02',0.00270,'FR00',0.00000,'FR00',0.00270,'FR00',0.00000,0.000,0.000,0.000,0.000,NULL,NULL,NULL,NULL,NULL,NULL,0.02000,0.00200,b'1',b'1',b'1',b'1');