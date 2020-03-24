alter table `item_info` add `starttime` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '开始上线时间';

update `item_info` set `starttime` = '2017-08-07' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `starttime` = '2018-01-01' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `starttime` = '2018-01-01' where `coin_type` = 'KKC-BJ0003';
update `item_info` set `starttime` = '2018-01-01' where `coin_type` = 'KKC-BJ0004';