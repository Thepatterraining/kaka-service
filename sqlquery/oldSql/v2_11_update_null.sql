

-- 修改 activity_info 表默认值
UPDATE `activity_info` SET `activity_no` = '' WHERE `activity_no` = 'null';
UPDATE `activity_info` SET `activity_name` = '' WHERE `activity_name` = 'null';
UPDATE `activity_info` SET `activity_limittype` = '' WHERE `activity_limittype` = 'null';
UPDATE `activity_info` SET `activity_event` = '' WHERE `activity_event` = 'null';
UPDATE `activity_info` SET `activity_filter` = '' WHERE `activity_filter` = 'null';
UPDATE `activity_info` SET `activity_code` = '' WHERE `activity_code` = 'null';
UPDATE `activity_info` SET `activity_status` = '' WHERE `activity_status` = 'null';


-- 修改 activity_invitation 表默认值
UPDATE `activity_invitation` SET `inviitation_no` = '' WHERE `inviitation_no` = 'null';
UPDATE `activity_invitation` SET `inviitation_code` = '' WHERE `inviitation_code` = 'null';
UPDATE `activity_invitation` SET `inviitation_type` = '' WHERE `inviitation_type` = 'null';
UPDATE `activity_invitation` SET `inviitation_reguser` = '' WHERE `inviitation_reguser` = 'null';
UPDATE `activity_invitation` SET `inviitation_user` = '' WHERE `inviitation_user` = 'null';


-- 修改 activity_item 表默认值
UPDATE `activity_item` SET `activity_no` = '' WHERE `activity_no` = 'null';
UPDATE `activity_item` SET `activity_itemtype` = '' WHERE `activity_itemtype` = 'null';
UPDATE `activity_item` SET `activity_itemno` = '' WHERE `activity_itemno` = 'null';


-- 修改 auth_login_log 表默认值
UPDATE `auth_login_log` SET `login_type` = '' WHERE `login_type` = 'null';
UPDATE `auth_login_log` SET `login_add` = '' WHERE `login_add` = 'null';
UPDATE `auth_login_log` SET `login_mac` = '' WHERE `login_mac` = 'null';
UPDATE `auth_login_log` SET `login_ip` = '' WHERE `login_ip` = 'null';
UPDATE `auth_login_log` SET `login_token` = '' WHERE `login_token` = 'null';


-- 修改 auth_user 表默认值
UPDATE `auth_user` SET `auth_id` = '' WHERE `auth_id` = 'null';
UPDATE `auth_user` SET `auth_nickname` = '' WHERE `auth_nickname` = 'null';
UPDATE `auth_user` SET `auth_name` = '' WHERE `auth_name` = 'null';
UPDATE `auth_user` SET `auth_idno` = '' WHERE `auth_idno` = 'null';
UPDATE `auth_user` SET `auth_headimgurl` = '' WHERE `auth_headimgurl` = 'null';
UPDATE `auth_user` SET `auth_sex` = '' WHERE `auth_sex` = 'null';
UPDATE `auth_user` SET `auth_mobile` = '' WHERE `auth_mobile` = 'null';
UPDATE `auth_user` SET `auth_pwd` = '' WHERE `auth_pwd` = 'null';
UPDATE `auth_user` SET `auth_status` = '' WHERE `auth_status` = 'null';
UPDATE `auth_user` SET `auth_lastlogin` = '' WHERE `auth_lastlogin` = 'null';


-- 修改 cash_bank_account 表默认值
UPDATE `cash_bank_account` SET `account_no` = '' WHERE `account_no` = 'null';
UPDATE `cash_bank_account` SET `account_name` = '' WHERE `account_name` = 'null';


-- 修改 cash_journal 表默认值
UPDATE `cash_journal` SET `cash_journal_no` = '' WHERE `cash_journal_no` = 'null';
UPDATE `cash_journal` SET `cash_journal_type` = '' WHERE `cash_journal_type` = 'null';
UPDATE `cash_journal` SET `cash_journal_jobno` = '' WHERE `cash_journal_jobno` = 'null';
UPDATE `cash_journal` SET `cash_journal_status` = '' WHERE `cash_journal_status` = 'null';
UPDATE `cash_journal` SET `hash` = '' WHERE `hash` = 'null';



