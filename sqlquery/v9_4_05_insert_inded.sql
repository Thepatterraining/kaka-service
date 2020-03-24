truncate table `index_coin_day`;
truncate table `index_coin_hour`;
truncate table `index_coin_month`;
truncate table `index_coin_week`;

INSERT INTO `index_coin_day` (`coin_type`, `price_open`, `price_close`, `price_high`, `price_low`, `price_scale`, `volume_val`, `volume_scale`, `turnover_val`, `turnover_scale`, `coin_scale`, `time_open`, `time_close`, `created_at`, `updated_at`)
VALUES
	('KKC-BJ0001',200000,200000,200000,200000,100,0,10000,0,100,0.010000000,'2017-09-04 00:00:00','2017-09-05 00:00:00','2017-09-04 19:05:52','2017-09-04 19:06:00'),
	('KKC-BJ0002',156900,156900,156900,156900,100,0,10000,0,100,0.010000000,'2017-09-04 00:00:00','2017-09-05 00:00:00','2017-09-04 19:05:52','2017-09-04 19:06:00');

INSERT INTO `index_coin_hour` (`coin_type`, `price_open`, `price_close`, `price_high`, `price_low`, `price_scale`, `volume_val`, `volume_scale`, `turnover_val`, `turnover_scale`, `coin_scale`, `time_open`, `time_close`, `created_at`, `updated_at`)
VALUES
	('KKC-BJ0001',200000,200000,200000,200000,100,0,10000,0,100,0.010000000,'2017-09-04 00:00:00','2017-09-04 01:00:00','2017-09-04 19:29:19','2017-09-04 19:29:19'),
	('KKC-BJ0002',156900,156900,156900,156900,100,0,10000,0,100,0.010000000,'2017-09-04 00:00:00','2017-09-04 01:00:00','2017-09-04 20:31:24','2017-09-04 20:31:24');

INSERT INTO `index_coin_month` (`coin_type`, `price_open`, `price_close`, `price_high`, `price_low`, `price_scale`, `volume_val`, `volume_scale`, `turnover_val`, `turnover_scale`, `coin_scale`, `time_open`, `time_close`, `created_at`, `updated_at`)
VALUES
	('KKC-BJ0001',200000,200000,200000,200000,100,0,10000,0,100,0.010000000,'2017-09-01 00:00:00','2017-10-01 00:00:00','2017-09-01 16:24:02','2017-09-04 19:02:51'),
	('KKC-BJ0002',156900,156900,156900,156900,100,0,10000,0,100,0.010000000,'2017-09-01 00:00:00','2017-10-01 00:00:00','2017-09-04 19:05:52','2017-09-04 19:06:00');

INSERT INTO `index_coin_week` (`coin_type`, `price_open`, `price_close`, `price_high`, `price_low`, `price_scale`, `volume_val`, `volume_scale`, `turnover_val`, `turnover_scale`, `coin_scale`, `time_open`, `time_close`, `created_at`, `updated_at`)
VALUES
	("KKC-BJ0001",200000,200000,200000,200000,100,0,10000,0,100,0.010000000,'2017-09-04 00:00:00','2017-09-10 00:00:00','2017-09-04 11:12:02','2017-09-04 19:02:51'),
	('KKC-BJ0002',156900,156900,156900,156900,100,0,10000,0,100,0.010000000,'2017-09-04 00:00:00','2017-09-10 00:00:00','2017-09-04 19:05:52','2017-09-04 19:06:00');