<?php

namespace App\Model\Sys;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use iscms\Alisms\SendsmsPusher as Sms;

class SmsLog extends Model
{
    //
    use SoftDeletes;
    protected $table = "sys_sms_log";
    protected $dates = ["created_at","updated_at","deleted_at"];

    /**
     * 阿里大雨
     *
     * @param  $phone 手机号,用户输入的手机号
     * @param  $name 短信签名,阿里大鱼申请的短信签名的名字
     * @param  $content 替换短信模板中的变量,JSON字符串格式,所有值都是字符串,不能有整形
     * @param  $code 阿里大鱼申请的短信模板编号
     * @param  Sms                                                                                                 $sms
     * @return \Iscloudx\AlibigfishSdk\ResultSet|mixed|\SimpleXMLElement
     */
    public function sendSms($phone, $name, $content, $code, $sms)
    {
        return $sms->send($phone, $name, $content, $code);
    }
}