-- 修改 cash_recharge 表默认值
UPDATE `cash_recharge` SET `cash_recharge_no` = '' WHERE `cash_recharge_no` = 'null';
UPDATE `cash_recharge` SET `cash_recharge_phone` = '' WHERE `cash_recharge_phone` = 'null';
UPDATE `cash_recharge` SET `cash_recharge_status` = '' WHERE `cash_recharge_status` = 'null';
UPDATE `cash_recharge` SET `cash_recharge_body` = '' WHERE `cash_recharge_body` = 'null';
UPDATE `cash_recharge` SET `cash_recharge_bankid` = '' WHERE `cash_recharge_bankid` = 'null';
UPDATE `cash_recharge` SET `cash_recharge_type` = '' WHERE `cash_recharge_type` = 'null';


-- 修改 cash_withdrawal 表默认值
UPDATE `cash_withdrawal` SET `cash_withdrawal_no` = '' WHERE `cash_withdrawal_no` = 'null';
UPDATE `cash_withdrawal` SET `cash_withdrawal_status` = '' WHERE `cash_withdrawal_status` = 'null';
UPDATE `cash_withdrawal` SET `cash_withdrawal_body` = '' WHERE `cash_withdrawal_body` = 'null';
UPDATE `cash_withdrawal` SET `cash_withdrawal_type` = '' WHERE `cash_withdrawal_type` = 'null';



-- 修改 coin_journal 表默认值
UPDATE `coin_journal` SET `coin_journal_no` = '' WHERE `coin_journal_no` = 'null';
UPDATE `coin_journal` SET `coin_journal_cointtype` = '' WHERE `coin_journal_cointtype` = 'null';
UPDATE `coin_journal` SET `coin_journal_status` = '' WHERE `coin_journal_status` = 'null';
UPDATE `coin_journal` SET `coin_journal_jobno` = '' WHERE `coin_journal_jobno` = 'null';
UPDATE `coin_journal` SET `coin_journal_type` = '' WHERE `coin_journal_type` = 'null';
UPDATE `coin_journal` SET `hash` = '' WHERE `hash` = 'null';


-- 修改 coin_rechage 表默认值
UPDATE `coin_rechage` SET `coin_recharge_no` = '' WHERE `coin_recharge_no` = 'null';
UPDATE `coin_rechage` SET `coin_recharge_cointype` = '' WHERE `coin_recharge_cointype` = 'null';
UPDATE `coin_rechage` SET `coin_recharge_status` = '' WHERE `coin_recharge_status` = 'null';
UPDATE `coin_rechage` SET `coin_recharge_address` = '' WHERE `coin_recharge_address` = 'null';
UPDATE `coin_rechage` SET `coin_recharge_type` = '' WHERE `coin_recharge_type` = 'null';



-- 修改 coin_withdrawal 表默认值
UPDATE `coin_withdrawal` SET `coin_withdrawal_no` = '' WHERE `coin_withdrawal_no` = 'null';
UPDATE `coin_withdrawal` SET `coin_withdrawal_cointype` = '' WHERE `coin_withdrawal_cointype` = 'null';
UPDATE `coin_withdrawal` SET `coin_withdrawal_status` = '' WHERE `coin_withdrawal_status` = 'null';
UPDATE `coin_withdrawal` SET `coin_withdrawal_toaddress` = '' WHERE `coin_withdrawal_toaddress` = 'null';
UPDATE `coin_withdrawal` SET `coin_withdrawal_fromaddress` = '' WHERE `coin_withdrawal_fromaddress` = 'null';
UPDATE `coin_withdrawal` SET `coin_withdrawal_type` = '' WHERE `coin_withdrawal_type` = 'null';


