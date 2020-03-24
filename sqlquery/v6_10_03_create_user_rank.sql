CREATE TABLE `user_rebate_rankday` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rank_user` bigint(20) DEFAULT NULL COMMENT '用户',
  `rank_index` bigint(20) DEFAULT NULL COMMENT '排名',
  `rank_rebate` decimal(20,3) DEFAULT NULL COMMENT '返佣金额',
  `rank_date` date DEFAULT NULL COMMENT '排行日期',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_id` bigint(20) DEFAULT NULL,
  `updated_id` bigint(20) DEFAULT NULL,
  `deleted_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rank` (`rank_date`,`rank_index`),
  KEY `money` (`rank_rebate`,`rank_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;