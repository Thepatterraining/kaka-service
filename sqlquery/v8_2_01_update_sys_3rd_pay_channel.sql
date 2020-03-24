update `sys_3rd_pay_channel` set `channel_infeecounttype` = 'FRT02', `channel_payplatform`=3,`channel_infeerate`=0.03,
                                `channel_infeetype`="FR01",`channel_whtidrawaltype`="3RD02",`channel_whithdrawalbankno`="110925871910801", 
                                `channel_infeeroutetype`="FRR01",`channel_infeemincount`=2 where `channel_name`= "快捷支付" ;

update `sys_3rd_pay_channel` set `channel_infeecounttype` = 'FRT01',`channel_infeeroutetype`="FRR01",`channel_infeemincount`=0 where `channel_name`= "线下扫码支付(光大深圳)-微信" ;
update `sys_3rd_pay_channel` set `channel_infeecounttype` = 'FRT00',`channel_infeeroutetype`="FRR01",`channel_infeemincount`=0 where `channel_name`= "线下充值" ;
update `sys_3rd_pay_channel` set `channel_infeecounttype` = 'FRT01',`channel_infeeroutetype`="FRR01",`channel_infeemincount`=0 where `channel_name`= "微信直冲" ;
update `sys_3rd_pay_channel` set `channel_infeecounttype` = 'FRT01',`channel_infeeroutetype`="FRR01",`channel_infeemincount`=0 where `channel_name`= "支付宝-扫码支付(光大银行)" ;