-- 修改 item_formula 表默认值
UPDATE `item_formula` SET `coin_type` = '' WHERE `coin_type` = 'null';
UPDATE `item_formula` SET `iamge` = '' WHERE `iamge` = 'null';
UPDATE `item_formula` SET `file` = '' WHERE `file` = 'null';
UPDATE `item_formula` SET `file_name` = '' WHERE `file_name` = 'null';
UPDATE `item_formula` SET `type` = '' WHERE `type` = 'null';

-- 修改 item_info 表默认值
UPDATE `item_info` SET `name` = '' WHERE `name` = 'null';
UPDATE `item_info` SET `coin_type` = '' WHERE `coin_type` = 'null';
UPDATE `item_info` SET `kk_name` = '' WHERE `kk_name` = 'null';
UPDATE `item_info` SET `compound` = '' WHERE `compound` = 'null';
UPDATE `item_info` SET `layout` = '' WHERE `layout` = 'null';
UPDATE `item_info` SET `diqu` = '' WHERE `diqu` = 'null';
UPDATE `item_info` SET `trade` = '' WHERE `trade` = 'null';
UPDATE `item_info` SET `number` = '' WHERE `number` = 'null';
UPDATE `item_info` SET `age` = '' WHERE `age` = 'null';
UPDATE `item_info` SET `rowards` = '' WHERE `rowards` = 'null';
UPDATE `item_info` SET `renovation` = '' WHERE `renovation` = 'null';
UPDATE `item_info` SET `school` = '' WHERE `school` = 'null';
UPDATE `item_info` SET `metro` = '' WHERE `metro` = 'null';
UPDATE `item_info` SET `school_district` = '' WHERE `school_district` = 'null';



-- 修改 item_quarters 表默认值
UPDATE `item_quarters` SET `coin_type` = '' WHERE `coin_type` = 'null';
UPDATE `item_quarters` SET `layout` = '' WHERE `layout` = 'null';
UPDATE `item_quarters` SET `space` = '' WHERE `space` = 'null';
UPDATE `item_quarters` SET `age` = '' WHERE `age` = 'null';
UPDATE `item_quarters` SET `rowards` = '' WHERE `rowards` = 'null';
UPDATE `item_quarters` SET `number` = '' WHERE `number` = 'null';


-- 修改 sys_3rd_account 表默认值
UPDATE `sys_3rd_account` SET `sys_3rd_type` = '' WHERE `sys_3rd_type` = 'null';
UPDATE `sys_3rd_account` SET `sys_3rd_name` = '' WHERE `sys_3rd_name` = 'null';
UPDATE `sys_3rd_account` SET `sys_3rd_account` = '' WHERE `sys_3rd_account` = 'null';
UPDATE `sys_3rd_account` SET `sys_3rd_key` = '' WHERE `sys_3rd_key` = 'null';
UPDATE `sys_3rd_account` SET `sys_3rd_secrect` = '' WHERE `sys_3rd_secrect` = 'null';


-- 修改 sys_bank 表默认值
UPDATE `sys_bank` SET `bank_type` = '' WHERE `bank_type` = 'null';
UPDATE `sys_bank` SET `bank_name` = '' WHERE `bank_name` = 'null';
UPDATE `sys_bank` SET `bank_add` = '' WHERE `bank_add` = 'null';
UPDATE `sys_bank` SET `bank_no` = '' WHERE `bank_no` = 'null';


-- 修改 sys_cash_fee 表默认值
UPDATE `sys_cash_fee` SET `cash_withdrawal_feeno` = '' WHERE `cash_withdrawal_feeno` = 'null';
UPDATE `sys_cash_fee` SET `cash_withdrawal_feestatus` = '' WHERE `cash_withdrawal_feestatus` = 'null';
UPDATE `sys_cash_fee` SET `cash_withdrawal_no` = '' WHERE `cash_withdrawal_no` = 'null';
UPDATE `sys_cash_fee` SET `cash_withdrawal_feetype` = '' WHERE `cash_withdrawal_feetype` = 'null';




