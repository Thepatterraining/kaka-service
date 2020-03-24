CREATE TABLE `coin_transfer_log` (
create table `sys_application_version
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) NOT NULL DEFAULT '' COMMENT '交易号',
  `trans_type` varchar(30) DEFAULT 0 COMMENT 'TLT01.KYC TLT02.充币 TLT03.提币 TLT04．转让',
  `coin_type` varchar(255) DEFAULT '' COMMENT '代币类型',
  `from` varchar(255) NOT NULL DEFAULT '' COMMENT '转出地址',
  `to` varchar(255) NOT NULL DEFAULT '' COMMENT '转入地址',
  `gas` decimal(20,10) NOT NULL DEFAULT 0 COMMENT '油费',
  `block` bigint NOT NULL DEFAULT 0 COMMENT '区块号',
  `confirm` int NOT NULL DEFAULT 0 COMMENT '确认数',
  `amount` DECIMAL(20,9) NOT NULL DEFAULT 0 COMMENT '数量',
  `status` varchar(30) NOT NULL DEFAULT '' COMMENT 'TLS01 申请 TLS02 成功 TLS03 失败',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;