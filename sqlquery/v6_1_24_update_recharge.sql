 
update `cash_recharge` set `cash_recharge_channel` = 2 where `cash_recharge_channel` = 0;
update  cash_recharge set cash_recharge_type = 'CRT02' where cash_recharge_no in (
select usercash_journal_jobno from user_cash_journal  where usercash_journal_type = 'CJ12' ) and cash_recharge_type ='CRT01';
