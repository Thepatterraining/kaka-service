<?php

namespace App\Http\Controllers\Sys;

use App\Data\Sys\SendSmsData;
use App\Data\User\UserData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Data\Sys\ErrorData;
use App\Data\API\Payment\PaymentServiceFactory ; 

class SendSmsBindCard extends Controller
{
    protected $validateArray=[
        "phone"=>"required",
        "name"=>"required",
        "idno"=>"required",
        "bankCard"=>"required",
    ];

    protected $validateMsg = [
        "phone.required"=>"请输入手机号!",
        "name.required"=>"请输入名称!",
        "idno.required"=>"请输入身份证号!",
        "bankCard.required"=>"请输入银行卡号!",
    ];

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
        $data = new SendSmsData();
        $phone = $this->request->input('phone');
        $name = $this->request->input('name');
        $idno = $this->request->input('idno');
        $bankCard = $this->request->input('bankCard');
        
        

        $res = $data->sendCode($phone, SendSmsData::SEND_SMS_TYPE_BIND_CARD, $this->sms);
        if ($res['res'] !== true) {
            return $this->Error(ErrorData::$VERIFY_SEND_OUT_FALSE);
        }
        $phone = $res['phone'];
        $verfy = $res['verfy'];
        $timeout = 300;
        Redis::command('set', [$phone,$verfy]);
        Redis::command('expire', [$phone,$timeout]);
        $res = '验证码发送成功！';
        return $this->Success($res);
    }
}
