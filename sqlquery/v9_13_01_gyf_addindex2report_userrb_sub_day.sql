alter table `report_userrb_sub_day` add index  rrb_reportno(`report_no`);
alter table `report_userrb_sub_day` add index rrb_get_topuser(`report_user`,`report_end`,`report_rbbuy_result`);
alter table `report_userrb_sub_day` add index rrb_get_top(`report_end`,`report_rbbuy_result`);

