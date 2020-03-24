--
-- Table structure for table 3rd_user_info
--

DROP TABLE IF EXISTS 3rd_user_info;

CREATE TABLE 3rd_user_info (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `kkuserid` int unsigned DEFAULT 0 COMMENT '咔咔普通用户id',
  `appid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用id',
  `openid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用用户id',
  `unionid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '多个第三方应用共享id',
  `groupid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用群组id',
  `iswatch` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '是否关注',
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用用户昵称',
  `sex` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用用户性别',
  `language` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用用户语言',
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用用户城市',
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用用户省份',
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用用户国家',
  `headimgurl` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用用户头像地址',
  `privilege` text COLLATE utf8_unicode_ci COMMENT '第三方应用用户特权',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '记录入库时的服务器账号id',
  PRIMARY KEY (id),
  UNIQUE KEY `3rd_user_info_id_unique_index` (`appid`,`kkuserid`,`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
