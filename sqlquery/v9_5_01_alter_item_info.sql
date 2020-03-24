alter table `item_info` add `first_year_rose` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '第一年涨幅',
add `second_year_rose` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '第二年涨幅',
add `third_year_rose` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '第三年涨幅',
add `fourth_year_rose` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '第四年涨幅',
add `fifth_year_rose` decimal(20,5) NOT NULL DEFAULT 0 COMMENT '第五年涨幅';

update `item_info` set `name` = '房产收益权系列001号' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `name` = '房产收益权系列002号' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `name` = '房产收益权系列003号' where `coin_type` = 'KKC-BJ0003';

update `item_info` set `rose` = '369' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `rose` = '301' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `rose` = '254' where `coin_type` = 'KKC-BJ0003';

update `item_info` set `first_year_rose` = '92' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `first_year_rose` = '96' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `first_year_rose` = '48' where `coin_type` = 'KKC-BJ0003';

update `item_info` set `second_year_rose` = '0' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `second_year_rose` = '6' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `second_year_rose` = '17' where `coin_type` = 'KKC-BJ0003';

update `item_info` set `third_year_rose` = '14' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `third_year_rose` = '-6' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `third_year_rose` = '-6' where `coin_type` = 'KKC-BJ0003';

update `item_info` set `fourth_year_rose` = '52' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `fourth_year_rose` = '34' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `fourth_year_rose` = '6' where `coin_type` = 'KKC-BJ0003';

update `item_info` set `fifth_year_rose` = '41' where `coin_type` = 'KKC-BJ0001';
update `item_info` set `fifth_year_rose` = '53' where `coin_type` = 'KKC-BJ0002';
update `item_info` set `fifth_year_rose` = '108' where `coin_type` = 'KKC-BJ0003';
