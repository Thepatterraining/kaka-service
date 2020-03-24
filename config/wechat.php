<?php
return [
    "appid"=>env('WECHAT_ID',"id"),
    "secret"=>env('WECHAT_SECRET','secret'),
    "checktmpid"=>env("WECHAT_CODETMEP","tmpid")
];