-- 修改 sys_cash_journal 表默认值
UPDATE `sys_cash_journal` SET `syscash_journal_no` = '' WHERE `syscash_journal_no` = 'null';
UPDATE `sys_cash_journal` SET `syscash_journal_type` = '' WHERE `syscash_journal_type` = 'null';
UPDATE `sys_cash_journal` SET `syscash_journal_jobno` = '' WHERE `syscash_journal_jobno` = 'null';
UPDATE `sys_cash_journal` SET `syscash_journal_status` = '' WHERE `syscash_journal_status` = 'null';
UPDATE `sys_cash_journal` SET `hash` = '' WHERE `hash` = 'null';



-- 修改 sys_coin 表默认值
UPDATE `sys_coin` SET `syscoin_account_type` = '' WHERE `syscoin_account_type` = 'null';
UPDATE `sys_coin` SET `syscoin_account_address` = '' WHERE `syscoin_account_address` = 'null';



-- 修改 sys_coin_account 表默认值
UPDATE `sys_coin_account` SET `account_type` = '' WHERE `account_type` = 'null';
UPDATE `sys_coin_account` SET `account_address` = '' WHERE `account_address` = 'null';


-- 修改 sys_coin_fee 表默认值
UPDATE `sys_coin_fee` SET `coin_withdrawal_feeno` = '' WHERE `coin_withdrawal_feeno` = 'null';
UPDATE `sys_coin_fee` SET `coin_withdrawal_no` = '' WHERE `coin_withdrawal_no` = 'null';
UPDATE `sys_coin_fee` SET `coin_withdrawal_cointype` = '' WHERE `coin_withdrawal_cointype` = 'null';
UPDATE `sys_coin_fee` SET `coin_withdrawal_feestatus` = '' WHERE `coin_withdrawal_feestatus` = 'null';
UPDATE `sys_coin_fee` SET `coin_withdrawal_feetype` = '' WHERE `coin_withdrawal_feetype` = 'null';


-- 修改 sys_coin_journal 表默认值
UPDATE `sys_coin_journal` SET `syscoin_journal_no` = '' WHERE `syscoin_journal_no` = 'null';
UPDATE `sys_coin_journal` SET `syscoin_journal_type` = '' WHERE `syscoin_journal_type` = 'null';
UPDATE `sys_coin_journal` SET `syscoin_journal_jobno` = '' WHERE `syscoin_journal_jobno` = 'null';
UPDATE `sys_coin_journal` SET `syscoin_journal_status` = '' WHERE `syscoin_journal_status` = 'null';
UPDATE `sys_coin_journal` SET `hash` = '' WHERE `hash` = 'null';
UPDATE `sys_coin_journal` SET `syscoin_coin_type` = '' WHERE `syscoin_coin_type` = 'null';


-- 修改 sys_dictionary 表默认值
UPDATE `sys_dictionary` SET `dic_no` = '' WHERE `dic_no` = 'null';
UPDATE `sys_dictionary` SET `dic_type` = '' WHERE `dic_type` = 'null';
UPDATE `sys_dictionary` SET `dic_name` = '' WHERE `dic_name` = 'null';


-- 修改 sys_error 表默认值
UPDATE `sys_error` SET `error_msg` = '' WHERE `error_msg` = 'null';


-- 修改 sys_log 表默认值
UPDATE `sys_log` SET `token` = '' WHERE `token` = 'null';
UPDATE `sys_log` SET `url` = '' WHERE `url` = 'null';


-- 修改 sys_login_log 表默认值
UPDATE `sys_login_log` SET `login_type` = '' WHERE `login_type` = 'null';
UPDATE `sys_login_log` SET `login_add` = '' WHERE `login_add` = 'null';
UPDATE `sys_login_log` SET `login_mac` = '' WHERE `login_mac` = 'null';
UPDATE `sys_login_log` SET `login_ip` = '' WHERE `login_ip` = 'null';
UPDATE `sys_login_log` SET `login_token` = '' WHERE `login_token` = 'null';


