<?php
namespace App\Data\API\Wechat ;

interface IWechat
{
    public function SendMsg($openid,$msg_tmpid,$msg_content);
}