INSERT INTO `sys_notify` (`id`, `notify_type`, `notify_fmt`, `notify_user_filter`, `noiffy_event`, `created_at`, `updated_at`, `deleted_at`, `created_id`, `updated_id`, `deleted_id`, `notify_model`)
VALUES
	(null,'NT10','您好，您有一笔{$item->report_invuser_rbbuy_return_cash}元补贴奖励到账。','','Rebate_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Report\\ReportUserrbSubDay'),
	(null,'NT11','您好，您有一笔{$item->pay_amount}元补贴奖励到账。','','SysPayUser_Check',NULL,NULL,NULL,NULL,NULL,NULL,'Sys\\PayUser');