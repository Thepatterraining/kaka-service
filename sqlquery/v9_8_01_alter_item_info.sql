alter table `item_info` add `insurance` varchar(20) NOT NULL DEFAULT '' COMMENT '保险公司',
add `bank` varchar(20) NOT NULL DEFAULT '' COMMENT '银行';

update `item_info` set `insurance` = '平安保险' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `insurance` = '阳光保险' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `insurance` = '平安保险' where `coin_type` = 'KKC-BJ0003';

update `item_info` set `bank` = '中国银行' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `bank` = '中国银行' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `bank` = '中国银行' where `coin_type` = 'KKC-BJ0003';
