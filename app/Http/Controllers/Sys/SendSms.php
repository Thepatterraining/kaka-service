<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Data\Sys\ErrorData;
use App\Data\Auth\AccessToken;

class SendSms extends Controller
{
    protected $validateArray=[
        "phone"=>"required",
        "type"=>"required|dic:sms_code",
    ];

    protected $validateMsg = [
        "phone.required"=>"请输入手机号!",
        "type.required"=>"请输入类型!",
        "type.dic:sms_code"=>"类型不正确!",
    ];

    const KEY = 'alisms_send_code_timeout';

    /**
     * 发送验证码
     *
     * @param   pohne 手机号
     * @param   type 类型
     * @author  zhoutao
     * @version 0.1
     */
    public function run()
    {
        $tokenData = new AccessToken;
        $data = new SendSmsData();
        $phone = $this->request->input('phone');
        $type = $this->request->input('type');
        $userData = new UserData();
        //如果取到手机号，说明操作频繁，返回错误
        $redsiMobile = Redis::command('get', [self::KEY . $phone]);
        if (!empty($redsiMobile)  && $redsiMobile == $phone) {
            return $this->Error(ErrorData::OPER_FREQUENT);
        }
        if ($type == SendSmsData::$SEND_SMS_TYPE_REG) {
            $user = $userData->getUser($phone);
            if ($user != null) {
                return $this->Error(ErrorData::$USER_REQUIRED);
            }
        } elseif ($type == SendSmsData::$SEND_SMS_TYPE_LOGIN || $type == SendSmsData::SEND_SMS_TYPE_SAVE_USER) {
            $user = $userData->getUser($phone);
            if ($user == null) {
                return $this->Error(ErrorData::$USER_NOT_FOUND);
            }
        }
        $res = $data->sendCode($phone, $type, $this->sms);
        if ($res['res'] !== true) {
            return $this->Error(ErrorData::$VERIFY_SEND_OUT_FALSE);
        }
        $phone = $res['phone'];
        $verfy = $res['verfy'];
        $timeout = 300;
        $tokenData->setVerfiy($phone, $verfy, $timeout);
        //增加时间限制
        $timeout = 60;
        $tokenData->setVerfiy(self::KEY . $phone, $phone, $timeout);
        
        $res = '验证码发送成功！';
        return $this->Success($res);
    }
}
