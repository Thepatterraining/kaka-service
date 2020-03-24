


DROP TABLE IF EXISTS `transaction_contract`;

CREATE TABLE `transaction_contract` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `contract_no` varchar(50) NOT NULL DEFAULT '' COMMENT '合同号',
  `transaction_orderno` varchar(50) NOT NULL DEFAULT '' COMMENT '交易号',
  `first_no` varchar(18) NOT NULL DEFAULT '' COMMENT '甲方ID/身份证或企业识别号',
  `first_name` varchar(30) NOT NULL DEFAULT '' COMMENT '甲方名称',
  `first_agent` varchar(30) NOT NULL DEFAULT '' COMMENT '甲方代理人/法人/为个人时同名称',
  `frist_sign` varchar(255) NOT NULL DEFAULT '' COMMENT '甲方签章',
  `second_no` varchar(18) NOT NULL DEFAULT '' COMMENT '乙方ID/身份证或企业识别号',
  `second_name` varchar(30) NOT NULL DEFAULT '' COMMENT '乙方名称',
  `second_agent` varchar(30) NOT NULL DEFAULT '' COMMENT '乙方代理人/法人/为个人时同名称',
  `second_sign` varchar(255) NOT NULL DEFAULT '' COMMENT '乙方签章',
  `third_no` varchar(18) NOT NULL DEFAULT '' COMMENT '丙方ID/身份证或企业识别号',
  `third_name` varchar(30) NOT NULL DEFAULT '' COMMENT '丙方名称',
  `third_agent` varchar(30) NOT NULL DEFAULT '' COMMENT '丙方代理人/法人/为个人时同名称',
  `third_sign` varchar(255) NOT NULL DEFAULT '' COMMENT '丙方签章',
  `fourth_no` varchar(18) NOT NULL DEFAULT '' COMMENT '丁方ID/身份证或企业识别号',
  `fourth_name` varchar(30) NOT NULL DEFAULT '' COMMENT '丁方名称',
  `fourth_agent` varchar(30) NOT NULL DEFAULT '' COMMENT '丁方代理人/法人/为个人时同名称',
  `fourth_sign` varchar(255) NOT NULL DEFAULT '' COMMENT '丁方签章',
  `contract_date` datetime NOT NULL DEFAULT '1970-01-01' COMMENT '日期',
  `contract_rate` decimal(20,3) NOT NULL DEFAULT 0 COMMENT '费率',
  `contract_count` decimal(20,9) NOT NULL DEFAULT 0 COMMENT '转让比例',
  `contract_amount` decimal(20,2) NOT NULL DEFAULT 0 COMMENT '合同金额',
  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
  `updated_at` datetime DEFAULT NULL COMMENT '更新时间',
  `deleted_at` datetime DEFAULT NULL COMMENT '删除时间',
  `created_id` bigint(20) DEFAULT NULL COMMENT '创建人',
  `updated_id` bigint(20) DEFAULT NULL COMMENT '更新人',
  `deleted_id` bigint(20) DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;