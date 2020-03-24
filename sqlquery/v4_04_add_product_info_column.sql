

-- 修改 product_info 表 增加字段
alter table `product_info` add `product_frozentime` bigint NOT NULL DEFAULT 0 COMMENT '冻结期';