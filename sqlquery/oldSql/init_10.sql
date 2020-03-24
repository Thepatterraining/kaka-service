-- 管理员表
DROP TABLE IF EXISTS `auth_user`;

CREATE TABLE `auth_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `auth_id` varchar(255) NOT NULL DEFAULT '' COMMENT '登录名',
  `auth_nickname` varchar(255) NOT NULL DEFAULT '' COMMENT '昵称',
  `auth_name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `auth_idno` varchar(255) NOT NULL DEFAULT '' COMMENT '身份证号',
  `auth_headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `auth_sex` varchar(255) NOT NULL DEFAULT '' COMMENT '性别',
  `auth_mobile` varchar(255) NOT NULL DEFAULT '' COMMENT '手机',
  `auth_pwd` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `auth_status` varchar(255) NOT NULL DEFAULT '' COMMENT '用户状态',
  `auth_lastlogin` varchar(255) NOT NULL DEFAULT '' COMMENT '上次登陆时间',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 管理员登陆日志
DROP TABLE IF EXISTS `auth_login_log`;

CREATE TABLE `auth_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `auth_user_id` int(11) NOT NULL DEFAULT 0 COMMENT '用户id',
  `login_type` char(10) NOT NULL DEFAULT '' COMMENT '登陆类型-字典表',
  `login_time` datetime COMMENT '登陆时间',
  `login_add` varchar(255) NOT NULL DEFAULT '' COMMENT '物理地点',
  `login_mac` varchar(255) NOT NULL DEFAULT '' COMMENT '地址／设备码',
  `login_ip` varchar(255) NOT NULL DEFAULT '' COMMENT '登陆ip',
  `login_token` varchar(255) NOT NULL DEFAULT '' COMMENT '登录时的accestken',
  `created_at` datetime COMMENT '创建时间',
  `updated_at` datetime COMMENT '更新时间',
  `deleted_at` datetime COMMENT '删除时间',
  `created_id` bigint COMMENT '创建人',
  `updated_id` bigint COMMENT '更新人',
  `deleted_id` bigint COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;