-- 修改 sys_mail 表默认值
UPDATE `sys_mail` SET `mail_type` = '' WHERE `mail_type` = 'null';
UPDATE `sys_mail` SET `mail_define` = '' WHERE `mail_define` = 'null';
UPDATE `sys_mail` SET `mail_url` = '' WHERE `mail_url` = 'null';
UPDATE `sys_mail` SET `mail_filter` = '' WHERE `mail_filter` = 'null';
UPDATE `sys_mail` SET `mail_user_filter` = '' WHERE `mail_user_filter` = 'null';
UPDATE `sys_mail` SET `mail_event` = '' WHERE `mail_event` = 'null';



-- 修改 sys_mail_log 表默认值
UPDATE `sys_mail_log` SET `mail_text` = '' WHERE `mail_text` = 'null';
UPDATE `sys_mail_log` SET `mail_status` = '' WHERE `mail_status` = 'null';
UPDATE `sys_mail_log` SET `mail_to` = '' WHERE `mail_to` = 'null';


-- 修改 sys_message 表默认值
UPDATE `sys_message` SET `msg_text` = '' WHERE `msg_text` = 'null';
UPDATE `sys_message` SET `msg_url` = '' WHERE `msg_url` = 'null';
UPDATE `sys_message` SET `msg_status` = '' WHERE `msg_status` = 'null';
UPDATE `sys_message` SET `msg_model` = '' WHERE `msg_model` = 'null';
UPDATE `sys_message` SET `msg_docno` = '' WHERE `msg_docno` = 'null';
UPDATE `sys_message` SET `msg_type` = '' WHERE `msg_type` = 'null';
UPDATE `sys_message` SET `msg_no` = '' WHERE `msg_no` = 'null';



-- 修改 sys_news 表默认值
UPDATE `sys_news` SET `news_no` = '' WHERE `news_no` = 'null';
UPDATE `sys_news` SET `news_title` = '' WHERE `news_title` = 'null';
UPDATE `sys_news` SET `news_subtitle` = '' WHERE `news_subtitle` = 'null';
UPDATE `sys_news` SET `news_intro` = '' WHERE `news_intro` = 'null';
UPDATE `sys_news` SET `news_writer` = '' WHERE `news_writer` = 'null';
UPDATE `sys_news` SET `news_source` = '' WHERE `news_source` = 'null';
UPDATE `sys_news` SET `news_type` = '' WHERE `news_type` = 'null';
UPDATE `sys_news` SET `news_pushtype` = '' WHERE `news_pushtype` = 'null';
UPDATE `sys_news` SET `news_refmodel` = '' WHERE `news_refmodel` = 'null';
UPDATE `sys_news` SET `news_refno` = '' WHERE `news_refno` = 'null';
UPDATE `sys_news` SET `news_refurl` = '' WHERE `news_refurl` = 'null';



-- 修改 sys_notify 表默认值
UPDATE `sys_notify` SET `notify_type` = '' WHERE `notify_type` = 'null';
UPDATE `sys_notify` SET `notify_user_filter` = '' WHERE `notify_user_filter` = 'null';
UPDATE `sys_notify` SET `noiffy_event` = '' WHERE `noiffy_event` = 'null';
UPDATE `sys_notify` SET `notify_model` = '' WHERE `notify_model` = 'null';



-- 修改 sys_sms_log 表默认值
UPDATE `sys_sms_log` SET `mobile` = '' WHERE `mobile` = 'null';
UPDATE `sys_sms_log` SET `sms_type` = '' WHERE `sms_type` = 'null';
UPDATE `sys_sms_log` SET `sms_text` = '' WHERE `sms_text` = 'null';
UPDATE `sys_sms_log` SET `sms_status` = '' WHERE `sms_status` = 'null';
UPDATE `sys_sms_log` SET `sms_body` = '' WHERE `sms_body` = 'null';


