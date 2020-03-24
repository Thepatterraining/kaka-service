

-- 更新原来充值的通道
update `cash_recharge` set `cash_recharge_channel` = 3 where `cash_recharge_type` = 'CRT01';
update `cash_recharge` set `cash_recharge_channel` = 2 where `cash_recharge_status` in ('CR03','CR04','CR05');