


-- 现金提现手续费率

update `cash_withdrawal` set `cash_withdrawal_rate` = `cash_withdrawal_rate` / 100;

update `sys_cash_fee` set `cash_withdrawal_rate` = 	`cash_withdrawal_rate` / 100;