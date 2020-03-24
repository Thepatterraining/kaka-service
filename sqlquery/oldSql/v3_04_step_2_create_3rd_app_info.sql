--
-- Table structure for table 3rd_app_info
--

DROP TABLE IF EXISTS 3rd_app_info;

CREATE TABLE 3rd_app_info (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `appid` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用id',
  `appkey` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用key',
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用名称',
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方应用类型',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '最后更新时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '记录入库时的服务器账号id',
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
