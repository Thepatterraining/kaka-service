

alter table `voucher_info` add `voucher_model_getting` varchar(255) NOT NULL DEFAULT '' COMMENT '领取前置model',
add `voucher_model_getted` varchar(255) NOT NULL DEFAULT '' COMMENT '领取后置model',
add `voucher_model_useing` varchar(255) NOT NULL DEFAULT '' COMMENT '使用前置model',
add `voucher_model_used` varchar(255) NOT NULL DEFAULT '' COMMENT '使用后置model',
add `voucher_note` varchar(255) NOT NULL DEFAULT '' COMMENT '使用说明';