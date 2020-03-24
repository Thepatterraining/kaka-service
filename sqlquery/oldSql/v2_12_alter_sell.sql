
-- 修改 transaction_sell 表默认值
UPDATE `transaction_sell` SET `sell_feetype` = 'FR00' WHERE `sell_feetype` = '';
UPDATE `transaction_sell` SET `sell_coinfeetype` = 'FR00' WHERE `sell_coinfeetype` = '';
UPDATE `transaction_sell` SET `sell_showcoinprice` = 1800 WHERE `sell_showcoinprice` = 0;
UPDATE `transaction_sell` SET `sell_showcoincount` = 1.31536 WHERE `sell_showcoincount` = 0;