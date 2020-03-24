alter table `event_define` modify `event_queue_type` varchar(255) DEFAULT NULL COMMENT '队列类型';
alter table `event_define` modify `event_observer` varchar(255) DEFAULT NULL COMMENT '观察类';