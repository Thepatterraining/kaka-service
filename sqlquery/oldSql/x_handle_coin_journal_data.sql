

-- coin_journal

update `coin_journal` set `coin_journal_in` = coin_journal_in / 100;
update `coin_journal` set `coin_journal_out` = coin_journal_out / 100;
update `coin_journal` set `coin_journal_pending` = coin_journal_pending / 100;
update `coin_journal` set `coin_result_pending` = coin_result_pending / 100;
update `coin_journal` set `coin_result_cash` = coin_result_cash / 100;


-- coin_rechage

update `coin_rechage` set `coin_recharge_amount` = coin_recharge_amount / 100;

-- coin_withdrawal

update `coin_withdrawal` set `coin_withdrawal_amount` = coin_withdrawal_amount / 100;
update `coin_withdrawal` set `coin_withdrawal_fee` = coin_withdrawal_fee / 100;
update `coin_withdrawal` set `coin_withdrawal_out` = coin_withdrawal_out / 100;

-- product_info

update `product_info` set `product_count` = product_count / 100;
update `product_info` set `product_price` = product_price * 100;

-- sys_coin

update `sys_coin` set `syscoin_account_cash` = syscoin_account_cash / 100;
update `sys_coin` set `syscoin_account_pending` = syscoin_account_pending / 100;

-- sys_coin_account

update `sys_coin_account` set `account_cash` = account_cash / 100;
update `sys_coin_account` set `account_pending` = account_pending / 100;

-- sys_coin_fee

update `sys_coin_fee` set `coin_withdrawal_feeamount` = coin_withdrawal_feeamount / 100;

-- sys_coin_journal

update `sys_coin_journal` set `syscoin_journal_in` = syscoin_journal_in / 100;
update `sys_coin_journal` set `syscoin_journal_out` = syscoin_journal_out / 100;
update `sys_coin_journal` set `syscoin_journal_pending` = syscoin_journal_pending / 100;
update `sys_coin_journal` set `syscoin_result_pending` = syscoin_result_pending / 100;
update `sys_coin_journal` set `syscoin_result_cash` = syscoin_result_cash / 100;

-- transaction_buy

update `transaction_buy` set `buy_count` = buy_count / 100;
update `transaction_buy` set `buy_limit` = buy_limit * 100;
update `transaction_buy` set `buy_transcount` = buy_transcount / 100;
update `transaction_buy` set `buy_transammount` = buy_transammount * 100;
update `transaction_buy` set `buy_showprice` = buy_showprice * 100;
update `transaction_buy` set `buy_showcount` = buy_showcount / 100;

-- transaction_order

update `transaction_order` set `order_count` = order_count / 100;
update `transaction_order` set `order_price` = order_price * 100;
update `transaction_order` set `order_coin` = order_coin / 100;

-- transaction_sell

update `transaction_sell` set `sell_count` = sell_count / 100;
update `transaction_sell` set `sell_limit` = sell_limit * 100;
update `transaction_sell` set `sell_transcount` = sell_transcount / 100;
update `transaction_sell` set `sell_showcoinprice` = sell_showcoinprice * 100;
update `transaction_sell` set `sell_showcoincount` = sell_showcoincount / 100;

-- user_coin_account

update `user_coin_account` set `usercoin_cash` = usercoin_cash / 100;
update `user_coin_account` set `usercoin_pending` = usercoin_pending / 100;

-- user_coin_journal

update `user_coin_journal` set `usercoin_journal_in` = usercoin_journal_in / 100;
update `user_coin_journal` set `usercoin_journal_out` = usercoin_journal_out / 100;
update `user_coin_journal` set `usercoin_journal_pending` = usercoin_journal_pending / 100;
update `user_coin_journal` set `usercoin_result_pending` = usercoin_result_pending / 100;
update `user_coin_journal` set `usercoin_result_cash` = usercoin_result_cash / 100;

-- user_order

update `user_order` set `userorder_price` = userorder_price * 100;
update `user_order` set `userorder_coin` = userorder_coin / 100;

