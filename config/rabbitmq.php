<?php
return array(
  "enable"=>env('MQ_ENABLE',true),
  "host"=>env('RBMQ_HOST','47.93.124.209'),
  "port"=>  env('RBMQ_PORT',5672),
  "user"=> env('RBMQ_USER','kakatest'),
  "pwd"=> env('RBMQ_PWD', '123456'),
  "hostname"=> env('RBMQ_HOSTNAME','kk_service'),
  "apiport"=>env('RBMQ_APIPORT',15672),
  "exname"=>env('RBMQ_EXNAME','kk.php.service.event'),
  "jsexname"=>env('RBMQ_JSEXNAME','js')
);
