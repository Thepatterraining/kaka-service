alter table `user_coin_journal` add index ucj_type (`usercoin_journal_type`);
alter table `user_coin_journal` add index ucj_doc (`usercoin_journal_jobno`);
alter table `user_coin_journal` add index ucj_user (`usercoin_journal_userid`);
alter table `user_coin_journal` add index ucj_coin (`usercoin_journal_cointype`);
alter table `user_coin_journal` add index ucj_date(`usercoin_journal_datetime`);
