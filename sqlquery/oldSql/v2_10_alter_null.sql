
-- 修改 activity_info 表默认值
alter table `activity_info` alter column `activity_no` set default '',alter column`activity_name` set default '',
alter column `activity_limittype` set default '',alter column `activity_event` set default '',alter column `activity_filter` set default '',
alter column `activity_code` set default '',alter column `activity_status` set default '';


-- 修改 activity_invitation 表默认值
alter table `activity_invitation` alter column `inviitation_no` set default '',alter column`inviitation_code` set default '',
alter column `inviitation_user` set default '',alter column `inviitation_reguser` set default '',alter column `inviitation_type` set default '';



-- 修改 activity_item 表默认值
alter table `activity_item` alter column `activity_no` set default '',alter column`activity_itemtype` set default '',
alter column `activity_itemno` set default '';


-- 修改 auth_login_log 表默认值
alter table `auth_login_log` alter column `login_type` set default '',alter column`login_add` set default '',
alter column `login_mac` set default '',alter column `login_ip` set default '',alter column `login_token` set default '';


-- 修改 auth_user 表默认值
alter table `auth_user` alter column `auth_id` set default '',alter column`auth_nickname` set default '',
alter column `auth_name` set default '',alter column `auth_idno` set default '',alter column `auth_headimgurl` set default '',
alter column `auth_sex` set default '',alter column `auth_mobile` set default '',alter column `auth_pwd` set default '',
alter column `auth_status` set default '',alter column `auth_lastlogin` set default '';


-- 修改 cash_bank_account 表默认值
alter table `cash_bank_account` alter column `account_no` set default '',alter column`account_name` set default '';


-- 修改 cash_journal 表默认值
alter table `cash_journal` alter column `cash_journal_no` set default '',alter column`cash_journal_type` set default '',
alter column `cash_journal_jobno` set default '',alter column `cash_journal_status` set default '',alter column `hash` set default '';


-- 修改 cash_recharge 表默认值
alter table `cash_recharge` alter column `cash_recharge_no` set default '',alter column`cash_recharge_phone` set default '',
alter column `cash_recharge_status` set default '',alter column `cash_recharge_body` set default '',alter column `cash_recharge_bankid` set default '',
alter column `cash_recharge_type` set default '';


-- 修改 cash_withdrawal 表默认值
alter table `cash_withdrawal` alter column `cash_withdrawal_no` set default '',alter column`cash_withdrawal_status` set default '',
alter column `cash_withdrawal_body` set default '',alter column `cash_withdrawal_type` set default '';


-- 修改 coin_journal 表默认值
alter table `coin_journal` alter column `coin_journal_no` set default '',alter column`coin_journal_cointtype` set default '',
alter column `coin_journal_status` set default '',alter column `coin_journal_jobno` set default '',alter column `coin_journal_type` set default '',
alter column `hash` set default '';


-- 修改 coin_rechage 表默认值
alter table `coin_rechage` alter column `coin_recharge_no` set default '',alter column`coin_recharge_cointype` set default '',
alter column `coin_recharge_status` set default '',alter column `coin_recharge_address` set default '',alter column `coin_recharge_type` set default '';


-- 修改 coin_withdrawal 表默认值
alter table `coin_withdrawal` alter column `coin_withdrawal_no` set default '',alter column`coin_withdrawal_cointype` set default '',
alter column `coin_withdrawal_status` set default '',alter column `coin_withdrawal_toaddress` set default '',alter column `coin_withdrawal_fromaddress` set default '',
alter column `coin_withdrawal_type` set default '';


-- 修改 item_formula 表默认值
alter table `item_formula` alter column `coin_type` set default '',alter column`iamge` set default '',
alter column `file` set default '',alter column `file_name` set default '',alter column `type` set default '';


-- 修改 item_info 表默认值
alter table `item_info` alter column `name` set default '',alter column`coin_type` set default '',
alter column `kk_name` set default '',alter column `compound` set default '',alter column `layout` set default '',
alter column `diqu` set default '',alter column `trade` set default '',alter column `number` set default '',
alter column `age` set default '',alter column `rowards` set default '',alter column `renovation` set default '',
alter column `school` set default '',alter column `metro` set default '',alter column `school_district` set default '',alter column `sublet` set default '';


