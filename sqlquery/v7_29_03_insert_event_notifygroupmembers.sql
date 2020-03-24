truncate table `event_notifygroupmembers`;
INSERT INTO `event_notifygroupmembers` (`id`,`group_id`,`authuser_id`,`authuser_name`, `authuser_email`, `authuser_mobile`, `authuser_openid`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`)
VALUES
	(null,1,8,"孙宏拾","sunhongshi@kakamf.com","13466799490",NULL,NULL,null,NULL,NULL,NULL,null),
	(null,1,11,"许洋","xuyang@kakamf.com","13801302010",NULL,NULL,null,NULL,NULL,NULL,null),
	(null,1,12,"葛云飞","geyunfei@kakamf.com","13521510781",NULL,NULL,null,NULL,NULL,NULL,null);