-- 修改 sys_user 表默认值
UPDATE `sys_user` SET `user_id` = '' WHERE `user_id` = 'null';
UPDATE `sys_user` SET `user_nickname` = '' WHERE `user_nickname` = 'null';
UPDATE `sys_user` SET `user_name` = '' WHERE `user_name` = 'null';
UPDATE `sys_user` SET `user_idno` = '' WHERE `user_idno` = 'null';
UPDATE `sys_user` SET `user_headimgurl` = '' WHERE `user_headimgurl` = 'null';
UPDATE `sys_user` SET `user_sex` = '' WHERE `user_sex` = 'null';
UPDATE `sys_user` SET `user_mobile` = '' WHERE `user_mobile` = 'null';
UPDATE `sys_user` SET `user_pwd` = '' WHERE `user_pwd` = 'null';
UPDATE `sys_user` SET `user_paypwd` = '' WHERE `user_paypwd` = 'null';
UPDATE `sys_user` SET `user_status` = '' WHERE `user_status` = 'null';



-- 修改 transaction_buy 表默认值
UPDATE `transaction_buy` SET `buy_no` = '' WHERE `buy_no` = 'null';
UPDATE `transaction_buy` SET `buy_status` = '' WHERE `buy_status` = 'null';
UPDATE `transaction_buy` SET `buy_cointype` = '' WHERE `buy_cointype` = 'null';
UPDATE `transaction_buy` SET `buy_region` = '' WHERE `buy_region` = 'null';




-- 修改 transaction_order 表默认值
UPDATE `transaction_order` SET `order_no` = '' WHERE `order_no` = 'null';
UPDATE `transaction_order` SET `order_buy_no` = '' WHERE `order_buy_no` = 'null';
UPDATE `transaction_order` SET `order_sell_no` = '' WHERE `order_sell_no` = 'null';
UPDATE `transaction_order` SET `order_coin_type` = '' WHERE `order_coin_type` = 'null';




-- 修改 transaction_sell 表默认值
UPDATE `transaction_sell` SET `sell_no` = '' WHERE `sell_no` = 'null';
UPDATE `transaction_sell` SET `sell_status` = '' WHERE `sell_status` = 'null';
UPDATE `transaction_sell` SET `sell_leveltype` = '' WHERE `sell_leveltype` = 'null';
UPDATE `transaction_sell` SET `sell_cointype` = '' WHERE `sell_cointype` = 'null';
UPDATE `transaction_sell` SET `sell_region` = '' WHERE `sell_region` = 'null';



-- 修改 user_bank_account 表默认值
UPDATE `user_bank_account` SET `account_no` = '' WHERE `account_no` = 'null';
UPDATE `user_bank_account` SET `account_name` = '' WHERE `account_name` = 'null';



-- 修改 user_cash_journal 表默认值
UPDATE `user_cash_journal` SET `usercash_journal_no` = '' WHERE `usercash_journal_no` = 'null';
UPDATE `user_cash_journal` SET `usercash_journal_type` = '' WHERE `usercash_journal_type` = 'null';
UPDATE `user_cash_journal` SET `usercash_journal_jobno` = '' WHERE `usercash_journal_jobno` = 'null';
UPDATE `user_cash_journal` SET `usercash_journal_status` = '' WHERE `usercash_journal_status` = 'null';
UPDATE `user_cash_journal` SET `hash` = '' WHERE `hash` = 'null';



-- 修改 user_cash_order 表默认值
UPDATE `user_cash_order` SET `usercashorder_no` = '' WHERE `usercashorder_no` = 'null';
UPDATE `user_cash_order` SET `usercashorder_type` = '' WHERE `usercashorder_type` = 'null';
UPDATE `user_cash_order` SET `usercashorder_jobno` = '' WHERE `usercashorder_jobno` = 'null';



