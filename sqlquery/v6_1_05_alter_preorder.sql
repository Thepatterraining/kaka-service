


-- 现金提现手续费率

alter table `product_preorder` add `preorder_status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态 字典表 preorder_status  ，PROST00 新建，PROST01 已经充值  ，PROST02 已经买入';

alter table `product_preorder` add `preorder_rechargeno` varchar(30) NOT NULL DEFAULT '' COMMENT '充值单号';
alter table `product_preorder` add `preorder_buyno` varchar(255) NOT NULL DEFAULT '' COMMENT '买单号';