-- 修改 item_quarters 表默认值
alter table `item_quarters` alter column `coin_type` set default '',alter column`layout` set default '',
alter column `space` set default '',alter column `age` set default '',alter column `rowards` set default '',
alter column `number` set default '';



-- 修改 sys_3rd_account 表默认值
alter table `sys_3rd_account` alter column `sys_3rd_type` set default '',alter column`sys_3rd_name` set default '',
alter column `sys_3rd_account` set default '',alter column `sys_3rd_key` set default '',alter column `sys_3rd_secrect` set default '';



-- 修改 sys_bank 表默认值
alter table `sys_bank` alter column `bank_type` set default '',alter column`bank_name` set default '',
alter column `bank_add` set default '',alter column `bank_no` set default '';


-- 修改 sys_cash_fee 表默认值
alter table `sys_cash_fee` alter column `cash_withdrawal_feeno` set default '',alter column`cash_withdrawal_feestatus` set default '',
alter column `cash_withdrawal_no` set default '',alter column `cash_withdrawal_feetype` set default '';


-- 修改 sys_cash_journal 表默认值
alter table `sys_cash_journal` alter column `syscash_journal_no` set default '',alter column`syscash_journal_type` set default '',
alter column `syscash_journal_jobno` set default '',alter column `syscash_journal_status` set default '',alter column `hash` set default '';


-- 修改 sys_coin 表默认值
alter table `sys_coin` alter column `syscoin_account_type` set default '',alter column`syscoin_account_address` set default '';


-- 修改 sys_coin_account 表默认值
alter table `sys_coin_account` alter column `account_type` set default '',alter column`account_address` set default '';



-- 修改 sys_coin_fee 表默认值
alter table `sys_coin_fee` alter column `coin_withdrawal_feeno` set default '',alter column`coin_withdrawal_no` set default '',
alter column `coin_withdrawal_cointype` set default '',alter column `coin_withdrawal_feestatus` set default '',alter column `coin_withdrawal_feetype` set default '';




-- 修改 sys_coin_journal 表默认值
alter table `sys_coin_journal` alter column `syscoin_journal_no` set default '',alter column`syscoin_journal_type` set default '',
alter column `syscoin_journal_jobno` set default '',alter column `syscoin_journal_status` set default '',alter column `hash` set default '',
alter column `syscoin_coin_type` set default '';


-- 修改 sys_dictionary 表默认值
alter table `sys_dictionary` alter column `dic_no` set default '',alter column`dic_type` set default '',alter column`dic_name` set default '';



-- 修改 sys_error 表默认值
alter table `sys_error` alter column `error_msg` set default '';


-- 修改 sys_log 表默认值
alter table `sys_log` alter column `token` set default '',alter column`url` set default '';


-- 修改 sys_login_log 表默认值
alter table `sys_login_log` alter column `login_type` set default '',alter column`login_add` set default '',
alter column `login_mac` set default '',alter column `login_ip` set default '',alter column `login_token` set default '';


-- 修改 sys_mail 表默认值
alter table `sys_mail` alter column `mail_type` set default '',alter column`mail_define` set default '',
alter column `mail_url` set default '',alter column `mail_filter` set default '',alter column `mail_user_filter` set default '',
alter column `mail_event` set default '';



-- 修改 sys_mail_log 表默认值
alter table `sys_mail_log` alter column `mail_text` set default '',alter column`mail_status` set default '',alter column`mail_to` set default '';


-- 修改 sys_message 表默认值
alter table `sys_message` alter column `msg_text` set default '',alter column`msg_url` set default '',
alter column `msg_status` set default '',alter column `msg_model` set default '',alter column `msg_docno` set default '',
alter column `msg_type` set default '',alter column `msg_no` set default '';



-- 修改 sys_news 表默认值
alter table `sys_news` alter column `news_no` set default '',alter column`news_title` set default '',
alter column `news_subtitle` set default '',alter column `news_intro` set default '',alter column `news_writer` set default '',
alter column `news_source` set default '',alter column `news_type` set default '',
alter column `news_pushtype` set default '',alter column `news_refmodel` set default '',
alter column `news_refno` set default '',alter column `news_refurl` set default '';


