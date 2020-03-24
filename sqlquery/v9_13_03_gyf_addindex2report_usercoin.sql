alter table `report_user_coin_day` add index rpt_usercoin_rptno(`report_no`);
alter table `report_user_coin_day` add index rpt_usercoin_popuser(`report_user`,`report_end`);
alter table `report_user_coin_day` add index rpt_usercoin_end(`report_end`);

