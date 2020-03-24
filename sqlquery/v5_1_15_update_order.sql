

update `transaction_order` set `order_price` = `order_price` / 100;
update `transaction_order` set `order_scale` = 0.01;
update `transaction_order` set `order_touser_showcount` = `order_count` / 0.01;
update `transaction_order` inner join `transaction_buy` on transaction_order.order_buy_no=transaction_buy.buy_no set transaction_order.order_touser_showprice=transaction_buy.buy_touser_feeprice;




update `transaction_sell` set `sell_scale` = 0.01;
update `transaction_sell` set `sell_touser_showprice` = `sell_limit` * 0.01;
update `transaction_sell` set `sell_touser_showcount` = `sell_count` / 0.01;
update `transaction_sell` set `sell_touser_feeprice` = `sell_touser_showprice` / (1+`sell_feerate`);
update `transaction_sell` set `sell_touser_feecount` = `sell_touser_showcount`;


update `transaction_buy` set `buy_scale` = 0.01;
update `transaction_buy` set `buy_touser_showprice` = `buy_limit` * 0.01;
update `transaction_buy` set `buy_touser_showcount` = `buy_count` / 0.01;
update `transaction_buy` set `buy_touser_feeprice` = `buy_touser_showprice` * (1+`buy_cashfeerate`);
update `transaction_buy` set `buy_touser_feecount` = `buy_touser_showcount`;