-- 修改 user_coin_account 表默认值
UPDATE `user_coin_account` SET `usercoin_cointype` = '' WHERE `usercoin_cointype` = 'null';
UPDATE `user_coin_account` SET `usercoin_address` = '' WHERE `usercoin_address` = 'null';



-- 修改 user_coin_frozen 表默认值
UPDATE `user_coin_frozen` SET `frozen_no` = '' WHERE `frozen_no` = 'null';
UPDATE `user_coin_frozen` SET `frozen_cointtype` = '' WHERE `frozen_cointtype` = 'null';
UPDATE `user_coin_frozen` SET `frozen_userid` = '' WHERE `frozen_userid` = 'null';
UPDATE `user_coin_frozen` SET `frozen_type` = '' WHERE `frozen_type` = 'null';
UPDATE `user_coin_frozen` SET `frozen_jobno` = '' WHERE `frozen_jobno` = 'null';
UPDATE `user_coin_frozen` SET `frozen_status` = '' WHERE `frozen_status` = 'null';



-- 修改 user_coin_journal 表默认值
UPDATE `user_coin_journal` SET `usercoin_journal_no` = '' WHERE `usercoin_journal_no` = 'null';
UPDATE `user_coin_journal` SET `usercoin_journal_type` = '' WHERE `usercoin_journal_type` = 'null';
UPDATE `user_coin_journal` SET `usercoin_journal_jobno` = '' WHERE `usercoin_journal_jobno` = 'null';
UPDATE `user_coin_journal` SET `usercoin_journal_status` = '' WHERE `usercoin_journal_status` = 'null';
UPDATE `user_coin_journal` SET `usercoin_journal_cointype` = '' WHERE `usercoin_journal_cointype` = 'null';
UPDATE `user_coin_journal` SET `hash` = '' WHERE `hash` = 'null';



-- 修改 user_order 表默认值
UPDATE `user_order` SET `userorder_no` = '' WHERE `userorder_no` = 'null';
UPDATE `user_order` SET `userorder_type` = '' WHERE `userorder_type` = 'null';
UPDATE `user_order` SET `userorder_jobno` = '' WHERE `userorder_jobno` = 'null';
UPDATE `user_order` SET `userorder_orderno` = '' WHERE `userorder_orderno` = 'null';
UPDATE `user_order` SET `userorder_cointype` = '' WHERE `userorder_cointype` = 'null';
UPDATE `user_order` SET `userorder_discounttype` = '' WHERE `userorder_discounttype` = 'null';
UPDATE `user_order` SET `userorder_discountno` = '' WHERE `userorder_discountno` = 'null';
UPDATE `user_order` SET `userorder_userid` = '' WHERE `userorder_userid` = 'null';



-- 修改 voucher_info 表默认值
UPDATE `voucher_info` SET `vaucher_no` = '' WHERE `vaucher_no` = 'null';
UPDATE `voucher_info` SET `vaucher_name` = '' WHERE `vaucher_name` = 'null';
UPDATE `voucher_info` SET `vaucher_type` = '' WHERE `vaucher_type` = 'null';
UPDATE `voucher_info` SET `voucher_model` = '' WHERE `voucher_model` = 'null';
UPDATE `voucher_info` SET `voucher_event` = '' WHERE `voucher_event` = 'null';
UPDATE `voucher_info` SET `voucher_filter` = '' WHERE `voucher_filter` = 'null';



-- 修改 voucher_storage 表默认值
UPDATE `voucher_storage` SET `vaucherstorage_no` = '' WHERE `vaucherstorage_no` = 'null';
UPDATE `voucher_storage` SET `vaucherstorage_voucherno` = '' WHERE `vaucherstorage_voucherno` = 'null';
UPDATE `voucher_storage` SET `vaucherstorage_activity` = '' WHERE `vaucherstorage_activity` = 'null';
UPDATE `voucher_storage` SET `voucherstorage_status` = '' WHERE `voucherstorage_status` = 'null';
UPDATE `voucher_storage` SET `voucherstorage_jobno` = '' WHERE `voucherstorage_jobno` = 'null';