-- 修改 sys_notify 表默认值
alter table `sys_notify` alter column `notify_type` set default '',alter column`notify_user_filter` set default '',
alter column `noiffy_event` set default '',alter column `notify_model` set default '';



-- 修改 sys_sms_log 表默认值
alter table `sys_sms_log` alter column `mobile` set default '',alter column`sms_type` set default '',
alter column `sms_text` set default '',alter column `sms_status` set default '',alter column `sms_body` set default '';



-- 修改 sys_user 表默认值
alter table `sys_user` alter column `user_id` set default '',alter column`user_nickname` set default '',
alter column `user_name` set default '',alter column `user_idno` set default '',alter column `user_headimgurl` set default '',
alter column `user_sex` set default '',alter column `user_mobile` set default '',
alter column `user_pwd` set default '',alter column `user_paypwd` set default '',
alter column `user_status` set default '';





-- 修改 transaction_buy 表默认值
alter table `transaction_buy` alter column `buy_no` set default '',alter column`buy_status` set default '',
alter column `buy_cointype` set default '',alter column `buy_region` set default '';



-- 修改 transaction_order 表默认值
alter table `transaction_order` alter column `order_no` set default '',alter column`order_buy_no` set default '',
alter column `order_sell_no` set default '',alter column `order_coin_type` set default '';




-- 修改 transaction_sell 表默认值
alter table `transaction_sell` alter column `sell_no` set default '',alter column`sell_status` set default '',
alter column `sell_leveltype` set default '',alter column `sell_cointype` set default '',alter column `sell_region` set default '';




-- 修改 user_bank_account 表默认值
alter table `user_bank_account` alter column `account_no` set default '',alter column`account_name` set default '';


-- 修改 user_cash_journal 表默认值
alter table `user_cash_journal` alter column `usercash_journal_no` set default '',alter column`usercash_journal_type` set default '',
alter column `usercash_journal_jobno` set default '',alter column `usercash_journal_status` set default '',alter column `hash` set default '';



-- 修改 user_cash_order 表默认值
alter table `user_cash_order` alter column `usercashorder_no` set default '',alter column`usercashorder_type` set default '',alter column`usercashorder_jobno` set default '';


-- 修改 user_coin_account 表默认值
alter table `user_coin_account` alter column `usercoin_cointype` set default '',alter column`usercoin_address` set default '';



-- 修改 user_coin_frozen 表默认值
alter table `user_coin_frozen` alter column `frozen_no` set default '',alter column`frozen_cointtype` set default '',
alter column `frozen_userid` set default '',alter column `frozen_type` set default '',alter column `frozen_jobno` set default ''
,alter column `frozen_status` set default '';



-- 修改 user_coin_journal 表默认值
alter table `user_coin_journal` alter column `usercoin_journal_no` set default '',alter column`usercoin_journal_type` set default '',
alter column `usercoin_journal_jobno` set default '',alter column `usercoin_journal_status` set default '',alter column `usercoin_journal_cointype` set default ''
,alter column `hash` set default '';


-- 修改 user_order 表默认值
alter table `user_order` alter column `userorder_no` set default '',alter column`userorder_type` set default '',
alter column `userorder_jobno` set default '',alter column `userorder_orderno` set default '',alter column `userorder_cointype` set default ''
,alter column `userorder_discounttype` set default '',alter column `userorder_discountno` set default ''
,alter column `userorder_userid` set default '';



-- 修改 voucher_info 表默认值
alter table `voucher_info` alter column `vaucher_no` set default '',alter column`vaucher_name` set default '',
alter column `vaucher_type` set default '',alter column `voucher_model` set default '',alter column `voucher_event` set default ''
,alter column `voucher_filter` set default '';





-- 修改 voucher_storage 表默认值
alter table `voucher_storage` alter column `vaucherstorage_no` set default '',alter column`vaucherstorage_voucherno` set default '',
alter column `vaucherstorage_activity` set default '',alter column `voucherstorage_status` set default '',alter column `voucherstorage_jobno` set default '';



