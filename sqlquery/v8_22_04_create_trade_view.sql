CREATE VIEW `transaction_view` AS SELECT s.sell_no as `no`, s.sell_count as `count`, s.sell_limit as `limit`, s.sell_userid as `userid`, s.sell_transcount as `transcount`, s.sell_status as `status`,s.sell_cointype as `cointype`, s.sell_scale as `scale`,s.sell_touser_showprice as `showprice`,s.sell_touser_showcount as `showcount`,s.created_at as `datetime`,s.sell_touser_feeprice as `feeprice`, s.sell_touser_feecount as `feecount`,s.sell_transammount as `averageprice`
FROM `transaction_sell` s 
where s.sell_leveltype = 'SL00'
union 
select b.buy_no as `no`, b.buy_count as `count`, b.buy_limit as `limit`, b.buy_userid as `userid`,b.buy_transcount as `transcount`,b.buy_status as `status`,b.buy_cointype as `cointype`,b.buy_scale as `scale`,b.buy_touser_showprice as `showprice`,b.buy_touser_showcount as `showcount`,b.created_at as `datetime`,b.buy_touser_feeprice as `feeprice`,b.buy_touser_feecount as `feecount`,b.buy_transammount as `averageprice`
from`transaction_buy` b;