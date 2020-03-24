

alter table `item_info`   
Add column `cost_price` decimal(20,3) not null default 0 COMMENT '成本价格';

update `item_info` set `cost_price` = '1476' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `cost_price` = '1493' where `coin_type` = 'KKC-BJ0002';