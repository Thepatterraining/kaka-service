alter table `event_define` add `event_queue_type` varchar(255) NOT NULL DEFAULT 0 COMMENT '队列类型';
alter table `event_define` add `event_observer` varchar(255) NOT NULL DEFAULT 0 COMMENT '观察类';