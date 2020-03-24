

-- 修改撤销数据错误
update `transaction_sell` set `sell_touser_showcount` = `sell_touser_showcount` / `sell_scale` where `sell_touser_showcount` < `sell_touser_feecount`;